<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Image Upload</title>
    </head>
    <body>
        <pre>
            <?php
                require_once("../config/connexion.php");
                require_once("../modele/groupe.php");
                require_once("../modele/utilisateur.php");
                session_start();

                Connexion::connect(); //Fichier appelé en dehors du routeur, on doit donc relancer une connexion

                if(isset($_POST["voteBlancCompte"])){
                    $voteBlancCompte = 1;
                }else{
                    $voteBlancCompte = 0;
                }

                $idGroupe = Groupe::insererGroupe($_POST["nomGroupe"],$_POST["description"], $_POST["regles"], $voteBlancCompte);
                $idUser = $_SESSION["utilisateurCourant"]->get("idUtilisateur");
                $idRole = 2; //id du role Administrateur dans la base (provisoire, à modifier)
                Groupe::insererMembre($idUser, $idGroupe, $idRole);

                echo "Groupe créé !";
            ?>
        </pre>
    </body>
</html>