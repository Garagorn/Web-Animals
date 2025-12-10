<?php
set_include_path("./src");
require_once("model/Animal.php");
require_once("model/AnimalStorage.php");
require_once("model/AnimalBuilder.php");

class Controller{
    private $view;

    private AnimalStorage $storage;

    public function __construct(View $vue,AnimalStorage $storage){
        $this->view = $vue;
        $this->storage = $storage;
    }

	public function afficheDefaut():void{
        $this->view->prepareAccueilPage();
    }

    public function showInformation(string $animalName):void{
        $animal = $this->storage->read($animalName);
        if($animal !=null){
            $this->view->prepareAnimalPage($animal);
        }
        else{
            $this->view->prepareUnknownAnimalPage();
        }
    }

    public function showList():void{
        $listeAnimaux = $this->storage->readAll();
        $this->view->prepareListPage($listeAnimaux);
    }

    public function createNewAnimal(): void{
	    $build = new AnimalBuilder([]);
        $this->view->prepareAnimalCreationPage($build);
    }

	
	public function saveNewAnimal(array $data){
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
            if (!is_dir('./image')) {
                mkdir('./image', 0755, true);
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
    $build = new AnimalBuilder($data);

    if (!$build->isValid()) {
        $this->view->prepareAnimalCreationPage($build);
        return null;
    }
    $animal = $build->createAnimal();
    $id = $this->storage->create($animal);
    $this->view->displayAnimalCreationSuccess($id);
    }
}
?>
