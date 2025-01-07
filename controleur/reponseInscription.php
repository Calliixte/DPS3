<pre>
    <?php
        $target_file ="";

        $requete = "SELECT max(idUtilisateur)+1 FROM `Utilisateur` WHERE 1; ";
        $resultat = Connexion::pdo()->query($requete);
        $idMax=$resultat->fetchColumn();

        $link = Server::uploadImage($_FILES["u_photo"]["tmp_name"], "img/profilePicture/", basename($_FILES["u_photo"]["name"]), (string)$idMax);
        
        $servUrl = "https://$_SERVER[HTTP_HOST]".dirname($_SERVER['PHP_SELF']);
       
        $path = $servUrl.$link;

        foreach($_POST as $val ){
            echo $val;
            echo "\n";
        }
        echo $_POST["adresse_utilisateur"];

        Utilisateur::insererUtilisateur($_POST["nom_utilisateur"],$_POST["prenom_utilisateur"],$_POST["pseudo_utilisateur"],$_POST["password_utilisateur"],date_format(date_create($_POST["u_ddn"]), 'Y-m-d 0:0:0'),$_POST["email_utilisateur"],$_POST["adresse_utilisateur"],$path);        
        $url = "routeur.php?action=afficherConnexion&actionConnexion=Connexion";
        echo "Vous avez bien été inscrit(e) ! ";
        echo " <meta http-equiv=\"refresh\" content=\"0; url=$url\"> " //redirige vers l'url donnée au bout de 0 secondes, modifier le 0 ou commenter la ligne si on veut voir la page de debug
    ?>
</pre>
