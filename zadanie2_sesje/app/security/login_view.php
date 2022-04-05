<!DOCTYPE HTML>
<html xmins="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta charset="utf-8">
    <title>login</title>
    <link rel="stylesheet" href="https://unpkg.com/purecss@2.1.0/build/pure-min.css" integrity="sha384-yHIFVG6ClnONEA5yB5DJXfW2/KC173DIQrYoZMEtBvGzmf0PKiGyNEqe9N6BNDBH" crossorigin="anonymous">
</head>
<body>
<form action="<?php print(_APP_URL);?>/app/security/login.php " method="post">
    <div style="margin:10px">
        Login: <input type="text" name="user" value="">
        <br>
        <br>
        Hasło: <input type="password" name="password" value="">
        <br>

    </div>
    <input style="margin:10px" type="submit" value="Zaloguj">

</form>

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($user_error)) {
    if (count ( $user_error ) > 0) {
        echo '<ol style="background-color: red; width: 20%; margin-left: 10px">';
        foreach ( $user_error as $key => $msg) {
            echo '<li>'.$msg.'</li>';
        }
        echo '</ol>';
    }
}
?>



</body>
</html>