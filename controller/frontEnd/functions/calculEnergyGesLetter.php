<?php

function calculEnergyLetter($energyNumber){
    if ($energyNumber <= 50) {
        $energyLetter = "A";
    } else if ($energyNumber > 50 && $energyNumber <= 90) {
        $energyLetter = 'B';
    } else if ($energyNumber > 90 && $energyNumber <= 150) {
        $energyLetter = "C";
    } else if ($energyNumber > 150 && $energyNumber <= 230) {
        $energyLetter = "D";
    } else if ($energyNumber > 230 && $energyNumber <= 330) {
        $energyLetter = "E";
    } else if ($energyNumber > 330 && $energyNumber <= 450) {
        $energyLetter = "F";
    } else if ($energyNumber > 450) {
        $energyLetter = "G";
    }
    return $energyLetter;
}

function calculGesLetter($gesNumber){
    if ($gesNumber <= 5) {
        $gesLetter = "A";
    } else if ($gesNumber > 5 && $gesNumber <= 10) {
        $gesLetter = 'B';
    } else if ($gesNumber > 10 && $gesNumber <= 20) {
        $gesLetter = "C";
    } else if ($gesNumber > 20 && $gesNumber <= 35) {
        $gesLetter = "D";
    } else if ($gesNumber > 35 && $gesNumber <= 55) {
        $gesLetter = "E";
    } else if ($gesNumber > 55 && $gesNumber <= 80) {
        $gesLetter = "F";
    } else if ($gesNumber > 80) {
        $gesLetter = "G";
    }
    return $gesLetter;
}