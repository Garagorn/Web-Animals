<?php 
/*
set_include_path("./src");
require_once("model/Animal.php");
require_once("model/AnimalStorage.php");
*/
require_once __DIR__ . "/Animal.php";
require_once __DIR__ . "/AnimalStorage.php";

/**
 * Classe de gestion des animaux avec une base de données
 */
class AnimalStorageMySQL implements AnimalStorage{
	private PDO $pdo; //Objet PDO
	
	public function __construct(?PDO $pdo = null) {
	    if ($pdo !== null) {
			$this->pdo = $pdo;
    	}
    }

	/**
	 * Fonction pour lire en bd les informations d'un animal
	 * @param id L'identifiant de  l'animal à lire
	 * @return Animal l'objet animal construit à partir du retour de la requete
	 */
    public function read(string $id): ?Animal {
<<<<<<< HEAD
		//Requete
		$requete = "SELECT idA, nom, espece, age, image FROM Animals WHERE idA = :id";
=======
		//Requete 
		$requete = "SELECT idA, nom, espece, age FROM Animals WHERE idA = :id";
>>>>>>> f4813ed (Ajout de commentaire)
		//Preparer la requete
		$stmt = $this->pdo->prepare($requete);
		//Execution de la requete
		$stmt->execute([":id" => $id]);
		//Méthode d'association
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
    
	/**
	 * Fonction pour lire en bd tous les animaux
	 * @return animals Le tableau des objets animaux
	 */
	public function readAll(): array {
    	$animals = []; //Le tableau ou stocker les animaux  

		$requete = "SELECT * FROM Animals"; 
		$stmt = $this->pdo->query($requete);

		//Parcourir tous les animaux de la basse
		while ($a = $stmt->fetch(PDO::FETCH_ASSOC)) {
			//Placer l'animal courant a dans le talbeau en creant l'animal avec les informations de a
		    $animals[$a['idA']] = new Animal(
		        $a['nom'],
		        $a['espece'],
		        $a['age'],
		        $a['idA']
		    );
		}
    	return $animals;
	}

	/**
	 * Fonction pour ajouter en bd un animal
	 * @param a L'animal à ajouter en bd
	 * @return idA L'id de l'animal qui vient d'etre ajouter
	 */
    public function create(Animal $a): string {
		$requete = "INSERT INTO Animals (nom, espece, age, image) VALUES (:nom, :espece, :age, :image)";
		$stmt = $this->pdo->prepare($requete);

		//Utilisation d'une requete preparee
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
