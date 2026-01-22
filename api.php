<?php
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

require_once('/users/tellier212/private/mysql_config.php');

set_include_path("./src");
require_once("RouterAPI.php");
require_once("model/AnimalStorageMySQL.php");

/**
 * Construction de l'objet PDO pour les requetes
 * A partir des identifiants de config
 */
function connecter(): ?PDO {
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];
    
    try {
        $dsn = DB_HOST . DB_NAME;
        $connection = new PDO($dsn, DB_USER, DB_PASS, $options);
        return $connection;
    } catch (PDOException $e) {
        error_log("Erreur de connexion à la base de données : " . $e->getMessage());
        return null;
    }
}
//Connection à la base et message d'erreur
$pdo = connecter();
if ($pdo === null) {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code(500);
    echo json_encode(['error' => 'Erreur de connexion à la base de données']);
    exit;
}

$storage = new AnimalStorageMySQL($pdo);
$router = new RouterAPI();
$router->main($storage);
?>
