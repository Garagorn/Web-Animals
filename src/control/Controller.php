<?php
set_include_path("./src");
require_once("model/Animal.php");

class Controller{
    private $view;

    private $animalsTab;

    public function __construct(View $vue){
        $this->view = $vue;
        $this->animalsTab=[
            "medor"=> new Animal("Médor",2,"chien"),
            "felix"=> new Animal("Félix",4,"chat"),
            "denver"=> new Animal("Denver",2000,"dinosaure")
        ];
    }

    public function showInformation(string $animalName):void{
        if(array_key_exists($animalName,$this->animalsTab)){
            $animal=$this->animalsTab[$animalName];
            $this->view->prepareAnimalPage($animal);
        }
        else{
            $this->view->prepareUnknownAnimalPage();
        }
    }

    public function afficheDefaut():void{
        $this->view->prepareAccueilPage();
    }

}
?>
