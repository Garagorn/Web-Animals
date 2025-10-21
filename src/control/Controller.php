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

}
?>
