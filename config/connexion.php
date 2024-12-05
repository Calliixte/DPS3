<?php
class Connexion{
    static private $hostname = 'localhost';
    static private $database = 'saes3-vjacqu3';
    static private $login = 'saes3-vjacqu3';
    static private $password = 'stegablix2000';

    // Utilisation de utf8mb4 pour prendre en charge tous les caractères Unicode
    static private $tabUTF8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4");

    static private $pdo;

    static public function pdo(){
        return self::$pdo;
    }

    static public function connect(){
        $host = self::$hostname;
        $db = self::$database;
        $user = self::$login;
        $pass = self::$password;
        $t = self::$tabUTF8;

        try{
            // Connexion avec utf8mb4 pour un meilleur support des caractères
            self::$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, $t);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e){
            echo "Erreur de connexion : ".$e->getMessage()."<br>";
        }
    }
}
?>
