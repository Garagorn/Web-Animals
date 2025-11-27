<?php
set_include_path("./src");
require_once("View/View.php");
require_once("control/Controller.php");

class Router{
	
	public function getAnimalURL(string $id):string{
		return "site.php?id=" . urlencode($id);
	}

	public function main(AnimalStorage $storage){
		$feedback = $_SESSION['feedback'] ?? null;
		unset($_SESSION['feedback']);
		$view = new View($this,$feedback);

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
				case "voir":
					if ($id === null) {
						$view->prepareUnknownActionPage();
					} else {
						$ctl->colorPage($id);
					}
					break;
				case "liste":
					$controller->showList();
					break;
				case "nouveau":
					$controller->createNewAnimal();
					break;
				case "sauverNouveau":
					$controller->saveNewAnimal($_POST);
					break;
				
				case "supprimer":
				if ($id === null) {
					$view->prepareUnknownActionPage();
				} else {
					$controller->deleteAnimal($id);
				}
				break;
				case "confirmerSuppression":
					if ($id === null) {
						$view->prepareUnknownActionPage();
					} else {
						$controller->confirmAnimalDeletion($id);
					}
					break;

				case "modifier":
					if ($id === null) {
						$view->prepareUnknownActionPage();
					} else {
						$controller->modifyAnimal($id);
					}
					break;

				case "sauverModifs":
					if ($id === null) {
						$view->prepareUnknownActionPage();
					} else {
						$controller->saveAnimalModifications($id, $_POST);
					}
					break;
				case "accueil":
					$controller->homePage();
					break;
				
				default:
					/* L'internaute a demandé une action non prévue. */
					$view->prepareUnknownActionPage();
					break;
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
	
	/* URL de la page d'édition d'une couleur existante */
	public function animalModifPage($id) {
		return "site.php?action=modifier";
	}
	
	/* URL d'enregistrement des modifications sur un
	 * animal (champ 'action' du formulaire) */
	public function updateModifiedAnimal($id) {
		return "site.php?action=sauverModifs";
	}

	/* URL de la page demandant la confirmation
	 * de la suppression d'un animal */
	public function animalDeletionPage($id) {
		return "site.php?action=supprimer";
	}

	/* URL de suppression effective d'un animal
	 * (champ 'action' du formulaire) */
	public function confirmAnimalDeletion($id) {
		return "site.php?action=confirmerSuppression";
	}
	
	public function POSTredirect(string $url,string $feedback){
		$_SESSION['feedback'] = $feedback;
		header("Location: " . $url, true, 303);
		exit();
	}
}
?>
