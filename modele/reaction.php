<?php
    Class Reaction{
        private Utilisateur $auteur;
        private string $emoticone;

        public function __construct(Utilisateur $auteur=NULL, string $emoticone=NULL){
            if(!is_null($auteur)){
                $this->auteur = $auteur;
                $this->emoticone = $emoticone;
            }
        }

        public function __toString(){
            return "<h3> Groupe </h3>
                    <p>auteur : $this->auteur<br>
                       emoticone : $this->emoticone</p>";
        }
    }
?>