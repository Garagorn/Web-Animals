<?php
set_include_path("./src");
require_once("model/Animal.php");
require_once("model/AnimalStorage.php");
class AnimalStorageStub implements AnimalStorage{

    private $animalsTab;

    public function __construct(){
        $this->animalsTab=[
            "medor"=> new Animal("Médor",2,"chien"),
            "felix"=> new Animal("Félix",4,"chat"),
            "denver"=> new Animal("Denver",2000,"dinosaure")
        ];
    }

    public function read(String $id): ?Animal{
        if(array_key_exists($id,$this->animalsTab)){
            $animal=$this->animalsTab[$id];
            return $animal;
        }
        return null;
    }

    public function readAll():array{
        return $this->animalsTab;
    }
}
?>