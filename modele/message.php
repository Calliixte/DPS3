<?php
    Class Message{
        private Utilisateur $auteur;
        private Vote $vote;
        private string $texte;
        private string $dateEnvoi;
        private array $listeReactions;

        public static function getMessages(Vote $vote){
            $requete = "SELECT texte, dateEnvoi FROM Message WHERE idVote = $vote->get('idVote');"
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Message");
            
            $listeMessages = $resultat->fetchAll();

            foreach($listeMessages as $message){
                $message->vote = $vote;
                $message->fillReaction();
            }

            return $listMessages;
        }

        public function fillReaction(){
            $requete = "SELECT idUtilisateur, unicodeEmoticone FROM ReactionMessage;";
            
            $resultat = Connexion::pdo()->query($requete);
            
            $i = 0;
            while($row = $resultat->fetch()){
                $listeReactions[$i] = Reaction(getUtilisateur($row['idUtilisateur']),$row['unicodeEmoticone']);
                $i++;
            }
        }
    }
?>