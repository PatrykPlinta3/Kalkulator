<?php

namespace app\controllers;

use app\forms\CalcForm;
use app\forms\KredytForm;
use PDOException;

class KredytList
{

    private $form; //dane formularza wyszukiwania
    private $records; //rekordy pobrane z bazy danych

    public function __construct()
    {
        $this->form = new KredytForm();
    }

    public function action_kredytList()
    {


        try {
            $this->records = getDB()->select("calc", [
                "kwota",
                "termin",
                "oprocentowanie",
                "wynik",
            ]);
        } catch (PDOException $e) {
            getMessages()->addError('Wystąpił błąd podczas pobierania rekordów');
            if (getConf()->debug) getMessages()->addError($e->getMessage());
        }
        $this->generateView();
    }

    public function generateView()
    {
        global $conf;
        // print_r($conf->root_path);
        //die();
        $loader = new \Twig\Loader\FilesystemLoader($conf->root_path . '/templates');
        $twig = new \Twig\Environment($loader, ['cache' => $conf->root_path . '/cache', 'auto_reload' => true]);

        echo $twig->render('list.html.twig', [
            "list"=>$this->records,
            "conf"=>$conf
        ]);

    }


}