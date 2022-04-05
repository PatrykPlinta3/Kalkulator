<?php
//zaczynamy sesje
session_start();
//pobranie z sesji roli
$role=isset($_SESSION['role']) ? $_SESSION['role'] : '';

if(empty($role)){
    include _ROOT_PATH.'/app/security/login.php';
    //zatrzymaj przetwarzanie
    exit();
}