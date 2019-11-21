<?php
function calculAccountCreationDateDayMonth($accountCreationDate){
    $accountCreationDateArray = explode('-',$accountCreationDate);
    return $accountCreationDateArray[2].$accountCreationDateArray[1];
}