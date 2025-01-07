<?php
    Class ReponseFormulaire{
        
        public static function reponse(){
            if(isset($_GET["form"])){
                $formulaire = $_GET["form"];
            } else{
                echo "Erreur : aucun formulaire spécifié";
                exit();
            }
            $titre = "Chargement";

            include('vues/debut.php');
            echo '<main>';
            include("reponse$formulaire.php");
            echo '</main>';
            include('vues/footer.html');
            include('vues/fin.html');
        }
    }
?>