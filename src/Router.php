<?php
set_include_path("./src");
require_once("View/View.php");
require_once("control/Controller.php");


class Router{
	
	public function getAnimalURL(string $id):string{
		return "site.php?id=" . urlencode($id);
	}

	public function main(){

		$view = new View($this);
		$controller = new Controller($view);
		if(isset($_GET["id"])){
			$id = ($_GET["id"]);
			$controller->showInformation($id);
		}
		else{
			$controller->afficheDefaut();
		}
		if(isset($_GET["action"])){
			if(htmlspecialchars($_GET["action"])==="liste"){
				$controller->showList();
			}
		}
		$view->render();
	}

	
}
?>
