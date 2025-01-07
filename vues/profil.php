<body>
    <div id="default">
        <h1>Profil et informations</h1>
        <div id="profil">
            <?php
            echo"<div id=\"verif\">";
            if($infoUtilisateur["estVerifie"]){
                echo "<p>Votre profil est vérifié</p> <p class=\"emote\">✅</p>";
            }else{
                echo "<p>Votre profil n'est pas vérifié</p> <p class=\"emote\">❌</p>";
            }
            echo"</div>";
            echo "<h2> Mes informations </h2>";
            echo"<div id=\"userInfo\">";
            $prenom =$infoUtilisateur["prenom"];
            $nom =$infoUtilisateur["nom"];
            $pseudo = $infoUtilisateur["pseudo"];
            $mail =$infoUtilisateur["mail"];
            $adresse =$infoUtilisateur["adresse"];
            $dateNaissance =$infoUtilisateur["dateNaissance"];

            $class = "infoValue"; //Plus facile à manipuler de cette manière
            echo "<p>Prénom :</p> <p class=$class>$prenom</p>";
            echo "<p>Nom :</p> <p class=$class>$nom</p>";
            echo "<p>Pseudo :</p> <p class=$class>$pseudo</p>";
            echo "<p>E-mail :</p> <p class=$class>$mail</p>";
            echo "<p>Adresse :</p> <p class=$class>$adresse</p>";
            echo "<p>Date de naissance :</p> <p class=$class>$dateNaissance</p>";
            echo "</div>";
            ?>
            <a href="routeur.php?controleur=controleurUtilisateur&action=modifierProfil">Modifier</a>
        </div>
    </div>
</body>