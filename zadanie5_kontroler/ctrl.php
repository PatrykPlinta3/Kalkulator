<?php
require_once 'init.php';

switch ($action) {
	default : // 'calcView'
		$ctrl = new app\controllers\KredytCtrl();
		$ctrl->generateView();
	break;
	case 'calcCompute' :

		$ctrl = new app\controllers\KredytCtrl();
		$ctrl->process();
	break;
	case 'action1' :
		// zrób coś innego ...
        print('hej');
	break;
	case 'action2' :
		// zrób coś innego ...
        print('pa');
	break;
}
