<?php 
class Animal{
    private string $nom;
    private int $age;
    private string $espece;
    private ?int $id;
    private ?string $imagePath;

    public function __construct(string $nom, string $espece, int $age, ?int $id = null, ?string $imagePath = null){
    $this->nom = $nom;
    $this->age = $age;
    $this->espece = $espece;
    $this->id = $id;
    $this->imagePath = $imagePath;
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

    public function getImagePath(){
    return $this->imagePath;
  }

  public function getId(){
    return $this->id; 
  }

  public function __toString() {
    return "{$this->nom} est un {$this->espece} de {$this->age} ans.";
  }
}


?>
