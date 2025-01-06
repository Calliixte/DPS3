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
            $_SESSION['groupeCourant'] = $groupe; //attention à ça ça peut causer des problemes
            $_SESSION['utilisateurCourant']->set('role',$groupe->getRoleMembre($_SESSION['utilisateurCourant']->get('idUtilisateur')) ?? 0);
            //                                  on met le role                  a la valeur du groupe pour l'idUser et l'id Groupe            si la fonction renvoie null on met membre
            $nomG = $_SESSION['groupeCourant']->get("nomGroupe");
            
            $titre = $nomG; //On défini le titre de la page
            $styleSpecial = '';
            include('vues/debut.php');
            ControleurApplication::afficherHeader();
            echo '<main>';

            $_SESSION['groupeCourant']->fillEtiquettes();
            $listeEtiquette = $_SESSION['groupeCourant']->get('listeEtiquette');

            echo '<div id="default">';
            echo "<h1> $nomG </h1>";
            echo '<div id="groupe">';
            $popup = "#popup-regles";
            $reglesGroupe = $_SESSION['groupeCourant']->getRegles();
            echo "<a href=$popup>Règles de la communauté </a>";
            echo "Récent <br/>"; // ATTENTION POUR LE CSS YA UN BR ICI ------------------------------------------------------------------------------------------------------------------
            $liste=$groupe->get("listeVote");
            for($i = 0;$i<count($liste);$i++){
                //   /!\    $liste[$i] est un objet Vote
                if($liste[$i]->get('propositionAcceptee')){
                    $liste[$i]->verifierDelaiDiscussion(); //On vérifie si la discussion est ouverte
                    $liste[$i]->verifierDelaiVote(); //On vérifie si le vote est ouvert
                    $liste[$i]->fillEtiquettes();

                    $idVote = $liste[$i]->get("idVote");
                    $titreVote = $liste[$i]->get("titreVote");
                    $listeEtiquette = $liste[$i]->get("listeEtiquettes");
                    //$dateCreation = $liste[$i]->get("dateCreation");
                    $description = $liste[$i]->getDescription(); 
                    $url = "routeur.php?controleur=controleurVote&action=afficherVoteGros&id=$i";
                    $txt = "Voter";
                    if ($_SESSION['utilisateurCourant']->get('role')==2){ //est administrateur 
                    $urlSuppr = "routeur.php?controleur=controleurVote&action=supprimerVote&id=$i";
                    $txtSuppr = "Supprimer";
                    }
                    include('vues/petitVote.php');
                }
                
            }
            // $groupe->display();
            echo "<a href=routeur.php?controleur=controleurGroupe&action=nouvelleProposition>nouvelle proposition</a>";
            echo "<a href=routeur.php?controleur=controleurGroupe&action=afficherNonAcceptes>Voir les propositions en cours de traitement</a>";
            $popupI = "#popup-invitation";
            $lienInvit = $_SESSION['groupeCourant']->getUrlRejoindre();
            echo "<a href=$popupI>Inviter quelqu'un</a>";

            echo '</div>';
            echo '</div>';
            echo '</main>';
            include('vues/footer.html');
            include('vues/popups/addGroup.php');
            include('vues/fin.html');
        }


        public static function nouvelleProposition(){
            $titre = "Proposer un vote";
            $nbChoix = 4; // Nombre de choix pour le vote, on pourra gérer ça dynamiquement avec un bouton si on veut
            $listeEtiquette = $_SESSION['groupeCourant']->get('listeEtiquette');
            $idGroupe = $_SESSION['groupeCourant']->get('idGroupe');
            $idCreateur = $_SESSION['utilisateurCourant']->get('idUtilisateur');
            $listeCodeSuffrage = Vote::getListeCodeSuffrage();
            
            include('vues/debut.php');
            ControleurApplication::AfficherHeader();
            echo '<main>';
            include('vues/formulaireVote.php');
            echo '</main>';
            include('vues/footer.html');
            include('vues/popups/addGroup.php');
            include('vues/fin.html');
        }

        public static function creerGroupe(){
            $titre = 'Nouveau groupe';
            include('vues/debut.php');
            ControleurApplication::AfficherHeader();
            echo '<main>';
            include('vues/formulaireGroupe.php');
            echo '</main>';
            include('vues/footer.html');
            include('vues/popups/addGroup.php');
            include('vues/fin.html');
        }

        public static function afficherNonAcceptes(){
            $nomG = $_SESSION['groupeCourant']->get("nomGroupe");
            $titre= $nomG;
            $styleSpecial = '';
            include('vues/debut.php');
            ControleurApplication::afficherHeader();
            echo '<main>';
            $liste=$_SESSION['groupeCourant']->get("listeVote");
            for($i = 0;$i<count($liste);$i++){
                //   /!\    $liste[$i] est un objet Vote
                if(!$liste[$i]->get('propositionAcceptee')){ //par rapport à l'autre y'a un not devant le boolean
                    $liste[$i]->fillEtiquettes();
                    $idVote = $liste[$i]->get("idVote");
                    $titreVote = $liste[$i]->get("titreVote");
                    $listeEtiquette = $liste[$i]->get("listeEtiquettes");
                    //$dateCreation = $liste[$i]->get("dateCreation");
                    $description = $liste[$i]->getDescription(); 
                    $titreSend = urlencode($titreVote);
                    if($_SESSION['utilisateurCourant']->get('role')==2){
                    $urlAccp = "vues/accepterVote.php?id=$idVote&titre=$titreSend";
                    $txtAccp = "Accepter la proposition";}
                    include('vues/petitVote.php');
                }
                
            }
            echo "<a href=routeur.php>Quitter ce menu</a>";

            echo '</main>';
            include('vues/footer.html');
            include('vues/popups/addGroup.php');
            include('vues/fin.html');
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