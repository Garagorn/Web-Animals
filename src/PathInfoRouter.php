<?php
set_include_path("./src");
require_once("View/View.php");
require_once("control/Controller.php");
/**
 * Router pour le pathInfo
 * 
 * On interprète les requêtes HTTP comme des actions, 
 * appelle le contrôleur, et affiche la vue.
 */
class PathInfoRouter extends Router {

    /**
     * Récupération de l'url d'un Animal
     * @param id Identifiant de l'animal
     * @return string URL de l'animal
     */
    public function getAnimalURL(string $id): string {
        return $_SERVER['SCRIPT_NAME'] . '/' . urlencode($id);
        //                  site.php      /      id de l'animal
    }

    public function main(AnimalStorage $storage): void {
        $feedback = $_SESSION['feedback'] ?? null;
        unset($_SESSION['feedback']);
        
        //Creation Vue et Controller
        $view = new View($this, $feedback);
        $controller = new Controller($view, $storage);

        //Recuperation du path
        $pathInfo = $_SERVER['PATH_INFO'] ?? '';
        $pathInfo = trim($pathInfo, '/');

        //Page d'accueil
        if ($pathInfo === '') {
            $controller->afficheDefaut();
            $view->render();
            return;
        }

        //Autre que  la page d'accueil
        $segments = explode('/', $pathInfo);
        $action = $segments[0]; //1er element du tableau -> l'action

        //Donner les actions a effectuer au controller suivant les cas
        switch ($action) {
            case 'accueil':
                $controller->afficheDefaut();
                break;                
            case 'liste':
                $controller->showList();
                break;                
            case 'nouveau':
                $controller->createNewAnimal();
                break;                
            case 'sauverNouveau':
                $controller->saveNewAnimal($_POST);
                break;                
            default:
                $view->prepareUnknownActionPage();
				break;
        }        
        $view->render();
    }

    /**
     * Acceder a la page d'accueil
     * @return url site.php
     */
    public function homePage(): string {
        return $_SERVER['SCRIPT_NAME'];
    }

    /**
     * Acceder a la liste des  animaux
     * @return url site.php/liste
     */
    public function allAnimalsPage(): string {
        return $_SERVER['SCRIPT_NAME'] . '/liste';
    }

    /**
     * Acceder a la page de création d'animaux
     * @return url site.php/nouveau
     */
    public function getAnimalCreationURL(): string {
        return $_SERVER['SCRIPT_NAME'] . '/nouveau';
    }

    /**
     * Acceder a la page de sauvegarde d'animaux
     * @return url site.php/sauverNouveau
     */
    public function getAnimalSaveURL(): string {
        return $_SERVER['SCRIPT_NAME'] . '/sauverNouveau';
    }

    /**
     * Gestion de la redirection et du feedback
     * Renvoyer les informations à l'internaute 
     */
    public function POSTredirect(string $url, string $feedback): void {
        $_SESSION['feedback'] = $feedback;
        header("Location: " . $url, true, 303);
        exit();
    }
}
?>
