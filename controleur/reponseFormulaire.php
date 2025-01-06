<?php
    Class ReponseFormulaire{
        
        public static function reponseProposerVote(){
            include('vues/debut.php');
            echo '<main>';
            include("reponseProposerVote.php");
            echo '</main>';
            include('vues/footer.html');
            include('vues/fin.html');
        }

        public static function reponseCreerGroupe(){
            include('vues/debut.php');
            echo '<main>';
            include("reponseCreerGroupe.php");
            echo '</main>';
            include('vues/footer.html');
            include('vues/fin.html');
        }
    }
?>