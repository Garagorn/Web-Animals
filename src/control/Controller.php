<?php
set_include_path("./src");
require_once("model/Animal.php");
require_once("model/AnimalStorage.php");
require_once("model/AnimalBuilder.php");

class Controller{
    private $view;

    private AnimalStorage $storage;

    public function __construct(View $vue,AnimalStorage $storage){
        $this->view = $vue;
        $this->storage = $storage;
    }

	public function afficheDefaut():void{
        $this->view->prepareAccueilPage();
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

    public function showList():void{
        $listeAnimaux = $this->storage->readAll();
        $this->view->prepareListPage($listeAnimaux);
    }

    public function createNewAnimal(): void{
	    $build = new AnimalBuilder([]);
        $this->view->prepareAnimalCreationPage($build);
    }

	
	public function saveNewAnimal(array $data){
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imagePath = basename($_FILES['image']['name']);
    }
    $data[AnimalBuilder::IMAGE_REF] = $imagePath;
    $build = new AnimalBuilder($data);

    if (!$build->isValid()) {
        $this->view->prepareAnimalCreationPage($build);
        return null;
    }
    $animal = $build->createAnimal();
    $id = $this->storage->create($animal);
    $this->view->displayAnimalCreationSuccess($id);
    }
}
?>
