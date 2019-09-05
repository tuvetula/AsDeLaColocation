<?php
require_once('model/bdd/bddConfig.php');





//TP VOYAGES
function getTravels(){
    $db = connectBdd();
    $answer = $db->query('SELECT * FROM voyagespost');
    return $answer->fetchAll(PDO::FETCH_ASSOC);
}