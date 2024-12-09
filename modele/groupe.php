<?php
    Class Groupe{
        private int $idGroupe;
        private string $nomGroupe;
        private string $regles;
        private int $nbMembres;
        private ?string $lienPhotoIcone;    // ? ⇒ nullable
        private array $listeVote;

        public const DEFAULT_LIEN_PHOTO_ICONE = 'media/filled-default-group-icon-1600.png';

        
        public function get($attribute){
            return $this->$attribute;
        }

        public function set($attribute, $val){
            $this->$attribute = $val;
        }

        public function __construct($idGroupe=NULL, $nomGroupe=NULL){
            if(!is_null($idGroupe)){
                $this->idGroupe = $idGroupe;
                $this->nomGroupe = $nomGroupe;
            }
        }

        public static function getGroupe(int $idGroupe){
            $requete = "SELECT idGroupe, nomGroupe, COUNT(*) AS nbMembres, lienPhotoIcone FROM Groupe NATURAL JOIN Membre WHERE idGroupe = $idGroupe;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Groupe");
            $groupe = $resultat->fetch();
            $groupe->listeVote = Vote::getVotesGroupe($idGroupe);

            if(is_null($groupe->lienPhotoIcone))
                $groupe->lienPhotoIcone = Groupe::DEFAULT_LIEN_PHOTO_ICONE;

            return $groupe;
        }

        public static function getGroupeUtilisateur(int $idUtilisateur){
            $requete = "SELECT G.idGroupe, G.nomGroupe, COUNT(*) AS nbMembres
                        FROM Groupe G INNER JOIN Membre M
                        ON G.idGroupe = M.idGroupe 
                        WHERE idUtilisateur = $idUtilisateur;";

            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Groupe");
            
            $listeGroupes = $resultat->fetchAll();

            foreach($listeGroupes as $groupe){
                $groupe->listeVote = Vote::getVotesGroupe($groupe->idGroupe);
            }

            return $listeGroupes;
        }

        public static function getJSON(int $idGroupe){
            $requete = "SELECT idGroupe, nomGroupe FROM Groupe WHERE idGroupe = $idGroupe;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Groupe");
            
            $data = $resultat->fetch(PDO::FETCH_ASSOC);

            return json_encode($data, JSON_UNESCAPED_UNICODE);
        }

        public function __toString(){
            return "<h3> Groupe </h3>
                    <p>
                    id : $this->idGroupe<br />
                    nom : $this->nomGroupe<br />
                    nbMembres : $this->nbMembres
                    </p>";
        }

        public function display(){
            echo $this;
            echo "<pre>";
            print_r($this->listeVote);
            echo "</pre>";
        }
    }
?>