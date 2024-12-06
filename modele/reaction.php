<?php
    Class Reaction{
        private int $idAuteur;
        private string $emoticone;

        public function __construct(int $idAuteur=NULL, string $emoticone=NULL){
            if(!is_null($idAuteur)){
                $this->idAuteur = $idAuteur;
                $this->emoticone = $emoticone;
            }
        }

        public static function getReactionMessage($idMessage){
            $requete = "SELECT idUtilisateur, unicodeEmoticone FROM ReactionMessage WHERE idMessage = $idMessage;";
            
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Reaction");
            
            return $resultat->fetchAll();
        }

        public static function getReactionVote($idVote){
            $requete = "SELECT idUtilisateur, unicodeEmoticone FROM ReactionMessage WHERE idVote = $idVote;";
            
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Reaction");
            
            return $resultat->fetchAll();
        }

        public function __toString(){
            return "<h3> Groupe </h3>
                    <p>auteur : $this->auteur<br>
                       emoticone : $this->emoticone</p>";
        }
    }
?>