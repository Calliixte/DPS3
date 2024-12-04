<?php
    Class Groupe{
        private int $idGroupe;
        private string $nomGroupe;
        private int $Membres= array();

        public function __construct($idGroupe=NULL, $nomGroupe=NULL){
            if(!is_null(idGroupe)){
                $this->idGroupe = $idGroupe;
                $this->nomGroupe = $nomGroupe;
            }
        }

        public function ___toString(){
            return "<h3> Groupe </h3>
                    <p>id : $this->idGroupe<br>
                       nom : $this->nomGroupe</p>";
        }

        public function display(){
            echo $this;
        }
    }
?>