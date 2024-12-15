<?php
          
    Class ControleurGroupe{
        
        public static function getGroupe(){
            $idGroupe = $_GET['id'];
            
            return $_SESSION['utilisateurCourant']->getGroupe($idGroupe);
        }
        public static function getRoleMembre($idUser,$idGroup){
            $idRole = null;
            $requete = "SELECT idRole FROM `Membre` WHERE idUtilisateur=? and idGroupe = ?; ";
            $stmt = Connexion::pdo()->prepare($requete);
            $stmt->bindParam(1, $idUser, PDO::PARAM_INT);
            $stmt->bindParam(2, $idGroup, PDO::PARAM_INT); 
            $stmt->execute();
            $idRole=$stmt->fetchColumn();
            return $idRole;
        }

        public static function afficherGrandGroupe(){
            $groupe = ControleurGroupe::getGroupe();
            $_SESSION['groupeCourant']=$groupe; //attention à ça ça peut causer des problemes
            $_SESSION['utilisateurCourant']->set('role',getRoleMembre($_SESSION['utilisateurCourant']->get('idUtilisateur'),$groupe->get('idGroupe')) ?? 0);
                                            //on met le role                  a la valeur du groupe pour l'idUser et l'id Groupe            si la fonction renvoie null on met membre
            $nomG = $groupe->get("nomGroupe");
            $titre= $nomG;
            $styleSpecial = '';
            include('vues/debut.php');
            ControleurApplication::afficherHeader();
            echo '<main>';
            echo "<h1> $nomG </h1>";
            echo "<div id=\"my-groups-bottom-grad\"></div>";
            $popup = "#popup-regles";
            $reglesGroupe = $groupe ->getRegles();
            echo "<a href=$popup>Règles de la communauté </a>";
            echo "Récent <br/>"; // ATTENTION POUR LE CSS YA UN BR ICI ------------------------------------------------------------------------------------------------------------------
            $liste=$groupe->get("listeVote");
            for($i = 0;$i<count($liste);$i++){
                //   /!\    $liste[$i] est un objet Vote
                // if($liste[$i]->get('accepte')){
                    $liste[$i]->fillEtiquettes();
                    $idVote = $liste[$i]->get("idVote");
                    $titreVote = $liste[$i]->get("titreVote");
                    $listeEtiquette = $liste[$i]->get("listeEtiquettes");
                    //$dateCreation = $liste[$i]->get("dateCreation");
                    $description = $liste[$i]->getDescription(); 
                    $idvkw=$i;
                    $url = "routeur.php?controleur=controleurVote&action=afficherVoteGros&id=$idvkw";
                    $txt = "Voter";
                    if ($_SESSION['utilisateurCourant']->get('role')==2){ //est administrateur 
                    $urlSuppr = "routeur.php?controleur=controleurVote&action=supprimerVote&id=$idvkw";
                    $txtSuppr = "Voter";
                    }
                    include('vues/petitVote.php');
                // }
                
            }
            $groupe->display();
            echo "<a href=vues/formulaireVote.php>nouvelle proposition</a>";
            echo "<a href=routeur.php?controleur=controleurVote&action=afficherNonAcceptes>Voir les propositions en cours de traitement</a>";

            echo '</main>';
            include('vues/footer.html');
            include('vues/popups/addGroup.php');
            include('vues/fin.html');
        }




        public static function afficherNonAcceptes(){
            $liste=$_SESSION['groupeCourant']->get("listeVote");
            for($i = 0;$i<count($liste);$i++){
                //   /!\    $liste[$i] est un objet Vote
                // if(!$liste[$i]->get('accepte')){ //par rapport à l'autre y'a un not devant le boolean
                    $liste[$i]->fillEtiquettes();
                    $idVote = $liste[$i]->get("idVote");
                    $titreVote = $liste[$i]->get("titreVote");
                    $listeEtiquette = $liste[$i]->get("listeEtiquettes");
                    //$dateCreation = $liste[$i]->get("dateCreation");
                    $description = $liste[$i]->getDescription(); 
                    $url = "vues/accepterVote.php?id=$idVote&titre=$titreVote";
                    $txt = "Accepter la proposition";
                    include('vues/petitVote.php');
                // }
                
            }
        }

        public static function afficherVotes(){
            $groupe = ControleurGroupe::getGroupe();
            $listeVote = $groupe->get('listeVote');
            // include("vue/listeVote.php");
            foreach($listeVote as $vote){
                $vote->display();
            }
            echo "afficher votes du groupe numéro $idGroupe";
        }
        
        public static function afficherRegle(){
            $groupe = ControleurGroupe::getGroupe();
            $regles = $groupe->get('regles');
            // include("vue/regles.php");
            echo "les règles du groupe numéro $idGroupe";
        }

        public static function afficherPetitGroupe(){
            $groupe = ControleurGroupe::getGroupe();
            $id = $groupe->get('idGroupe');

            echo "petit groupe $i";
            // include("vue/petitGroupe.php");
            echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherGrandGroupe> rejoindre un groupe </a>";
        }
    }
?>