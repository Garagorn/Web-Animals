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

		$id = key_exists('id', $_GET)? $_GET['id']: null;
		$action = key_exists('action', $_GET)? $_GET['action']: null;
		if ($action === null) {
			/* Pas d'action demandée : par défaut on affiche
	 	 	 * la page d'accueil, sauf si une couleur est demandée,
	 	 	 * auquel cas on affiche sa page. */
			$action = ($id === null)? "accueil": "voir";
		}
		if(isset($_GET["action"])){
			$action = $_GET["action"];
			
			switch($action){
				case "liste":
					$controller->showList();
					break;
				case "nouveau":
					$controller->createNewAnimal();
					break;
				case "sauverNouveau":
					$controller->saveNewAnimal($_POST);
					break;
				default:
					$controller->afficheDefaut();
			}
		}
		
		elseif(isset($_GET["id"])){
			$id = ($_GET["id"]);
			$controller->showInformation($id);
		}
		else{
			$controller->afficheDefaut();
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
    public function allAnimalsPage(){
        return "site.php?action=liste";
    }

	public function getAnimalCreationURL(){
		return "site.php?action=nouveau";
	}
	
	public function getAnimalSaveURL(){
		return "site.php?action=sauverNouveau";
	}
	
	public function POSTredirect(string $url,string $feedback){
		header("Location: " . $url, true, 303);
    	exit();
	}
}
?>
