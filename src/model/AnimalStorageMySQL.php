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

    public function create(Animal $a): String {
        throw new Exception("not yet implemented");
    }

    public function delete($id): Boolean {
        throw new Exception("not yet implemented");
    }

    public function update($id, Animal $a): Boolean {
        throw new Exception("not yet implemented");
    }
}
/*
public function enregistrer(): bool{
    	$connection= connecter();
    	if($connection==null){
    		return false;
    	}
    	else{
            $requete="INSERT INTO Animals (nom,espece,age) VALUES ('$this->age','$this->espece','$this->age')";
            $connection->query($requete);
            if($connection->query($requete)){
                $this->idA= $connection->lastInsertId();
            }
            return true;
    	}
    }
    
    public function modifier(string $nouveau_titre,string $nouveau_groupe,string $nouvel_album): bool{
    	$connection= connecter();
    	if($connection==null){
    		return false;
    	}
	else{
        $requete = "UPDATE Musique  SET titre ='$nouveau_titre',groupe ='$nouveau_groupe',album ='$nouvel_album' WHERE idM =$this->idM";
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
        $requete="DELETE FROM Musique WHERE idM='$this->idM'";
        $connection->query($requete);
	}
	return true;
    }
*/
