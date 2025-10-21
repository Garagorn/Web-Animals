<?php
set_include_path("./src");
require_once("View/View.php");
require_once("control/Controller.php");


class Router{
	
	public function main(){

		$view = new View();
		$controller = new Controller($view);
		if(isset($_GET["id"])){
			$id = ($_GET["id"]);
			$controller->showInformation($id);
		}
		else{
			$controller->afficheDefaut();
		}
		$view->render();
	}

	
}
?>
