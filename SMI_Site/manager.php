<?php
require_once("../lib/lib.php");
require_once ("../database/mysqlDatabase.php");

function removeEvent($eventRemove) {
    if (removeEventFromDB($eventRemove)) {
        echo '&ensp; <p> O evento '.$eventRemove.' foi removido com sucesso. </p>';
    } else {
        echo '&ensp; <p> O evento '.$eventRemove.'  não foi removido. </p>';
    }
}

function editEvent($eventEdit, $dateEdit, $pCatEdit, $visEdit, $localEdit) {
    if (editEventFromDB($eventEdit, $dateEdit, $pCatEdit, $visEdit, $localEdit)) {
        echo '&ensp; <p> O evento '.$eventEdit.' foi editado com sucesso. </p>';
    } else {
        echo '&ensp; <p> O evento '.$eventEdit.' não foi editado. </p>';
    }
}

function removeCategory($catRemove) {
    if (removeCatFromDB($catRemove)) {
        echo '&ensp; <p> A categoria '.$catRemove.' foi removida com sucesso. </p>';
    } else {
        echo '&ensp; <p> A categoria '.$catRemove.' não foi removida. </p>';
    }
}

function addCategory($catAdd) {
    if (addCatInDB($catAdd)) {
        echo '&ensp; <p> A categoria '.$catAdd.' foi adicionada com sucesso. </p>';
    } else {
        echo '&ensp; <p> A categoria '.$catAdd.' não foi adicionada. </p>';
    }
}

function validateSimp($userSimp) {
    if (validateSimpFromDB($userSimp)) {
        echo '&ensp; <p> O utilizador '.$userSimp.' foi validado com sucesso. </p>';
    } else {
        echo '&ensp; <p> O utilizador '.$userSimp.' não foi validado. </p>';
    }
}

function editUser($nameEdit, $emailEdit, $roleEdit, $nicknameEdit, $hierEdit) {
    if (editUserFromDB($nameEdit, $emailEdit, $roleEdit, $nicknameEdit, $hierEdit)) {
        echo '&ensp; <p> O utilizador '.$nameEdit.' foi editado com sucesso. </p>';
    } else {
        echo '&ensp; <p> O utilizador '.$nameEdit.' não foi editado. </p>';
    }
}

function removeUser($userRem) {
    if (removeUserFromDB($userRem)) {
        echo '&ensp; <p> O utilizador '.$userRem.' foi removido com sucesso. </p>';
    } else {
        echo '&ensp; <p> O utilizador '.$userRem.' não foi removido. </p>';
    }
}