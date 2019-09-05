<?php
function reArrangeListOfAdvertisement($userAdvertisements)
{
    $arrangeListOfAdvertisements = array();
    $count = 0;
    $key = 0;
    for ($i = 0 ; $i < count($userAdvertisements) ; $i++) {
        if ($i%3 == 0) {
            if ($i!=0) {
                $count++;
                $key = 0;
            }
            $arrangeListOfAdvertisements[$count] = array();
            $arrangeListOfAdvertisements[$count][$key] = array();
            array_push($arrangeListOfAdvertisements[$count][$key], $userAdvertisements[$i]['advertisement_title']);
            array_push($arrangeListOfAdvertisements[$count][$key], $userAdvertisements[$i]['advertisement_description']);
            array_push($arrangeListOfAdvertisements[$count][$key], $userAdvertisements[$i]['advertisement_isActive']);
            $key++;
        } else {
            $arrangeListOfAdvertisements[$count][$key] = array();
            array_push($arrangeListOfAdvertisements[$count][$key], $userAdvertisements[$i]['advertisement_title']);
            array_push($arrangeListOfAdvertisements[$count][$key], $userAdvertisements[$i]['advertisement_description']);
            array_push($arrangeListOfAdvertisements[$count][$key], $userAdvertisements[$i]['advertisement_isActive']);
            $key++;
        }
    }
    return $arrangeListOfAdvertisements;
}