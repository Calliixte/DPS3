<?php

/* fonctions de la classe statique Date :
- (TODO) toDateTime(string $mariaDbDateTime)
- (TODO) toSqlDateTime(DateTime $dt, bool $withMs=false)
- toDateInterval(string $mariaDbTime)
- toSqlTime(DateInterval $di)

*/


class Date {
    // Date est une classe statique ⇒ pas insantiable ⇒ constructeur privé    
    private function __construct() {  
    }

    // prend en param une string d'un DATETIME renvoyé par mariaDB lors q'une requête sql
    // exemple de $mariaDate : '2024-12-28 10:15:03'
    // Cette fonction ne sert pas à vérifier que la date ait un nombre de jours, mois, minutes, etc... "naturel" (ex : max 59 minutes)
    // Cette fonction ne vérifie que le format et part du princie que les données venant de la BD sont correctes
    public static function toDateTime(string $mariaDbDateTime) {
        if(!preg_match('/^(\d{4})-(\d\d)-(\d\d) (\d\d):(\d\d):(\d\d)(?:\.(\d+))?$/', $mariaDbDateTime))
            throw new Exception("mauvais format de string DATETIME de mariaDb (format attendu : 'YYYY-MM-DD HH:mm:ss' ou 'YYYY-MM-DD HH:mm:ss.fff')");
        return new DateTime($mariaDbDateTime);
    }

    // prend en param un DateTime (supposé avec des jours, mois, heures, etc... "naturels" (ex : max 59 minutes))
    // exemple de $mariaDate : '2024-12-28 10:15:03'
    public static function toSqlDateTime(DateTime $d1, bool $withMs=false) {
        if($withMs)
            return $d1->format('Y-m-d H:i:s.u');
        else
            return $d1->format('Y-m-d H:i:s').'.000000';
    }

    // accepte une string au format de TIME de MariaDB ex : '28 12:59:30', '12:59:30'
    // NOTA: quand on SELECT une collone de type TIME sur mariaDb cela retourne une string au fomat 'nbHeures:nbMinutes:nbSecondes'
    public static function toDateInterval(string $mariaDbTime) {
        if(!preg_match('/^(?:(\d+)\s)?(\d+):(\d+):(\d+)$/', $mariaDbTime)) {
            throw new Exception("mauvais format de string TIME de mariaDB (format attendu : 'DD HH:mm:ss' ou 'HH:mm:ss')");
        }
        return new DateInterval('P' . preg_replace('/(?:(\d+)\s)?(\d+):(\d+):(\d+)/', '0$1DT0$2H0$3M0$4S', $mariaDbTime));
    }



    // retourne une string au fromat de TIME de MariaDB ex : '28 12:59:30', '12:59:30'
    // retourne une string correspondant au format de l'intervalle de temps utilisé dans la base de donnés
    // ATTENTION, cela modifie aussi l'intervale de temps $di passé en paramètre en le faisant correspondre au format utilisé dans la base de données
    // les intervalles de temps négatifs ne sont actuellement pas supportés
    // NOTA: quand on INSERT dans une collone de type TIME sur mariaDb on peut insérer une string au fomat 'nbJours nbHeures:nbMinutes:nbSecondes'
    public static function toSqlTime(DateInterval $di) {
    // seuls les intervales <= 30 jours sont acceptés
    $time = '';

    // on ne veux pas de millisecondes
    $di->f = 0;

    // si l'intervalle a été fait avec DateTime::diff(), DateTimeImmutable::diff(), ou DateTimeInterface::diff()
    // alors on a accès au nombre de jours total
    if($di->days) {
        $di->d = $di->days;
        // $di->days est inutile, mais impossible de le modifier
        $di->y = 0;
        $di->m = 0;
        
    }
    // si l'intervalle a été fait autrement qu'avec DateTime::diff(), DateTimeImmutable::diff(), ou DateTimeInterface::diff()
    // il faut mettre les secondes, minutes, heures et jours au bon format (23h max, 59min max, 59s max)
    else {
        // on en veux pas de nb de mois ou d'années
        if($di->y!=0 || $di->m!=0) {
                throw new Exception("intervalle de temps supérieur à 30 jours (peut-être une mauvaise saissie ?)");
        }
        $di->s = $di->d*86400 + $di->h*3600 + $di->m*60 + $di->s;
        $di->d = floor($di->s/86400); // on calcule le nombre de jours total et on le stocke dans $di->days
        // $di->days est inutile mais il est déjà = false donc on ne peux pas le modifier (modif dynamique de type mixed, interdite depuis une certaine version de php)
        $di->s %= 86400;
        $di->h = floor($di->s/3600);
        $di->s %= 3600;
        $di->m = floor($di->s/60);
        $di->s %= 60;
    }

    // On n'accepte que les intervalles >= 30 jours pile-poil
    if($di->d >= 30) {
        if($di->d==30 && !($di->h==0 && $di->i==0 && $di->s==0)) {
            return $di->format('%D	 %H:%I:%S'); // $di correspond exactement à 30 jours pile-poil
        }
        throw new Exception("intervalle de temps supérieur à 30 jours (peut-être une mauvaise saissie ?)");
    }


    return $di->format('%D %H:%I:%S'); // $di < 30 jours
    }

}




?>