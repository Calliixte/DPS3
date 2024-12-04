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

        public static function getVote(int $idVote, int $idUser){
            $requete = "SELECT idVote, titreVote FROM Vote WHERE idVote = $idVote;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Vote");
            
            $vote = $resultat->fetch();
            $vote->fillChoixVote($idUser);
            
            return $vote;
        }

        public function fillChoixVote($idUser){
            $requete = "SELECT idChoixVote, intitule, CountVoteChoix(idChoixVote) AS nbVote FROM ChoixVote WHERE idVote=$this->idVote;";
            $resultat = Connexion::pdo()->query($requete);
            
            $i = 0;
            while ($row = $resultat->fetch()) {
                $aVote = $this->aChoisi($idUser, $row['idChoixVote']);
                
                $this->choixVote[$row['intitule']] = array ('nbVote' => $row['nbVote'],
                                                            'aVote' => $aVote);
                $i++;
            }
        }

        public function aChoisi(int $idUser, int $idChoixVote){
            $idGroupe = $this->groupe->get('idGroupe');

            $requete = "SELECT COUNT(*) AS 'nbVote' FROM ChoixMembre 
                        WHERE idChoixVote = $idChoixVote
                        AND idUtilisateur = $idUser
                        AND idGroupe = $idGroupe;";

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
        }
    }
?>