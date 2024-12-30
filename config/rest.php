<?php 
Class Rest{
    public static function getGroupe(int $idGroupe){
        $requete = "SELECT idGroupe, nomGroupe FROM Groupe WHERE idGroupe = $idGroupe;";
        $resultat = Connexion::pdo()->query($requete);
        $resultat->setFetchmode(PDO::FETCH_CLASS,"Groupe");
        
        $data = $resultat->fetch(PDO::FETCH_ASSOC);

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    public static function getUtilisateur($idUtilisateur){
        $requete = "SELECT * FROM Utilisateur WHERE idUtilisateur = $idUtilisateur;";
        $resultat = Connexion::pdo()->query($requete);

        return json_encode($resultat->fetch(PDO::FETCH_ASSOC),JSON_UNESCAPED_UNICODE);
    }

    /*
        ATTENTION: si json_encode() ou getJSON() ne fonctionne plus, c'est de la faute de Vianney (moi)
        car les DateTime et les DateInterval n'ont pas de méthode __toString() (il faut utiliser leur méthode format())
    */
    public static function getVote(int $idVote, int $idUser=NULL){
        $vote = Vote::getVote($idVote, $idUser);

        return json_encode((array) $vote,JSON_UNESCAPED_UNICODE);
        //Vote va garder un json fucked up pour l'instant TODO : creer une fonction to_array pour Vote
    }
}

?>