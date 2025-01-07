<?php
    Class ReponseFormulaire{
        
        // Faudra penser à globaliser tout ça (sûrement avec un $_GET[formulaire])
        public static function reponse(){
            if(isset($_GET["form"])){
                $formulaire = $_GET["form"];
            } else{
                echo "Erreur : aucun formulaire spécifié";
                exit();
            }

            include('vues/debut.php');
            echo '<main>';
            include("reponse$formulaire.php");
            echo '</main>';
            include('vues/footer.html');
            include('vues/fin.html');
        }
    }
?>