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
	
	public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

    public function read(string $id): ?Animal {
		$requete = "SELECT idA, nom, espece, age FROM Animals WHERE idA = :id";
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
		    $a['idA']
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
		$requete = "INSERT INTO Animals (nom, espece, age) VALUES (:nom, :espece, :age)";
		$stmt = $connection->prepare($requete);
		$stmt->execute([
		    ':nom'    => $a->getNom(),
		    ':espece' => $a->getEspece(),
		    ':age'    => $a->getAge()
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
/*
public function modifier(string $nouveau_nom,string $nouvelle_espece,int $nouvel_age): bool{
    	$connection= connecter();
    	if($connection==null){
    		return false;
    	}
	else{
        $requete = "UPDATE Animals  SET nom ='$nouveau_nom',espece ='$nouvelle_espece',album ='$nouvel_age' WHERE idA =$this->idA";
        $connection->query($requete);
	}
	return true;
    }
    
    public function supprimer(): bool{
        $connection= connecter();
    	if($connection==null){
    		return false;
    	}
	else{
        $requete="DELETE FROM Animals WHERE idA='$this->idA'";
        $connection->query($requete);
	}
	return true;
    }
*/
