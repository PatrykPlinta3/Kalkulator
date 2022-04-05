<?php

require_once dirname(__FILE__).'/../config.php';
//bramkarz
include _ROOT_PATH.'/app/security/check.php';

//parametry
function getParametry(&$kwota,&$lata,&$procent)
{

    $lata = isset($_REQUEST['lata']) ? $_REQUEST['lata'] : null;
    $procent = isset($_REQUEST['procent']) ? $_REQUEST['procent'] : null;
    $kwota = isset($_REQUEST['kwota'])?$_REQUEST['kwota']:null;
}

function waldacja(&$kwota,&$lata,&$procent,&$error){

        if(!(isset($lata)&&isset($procent)&&isset($kwota))){

            return false;
        }

    if(!isset($kwota)){
        $error []= "nie podano kwota";
    }
    if(!isset($procent)){
        $error []= "nie podano procent";
    }
    if(!isset($lata)){
        $error []= "nie podano lata";
    }
        if(count($error)!=0) return false;

    if ( is_numeric( $kwota )==false) {
        $error [] = 'wartość KWOTA nie jest liczbą całkowitą';
    }

    if (is_numeric( $procent )==false) {
        $error [] = ' wartość PROCENT nie jest liczbą całkowitą';
    }
    if (is_numeric( $lata )==false) {
        $error [] = ' wartość LATA nie jest liczbą całkowitą';
    }
        if(count($error)!=0) return false;



    if($kwota<0){
        $error []= "kwota mniejsza od zera";
    }
    if($procent<0){
        $error []= "procent mniejszy od zera";
    }
    if($lata<0){
        $error []= "wartość lat mniejsza od zera";
    }

    if($lata==0){
        $error []= "wartość lat to zero";
    }
        if(count($error)!=0) return false;
        else return true;

}
function oblicz(&$kwota,&$lata,&$procent,&$error,&$wynik){

        $kwota = floatval($kwota);
        $lata = intval($lata);
        $procent = floatval($procent);

        //wykonanie operacji
        $ilosc_rat = $lata*12;
        $kwota_kredytu = $kwota * pow(1 + ($procent / 100), $lata);
        $kwota_kredytu_zaokr = round($kwota_kredytu, 2);
        $rata_zaokr = round($kwota_kredytu / $ilosc_rat, 2);
        $wynik = "Rata miesięczna wynosi: " . $rata_zaokr . " zł, a cała kwota kredytu to: " . $kwota_kredytu_zaokr . " zł, rat będzie: ".$ilosc_rat;

}


$procent=null;
$lata=null;
$kwota=null;
$wynik=null;
$error=array();
getParametry($kwota,$lata,$procent);
if (waldacja($kwota,$lata,$procent,$error)){
    oblicz($kwota,$lata,$procent,$error,$wynik);
}

include 'kredyt_view.php';