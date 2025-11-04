<?php
set_include_path("./src");
require_once("View/View.php");
require_once("control/Controller.php");

class Router{
	
	public function getAnimalURL(string $id):string{
		return "site.php?id=" . urlencode($id);
	}

	public function main(AnimalStorage $storage){
		$view = new View($this);

		$controller = new Controller($view,$storage);
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

	/* URL de la page d'accueil */
    public function homePage() {
        return "site.php";
    }

	/* URL de la page d'animaux d'identifiant $id */
    public function listPage($id) {
        return "site.php?id=$id";
    }

	/* URL de la page avec tout les animaix */
    public function allAnimauxPage() {
        return "site.php?action=liste";
    }

	
}
?>
