<?php 
/**
 * Classe pour modéliser un animal
 */
class Animal{
    private string $nom;
    private int $age;
    private string $espece;
    private ?int $id;
    private ?string $imagePath;

<<<<<<< HEAD
    public function __construct(string $nom, string $espece, int $age, ?int $id = null, ?string $imagePath = null){
    //Echapper les données si attaque xss
    $this->nom = htmlspecialchars($nom);
    $this->age = htmlspecialchars($age);
    $this->espece = htmlspecialchars($espece);
    $this->id = $id;
    $this->imagePath = $imagePath;
  }

//Getter
  public function getNom(){
=======
    public function __construct(string $nom, string $espece, int $age){
        //Echapper les données si attaque xss
        $this->nom = htmlspecialchars($nom);
        $this->age = htmlspecialchars($age);
        $this->espece = htmlspecialchars($espece);
    }

//Getter
    public function getNom(){
>>>>>>> f4813ed (Ajout de commentaire)
		return $this->nom;
	}

  public function getAge(){
		return $this->age;
	}

  public function getEspece(){
		return $this->espece;
	}

<<<<<<< HEAD
  public function getImagePath(){
    return $this->imagePath;
  }

  public function getId(){
    return $this->id; 
  }

=======
//To String
>>>>>>> f4813ed (Ajout de commentaire)
  public function __toString() {
    return "{$this->nom} est un {$this->espece} de {$this->age} ans.";
  }
}


?>
