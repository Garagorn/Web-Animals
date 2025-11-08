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
		$build = new AnimalBuilder([]);
        $this->view->prepareAnimalCreationPage($build);
    }

	
	public function saveNewAnimal(array $data){
		$build = new AnimalBuilder($data);

		if (!$build->isValid()) {
        	$this->view->prepareAnimalCreationPage($build);
        return null;
    }

    $animal = $build->createAnimal();
    $id = $this->storage->create($animal);
    $this->view->prepareAnimalPage($animal);
}
/*
    public function saveNewAnimal(array $data): void{
    	$an = new AnimalBuilder($data);
        $nom = trim($_POST['nom']??'');
        $espece = trim($_POST['espece']??'');
        $age = $_POST['age']??'';
        $error= null;

        if($nom ==='' || $espece === '' ){
            $error = "Le nom et  l'espèce ne peuvent pas etre vides";
        }
        elseif(!is_numeric($age) || $age < 0){
            $error = "L'âge doit être un nombre positif.";
        }

        if($error !=null){
            $this->view->prepareAnimalCreationPage($data,$error);
            return;
        }

        $animal = new Animal($nom, (int)$age, $espece);
        $id = $this->storage->create($animal);
        $this->view->prepareAnimalPage($animal);
    }*/
}
?>
