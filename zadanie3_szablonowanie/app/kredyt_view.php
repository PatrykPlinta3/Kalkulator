<?php

require_once dirname(__FILE__).'/../config.php';

global $twig;

echo $twig->render('kredyt.html.twig', [
    "messages" => isset($messages) ? $messages : null,
    "kwota" => isset($kwota) ? $kwota : null,
    "lata" => isset($lata) ? $lata : null,
    "oprocentowanie" => isset($oprocentowanie) ? $oprocentowanie : null,
    "result" => isset($result) ? $result : null,
    "app_url" => _APP_URL,
]);

