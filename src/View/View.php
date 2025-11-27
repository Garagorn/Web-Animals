<?php
class View{
    public $title;
    public $content;

    private $router;
    private array $menu;
    private ?string $feedback;

    public function __construct(Router $routeur,?string $feedback=null){
        $this->router = $routeur;
        $this->feedback =$feedback;
    }

    public function prepareTestPage(): void{
        $this->title = "Titre de la page";
        $this->content = "<p> Contenu de la page </p>";
    }

    public function prepareAnimalPage(Animal $animal):void{
        $this->title = "Page sur {$animal->getNom()}";
        $this->content = "<p>" . htmlspecialchars($animal->getNom()) ." est un " . htmlspecialchars($animal->getEspece())." de " . htmlspecialchars($animal->getAge()) ." ans.</p>";
    }

	public function prepareUnknownAnimalPage(): void{
		$this->title = "Animal inconnu";
        $this->content = "<p>  Animal inconnu est d'une espèce inconnue </p>";
	}

    public function prepareAccueilPage(): void{
		$this->title = "Page d'accueil";
        $this->content = "<p>  Vous êtes sur la page d'accueil </p>";
	}

    public function prepareListPage($listeAnimaux): void{
        $this->title="Liste  des animaux";
        $this->content= "<ul>";
        foreach($listeAnimaux as $cle=>$animal){
            $nom = htmlspecialchars(($animal->getNom()));
            $url = $this->router->getAnimalURL($cle);
            $this->content .= "<li><a href='{$url}'>{$nom}</a></li>";
        }
        $this->content.= "</ul>";
	}

    protected function getMenu() {
        return array(
            "Accueil" => $this->router->homePage(),
            "Liste animaux" => $this->router->allAnimalsPage(),
            "Créer un animal" => $this->router->getAnimalCreationURL(),
        );
    }

	public function prepareAnimalCreationPage(AnimalBuilder $build){
		$this->title ="Créer un nouvel animal";
		$saveURL = htmlspecialchars($this->router->getAnimalSaveURL());

		$data = $build->getData();
    	$error = $build->getError();

        $nom = htmlspecialchars($data[AnimalBuilder::NAME_REF]??'');
        $espece = htmlspecialchars($data[AnimalBuilder::SPECIES_REF]??'');
        $age = htmlspecialchars($data[AnimalBuilder::AGE_REF]??'');

        $errorA='';
        if($error != null){
            $errorA=$error;
        }
		$this->content = "
        {$errorA}
		<form method='POST' action={$saveURL}>
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
				<button type='submit'>Créer l'animal</button>
			</div>
		</form>
		";
    }

    private function prepareUnexpectedErrorPage(): void {
        $this->title = 'Erreur';
        $this->content = '<p>Une erreur inattendue s\'est produite.</p>';
    }
    
    public function displayAnimalCreationSuccess(string $id): void {
    	$url = $this->router->getAnimalURL($id);
    	$this->router->POSTredirect($this->router->getAnimalURL($id), "Animal creer avec succès !");
	}

    
///Debug 

    public function prepareDebugPage($variable) {
        $this->title = 'Debug';
        $this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
    }

///Rendu de la page

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
            <link rel="stylesheet" href="skin/screen.css" />
            <style>
        <?php echo $this->style; ?>
            </style>
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
						<?php echo htmlspecialchars($this->feedback); ?>
					</div>
				<?php endif; ?>
                <h1><?php echo $this->title; ?></h1>
        <?php
        echo $this->content;
        ?>
            </main>
        </body>
        </html>
        <?php /* fin de l'affichage de la page et fin de la mÃ©thode render() */
	}

}
?>
