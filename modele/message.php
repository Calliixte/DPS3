<?php
    Class Message{
        private int $idMessage;
        private int $idAuteur;
        private string $texte;
        private string $dateEnvoi;
        private array $listeReactions;

        public function get($attribute){
            return $this->$attribute;
        }

        public function set($attribute, $val){
            $this->$attribute = $val;
        }

        public static function getMessages(int $idVote){
            $requete = "SELECT idMessage, idUtilisateur AS idAuteur, texte, dateEnvoi FROM Message WHERE idVote = $idVote;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Message");
            
            $listeMessages = $resultat->fetchAll();

            foreach($listeMessages as $message){
                $message->listeReaction = Reaction::getReactionMessage($message->idMessage);
            }

            return $listeMessages;
        }
    }
?>