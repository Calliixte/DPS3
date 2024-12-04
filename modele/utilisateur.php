<?php
    const MEMBRE = 0;
    const MODO = 1;
    const ADMIN = 2;
    const ASSESS = 3;
    const ORGA = 4;
    Class Utilisateur{
        private int $idUtilisateur;
        private string $pseudo;
        private string $nom;
        private string $prenom;
        private string $lienPhotoProfil;
        private int $role = MEMBRE;
        private array $listeGroupes;

        public function get($attribute){
            return $this->$attribute;
        }

        public function set($attribute, $val){
            $this->$attribute = $val;
        }

        public function __construct(int $idUtilisateur=NULL, 
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
            
            $User = $resultat->fetch();
            $User->fillGroupList();

            return $User;
        }

        public function fillGroupList(){
            $requete = "SELECT G.idGroupe, G.nomGroupe 
                        FROM Groupe G INNER JOIN Membre M
                        ON G.idGroupe = M.idGroupe 
                        WHERE idUtilisateur = $this->idUtilisateur;";

            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Groupe");

            $this->listeGroupes = $resultat->fetchAll(); 
        }

        public static function getJSON($idUtilisateur){
        $requete = "SELECT idUtilisateur, pseudo, nom, prenom, lienPhotoProfil FROM Utilisateur WHERE idUtilisateur = $idUtilisateur;";
        $resultat = Connexion::pdo()->query($requete);
        $resultat->setFetchmode(PDO::FETCH_CLASS,"Utilisateur");
        
        return json_encode($resultat->fetch(PDO::FETCH_ASSOC),JSON_PRETTY_PRINT);
        }

        public function __toString(){
            return "<h3>Utilisateur</h3>
                    <p>id : $this->idUtilisateur<br>
                       pseudo : $this->pseudo<br>
                       nom : $this->nom<br>
                       prenom : $this->prenom<br>
                       photo de Profil : $this->lienPhotoProfil<p>
                       numéro de role : $this->role";
        }

        public function display(){
            echo $this;
        }

    }
?>