<?php
    Class Message{
        private int $idMessage;
        private Utilisateur $auteur;
        private string $texte;
        private string $dateEnvoi;
        private array $listeReactions;

        public function get($attribute){
            return $this->$attribute;
        }

        public function set($attribute, $val){
            $this->$attribute = $val;
        }

        public static function getMessages(Vote $vote){
            $idVote = $vote->get('idVote');
            $requete = "SELECT idMessage, texte, dateEnvoi FROM Message WHERE idVote = $idVote;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Message");
            
            $listeMessages = $resultat->fetchAll();

            foreach($listeMessages as $message){
                $message->fillReaction();
            }

            return $listeMessages;
        }

        public function fillReaction(){
            $requete = "SELECT idUtilisateur, unicodeEmoticone FROM ReactionMessage WHERE idMessage = $this->idMessage;";
            
            $resultat = Connexion::pdo()->query($requete);
            
            $i = 0;
            while($row = $resultat->fetch()){
                $listeReactions[$i] = new Reaction(Utilisateur::getUtilisateur($row['idUtilisateur']),$row['unicodeEmoticone']);
                $i++;
            }
        }
    }
?>