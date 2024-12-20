<?php
/*  
    QUICK FIX : les fonctions suivantes pouront être déplacées dans un autre fichier plus tard
    (la classe Vote est un peu plus bas)
*/

// NOTA: quand on SELECT une collone de type TIME sur mariaDb cela retourne une string au fomat 'nbHeures:nbMinutes:nbSecondes'
function toDateInterval(string $mariaDbTime) {
    return new DateInterval('PT' . preg_replace('/(\d+):(\d+):(\d+)/', '$1H$2M$3S', $mariaDbTime));
}

/*
    DISCLAIMER, la fnction suivante n'est pas finie, Vianney la terminera
    TODO: 
    - contourner $di->days dans lequel on ne peux pas mettre la valeur du nombre de jours total si $di->days==false (simple en bricolant mais ce serait bien de le faire proprement)
    - implémenter cette fonction dans les méthodes utilisant INSERT
*/
// // retourne une string correspondant au format de l'intervalle de temps utilisé dans la base de donnés
// // ATTENTION, cela modifie aussi l'intervale de temps $di passé en paramètre en le faisant correspondre au format utilisé dans la base de données
// // les intervalles de temps négatifs ne sont actuellement pas supportés
// // NOTA: quand on INSERT dans une collone de type TIME sur mariaDb on peut insérer une string au fomat 'nbJours nbHeures:nbMinutes:nbSecondes'
// function toSqlTime(DateInterval $di) {
// 	// seuls les intervales <= 30 jours sont acceptés
// 	$time = '';
    
// 	// on ne veux pas de millisecondes
// 	$di->f = 0;
    
// 	// si l'intervalle a été fait avec DateTime::diff(), DateTimeImmutable::diff(), ou DateTimeInterface::diff()
// 	// alors on a accès au nombre de jours total
// 	if($di->days) {
// 		$di->y = 0;
// 		$di->m = 0;
// 		$di->d = 0; 
// 		// $di->days contient déjà le nombre de jours total
// 	}
// 	// si l'intervalle a été fait autrement qu'avec DateTime::diff(), DateTimeImmutable::diff(), ou DateTimeInterface::diff()
// 	// il faut mettre les secondes, minutes, heures et jours au bon format (23h max, 59min max, 59s max)
// 	else {
// 		// on en veux pas de nb de mois ou d'années
// 		if($di->y!=0 || $di->m!=0) {
// 			 throw new Exception("intervalle de temps supérieur à 30 jours (peut-être une mauvaise saissie ?)");
// 		}
// 		$di->s = $di->d*86400 + $di->h*3600 + $di->m*60 + $di->s;
// 		$di->days = floor($di->s/86400); // on calcule le nombre de jours total et on le stocke dans $di->days
// 		$di->d = 0; // $di->d est inutile
// 		$di->s %= 86400;
// 		$di->h = floor($di->s/3600);
// 		$di->s %= 3600;
// 		$di->m = floor($di->s/60);
// 		$di->s %= 60;
// 	}
    
// 	// On n'accepte que les intervalles >= 30 jours pile-poil
// 	if($di->d >= 30) {
// 		if($di->d==30 && !($di->h==0 && $di->i==0 && $di->s==0)) {
// 			return $di->format('%a %H:%I:%S'); // $di correspond exactement à 30 jours pile-poil
// 		}
// 		throw new Exception("intervalle de temps supérieur à 30 jours (peut-être une mauvaise saissie ?)");
// 	}
    
    
// 	return $di->format('%a %H:%I:%S'); // $di < 30 jours
// }

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
            
            $this->delaiDiscussion = toDateInterval($delaiDiscussion);
            $this->delaiVote = toDateInterval($delaiVote);
            $this->dateCreationVote = new DateTime($dateCreationVote);

            $this->codeSuffrage = $codeSuffrage;
            $this->autoriserVoteBlanc = $autoriserVoteBlanc;
            $this->autoriserPlusieursChoix = $autoriserPlusieursChoix;

            $this->evalBudget = $evalBudget;
            $this->propositionAcceptee = $propositionAcceptee;
        }
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


    public static function insererVote($titre, $delaiDiscussion, $delaiVote, 
                                       $description, $voteBlanc, $multiChoix, 
                                       $idGroupe, $listeEtiquettes, $listeChoix){

        $requete = "SELECT MAX(idVote)+1 FROM Vote)";

        $resultat = Connexion::pdo()->query($requete);
        $idVote = $resultat->fetch(PDO::FETCH_COLUMN);

        $requete = "INSERT INTO Vote :idVote, :titre, :delaiDiscussion, :delaiVote, :descriptionVote, NOW(), 0, NULL, :voteBlanc, :multiChoix, NULL, :idGroupe;";
        
        $statement = Connexion::pdo()->prepare($requete);
        $statement->execute([
            ':idVote' => $idVote,
            ':titre' => $titre,
            ':delaiDiscussion' => $delaiDiscussion,
            ':delaiVote' => $delaiVote, 
            ':descriptionVote' => $description,
            ':voteBlanc' => $voteBlanc,
            ':multiChoix' => $multiChoix,
            ':idGroupe' => $idGroupe
        ]);

        $requete = "INSERT INTO EtiquetteVote VALUES(:idVote, :idEtiquette);";
        $statement = Connexion::pdo()->prepare($requete);
        foreach($listeEtiquettes as $eti){
            $statement->execute([
                ':idVote' => $idVote,
                ':idEtiquette' => $eti
            ]);
        }


        $requete = "INSERT INTO ChoixVote VALUES(MAX(idChoixVote)+1, :intitule, :idVote);";
        $statement = Connexion::pdo()->prepare($requete);
        foreach($listeChoix as $choixVote){
            $statement->execute([
                ':intitule' => $choixVote,
                ':idVote' => $idVote
            ]);
        }
    }

    /*
        ATTENTION: si json_encode() ou getJSON() ne fonctionne plus, c'est de la faute de Vianney (moi)
        car les DateTime et les DateInterval n'ont pas de méthode __toString() (il faut utiliser leur méthode format())
    */
    public static function getJSON(int $idVote, int $idUser=NULL){
        $vote = Vote::getVote($idVote, $idUser);

        return json_encode((array) $vote,JSON_UNESCAPED_UNICODE);
        //Vote va garder un json fucked up pour l'instant TODO : creer une fonction to_array pour Vote
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