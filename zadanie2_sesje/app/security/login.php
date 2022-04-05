<?php
require_once dirname(__FILE__).'/../../config.php';
//parametry
function bioreinformacje(&$form)
{
    $form['user'] = isset($_REQUEST['user']) ? $_REQUEST['user'] : null;
    $form['password'] = isset($_REQUEST['password']) ? $_REQUEST['password'] : null;

}

function checkBoxes(&$form,&$user_error){

    if(!(isset($form['user'])&&isset($form['password']))){

        return false;
    }

    if ($form['user']==''){
    $user_error[]='Nie podano nazwy użytkownika';
    }

    if ($form['password']==''){
    $user_error[]='Nie podano hasła';
    }
if (count($user_error)!=0)return false;

    if ($form['user']=='admin'&&$form['password']=='admin') {
        session_start();
        $_SESSION['role'] = 'admin';
        return true;
    }else if ($form['user']=='user'&&$form['password']=='user'){
        session_start();
        $_SESSION['role']='user';
        return true;
    }
}

$form=array();
$user_error=array();

bioreinformacje($form);

if(!checkBoxes($form,$user_error)){
    include _ROOT_PATH.'/app/security/login_view.php';
}else{

    header("Location: "._APP_URL);
}