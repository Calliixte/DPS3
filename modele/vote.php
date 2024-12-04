<?php
    Class Vote{
        private int $idVote;
        private string $titreVote;
        private array $choixMembre;

        public __construct(int $idVote=NULL, string $titreVote=NULL){
            if(!is_null($idVote)){
                $this->idVote = $idVote;
                $this->titreVote = $titreVote;
            }
        }

        public static function getVote(int $idVote){
            $requete = "SELECT idVote, titreVote FROM Vote WHERE idVote = $idVote;";
            $resultat = Connexion::pdo()->query($requete);
            $resultat->setFetchmode(PDO::FETCH_CLASS,"Vote");
            
            return $resultat->fetch();
        }

        public __toString(){
            return "<h3>Vote</h3>
                    <p>id : $idVote<br>
                       titre : $titreVote</p>";
        }

        public display(){
            echo $this;
        }
    }
?>