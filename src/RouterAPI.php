<?php
set_include_path("./src");
require_once("View/ViewAPI.php");
require_once("control/Controller.php");

/**
 * Routeur pour l'API
 */
class RouterAPI {
    
    public function main(AnimalStorage $storage): void {
        
        $view = new ViewAPI();
        
        $controller = new Controller($view, $storage);
        //Recuperer la collection et l'id
        $collection = $_GET['collection'] ?? null;
        $id = $_GET['id'] ?? null;

        if ($collection === 'animaux') {            
            if ($id !== null) {//Affichage de la liste json
                $controller->showInformation($id);
            } else { //Affichage de l'animal json
                $controller->showList();
            }
        }
        $view->render();
    }
   
}
