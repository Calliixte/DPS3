<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <title><?=$titre?></title>
        <link rel="icon" type="image/x-icon" href="/media/logo.svg">

        <link type='text/css' rel='stylesheet' href='css/style.css'>
        <?php
            if(isset($styleSpecial)){
                echo "<link type='text/css' rel='stylesheet' href='css/$styleSpecial.css'>";
            }
        ?>
    </head>
    <body>
