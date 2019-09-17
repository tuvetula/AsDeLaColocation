<?php
require_once('model/bdd/config.php');

function connectBdd(){
    global $acces,$dbName,$login,$password;

    //Connexion Base de donnée
    try {
        $db = new PDO($acces.$dbName,$login,$password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $db;
    } catch (Exception $e) {
        die('Erreur : '.$e->getMessage());
    }
}