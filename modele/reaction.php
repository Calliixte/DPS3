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

        public static function getReactionsMessage($idMessage){
            $requete = "SELECT idUtilisateur, unicodeEmoticone FROM ReactionMessage WHERE idMessage = $idMessage;";
            
            $resultat = Connexion::pdo()->query($requete);
            
            $i = 0;
            while($row = $resultat->fetch()){
                $listeReactions[$i] = new Reaction(Utilisateur::getUtilisateur($row['idUtilisateur']),$row['unicodeEmoticone']);
                $i++;
            }
        }

        public function __toString(){
            return "<h3> Groupe </h3>
                    <p>auteur : $this->auteur<br>
                       emoticone : $this->emoticone</p>";
        }
    }
?>