<?php

function reArrayFiles(&$file_post) {

    $newFileArray = array();
    $fileCount = count($file_post['file']['name']);
    $fileKeys = array_keys($file_post['file']);

    for ($i=0; $i<$fileCount; $i++) {
        foreach ($fileKeys as $key) {
            $newFileArray[$i][$key] = $file_post['file'][$key][$i];
        }
    }

    return $newFileArray;
}