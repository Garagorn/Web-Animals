<?php
require_once("ViewInterface.php");

/**
<<<<<<< HEAD
 * Affichage html 
=======
>>>>>>> f4813ed (Ajout de commentaire)
 * Gestion de l'affichage HTML en fonction de l'état du modèle
 */
class View implements ViewInterface{
    public $title;
    public $content;

    private $router;
    private array $menu;
    private ?string $feedback; //String ou null si aucun feedback

    public function __construct(Router $routeur,?string $feedback=null){
        $this->router = $routeur;
        $this->feedback =$feedback;
    }

/******************************************************************************/
	/* Méthodes de génération des pages                                           */
	/******************************************************************************/

    /**
     * Page d'accueil 
     */
    public function prepareAccueilPage(): void{
		$this->title = "Page d'accueil";
        $this->content = "<p>  Vous êtes sur la page d'accueil </p>";
	}

    /**
     * Affichage de la page del'animal
     * @param animal L'animal à afficher sur la page
     */
    public function prepareAnimalPage(Animal $animal):void{
        //Echapper les informations
        $this->title = "Page sur " .self::htmlesc($animal->getNom());
        $this->content = "<p>" . self::htmlesc($animal->getNom()) ." est un " . self::htmlesc($animal->getEspece())." de " . self::htmlesc($animal->getAge()) ." ans.</p>";
        $imageName = $animal->getImagePath();
        $imageHtml = '';
        if ($imageName !== null && $imageName !== '') {
            $serverPath = 'image/' . $imageName;
            $webPath = './image/' . self::htmlesc($imageName);
            if (file_exists($serverPath)){
                $imageHtml = "<img src='{$webPath}' alt='Image de ". self::htmlesc($animal->getNom()) . "'>";
            }
            else{
                $imageHtml = "<p><strong> IMAGE INTROUVABLE </strong></p>";
            }
        }
        $this->content .= $imageHtml;
    }

	public function prepareAnimalCreationPage(AnimalBuilder $build): void{
		$this->title ="Créer un nouvel animal";
		$saveURL = htmlspecialchars($this->router->getAnimalSaveURL());

        //Recuperer les informations enregistrees
		$data = $build->getData();
    	$error = $build->getError();

        //Echapper les informations
        $nom = self::htmlesc($data[AnimalBuilder::NAME_REF]??'');
        $espece = self::htmlesc($data[AnimalBuilder::SPECIES_REF]??'');
        $age = self::htmlesc($data[AnimalBuilder::AGE_REF]??'');

        $errorA='';
        if($error != null){
            //Echapper les erreurs
            $errorA=self::htmlesc($error);
        }
        //Renvoyer le formulaire avec les erreurs et les champs deja remplis
		$this->content = "
        {$errorA}
		<form method='POST' action='$saveURL' enctype='multipart/form-data'>
			<div>
				<label for='nom'>Nom :</label>
				<input type='text' id='nom' name='".AnimalBuilder::NAME_REF."' value='{$nom}' />
			</div>
			
			<div>
				<label for='espece'>Espèce :</label>
				<input type='text' id='espece' name='".AnimalBuilder::SPECIES_REF."' value='{$espece}' />
			</div>
			
			<div>
				<label for='age'>Âge :</label>
				<input type='number' id='age' name='".AnimalBuilder::AGE_REF."' value='{$age}' />
			</div>
			
            <div>
                <label for='image'>Image :</label>
                <input type='file' id='image' name='image' accept='image/*' />
            </div>
			<div>
				<button type='submit'>Créer l'animal</button>
			</div>
		</form>
		";
    }

    /**
     * Afficher la liste des animaux 
     * @param listeAnimaux le tableau a afficher sur la page
     */
    public function prepareListPage($listeAnimaux): void{
        $this->title="Liste  des animaux";
<<<<<<< HEAD
        $this->content= "<ul>";
        //$this->content= "<ul class=\"gallery\">";
=======
        //$this->content= "<ul>";
        $this->content= "<ul class=\"gallery\">";
>>>>>>> f4813ed (Ajout de commentaire)
        foreach($listeAnimaux as $cle=>$animal){
            //Echapper les informations
            $nom = self::htmlesc($animal->getNom());
            $url = $this->router->getAnimalURL($cle);
            $this->content .= "<li><a href='{$url}'>{$nom}</a></li>";
        }
        $this->content.= "</ul>";
	}

    public function displayAnimalCreationSuccess(string $id): void {
    	$url = $this->router->getAnimalURL($id);
    	$this->router->POSTredirect($this->router->getAnimalURL($id), "Animal creer avec succès !");
	}
 
/******************************************************************************/
/* Erreurs, debug et test                                                     */
/******************************************************************************/

	public function prepareTestPage(): void{
        $this->title = "Titre de la page";
        $this->content = "<p> Contenu de la page </p>";
    }

    public function prepareDebugPage($variable): void{
        $this->title = 'Debug';
        $this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
    }
    
    public function prepareUnknownAnimalPage(): void{
		$this->title = "Animal inconnu";
        $this->content = "<p>  Animal inconnu est d'une espèce inconnue </p>";
	}
    
    public function prepareUnknownActionPage(): void{
		$this->title = "Erreur";
		$this->content = "La page demandée n'existe pas.";
	}
    
    private function prepareUnexpectedErrorPage(): void {
        $this->title = 'Erreur';
        $this->content = '<p>Une erreur inattendue s\'est produite.</p>';
    }

/******************************************************************************/
/* Méthodes utilitaires                                                       */
/******************************************************************************/

	protected function getMenu() {
        return array(
            "Accueil" => $this->router->homePage(),
            "Liste animaux" => $this->router->allAnimalsPage(),
            "Créer un animal" => $this->router->getAnimalCreationURL(),
        );
    }

	/* Une fonction pour échapper les caractères spéciaux de HTML,
	* car celle de PHP nécessite trop d'options. */
	public static function htmlesc($str) {
		return htmlspecialchars($str,
			/* on échappe guillemets _et_ apostrophes : */
			ENT_QUOTES
			/* les séquences UTF-8 invalides sont
			* remplacées par le caractère �
			* au lieu de renvoyer la chaîne vide…) */
			| ENT_SUBSTITUTE
			/* on utilise les entités HTML5 (en particulier &apos;) */
			| ENT_HTML5,
			'UTF-8');
	}

/******************************************************************************/
/* Rendu de la page                                                           */
/******************************************************************************/

    public function render(): void{
        if ($this->title === null || $this->content === null) {
            $this->prepareUnexpectedErrorPage();
        }
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <title><?php echo $this->title; ?></title>
            <meta charset="UTF-8" />
        	<base href="<?php echo dirname($_SERVER['SCRIPT_NAME']) . '/'; ?>" />
    		<link rel="stylesheet" href="skin/screen.css" />
        </head>
        <body>
            <nav class="menu">
                <ul>
        <?php
        /* Construit le menu à  partir d'un tableau associatif texte=>lien. */
        foreach ($this->getMenu() as $text => $link) {
            echo "<li><a href=\"$link\">$text</a></li>";
        }
        ?>
                </ul>
            </nav>
            <main>
		        <?php if (!empty($this->feedback)) : ?>
					<div class="feedback">
						<?php echo self::htmlesc($this->feedback); ?>
					</div>
				<?php endif; ?>
                <h1><?php echo $this->title; ?></h1>
        <?php
        echo $this->content;
        ?>
            </main>
        </body>
        </html>
        <?php /* fin de l'affichage de la page et fin de la méthode render() */
	}

}
?>
