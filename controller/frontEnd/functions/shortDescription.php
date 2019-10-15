<?php
//Fonction qui raccourcit la description pour affichage dans la page "mes annonces"
    function shortDescription($description){
        $nbMaxCaracteresToDisplayForDescription = 170;
        if (strlen($description)>$nbMaxCaracteresToDisplayForDescription && !empty($description)) {
            return substr($description, 0, $nbMaxCaracteresToDisplayForDescription).' ...';
        } else{
            return $description;
        }
    }    