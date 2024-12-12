<div id="default">
    <h1>Connexion à DPS3</h1>
    <?php 
    if (isset($_SESSION['previous'])) {
        if (  "connexion" != $_SESSION['previous']) {
            session_destroy();
        }
    }
    ?> 
    <form action="controleur/reponseConnexionUtilisateur.php" method="POST" enctype="multipart/form-data">

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
        if(isset($_GET["erreur"])){
                $nb = $_GET["erreur"];
                echo "Tentative numéro : $nb ";
                echo "<input id=\"erreur\" name=\"erreur\" type=\"hidden\" value=$nb />";
            } 
        
        
        ?>

        <input id="submit" type="submit" value="S'inscrire">
    </form>
</div>

