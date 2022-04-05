<?php

require_once dirname(__FILE__).'/../config.php';

//parametry
$kwota=$_REQUEST['kwota'];
$lata=$_REQUEST['lata'];
$procent=$_REQUEST['procent'];
$error=[];

if(!(isset($lata)&&isset($procent)&&isset($kwota))){
    $error [] = "nie podano nic";
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
//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $error )) {

    // sprawdzenie, czy $x i $y są liczbami całkowitymi
    if (! is_numeric( $kwota )) {
        $error [] = 'Podana kwota nie jest liczbą całkowitą';
    }

    if (! is_numeric( $lata )) {
        $error [] = 'Podana ilość lat nie jest liczbą całkowitą';
    }

    if (! is_numeric( $procent )) {
        $error [] = 'Podane oprocentowanie nie jest liczbą całkowitą';
    }

}



if (empty($error)){
        //konwersja parametrów na int
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


include 'kredyt_view.php';