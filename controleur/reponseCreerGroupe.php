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
                require_once("../config/server.php");
                require_once("../modele/groupe.php");
                require_once("../modele/utilisateur.php");
                session_start();

                Connexion::connect(); //Fichier appelé en dehors du routeur, on doit donc relancer une connexion

                //Checkbox, on si elle n'est pas coché elle ne sera pas transmise
                $voteBlancCompte = isset($_POST["voteBlancCompte"]); 

                $idGroupe = Groupe::insererGroupe($_POST["nomGroupe"],$_POST["description"], $_POST["regles"], $voteBlancCompte);
                $idUser = $_SESSION["utilisateurCourant"]->get("idUtilisateur");
                $idRole = 2; //id du role Administrateur dans la base (provisoire, à modifier)
                
                Groupe::insererMembre($idUser, $idGroupe, $idRole);

                $linkBanniere = Server::uploadImage($_FILES["imageBanniere"]["tmp_name"], "../img/GroupPicture/", basename($_FILES["imageBanniere"]["name"]), (string)$idGroupe);
                
                $linkIcone = Server::uploadImage($_FILES["imageIcone"]["tmp_name"], "../img/GroupPicture/", basename($_FILES["imageIcone"]["name"]), (string)$idGroupe."_icon");

                $url = "../routeur.php";
                echo "Groupe créé !";
                echo " <meta http-equiv=\"refresh\" content=\"1; url=$url\"> "; //redirige vers l'url donnée au bout de 0 secondes, modifier le 0 ou commenter la ligne si on veut voir la page de debug

            ?>
        </pre>
    </body>
</html>