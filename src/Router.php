<?php
set_include_path("View/View.php");
require_once("View/View.php");

class Router{

	public function main(){
		echo "Hello world";


		$view = new View();

		$view->prepareAnimalPage("Médor","chien");
		$view->render();
	}

	
}
?>
