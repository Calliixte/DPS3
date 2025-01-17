<?php


require_once(__DIR__.'/../config/date.php');

Class Vote{
    private static array $listeCodeSuffrage = ["UNIMAJ1","UNIMAJ2","PETITION1","UNIDIPRO1","UNIDI2"]; //Les types de suffrages


    private int $idVote;
    private string $titreVote;
    private ?string $lienPhoto;

    private ?DateInterval $delaiDiscussion;
    private ?DateInterval $delaiVote;
    private DateTime $dateCreationVote;
    
    private string $codeSuffrage;
    private bool $autoriserVoteBlanc;
    private bool $autoriserPlusieursChoix;
    private ?int $idChoixGagnant;

    private ?float $evalBudget;
    private ?bool $propositionAcceptee;

    private bool $voteOuvert;
    private bool $discussionOuverte;

    private array $choixVote;
    private array $listeEtiquettes;
    private array $listeMessages;
    private array $listeReactions;

    public static function getListeCodeSuffrage(){
        return self::$listeCodeSuffrage;
    }

    public function get($attribute){
        return $this->$attribute;
    }

    public function set($attribute, $val){
        $this->$attribute = $val;
    }


    public function __construct(int $idVote=NULL, string $titreVote=NULL, string $lienPhoto=NULL,
                                string $delaiDiscussion=NULL, string $delaiVote=NULL, string $dateCreationVote=NULL,
                                string $codeSuffrage=NULL, bool $autoriserVoteBlanc=NULL, bool $autoriserPlusieursChoix=NULL,
                                int $idChoixGagnant=NULL, float $evalBudget=NULL, bool $propositionAcceptee=NULL){
                                    
        if(!is_null($idVote)){
            $this->idVote = $idVote;
            $this->titreVote = $titreVote;
            $this->lienPhoto = $lienPhoto;
            
            $this->delaiDiscussion = Date::toDateInterval($delaiDiscussion);
            $this->delaiVote = Date::toDateInterval($delaiVote);
            $this->dateCreationVote = Date::toDateTime($dateCreationVote);

            if(in_array($codeSuffrage,Vote::$listeCodeSuffrage)){
                $this->codeSuffrage = $codeSuffrage;
            } else {
                $this->codeSuffrage = Vote::$listeCodeSuffrage[0]; //Si le code suffrage est invalide on prend celui par défaut (ici UNIMAJ1)
            }

            $this->autoriserVoteBlanc = $autoriserVoteBlanc;
            $this->autoriserPlusieursChoix = $autoriserPlusieursChoix;
            
            $this->idChoixGagnant = $idChoixGagnant;
            
            $this->evalBudget = $evalBudget;
            $this->propositionAcceptee = $propositionAcceptee;

            $this->voteOuvert = false;
            $this->discussionOuverte = $propositionAcceptee;
        }
    }

    public function toArray() {
        $resultat = [];
        
        // Obtenir l'objet de réflexion pour la classe Vote
        $reflexion = new ReflectionClass($this);
        
        // Parcourir tous les attributs de la classe
        foreach ($reflexion->getProperties() as $attribut) {
            // Rendre l'attribut accessible même s'il est privé
            $attribut->setAccessible(true);
            
            // Obtenir le nom de l'attribut sans le préfixe "Vote" et sans la visibilité
            $nomAttribut = $attribut->getName();
            
            // Ajouter la clé et sa valeur au tableau résultat
            $resultat[$nomAttribut] = $attribut->getValue($this);
        }
        //convertit l'objet en array mais les messages et reactions qui sont des objets a l'interieur ne sont pas convertis pour la recursion
        //considerer changer un peu l'array de messages en un array de string pour avoir le contenu ou alors juste on s'en blk car on les utilisera pas dans l'api
        return $resultat;
    }
    
    public static function updateDateCreation($idVote, $date) {
        $requete = "UPDATE Vote SET dateCreationVote=:dateCreationVote WHERE idVote=:idVote;";
        $statement = Connexion::pdo()->prepare($requete);
        $statement->execute([
            ":dateCreationVote" => Date::toSqlDateTime($date),
            ":idVote" => $idVote
        ]);
    }

    public static function getVote(int $idVote, int $idUser=NULL){
        $requete = "SELECT  idVote, titreVote, lienPhoto, 
                            delaiDiscussion, delaiVote, dateCreationVote,
                            codeSuffrage, autoriserVoteBlanc, autoriserPlusieursChoix,
                            idChoixGagnant, propositionAcceptee, evalBudget
                    FROM Vote WHERE idVote = $idVote;";
        $resultat = Connexion::pdo()->query($requete);

        // utilisation du constructeur pour créer l'objet 
        // il est nécessaire de créer l'objet via le contructeur pour initialiser correctement $this->delaiDiscussion, $this->delaiVote, et $this->dateCreationVote
        // l'ordre des colonne sélectionnées dans la requête ne compte pas, 
        // chaque paramètre du contructeur est mappé aevc une valeur ayant une clé du même nom dans le tableau retourné par fetch()
        $vote = new Vote(... $resultat->fetch(PDO::FETCH_ASSOC));

        $vote->fillChoixVote($idUser);
        $vote->fillEtiquettes();
        
        $vote->listeMessages = Message::getMessages($idVote);
        $vote->listeReactions = Reaction::getReactionVote($idVote);
        $vote->discussionOuverte = $vote->propositionAcceptee;
        return $vote;
    }

    public static function getVotesGroupe($idGroupe){
        $requete = "SELECT  idVote, titreVote, lienPhoto, 
                            delaiDiscussion, delaiVote, dateCreationVote,
                            codeSuffrage, autoriserVoteBlanc, autoriserPlusieursChoix,
                            idChoixGagnant, propositionAcceptee, evalBudget
                    FROM Vote WHERE idGroupe = $idGroupe";
        $resultat = Connexion::pdo()->query($requete);

        // utilisation du constructeur pour créer l'objet 
        // il est nécessaire de créer l'objet via le contructeur pour initialiser correctement $this->delaiDiscussion, $this->delaiVote, et $this->dateCreationVote
        // l'ordre des colonne sélectionnées dans la requête ne compte pas, 
        // chaque paramètre du contructeur est mappé aevc une valeur ayant une clé du même nom dans le tableau retourné par fetch()
        $listeVote = [];
        while($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            $vote = new Vote(... $ligne);
            // pour des raisons d'efficacité, pas de fillEtiquettes() ni de fillChoixVote(), on les appelera quand ce sera nécessaire
            $vote->set('listeMessages', Message::getMessages($vote->idVote));
            $listeVote[] = $vote;
        }

        return $listeVote;
    }

    //Insère une ligne dans la table vote de la base de données, et retourne l'idVote de la nouvelle ligne
    public static function insererVote($titre, $delaiDiscussion, $delaiVote, 
                                       $description, $voteBlanc, $multiChoix, 
                                       $idGroupe, $listeEtiquettes, $listeChoix, $idCreateur, $codeSuffrage){

        //On récupère l'id vote max et on ajoute un, ce sera l'id du vote inséré
        //On le fait de cette manière car on en a besoin à plus endroit, et qu'on la retourne à la fin, il faut donc le stocker
        $requete = "SELECT MAX(idVote)+1 FROM Vote;"; 

        $resultat = Connexion::pdo()->query($requete);
        $idVote = $resultat->fetch(PDO::FETCH_COLUMN);


        $requete = "INSERT INTO Vote VALUES(:idVote, :titre, :delaiDiscussion, :delaiVote, NOW(), :descriptionVote, :propositionAccepte, :evalBudget, :idCreateur, :codeSuffrage, :idGroupe, :voteBlanc, :multiChoix, :lienPhoto);";
        $statement = Connexion::pdo()->prepare($requete);
        $statement->execute([
            ':idVote' => $idVote,
            ':titre' => $titre,
            ':delaiDiscussion' => Date::toSqlTime(new DateInterval("P$delaiDiscussion"."D")),
            ':delaiVote' => Date::toSqlTime(new DateInterval("P$delaiVote"."D")),
            ':descriptionVote' => $description,
            ':propositionAccepte' => 0,
            ':evalBudget' => NULL,
            ':idCreateur' => $idCreateur,
            ':codeSuffrage' => $codeSuffrage,
            ':voteBlanc' => $voteBlanc,
            ':multiChoix' => $multiChoix,
            ':idGroupe' => $idGroupe,
            ':lienPhoto' => NULL //On a besoin du nom du fichier sur le serveur, qui ne sera upload qu'après l'insertion
        ]);

        $requete = "INSERT INTO EtiquetteVote VALUES(:idVote, :idEtiquette);";
        $statement = Connexion::pdo()->prepare($requete);
        foreach($listeEtiquettes as $eti){
            $statement->execute([
                ':idVote' => $idVote,
                ':idEtiquette' => $eti
            ]);
        }

        //La base de donnée étant paramétrée avec auto increment, pas besoin de spécifier d'idChoixVote
        $requete = "INSERT INTO ChoixVote VALUES(NULL, :intitule, :idVote);";
        $statement = Connexion::pdo()->prepare($requete);
        foreach($listeChoix as $choixVote){
            $statement->execute([
                ':intitule' => $choixVote,
                ':idVote' => $idVote
            ]);
        }

        return $idVote;
    }

    public static function validerChoix($idVote, $idChoix){
        try{
            $requete = "UPDATE Vote SET idChoixGagnant=:idChoix WHERE idVote=:idVote";
            $statement = Connexion::pdo()->prepare($requete);
            $statement->execute([
                ":idChoix"=> $idChoix,
                ":idVote"=> $idVote
            ]);
        }catch(Exception $e){
            echo $e;
        }
    }

    public static function setLienPhoto($idVote, $lien) {
        $requete = "CALL modifierPhotoVote(:idVote,:lienPhoto)"; //Procédure stocké PL/SQL
        $statement = Connexion::pdo()->prepare($requete);
        $statement->execute(
            [
                ':idVote' => $idVote,
                'lienPhoto' => $lien
            ]
        );
    }

    public function getChoixVoteById($idChoix){
        foreach($this->choixVote as $choix){
            if($choix["idChoixVote"] == $idChoix){
                return $choix;
            }
        }

        return null;
    }

    public function getIdMaxChoix(){
        $max = 0;
        foreach($this->choixVote as $choix){
            $max = max($max, $choix["nbVote"]);
            
        }

        return $max;
    }

    public function verifierDelaiDiscussion(){
        //La date de fin de discussion = date création vote + délai discussion
        $dateFin = $this->dateCreationVote;
        $dateFin->add($this->delaiDiscussion);

        $currentDate = new DateTime("now");

        if($currentDate >= $dateFin){ //Si la date est passé
            $this->discussionOuverte = false; //On ferme la discussion
            $this->voteOuvert = true; //On ouvre le vote
        }
    }

    public function verifierDelaiVote(){
        //Le vote est ouvert quand le délai discussion est fini
        //On a donc dateFin = date création + délai discussion + délai vote
        $dateFin = $this->dateCreationVote;
        $dateFin->add($this->delaiDiscussion);
        $dateFin->add($this->delaiVote);

        $currentDate = new DateTime("now");

        if($currentDate >= $dateFin){ //Si la date est passé
            $this->voteOuvert = false; //On ferme le vote
        }
    }

    public function addMessage($message){
        $this->listeMessages[] = $message;
    }
    public function fillEtiquettes(){
        $requete = "SELECT E.idEtiquette, labelEtiquette, couleur 
                    FROM EtiquetteVote EV INNER JOIN Etiquette E
                    ON EV.idEtiquette = E.idEtiquette
                    WHERE idVote=$this->idVote;";

        $resultat = Connexion::pdo()->query($requete);
        $resultat->setFetchMode(PDO::FETCH_ASSOC);
        
        $this->listeEtiquettes = $resultat->fetchAll();
    }

    public static function AccepterVote($idVote,$idRole){
        if ($idRole != 2 ){
            return -1;
        }
        $requete=" UPDATE Vote set propositionAcceptee = 1 where idVote = $idVote";
        $resultat = Connexion::pdo()->query($requete);
        return 1;
    }

    public static function SupprimerVote($idVote){
        $requetePreparee = Connexion::pdo()->prepare("DELETE FROM Vote where idVote= :log");
        $requetePreparee -> bindParam(':log',$idVote);
        try{
            $requetePreparee->execute();
        }catch(PDOException $e){echo $e->getMessage();}
    }

    public function voterChoixVote($idChoixVote){
        foreach($this->choixVote as $choix){
            if ($choix["idChoixVote"] == $idChoixVote){
                $choix["aVote"] = true;
            }
        }
    }

    public function getDescription(){ // description étant un string de taille conséquente et étant reservé à des cas précis,le conserver dans l'objet n'est pas pertinent
        $requete = "SELECT descriptionVote FROM Vote WHERE idVote=$this->idVote;";
        $resultat = Connexion::pdo()->query($requete);
        return $resultat->fetch()["descriptionVote"];

    }
    public function fillChoixVote($idUser=NULL){
        $requete = "SELECT idChoixVote, intitule, CountVoteChoix(idChoixVote) AS nbVote FROM ChoixVote WHERE idVote=$this->idVote;";
        $resultat = Connexion::pdo()->query($requete);
        $resultat->setFetchMode(PDO::FETCH_ASSOC);
        $this->choixVote = $resultat->fetchAll();

        if(!is_null($idUser)){
            for($i=0; $i < count($this->choixVote); $i++) {
                $aVote = $this->aChoisi($idUser, $this->choixVote[$i]['idChoixVote']);
                
                $this->choixVote[$i]['aVote'] = $aVote;
            }
        }
    }
    

    // à mettre dans la classe Utilisateur en static et sans $idUser en paramètre
    public function aChoisi(int $idUser, int $idChoixVote){
        $requete = "SELECT CountVoteChoix($idChoixVote) AS 'nbVote' FROM ChoixMembre 
                    WHERE idUtilisateur = $idUser;";

        $resultat = Connexion::pdo()->query($requete);
        
        return $resultat->fetch()['nbVote'] > 0;
    }


    public function __toString(){
        return "<h3>Vote</h3>
                <p>id : $this->idVote<br>
                    titre : $this->titreVote<br>
                    id gagnant : $this->idChoixGagnant</p>";
    }


    public function display(){
        echo $this;
        echo "<pre>";
        print_r($this->choixVote);
        echo "</pre>";
        echo "<pre>";
        print_r($this->listeEtiquettes);
        echo "</pre>";
        echo "<pre>";
        print_r($this->listeMessages);
        echo "</pre>";
        
        echo $this->delaiDiscussion->format('%H:%I:%S');
        echo '<br />';

        echo $this->delaiVote->format('%H:%I:%S');
        echo '<br />';

        echo $this->dateCreationVote->format('Y-m-d H:i:s');
        echo '<br />';
    }
}


?>