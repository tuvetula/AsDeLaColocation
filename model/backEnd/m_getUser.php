<?php
require_once('model/bdd/bddConfig.php');

//Vérifie si le login existe en base de donnée
function getUser($postLogin)
{
    $postLogin = htmlspecialchars(strip_tags($postLogin));
    $db = connectBdd();
    $answer = $db->prepare('SELECT * FROM users WHERE user_mail=:login');
    $answer->execute([
        ':login' => $postLogin
    ]);
    return $answer->fetch();
}