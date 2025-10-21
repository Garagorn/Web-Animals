<?php
set_include_path("./src");
require_once("model/Animal.php");
Interface AnimalStorage{

    public function read(String $id): ?Animal;

    public function readAll():array;

}
?>