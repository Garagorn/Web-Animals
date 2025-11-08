<?php 
class Animal{
    private String $nom;
    private int $age;
    private String $espece;

    public function __construct(String $nom, String $espece, Int $age){
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

  public function __toString() {
    return "{$this->nom} est un {$this->espece} de {$this->age} ans.";
  }
}


?>
