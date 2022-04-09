<?php
require_once __DIR__ . "/vendor/autoload.php";
define('_SERVER_NAME', 'localhost:80');
define('_SERVER_URL', 'http://' . _SERVER_NAME);
define('_APP_ROOT', '/zadanie3_szablonowanie');
define('_APP_URL', _SERVER_URL . _APP_ROOT);
define("_ROOT_PATH", dirname(__FILE__));

$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, ['cache' => __DIR__ . '/cache', 'auto_reload' => true]);
