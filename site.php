<?php


/*
 * On indique que les chemins des fichiers qu'on inclut
 * seront relatifs au répertoire src.
 */


/* Inclusion des classes utilisées dans ce fichier */
set_include_path("./src");
require_once("model/AnimalStorageMySQL.php");
require_once("Router.php");
require_once('/users/diare211/private/mysql_config.php');
require_once('PathInfoRouter.php');
/*
 * Cette page est simplement le point d'arrivée de l'internaute
 * sur notre site. On se contente de créer un routeur
 * et de lancer son main.
 */
session_name('Animal');
session_start();

try {
    // Création d'une instance unique de PDO
    $dsn = 'mysql:host=' .MYSQL_HOST .';dbname=' . MYSQL_DB;
    $username = MYSQL_USER;
    $password = MYSQL_PASSWORD;
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];
    $pdo = new PDO($dsn, $username, $password, $options);

    // Passage de l'instance PDO à AnimalStorageMySQL
    $animalStorage = new AnimalStorageMySQL($pdo);

    $router = new PathInfoRouter();
    $router->main($animalStorage);

} catch (Exception $e) {
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    die();
}
?>