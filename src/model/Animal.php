<?php 
class Animal{
    private String $nom;
    private int $age;
    private String $espece;

    public function __construct(String $nom, Int $age, String $espece){
        $this->nom = $nom;
        $this->age = $age;
        $this->espece = $espece;
    }

    public function getNom(){
		return $this->nom;
	}

    public function getAge(){
		return $this->age;
	}

    public function getEspece(){
		return $this->espece;
	}

}


?>