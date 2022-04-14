<?php
// W skrypcie definicji kontrolera nie trzeba dołączać problematycznego skryptu config.php,
// ponieważ będzie on użyty w miejscach, gdzie config.php zostanie już wywołany.

namespace app\controllers;

global $conf;

use app\forms\KredytForm;
use app\transfer\KredytResult;
use core\Messages;


class KredytCtrl {

    private $msgs;   //wiadomości dla widoku
    private $form;   //dane formularza (do obliczeń i dla widoku)
    private $result; //inne dane dla widoku

    /**
     * Konstruktor - inicjalizacja właściwości
     */
    public function __construct(){
        //stworzenie potrzebnych obiektów
        $this->msgs = new Messages();
        $this->form = new KredytForm();

    }

    /**
      *Pobranie parametrów
     */
    public function getParams(){
        $this->form->kwota = isset($_REQUEST ['kwota']) ? $_REQUEST ['kwota'] : null;
        $this->form->lata = isset($_REQUEST ['lata']) ? $_REQUEST ['lata'] : null;
        $this->form->oprocentowanie = isset($_REQUEST ['oprocentowanie']) ? $_REQUEST ['oprocentowanie'] : null;
    }

    /**
     * Walidacja parametrów
     * @return true jeśli brak błedów, false w przeciwnym wypadku
     */
    public function validate() {
        // sprawdzenie, czy parametry zostały przekazane
        if (! (isset ( $this->form->kwota ) && isset ( $this->form->lata ) && isset ( $this->form->oprocentowanie ))) {
            // sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
            return false; //zakończ walidację z błędem
        }

        // sprawdzenie, czy potrzebne wartości zostały przekazane
        if ($this->form->kwota == "") {
            $this->msgs->addError('Nie podano kwoty');
        }
        if ($this->form->lata == "") {
            $this->msgs->addError('Nie podano lat');
        }

        if ($this->form->oprocentowanie == "") {
            $this->msgs->addError('Nie podano oprocentowania');
        }

        // nie ma sensu walidować dalej gdy brak parametrów
        if (! $this->msgs->isError()) {
            if (! is_numeric( $this->form->kwota )) {
                $this->msgs->addError('Podana kwota nie jest liczbą całkowitą');
            }

            if (! is_numeric( $this->form->lata )) {
                $this->msgs->addError('Podana ilość lat nie jest liczbą całkowitą');
            }

            if (! is_numeric( $this->form->oprocentowanie )) {
                $this->msgs->addError('Podane oprocentowanie nie jest liczbą całkowitą');
            }
            if (0==( $this->form->lata)) {
                $this->msgs->addError('Podane oprocentowanie nie jest zerem');
            }
        }
        if (! $this->msgs->isError()) {
            if (0>( $this->form->kwota )) {
                $this->msgs->addError('Podana kwota jest liczbą mniejszą od zera');
            }

            if (0>( $this->form->lata )) {
                $this->msgs->addError('Podana ilość lat jest liczbą mniejszą od zera');
            }

            if (0>( $this->form->oprocentowanie )) {
                $this->msgs->addError('Podane oprocentowanie jest liczbą mniejszą od zera');
            }

        }

        return ! $this->msgs->isError();
    }

    /**
     * Pobranie wartości, walidacja, obliczenie i wyświetlenie
     */
    public function action_calcCompute(){

        $this->getparams();

        if ($this->validate()) {

            //konwersja parametrów na int
            $this->form->kwota = intval($this->form->kwota);
            $this->form->lata = intval($this->form->lata);
            $this->form->oprocentowanie = intval($this->form->oprocentowanie);
            $this->msgs->addInfo('Parametry poprawne.');

            //wykonanie operacji
            $ilosc_rat = ($this->form->lata * 12);
            $kwota_kredytu = $this->form->kwota * pow(1 + ($this->form->oprocentowanie / 100), $this->form->lata);
            $this->result = new KredytResult();
            $this->result->rata = round($kwota_kredytu / $ilosc_rat, 2);
            $this->result->kwota_kredytu = round($kwota_kredytu, 2);

            $this->msgs->addInfo('Wykonano obliczenia.');
        }

        $this->generateView();
    }


    /**
     * Wygenerowanie widoku
     */
    public function action_calcShow(){
        $this->msgs->addInfo('Witaj w kalkulatorze');
        $this->generateView();
    }

    public function generateView(){
        global $conf;
       // print_r($conf->root_path);
       //die();
        $loader = new \Twig\Loader\FilesystemLoader( $conf->root_path . '/templates');
        $twig = new \Twig\Environment($loader, ['cache' => $conf->root_path  . '/cache', 'auto_reload' => true]);

        echo $twig->render('kredyt.html.twig', [
            "msgs" => $this->msgs,
            "form" => $this->form,
            "res" => $this->result,
            "conf" => $conf,
        ]);
    }
}
