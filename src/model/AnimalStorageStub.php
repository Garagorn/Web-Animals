<?php
set_include_path("./src");
require_once("model/Animal.php");
require_once("model/AnimalStorage.php");
class AnimalStorageStub implements AnimalStorage{

    private $animalsTab;

    public function __construct(){
        $this->animalsTab=[
            "medor"=> new Animal("Médor","chien",2),
            "felix"=> new Animal("Félix","chat",4),
            "denver"=> new Animal("Denver","dinosaure",4000)
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

    public function create(Animal $a): String{
        throw new ErrorException($a);
    }

    public function delete($id): Boolean{
        throw new ErrorException($id);
    }

    public function update($id, Animal $a): Boolean{
        throw new ErrorException($id,$a);
    }
}
?>
