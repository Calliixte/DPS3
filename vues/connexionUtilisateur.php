<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Upload</title>

</head>
<body>

<h1>Inscription à DPS3</h1>
<?php 
if (isset($_SESSION['previous'])) {
    if (  "connexion" != $_SESSION['previous']) {
         session_destroy();
         ### or alternatively, you can use this for specific variables:
         ### unset($_SESSION['varname']);
    }
 }
?> 
<form action="../controleur/reponseConnexionUtilisateur.php" method="POST" enctype="multipart/form-data">

    <label for="u_addr">Email ou Nom d'utilisateur</label>
    <input type="text" id="u_addr" name="login_utilisateur" placeholder="Email ou Login">			
    
    <label for="u_password">
        Mot de passe
    </label>
    <input id="u_password"
        name="password_utilisateur"
        type="password"
        required
        placeholder="***"
    />
    <?php 
    if(isset($_POST["erreur"])){
        if ($_POST["erreur"]){
            echo "Login ou Mot de passe incorrect, veuillez réessayer";
        } 
    }
    ?>

    <input type="submit" value="S'inscrire">
</form>

</body>
</html>
