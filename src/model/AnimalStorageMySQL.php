<?php 
/*
set_include_path("./src");
require_once("model/Animal.php");
require_once("model/AnimalStorage.php");
*/
require_once __DIR__ . "/Animal.php";
require_once __DIR__ . "/AnimalStorage.php";

class AnimalStorageMySQL implements AnimalStorage{
	private PDO $pdo;
	
	public function __construct(?PDO $pdo = null) {
	    if ($pdo !== null) {
			$this->pdo = $pdo;
		return;
    	}
    }

    public function read(string $id): ?Animal {
		$requete = "SELECT idA, nom, espece, age, image FROM Animals WHERE idA = :id";
		$stmt = $this->pdo->prepare($requete);
		$stmt->execute([":id" => $id]);
		$a = $stmt->fetch(PDO::FETCH_ASSOC);
		
		if ($a === false) {
		    return null;
		}

		return new Animal(
		    $a['nom'],
		    $a['espece'],
		    $a['age'],
		    $a['idA'],
			$a['image'] ?? null
		);
	}
    
	public function readAll(): array {
    	$animals = [];
		$requete = "SELECT * FROM Animals"; 
		$stmt = $this->pdo->query($requete);

		while ($a = $stmt->fetch(PDO::FETCH_ASSOC)) {
		    $animals[$a['idA']] = new Animal(
		        $a['nom'],
		        $a['espece'],
		        $a['age'],
		        $a['idA']
		    );
		}
    	return $animals;
	}

    public function create(Animal $a): string {
		$requete = "INSERT INTO Animals (nom, espece, age, image) VALUES (:nom, :espece, :age, :image)";
		$stmt = $this->pdo->prepare($requete);
		$stmt->execute([
		    ':nom'    => $a->getNom(),
		    ':espece' => $a->getEspece(),
		    ':age'    => $a->getAge(),
			':image'  => $a->getImagePath(),
		]);
		return $this->pdo->lastInsertId();
	}

    public function delete($id): Boolean {
        throw new Exception("not yet implemented");
    }

    public function update($id, Animal $a): Boolean {
        throw new Exception("not yet implemented");
    }
}
