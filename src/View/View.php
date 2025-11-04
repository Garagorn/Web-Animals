<?php
class View{
    public $title;
    public $content;

    private $router;
    private array $menu;

    public function __construct(Router $routeur){
        $this->router = $routeur;
    }

    public function prepareTestPage(): void{
        $this->title = "Titre de la page";
        $this->content = "<p> Contenu de la page </p>";
    }

    public function prepareAnimalPage(Animal $animal):void{
        $this->title = "Page sur {$animal->getNom()}";
        $this->content = "<p> {$animal->getNom()} est un {$animal->getEspece()} de {$animal->getAge()} ans. </p>";
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
            "Liste animaux" => $this->router->allAnimauxPage(),
        );
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
        /* Construit le menu à partir d'un tableau associatif texte=>lien. */
        foreach ($this->getMenu() as $text => $link) {
            echo "<li><a href=\"$link\">$text</a></li>";
        }
        ?>
                </ul>
            </nav>
            <main>
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
