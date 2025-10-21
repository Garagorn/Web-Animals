<?php
set_include_path("./src");
require_once("View/View.php");
require_once("control/Controller.php");

class Router{

	public function main(){
		echo "Hello world";


		$view = new View();

		$controller = new Controller($view);
		$controller->showInformation("denver");
		$view->render();
	}

	
}
?>
