<?php 
class Animal{
    private string $nom;
    private int $age;
    private string $espece;

    public function __construct(string $nom, string $espece, int $age){
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
