<?php
    Class Message{
        private int $idMessage;
        private int $idAuteur;
        private string $texte;
        private DateTime $dateEnvoi;
        private array $listeReactions;

        public function __contruct(int $idMessage= NULL, int $idAuteur= NULL, string $texte= NULL, string $dateEnvoi= NULL) {
            $this->idMessage = $idMessage;
            $this->idAuteur = $idAuteur;
            $this->texte = $texte;
            $this->dateEnvoi = new DateTime($dateEnvoi);
        }

        public function get($attribute){
            return $this->$attribute;
        }

        public function set($attribute, $val){
            $this->$attribute = $val;
        }

        public static function getMessages(int $idVote){
            $requete = "SELECT idMessage, idUtilisateur AS idAuteur, texte, dateEnvoi FROM Message WHERE idVote = $idVote;";
            $resultat = Connexion::pdo()->query($requete);
            
            $listeMessages = [];
            while($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $message = new Message(... $ligne);
                $message->listeReaction = Reaction::getReactionMessage($message->idMessage);
                $listeMessages[] = $message;
            }

            return $listeMessages;
        }
    }
?>