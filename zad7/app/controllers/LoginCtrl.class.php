<?php

namespace app\controllers;

use app\transfer\User;
use app\forms\LoginForm;
use core\Messages;

class LoginCtrl{
	private $form;
    private $msgs;   //wiadomości dla widoku
	
	public function __construct(){
		//stworzenie potrzebnych obiektów
        $this->msgs = new Messages();
		$this->form = new LoginForm();
	}
	
	public function getParams(){
		// 1. pobranie parametrów
		$this->form->login = getFromRequest('login');
		$this->form->pass = getFromRequest('pass');
	}
	
	public function validate() {
		// sprawdzenie, czy parametry zostały przekazane
		if (! (isset ( $this->form->login ) && isset ( $this->form->pass ))) {
			// sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
            $this->msgs->addError('Błędne wywołanie aplikacji !');
		}
			
			// nie ma sensu walidować dalej, gdy brak parametrów
		if (! $this->msgs->isError ()) {
			
			// sprawdzenie, czy potrzebne wartości zostały przekazane
			if ($this->form->login == "") {
                $this->msgs->addError ( 'Nie podano loginu' );
			}
			if ($this->form->pass == "") {
                $this->msgs->addError ( 'Nie podano hasła' );
			}
		}

		//nie ma sensu walidować dalej, gdy brak wartości
		if ( !$this->msgs->isError() ) {

			// sprawdzenie, czy dane logowania poprawne
			// (takie informacje najczęściej przechowuje się w bazie danych)
			if ($this->form->login == "admin" && $this->form->pass == "admin") {
				if (session_status() == PHP_SESSION_NONE) {
					session_start();
				}
				$user = new User($this->form->login, 'admin');
				// zapis wartości do sesji
				//$_SESSION['user_login'] = $user->login;
				//$_SESSION['user_role'] = $user->role;
				// LUB można zapisać or razu cały obiekt, ale trzeba go zserializować
				$_SESSION['user'] = serialize($user);				
			} else if ($this->form->login == "user" && $this->form->pass == "user") {
				if (session_status() == PHP_SESSION_NONE) {
					session_start();
				}
				$user = new User($this->form->login, 'user');
				// zapis wartości do sesji
				//$_SESSION['user_login'] = $user->login;
				//$_SESSION['user_role'] = $user->role;
				// LUB całego obiekt, po serializacji
				$_SESSION['user'] = serialize($user);				
			} else {
                $this->msgs->addError('Niepoprawny login lub hasło');
			}
		}
		
		return ! $this->msgs->isError();
	}
	
//	public function doLogin(){
//
//		$this->getParams();
//
//		if ($this->validate()){
//			//zalogowany => przekieruj na stronę główną, gdzie uruchomiona zostanie domyślna akcja
//			header("Location: ".getConf()->app_url."/");
//		} else {
//			//niezalogowany => wyświetl stronę logowania
//			$this->generateView();
//		}
//
//	}
//
//	public function doLogout(){
//		// 1. zakończenie sesji
//		if (session_status() == PHP_SESSION_NONE) {
//			session_start();
//		}
//		session_destroy();
//
//		// 2. wyświetl stronę logowania z informacją
//        $this->msgs->addInfo('Poprawnie wylogowano z systemu');
//
//		$this->generateView();
//	}
//

    public function action_login(){

        $this->getParams();

        if ($_SERVER['REQUEST_METHOD'] == 'POST' &&$this->validate()){
            //zalogowany => przekieruj na stronę główną, gdzie uruchomiona zostanie domyślna akcja
            header("Location: ".getConf()->app_url."/");
        } else {
            //niezalogowany => wyświetl stronę logowania
            $this->generateView();
        }

    }

    public function action_logout(){
        // 1. zakończenie sesji - tylko kończymy, jesteśmy już podłączeni w init.php
        session_destroy();

        // 2. wyświetl stronę logowania z informacją
        $this->msgs->addInfo('Poprawnie wylogowano z systemu');

        $this->generateView();
    }



    public function generateView(){
        global $conf;
        // print_r($conf->root_path);
        //die();
        $loader = new \Twig\Loader\FilesystemLoader( $conf->root_path . '/templates');
        $twig = new \Twig\Environment($loader, ['cache' => $conf->root_path  . '/cache', 'auto_reload' => true]);

        echo $twig->render('login.html.twig', [
            "msgs" => $this->msgs,
            "form" => $this->form,
            "conf" => $conf,
        ]);
    }
}