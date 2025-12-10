<?php
require_once __DIR__ . "/ViewInterface.php";
require_once __DIR__ . "/../model/Animal.php";

/**
 * Affichage JSON
 */
class ViewAPI implements ViewInterface {
    private ?array $data = null;    

    public function prepareAnimalPage(Animal $animal): void {
        $this->data = [
            'nom' => $animal->getNom(),
            'espece' => $animal->getEspece(),
            'age' => $animal->getAge()
        ];
    }
    
    /**
     * Affichage des noms et ids des animaux
     */
    public function prepareListPage(array $listeAnimaux): void {
		$this->data = [];

		foreach ($listeAnimaux as $id => $animal) {
			$this->data[] = [
				'id' => $id,
				'nom' => $animal->getNom()
			];
		}
	}

    /**
     * Affichage en cas d'erreur d'id
     */
    public function prepareUnknownAnimalPage(): void {
        $this->data = [
            'error' => 'Animal non trouvé',
        ];
    }

    /**
     * Affichage du php avec le json
     */
    public function render(): void {
        if ($this->data === null) {
            $this->data = [
                'error' => 'Entrez une collection',
            ];
        }
        //Transformer le php en json
<<<<<<< HEAD
<<<<<<< HEAD
        echo json_encode($this->data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
=======
        echo json_encode($this->data);
>>>>>>> f4813ed (Ajout de commentaire)
=======
        echo json_encode($this->data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
>>>>>>> 57aa0ab (DM version finale (Ajout de commentaires))
    }
    
//Méthodes inutilisées
    public function prepareAccueilPage(): void{
		 $this->data = []; 
	}
	
	public function prepareAnimalCreationPage($builder): void{
		 $this->data = []; 
	}
	
	public function prepareDebugPage($var): void{
		 $this->data = []; 
	}
	
	public function prepareUnknownActionPage(): void{
		$this->data = ["error" => "Action inconnue"];
	}
	public function prepareUnexpectedErrorPage(): void{
		$this->data = ["error" => "Erreur inattendue"];
	}

}
?>
