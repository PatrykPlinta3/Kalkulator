
<!DOCTYPE HTML>
<html xmins="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta charset="utf-8">
    <title>Kalkulator Kredytowy</title>
    <link rel="stylesheet" href="https://unpkg.com/purecss@2.1.0/build/pure-min.css" integrity="sha384-yHIFVG6ClnONEA5yB5DJXfW2/KC173DIQrYoZMEtBvGzmf0PKiGyNEqe9N6BNDBH" crossorigin="anonymous">
</head>
<body>

    <div style=" margin-top: 10px;margin-bottom:10px; margin-left: 10px">
        <a href="<?php print(_APP_ROOT); ?>/app/inna_chroniona.php" class="pure-button pure-button-active">kolejna chroniona strona</a>
        <a href="<?php print(_APP_ROOT); ?>/app/security/logout.php" class="pure-button pure-button-active">Wyloguj</a>
    </div>


<form action="<?php print(_APP_URL);?>/app/kredyt.php" method="post" class="pure-form pure-form-stacked" >
    <div style="margin:10px">
    Kwota: <input type="text" name="kwota" value="<?php echo isset($kwota) ? $kwota : '' ;   ?>">
        <br>
        <br>
    Lata: <input type="text" name="lata" value="<?php echo isset($lata) ? $lata : '' ;   ?>">
        <br>
        <br>
    Procent: <input type="text" name="procent" value="<?php echo isset($procent) ? $procent : '' ;   ?>">
        <br>

    </div>
    <input class="pure-button pure-button-primary" style="margin-left: 10px" type="submit" value="Licz">

</form>

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($error)) {
    if (count ( $error ) > 0) {
        echo '<ol style="background-color: red; width: 400px; padding: 2em; border-radius: 0.5em ;margin-left: 10px">';
        foreach ( $error as $key => $msg) {
            echo '<li>'.$msg.'</li>';
        }
        echo '</ol>';
    }
}
?>

<?php if (isset($wynik)){ ?>
        <br>
    <div>
        <?php echo '<div style="background-color: lightblue; width: 400px;padding: 2em;border-radius: 0.5em; margin-left: 10px"> Wynik: '.$wynik.'</div>'; ?>
    </div>
<?php } ?>

</body>
</html>