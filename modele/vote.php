<?php
    Class Vote{
        private int $idVote;
        private string $titreVote;
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

        public function __construct(int $idVote=NULL, string $titreVote=NULL){
            if(!is_null($idVote)){
                $this->idVote = $idVote;
                $this->titreVote = $titreVote;
            }
        }

        public static function getVote(int $idVote, int $idUser=NULL){
            $requete = "SELECT idVote, titreVote FROM Vote WHERE idVote = $idVote;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Vote");
            $vote = $resultat->fetch();
            $vote->fillChoixVote($idUser);
            $vote->fillEtiquettes();
            $vote->listeMessages = Message::getMessages($idVote);
            $vote->listeReactions = Reaction::getReactionMessage($idVote);
            return $vote;
        }

        public static function getVotesGroupe($idGroupe){
            $requete = "SELECT idVote, titreVote FROM Vote WHERE idGroupe = $idGroupe";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Vote");
            $listeVote = $resultat->fetchAll();

            foreach($listeVote as $vote){
                $vote->fillChoixVote();
                $vote->fillEtiquettes();
                $vote->set('listeMessages', Message::getMessages($vote->idVote));
            }

            return $listeVote;
        }

        public static function getJSON(int $idVote, int $idUser=NULL){
            $vote = Vote::getVote($idVote, $idUser);

            return json_encode((array) $vote,JSON_UNESCAPED_UNICODE);
            //Vote va garder un json fucked up pour l'instant TODO : creer une fonction to_array pour Vote
        }


        public function fillEtiquettes(){
            $requete = "SELECT labelEtiquette 
                        FROM EtiquetteVote EV INNER JOIN Etiquette E
                        ON EV.idEtiquette = E.idEtiquette
                        WHERE idVote=$this->idVote;";

            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_COLUMN, 0);
            
            $this->listeEtiquettes = $resultat->fetchAll();
        }

        public function fillChoixVote($idUser=NULL){
            $requete = "SELECT idChoixVote, intitule, CountVoteChoix(idChoixVote) AS nbVote FROM ChoixVote WHERE idVote=$this->idVote;";
            $resultat = Connexion::pdo()->query($requete);
            
            if(!is_null($idUser)){
                while ($row = $resultat->fetch()) {
                    $aVote = $this->aChoisi($idUser, $row['idChoixVote']);
                    
                    $this->choixVote[$row['intitule']] = array ('nbVote' => $row['nbVote'],
                                                                'aVote' => $aVote);
                }
            }else{
                while ($row = $resultat->fetch()) {
                    $this->choixVote[$row['intitule']] = array ('nbVote' => $row['nbVote']);
                }
            }
        }

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
        }
    }
?>