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

        public static function supprimerMessage($idMessage){
            $requetePreparee = Connexion::pdo()->prepare("DELETE FROM Message where idMessage= :log");
            $requetePreparee -> bindParam(':log',$idMessage);
            try{
              $requetePreparee->execute();
            }catch(PDOException $e){echo $e->getMessage();}
        }
        

        public static function ajouterReaction($idAuteur,$idGroupe,$idMessage,$emoji){
            try{
            $sql = "INSERT INTO ReactionMessage (idUtilisateur, idGroupe, idMessage, unicodeEmoticone) 
            VALUES (:idAuteur, :idGroupe, :idMessage, :emoji)";
    
            $stmt = Connexion::pdo()->prepare($sql);
            $stmt->bindParam(':idAuteur', $idAuteur, PDO::PARAM_INT);
            $stmt->bindParam(':idGroupe', $idGroupe, PDO::PARAM_INT);
            $stmt->bindParam(':idMessage', $idMessage, PDO::PARAM_INT);
            $stmt->bindParam(':emoji', $emoji, PDO::PARAM_STR);

            // Exécution de la requête
            $stmt->execute();
            return "Réaction ajoutée avec succès.";
            } catch (PDOException $e) {
                // Gérer les erreurs de connexion ou d'exécution
                return "Erreur : " . $e->getMessage();
            }   
        }
    }
?>