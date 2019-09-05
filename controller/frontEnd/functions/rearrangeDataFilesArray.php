<?php

function reArrayFiles($filePost) {

    $newFileArray = array();
    $fileCount = count($filePost['file']['name']);
    $fileKeys = array_keys($filePost['file']);

    for ($i=0; $i<$fileCount; $i++) {
        foreach ($fileKeys as $key) {
            $newFileArray[$i][$key] = $filePost['file'][$key][$i];
        }
    }

    return $newFileArray;
}