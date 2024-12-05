<?php
    Class Vote{
        private int $idVote;
        private string $titreVote;
        private Groupe $groupe;
        private array $choixVote;
        private array $listeEtiquettes;
        private array $listeMessages;

        public function get($attribute){
            return $this->$attribute;
        }

        public function set($attribute, $val){
            $this->$attribute = $val;
        }

        public function __construct(int $idVote=NULL, string $titreVote=NULL, Groupe $groupe=NULL){
            if(!is_null($idVote)){
                $this->idVote = $idVote;
                $this->titreVote = $titreVote;
                $this->groupe = $groupe;
            }
        }

        public static function getVote(int $idVote, int $idUser, Groupe $groupe){
            $requete = "SELECT idVote, titreVote FROM Vote WHERE idVote = $idVote;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Vote");
            
            $vote = $resultat->fetch();
            $vote->set('groupe', $groupe);
            $vote->fillChoixVote($idUser);
            $vote->fillEtiquettes();
            $this->listeMessages = Message::getMessages($this);
            return $vote;
        }

        public static function getJSON(int $idVote, int $idUser, Groupe $groupe){
            $requete = "SELECT idVote, titreVote FROM Vote WHERE idVote = $idVote;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Vote");
            
            $vote = $resultat->fetch();
            $vote->set('groupe', $groupe);
            $vote->fillChoixVote($idUser);
            $vote->fillEtiquettes();

            return json_encode((array) $vote,JSON_UNESCAPED_UNICODE);
        }

        public function fillReaction(){
            $requete = "SELECT idUtilisateur, unicodeEmoticone FROM ReactionVote;";
            
            $resultat = Connexion::pdo()->query($requete);
            
            $i = 0;
            while($row = $resultat->fetch()){
                $listeReactions[$i] = Reaction(getUtilisateur($row['idUtilisateur']),$row['unicodeEmoticone']);
                $i++;
            }
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

        public function fillChoixVote($idUser){
            $requete = "SELECT idChoixVote, intitule, CountVoteChoix(idChoixVote) AS nbVote FROM ChoixVote WHERE idVote=$this->idVote;";
            $resultat = Connexion::pdo()->query($requete);
            
            while ($row = $resultat->fetch()) {
                $aVote = $this->aChoisi($idUser, $row['idChoixVote']);
                
                $this->choixVote[$row['intitule']] = array ('nbVote' => $row['nbVote'],
                                                            'aVote' => $aVote);
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
            echo "<pre>";
            print_r($this->listeEtiquettes);
            echo "</pre>";
        }
    }
?>