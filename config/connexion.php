<?php 
    class Connexion{
        static private $hostname = 'localhost';
        static private $database = 'saes3-vjacqu3';
        static private $login = 'saes3-vjacqu3';
        static private $password = 'stegablix2000';

        static private $tabUTF8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
    
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
                self::$pdo = new PDO("mysql:host=$host;dbname=$db",$user,$pass,$t);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                echo "erreur de connexion : ".$e->getMessage()."<br>";
            }
        }
    }
?>