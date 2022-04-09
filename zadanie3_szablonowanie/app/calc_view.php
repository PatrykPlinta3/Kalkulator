<?php

require_once dirname(__FILE__).'/../config.php';

global $twig;

echo $twig->render('calc.html.twig', [
    "messages" => isset($messages) ? $messages : null,
    "x" => isset($x) ? $x : null,
    "y" => isset($y) ? $y : null,
    "operation" => isset($operation) ? $operation : null,
    "result" => isset($result) ? $result : null,
    "app_url" => _APP_URL,
]);

