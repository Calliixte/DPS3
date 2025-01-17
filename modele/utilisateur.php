<?php
    Class Utilisateur{
        const ADMIN = 2;
        const MEMBRE = 3;
        const DECIDEUR = 4;
        const MODO = 5;
        const ASSESSEUR = 6;
        const ORGANISATEUR = 7;
        const BANNI = 8;

        private int $idUtilisateur;
        private string $pseudo;
        private string $nom;
        private string $prenom;
        private ?string $lienPhotoProfil; 
        
        private int $role = self::MEMBRE;
        private bool $estVerifie;

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
                                    string $lienPhotoProfil=NULL,
                                    bool $estVerifie=NULL,
                                    int $role=NULL) {
                
            if(!is_null($idUtilisateur)){
                $this->idUtilisateur = $idUtilisateur;
                $this->pseudo = $pseudo;
                $this->nom = $nom;
                $this->prenom = $prenom;
                $this->lienPhotoProfil = $lienPhotoProfil;
                $this->estVerifie = $estVerifie;
                $this->role=$role;
            }
        }
        
        public static function updateUtilisateur($idUtilisateur, $nom, $prenom, $pseudo, $dateNaissance, $adresse, $mail, $lienPhotoProfil){
            $requete = "UPDATE Utilisateur  SET pseudo = :pseudo, 
                                                nom = :nom, 
                                                prenom = :prenom, 
                                                dateNaissance = :dateNaissance, 
                                                mail = :mail,
                                                adresse = :adresse,
                                                lienPhotoProfil = :lienPhotoProfil
                                            WHERE idUtilisateur = :idUtilisateur";

            $statement = Connexion::pdo()->prepare($requete);

            $statement->execute([
                ":idUtilisateur"=> $idUtilisateur,
                ":nom"=> $nom,
                ":prenom"=> $prenom,
                ":pseudo"=> $pseudo,
                ":dateNaissance"=> $dateNaissance,
                ":adresse"=> $adresse,
                ":mail"=> $mail,
                ":lienPhotoProfil" => $lienPhotoProfil
            ]);
        }

        public static function insererUtilisateur($nomUtilisateur, $prenomUtilisateur, $pseudo, $mdp, $ddn,$email,$adresse,$lienPdp){
            $requete = "SELECT max(idUtilisateur)+1 FROM `Utilisateur` WHERE 1; ";
            $resultat = Connexion::pdo()->query($requete);
            $idMax=$resultat->fetchColumn();

            $requete = "INSERT INTO Utilisateur (
                            idUtilisateur, pseudo, mdp, nom, prenom, dateNaissance, mail, adresse, estVerifie, lienPhotoProfil
                        ) VALUES (
                            :idUtilisateur, :pseudo, PASSWORD(:mdp), :nom, :prenom, :dateNaissance, :mail, :adresse, :estVerifie, :lienPhotoProfil
                        );";
                        //PASSWORD est la fonction de hash de mySQL
    
            $statement = Connexion::pdo()->prepare($requete);
            $statement->execute([
                ':idUtilisateur' => $idMax,
                ':pseudo' => $pseudo,
                ':mdp' => $mdp, 
                ':nom' => $nomUtilisateur,
                ':prenom' => $prenomUtilisateur,
                ':dateNaissance' => $ddn,
                ':mail' => $email,
                ':adresse' => $adresse,
                ':estVerifie' => 0, //on met false car un utilisateur qui vient d'être crée ne peut être vérifié
                ':lienPhotoProfil' => $lienPdp
            ]);
        }

        public static function connexion($log,$mdp){
            //on hash le mot de passe dès le début pour éviter de trop manipuler la version en clair
            $requete = "select PASSWORD(:mdp) as mdp";
            $statement = Connexion::pdo()->prepare($requete);
            $statement->execute([':mdp' => $mdp]);
            $mdpHash = $statement->fetch(PDO::FETCH_ASSOC)['mdp'];

            
            $id=Utilisateur::verifLogin($log);
            if($id>=0){
                return Utilisateur::verifMdp($id,$mdpHash) ? $id : false;  //si le login marche il renvoie un id qui est forcément > 0 donc interprété comme true si on veut un bool
            }                                           //peu importe ce qui foire entre le login et le mdp ça renverra false donc mdp erreur sera : login ou mdp incorrect
            return false; 
            
        }


        public static function verifLogin($log /*log est soit un email soit un pseudo*/){
                      //pour distinguer pseudo ou email -> on vérifie si il y a un @ dans le string, les @ sont interdits dans les pseudos mais tjrs présents dans les emails
            $estEmail = false;
            foreach (mb_str_split($log) as $char) {
                if($char=='@'){
                    $estEmail=true;
                    break;
                }
            }
            $valLogin = $estEmail ? "mail" : "pseudo" ;      
            $requete = "SELECT idUtilisateur FROM `Utilisateur` WHERE $valLogin = :logu"; //pour quelconque raison les noms de colonnes ne peuvent pas être mis avec des prepare statement                                                                        
            $statement = Connexion::pdo()->prepare($requete);  // du coup le prepare est pas ouf mais je le garde par ego
            $statement->execute([
                ':logu' => $log
            ]);
            return $statement->fetch(PDO::FETCH_ASSOC)['idUtilisateur'] ?? -1;  //return l'idUtilisateur obtenu à la requete et -1 s'il n'y en a pas
        }


        public static function verifMdp($idUser,$hashMdp){
            $requete = "select mdp from `Utilisateur` WHERE idUtilisateur= :log ";
            $statement = Connexion::pdo()->prepare($requete);
            $statement->execute([':log' => $idUser]);
            $resultat = $statement->fetch(PDO::FETCH_ASSOC)['mdp'];
            return $hashMdp==$resultat;
        }

        public static function getUtilisateur($idUtilisateur){
            $requete = "SELECT idUtilisateur, pseudo, nom, prenom, estVerifie, lienPhotoProfil FROM Utilisateur WHERE idUtilisateur = $idUtilisateur;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Utilisateur");
            
            $User = $resultat->fetch();
            $User->listeGroupes = Groupe::getGroupesUtilisateur($idUtilisateur);
            return $User;
        }


        public function getGroupe($idGroupe){
            foreach($this->listeGroupes as $groupe){
                if ($groupe->get('idGroupe') == $idGroupe){
                    return $groupe;
                }
            }
            return -1;
        }

        public function addGroupe($groupe){
            $this->listeGroupes[] = $groupe;
        }

        public function __toString(){
            return "<h3>Utilisateur</h3>
                    <p>id : $this->idUtilisateur<br>
                       pseudo : $this->pseudo<br>
                       nom : $this->nom<br>
                       prenom : $this->prenom<br>
                       photo de Profil : $this->lienPhotoProfil<br>
                       numéro de role : $this->role</p>";
        }
        public function getAllInfoUtilisateur(){
            $requete = "select pseudo,nom,prenom,dateNaissance,mail,adresse,estVerifie from `Utilisateur` WHERE idUtilisateur= :log ";
            $statement = Connexion::pdo()->prepare($requete);
            $statement->execute([':log' => $this->idUtilisateur]);
            $resultat = $statement->fetch(PDO::FETCH_ASSOC);
            return $resultat;
        }

        public function display(){
            echo $this;

            foreach ($this->listeGroupes as $elem){
                $elem->display();
            }
        }



    }
?>