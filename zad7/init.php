<?php

require_once 'core/Config.class.php';
$conf = new core\Config();
require_once 'config.php'; //ustaw konfigurację

function &getConf(){ global $conf; return $conf; }

//załaduj definicję klasy Messages i stwórz obiekt
require_once 'core/Messages.class.php';
$msgs = new core\Messages();

function &getMessages(){ global $msgs; return $msgs; }

require_once 'core/ClassLoader.class.php'; //załaduj i stwórz loader klas

$cloader = new core\ClassLoader();
function &getLoader() {
    global $cloader;
    return $cloader;
}
require_once 'core/Router.class.php'; //załaduj i stwórz router
$router = new core\Router();
function &getRouter(): core\Router {
    global $router; return $router;
}

$db = null; //przygotuj Medoo, twórz tylko raz - wtedy kiedy potrzeba
function &getDB() {
    global $conf, $db;
    if (!isset($db)) {
        require_once 'vendor/medoo/Medoo.php';
        $db = new \Medoo\Medoo([
            'database_type' => &$conf->db_type,
            'server' => &$conf->db_server,
            'database_name' => &$conf->db_name,
            'username' => &$conf->db_user,
            'password' => &$conf->db_pass,
            'charset' => &$conf->db_charset,
            'port' => &$conf->db_port,
            'prefix' => &$conf->db_prefix,
            'option' => &$conf->db_option
        ]);
    }
    return $db;
}

require_once 'core/functions.php';

session_start(); //uruchom lub kontynuuj sesję
if (isset($_SESSION['user'])){
    $user = unserialize($_SESSION['user']);
    addRole($user->role);
}

//print_r(getConf()->roles);
//die();
//$conf->roles = isset($_SESSION['_roles']) ? unserialize($_SESSION['_roles']) : array(); //wczytaj role

$router->setAction( getFromRequest('action') );