<?php
    Class Groupe{
        private int $idGroupe;
        private string $nomGroupe;

        public function __construct($idGroupe=NULL, $nomGroupe=NULL){
            if(!is_null($idGroupe)){
                $this->idGroupe = $idGroupe;
                $this->nomGroupe = $nomGroupe;
            }
        }

        public static function getGroupe(int $idGroupe){
            $requete = "SELECT idGroupe, nomGroupe FROM Groupe WHERE idGroupe = $idGroupe;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Groupe");
            
            return $resultat->fetch();
        }

        public function __toString(){
            return "<h3> Groupe </h3>
                    <p>id : $this->idGroupe<br>
                       nom : $this->nomGroupe</p>";
        }

        public function display(){
            echo $this;
        }
    }
?>