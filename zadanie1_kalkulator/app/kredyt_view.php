<!DOCTYPE HTML>
<html xmins="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
    <meta charset="utf-8">
    <title>Kalkulator Kredytowy</title>
</head>
<body>
<form action="<?php print(_APP_URL);?>/app/kredyt.php" method="post">

    Kwota: <input type="text" name="kwota" value="<?php echo isset($kwota) ? $kwota : '' ;   ?>">
    <br>
    Lata: <input type="text" name="lata" value="<?php echo isset($lata) ? $lata : '' ;   ?>">
    <br>
    Procent: <input type="text" name="procent" value="<?php echo isset($procent) ? $procent : '' ;   ?>">
    <br>
    <input type="submit" value="Licz">

</form>

<?php
//wyświeltenie listy błędów, jeśli istnieją
if (isset($error)) {
    if (count ( $error ) > 0) {
        echo '<ol style="background-color: red;width: 30%">';
        foreach ( $error as $key => $msg) {
            echo '<li>'.$msg.'</li>';
        }
        echo '</ol>';
    }
}
?>

<?php if (isset($wynik)){ ?>
    <div style="background-color: aquamarine;width: 20%">
        <?php echo 'Wynik: '.$wynik; ?>
    </div>
<?php } ?>

</body>
</html>