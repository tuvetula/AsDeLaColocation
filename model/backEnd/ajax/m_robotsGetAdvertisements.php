<?php
header('Content-Type: application/json');
//require_once('../bdd/bddConfig.php');
//Stocke la date - 7 jours
$date = date('Y-m-d', strtotime('-7 day'));
// echo $date;

//Connexion Base de donnée
try {
    $bdd = new PDO('mysql:host=localhost;dbname=asdelacolocation;charset=utf8', 'root', '',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
} catch (Exception $e) {
    die('Erreur : '.$e->getMessage());
}

//Requete Suppression: Annonce inactive + date non null
$request=$bdd->prepare('SELECT * FROM advertisements 
                        join users on advertisements.user_id = users.user_id
                        where advertisement_isActive=:isActive 
                        AND advertisement_dateOfLastDiffusion IS NOT NULL');

$request->execute([
    ':isActive' => false,
]);

$deletion = $request->fetchAll(PDO::FETCH_ASSOC);
$json['Deletion'] = $deletion;

//Requete Publication: Annonce active + date vide
$request1=$bdd->prepare('SELECT * FROM advertisements 
                        join addresses on advertisements.address_id = addresses.address_id 
                        join users on advertisements.user_id = users.user_id
                        join pictures on advertisements.advertisement_id = pictures.advertisement_id
                        where advertisement_isActive=:isActive 
                        AND advertisement_dateOfLastDiffusion IS NULL');

$request1->execute([
    ':isActive' => true,
]);
$jsonPublication = $request1->fetchAll(PDO::FETCH_ASSOC);
$json['Publication'] = $jsonPublication;


//Requete RePublication: Annonce active + Date de + de 7 jours
$request2=$bdd->prepare('SELECT * FROM advertisements 
                        join addresses on advertisements.address_id = addresses.address_id 
                        join users on advertisements.user_id = users.user_id
                        join pictures on advertisements.advertisement_id = pictures.advertisement_id
                        where advertisement_isActive=:isActive 
                        AND advertisement_dateOfLastDiffusion<=:dateOfLastDiffusion');

$request2->execute([
    ':isActive' => true,
    ':dateOfLastDiffusion' => $date
]);
$jsonRepublication = $request2->fetchAll(PDO::FETCH_ASSOC);
$json['Republication'] = $jsonRepublication;

//Ecriture fichier json
echo json_encode($json);
