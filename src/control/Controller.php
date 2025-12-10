<?php
set_include_path("./src");
require_once("model/Animal.php");
require_once("model/AnimalStorage.php");
require_once("model/AnimalBuilder.php");
/**
 * Modifie le modèle et construit la vue adaptée 
 * en fonction des actions de l'internaute.
 */
class Controller{
    private ViewInterface $view;

    private AnimalStorage $storage;

    public function __construct(ViewInterface $vue,AnimalStorage $storage){
        $this->view = $vue;
        $this->storage = $storage;
    }

    /**
     * Le routeur  demande a afficher la page d'accueil
     * La vue doit renvoyer cette page
     */
	public function afficheDefaut():void{
        $this->view->prepareAccueilPage();
    }

    /**
     * Le routeur  demande a afficher la page d'un animal
     * La vue doit renvoyer cette page
     */
    public function showInformation(string $animalName):void{
        $animal = $this->storage->read($animalName);
        if($animal !=null){ //L'animal existe
            $this->view->prepareAnimalPage($animal);
        }
        else{ //Aucun animal avec ce nom -> erreur
            $this->view->prepareUnknownAnimalPage();
        }
    }

    /**
     * Le routeur  demande a afficher la liste des animaux
     * La vue doit renvoyer cette page
     */
    public function showList():void{
        //Costruction du tableau
        $listeAnimaux = $this->storage->readAll();
        
        //Afficher ce tableau dans la vue
        $this->view->prepareListPage($listeAnimaux);
    }

    /**
     * Le routeur  demande a creer un nouvel animal
     * La vue doit renvoyer cette page
     */
    public function createNewAnimal(): void{
	    $build = new AnimalBuilder([]); //Création du builder pour feedback..
        //Afficher le formulaire et remettre les informations au besoin
        $this->view->prepareAnimalCreationPage($build);
    }

	/**
     * Enregistrer un nouvel ainimal 
     * @param data Les informations de cet animal
     */
	public function saveNewAnimal(array $data){
<<<<<<< HEAD
        $imagePath = null;
        if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            try {
                if (!isset($_FILES['image']['error']) || is_array($_FILES['image']['error'])) {
                    throw new RuntimeException('Paramètres invalides.');
                }
                if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
                    throw new RuntimeException('Fichier trop volumineux (max 2Mo).');
                }
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mime = $finfo->file($_FILES['image']['tmp_name']);
                $extensions = [
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                    'webp' => 'image/webp'
                ];
                if (false === $ext = array_search($mime, $extensions, true)) {
                    throw new RuntimeException('Format de fichier non supporté (jpg, png, gif, webp uniquement).');
                }
                $nomUnique = sprintf('%s.%s', sha1_file($_FILES['image']['tmp_name']) . uniqid(), $ext);
                $cheminComplet = './image/' . $nomUnique;
                if (!move_uploaded_file($_FILES['image']['tmp_name'], $cheminComplet)) {
                    throw new RuntimeException('Impossible de sauvegarder le fichier.');
                }
                $imagePath = $nomUnique;              
            } 
            catch (RuntimeException $e) {
                $data['error_image'] = $e->getMessage();
            }
        }
        $data[AnimalBuilder::IMAGE_REF] = $imagePath;
        //Creer le build avec les informations
        $build = new AnimalBuilder($data);

        //Buiilder invalide
        if (!$build->isValid()) {
            //Il faut re-remplir le formulaire mais avec les données et feedback
            $this->view->prepareAnimalCreationPage($build);
            return null;
        }
        $animal = $build->createAnimal();
        $id = $this->storage->create($animal);
        $this->view->displayAnimalCreationSuccess($id);
    }
=======
        //Creer le build avec les informations
		$build = new AnimalBuilder($data);

        //Buiilder invalide
		if(!$build->isValid()){
            //Il faut re-remplir le formulaire mais avec les données et feedback
        	$this->view->prepareAnimalCreationPage($build);
            return null;
        }
        //Build valide
		$animal = $build->createAnimal();
		$id = $this->storage->create($animal);
		$this->view->displayAnimalCreationSuccess($id);
	}
>>>>>>> f4813ed (Ajout de commentaire)
}
?>
