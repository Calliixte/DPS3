<?php
Class Server{
    
    public static function uploadImage($sourcefolder,$destinationfolder, $filename, $rename){
        //On récupère son extension
        $imageFileType = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        //On défini ou stocker le fichier tout en le renommant
        $path = $destinationfolder . $rename .".". $imageFileType; 

        print_r($_FILES);
        
        //On upload l'image sur le serveur 
        if (move_uploaded_file($sourcefolder, $path)) //On met le fichier dans le bon répertoire et on vérifie que ça a fonctionné
        {
            echo "The file " . htmlspecialchars($filename) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }

        return $path;
    }
}
?>