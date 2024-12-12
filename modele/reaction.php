<?php
    Class Reaction{
        private int $idAuteur;
        private string $emoticone;

        public function get($attribute){
            return $this->$attribute;
        }

        public function set($attribute, $val){
            $this->$attribute = $val;
        }

        public function __construct(int $idAuteur=NULL, string $emoticone=NULL){
            if(!is_null($idAuteur)){
                $this->idAuteur = $idAuteur;
                $this->emoticone = $emoticone;
            }
        }

        public static function getReactionMessage($idMessage){
            $requete = "SELECT idUtilisateur AS idAuteur, unicodeEmoticone AS emoticone FROM ReactionMessage WHERE idMessage = $idMessage;";
            
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Reaction");
            
            return $resultat->fetchAll();
        }

        public static function getReactionVote($idVote){
            $requete = "SELECT idUtilisateur AS idAuteur, unicodeEmoticone AS emoticone FROM ReactionVote WHERE idVote = $idVote;";
            
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Reaction");
            
            return $resultat->fetchAll();
        }

        public function __toString(){
            return "<p>auteur : $this->idAuteur<br>
                    emoticone : $this->emoticone</p>";
        }
    }
?>