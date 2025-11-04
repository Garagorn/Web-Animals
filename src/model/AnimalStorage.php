<?php
set_include_path("./src");
require_once("model/Animal.php");
Interface AnimalStorage{

    public function read(String $id): ?Animal;

    public function readAll():array;

    public function create(Animal $a): Int;

    public function delete($id): Boolean;

    public function update($id, Animal $a): Boolean;

}
?>