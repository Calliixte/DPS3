<?php
Class Message{
    private int $idMessage;
    private int $idAuteur;
    private string $texte;
    private DateTime $dateEnvoi;
    private array $listeReactions;

    public function __construct(int $idMessage = NULL, int $idAuteur= NULL, string $texte= NULL, string $dateEnvoi= NULL) {
        if(!is_null($idMessage)){
            $this->idMessage = $idMessage;
            $this->idAuteur = $idAuteur;
            $this->texte = $texte;
            $this->dateEnvoi = Date::toDateTime($dateEnvoi);
        }
    }

    public function get($attribute){
        return $this->$attribute;
    }

    public function set($attribute, $val){
        $this->$attribute = $val;
    }

    public function getDateEnvoi(){
        return $this->dateEnvoi->format("d/m/Y");
    }

    public static function getMessages(int $idVote){
        $requete = "SELECT idMessage, idUtilisateur AS idAuteur, texte, dateEnvoi FROM Message WHERE idVote = $idVote;";
        $resultat = Connexion::pdo()->query($requete);
        
        $listeMessages = [];
        while($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            // echo "<pre>";
            // print_r($ligne);
            // echo "</pre>";
            $message = new Message(... $ligne);
            $message->listeReaction = Reaction::getReactionMessage($message->idMessage);
            $listeMessages[] = $message;
        }

        return $listeMessages;
    }

    public static function supprimerMessage($idMessage){
        $requetePreparee = Connexion::pdo()->prepare("DELETE FROM Message where idMessage= :log");
        $requetePreparee -> bindParam(':log',$idMessage);
        try{
            $requetePreparee->execute();
        }catch(PDOException $e){echo $e->getMessage();}
    }
    

    public static function ajouterReaction($idAuteur,$idGroupe,$idMessage,$emoji){
        try{
        $sql = "INSERT INTO ReactionMessage (idUtilisateur, idGroupe, idMessage, unicodeEmoticone) 
        VALUES (:idAuteur, :idGroupe, :idMessage, :emoji)";

        $stmt = Connexion::pdo()->prepare($sql);
        $stmt->bindParam(':idAuteur', $idAuteur, PDO::PARAM_INT);
        $stmt->bindParam(':idGroupe', $idGroupe, PDO::PARAM_INT);
        $stmt->bindParam(':idMessage', $idMessage, PDO::PARAM_INT);
        $stmt->bindParam(':emoji', $emoji, PDO::PARAM_STR);

        // Exécution de la requête
        $stmt->execute();
        return "Réaction ajoutée avec succès.";
        } catch (PDOException $e) {
            // Gérer les erreurs de connexion ou d'exécution
            return "Erreur : " . $e->getMessage();
        }   
    }
}


?>