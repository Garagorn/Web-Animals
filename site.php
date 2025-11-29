<?php
require_once('/users/tellier212/private/mysql_config.php');
/*
 * On indique que les chemins des fichiers qu'on inclut
 * seront relatifs au répertoire src.
 */
set_include_path("./src");

/* Inclusion des classes utilisées dans ce fichier */
require_once("Router.php");

require_once("model/AnimalStorageSession.php");
require_once("model/AnimalStorageMySQL.php");
require_once("PathInfoRouter.php");

// Fonction de connection à la base de données
function connecter(): ?PDO{
    
    // Options de connection
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    // connection à la base de données
    try {
        $dsn = DB_HOST . DB_NAME;
        $connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $connection;
    } catch (PDOException $e) {
        echo "connection à MySQL impossible : ", $e->getMessage();
        return null;
    }
}

$pdo = connecter();
//Conection à la base et ajout de celle-ci dans l'instance
$storage = new AnimalStorageMySQL($pdo);
/*
 * Cette page est simplement le point d'arrivée de l'internaute
 * sur notre site. On se contente de créer un routeur
 * et de lancer son main.
 */

$router = new PathInfoRouter();
$router->main($storage); //Envoi du gestionnaire dans le router

?>
