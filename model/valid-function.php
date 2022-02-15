<?php

function validComs($usercomm){

    $comms = getcomm();

    //Check each selected comment
    foreach($usercomm as $selection) {
        if (!in_array($selection, $comms)) {
            return false;
        }
    }
    return true;
}