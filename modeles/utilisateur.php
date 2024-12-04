<?php
    Class Utilisateur{
        private int $idUtilisateur;
        private string $pseudo;
        private string $nom;
        private string $prenom;
        private string $lienPhotoProfil;

        public function get($attribute){
            return $this->$attribute;
        }

        public function set($attribute, $val){
            $this->$attribute = $val;
        }

        public function __construct(string $idUtilisateur=NULL, 
                                    string $pseudo=NULL, 
                                    string $nom=NULL,
                                    string $prenom=NULL,
                                    string $lienPhotoProfil=NULL) {
                
            if(!is_null($idUtilisateur)){
                $this->idUtilisateur = $idUtilisateur;
                $this->pseudo = $pseudo;
                $this->nom = $nom;
                $this->prenom = $prenom;
                $this->lienPhotoProfil = $lienPhotoProfil;
            }
        }

        public static function getUtilisateur($idUtilisateur){
            $requete = "SELECT idUtilisateur, pseudo, nom, prenom, lienPhotoProfil FROM Utilisateur WHERE idUtilisateur = $idUtilisateur;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Utilisateur");
            
            return $resultat->fetch();
        }

        public function __toString(){
            return "<p>id : $this->idUtilisateur<br>
                    pseudo : $this->pseudo<br>
                    nom : $this->nom<br>
                    prenom : $this->prenom<br>
                    photo de Profil : $this->lienPhotoProfil<p>";
        }

        public function display(){
            echo $this;
        }
    }
?>