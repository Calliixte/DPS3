<?php
    Class Vote{
        private int $idVote;
        private string $titreVote;
        private Groupe $groupe;
        private array $choixVote;

        public function get($attribute){
            return $this->$attribute;
        }

        public function set($attribute, $val){
            $this->$attribute = $val;
        }

        public function __construct(int $idVote=NULL, string $titreVote=NULL){
            if(!is_null($idVote)){
                $this->idVote = $idVote;
                $this->titreVote = $titreVote;
            }
        }

        public static function getVote(int $idVote){
            $requete = "SELECT idVote, titreVote FROM Vote WHERE idVote = $idVote;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Vote");
            
            return $resultat->fetch();
        }

        public function fillChoixVote($idUser){
            $requete = "SELECT intitule, CountVoteChoix(idChoixVote) AS nbVote FROM ChoixVote WHERE idVote=$this->idVote;";
            $resultat = Connexion::pdo()->query($requete);
            
            $i = 0;
            while ($row = $resultat->fetch()) {
                $this->choixVote[$i]['intitule'] = $row['intitule'];
                $this->choixVote[$i]['nbVote'] = $row['nbVote'];
                $i++;
            }
        }

        public function aChoisi($idUser, $idChoixVote){
            $requete = "SELECT COUNT(*) FROM idChoixMembre 
                        WHERE idChoixVote = $idChoixVote
                        AND idUtilisateur = $idUser
                        AND idGroupe = $groupe->get(idGroupe)";

        $resultat = Connexion::pdo()->query($requete);

            echo "<pre>";
            print_r($resultat->fetchAll());
            echo "</pre>";
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
        }
    }
?>