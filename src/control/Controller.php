<?php
set_include_path("./src");
require_once("model/Animal.php");
require_once("model/AnimalStorage.php");

class Controller{
    private $view;

    private AnimalStorage $storage;

    public function __construct(View $vue,AnimalStorage $storage){
        $this->view = $vue;
        $this->storage = $storage;
    }

    public function showInformation(string $animalName):void{
        $animal = $this->storage->read($animalName);
        if($animal !=null){
            $this->view->prepareAnimalPage($animal);
        }
        else{
            $this->view->prepareUnknownAnimalPage();
        }
    }

    public function afficheDefaut():void{
        $this->view->prepareAccueilPage();
    }

    public function showList():void{
        $listeAniimaux = $this->storage->readAll();
        $this->view->prepareListPage($listeAniimaux);
    }

    
    public function createNewAnimal(): void{
        $this->view->prepareAnimalCreationPage();
    }

    public function saveNewAnimal(array $data){
        if (!isset($_POST['nom']) || !isset($_POST['espece']) || !isset($_POST['age'])) {
            $this->view->prepareErrorPage("Données manquantes pour créer l'animal.");
            return;
        }

        $nom = trim($_POST['nom']);
        $espece = trim($_POST['espece']);
        $age = $_POST['age'];
        
        if (empty($nom) || empty($espece)) {
            $this->view->prepareErrorPage("Le nom et l'espèce ne peuvent pas être vides.");
            return;
        }
        
        if (!is_numeric($age) ) {
            $this->view->prepareErrorPage("L'âge doit être un nombre.");
            return;
        }
        
        $animal = new Animal($nom, (int)$age, $espece);
        $id = $this->storage->create($animal);
        $this->view->prepareAnimalPage($animal);
    }
}
?>
