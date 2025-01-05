<?php


require_once(__DIR__.'/../config/date.php');

Class Vote{
    private int $idVote;
    private string $titreVote;
    private ?string $lienPhoto;
    
    private ?DateInterval $delaiDiscussion;
    private ?DateInterval $delaiVote;
    private DateTime $dateCreationVote;
    
    private string $codeSuffrage;
    private bool $autoriserVoteBlanc;
    private bool $autoriserPlusieursChoix;

    private ?float $evalBudget;
    private ?bool $propositionAcceptee;

    private array $choixVote;
    private array $listeEtiquettes;
    private array $listeMessages;
    private array $listeReactions;


    public function get($attribute){
        return $this->$attribute;
    }


    public function set($attribute, $val){
        $this->$attribute = $val;
    }


    public function __construct(int $idVote=NULL, string $titreVote=NULL, string $lienPhoto=NULL,
                                string $delaiDiscussion=NULL, string $delaiVote=NULL, string $dateCreationVote=NULL,
                                string $codeSuffrage=NULL, bool $autoriserVoteBlanc=NULL, bool $autoriserPlusieursChoix=NULL,
                                float $evalBudget=NULL, bool $propositionAcceptee=NULL){
                                    
        if(!is_null($idVote)){
            $this->idVote = $idVote;
            $this->titreVote = $titreVote;
            $this->lienPhoto = $lienPhoto;
            
            $this->delaiDiscussion = Date::toDateInterval($delaiDiscussion);
            $this->delaiVote = Date::toDateInterval($delaiVote);
            $this->dateCreationVote = Date::toDateTime($dateCreationVote);

            $this->codeSuffrage = $codeSuffrage;
            $this->autoriserVoteBlanc = $autoriserVoteBlanc;
            $this->autoriserPlusieursChoix = $autoriserPlusieursChoix;

            $this->evalBudget = $evalBudget;
            $this->propositionAcceptee = $propositionAcceptee;
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
    

    public static function getVote(int $idVote, int $idUser=NULL){
        $requete = "SELECT  idVote, titreVote, lienPhoto, 
                            delaiDiscussion, delaiVote, dateCreationVote,
                            codeSuffrage, autoriserVoteBlanc, autoriserPlusieursChoix,
                            propositionAcceptee, evalBudget
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
        return $vote;
    }


    public static function getVotesGroupe($idGroupe){
        $requete = "SELECT  idVote, titreVote, lienPhoto, 
                            delaiDiscussion, delaiVote, dateCreationVote,
                            codeSuffrage, autoriserVoteBlanc, autoriserPlusieursChoix,
                            propositionAcceptee, evalBudget
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
                                       $idGroupe, $listeEtiquettes, $listeChoix, $idCreateur){

        $requete = "SELECT MAX(idVote)+1 FROM Vote;";

        $resultat = Connexion::pdo()->query($requete);
        $idVote = $resultat->fetch(PDO::FETCH_COLUMN);

        $requete = "SELECT MAX(idChoixVote)+1 FROM ChoixVote;";

        $resultat = Connexion::pdo()->query($requete);
        $idChoixVote = $resultat->fetch(PDO::FETCH_COLUMN);

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
            ':codeSuffrage' => 'UNIMAJ1',
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


        $requete = "INSERT INTO ChoixVote VALUES(:idChoixVote, :intitule, :idVote);";
        $statement = Connexion::pdo()->prepare($requete);
        foreach($listeChoix as $choixVote){
            $statement->execute([
                ':idChoixVote' => $idChoixVote,
                ':intitule' => $choixVote,
                ':idVote' => $idVote
            ]);

            $idChoixVote++;
        }

        return $idVote;
    }

    public static function setLienPhoto($idVote, $lien) {
        $requete = "CALL modifierPhotoGroupe(:idVote,:lienPhoto)"; //Procédure stocké PL/SQL
        $statement = Connexion::pdo()->prepare($requete);
        $statement->execute(
            [
                ':idVote' => $idVote,
                'lienPhoto' => $lien
            ]
        );
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
        $requete = "SELECT COUNT(*) AS 'nbVote' FROM ChoixMembre 
                    WHERE idChoixVote = $idChoixVote
                    AND idUtilisateur = $idUser;";

        $resultat = Connexion::pdo()->query($requete);
        
        return $resultat->fetch()['nbVote'] > 0;
    }


    public function __toString(){
        return "<h3>Vote</h3>
                <p>id : $this->idVote<br>
                    titre : $this->titreVote</p>";
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