<?php
class View{
    public $title;
    public $content;

    private $router;

    public function __construct(Router $routeur){
        $this->router = $routeur;

    }

    public function render(): void{
        echo"
            <!DOCTYPE html> 
            <html lang='fr'>
            <head>
            <meta charset = 'UTF-8'>
            <title> {$this->title} </title>
            </head>
            <body>
            <h1> {$this->title}</h1>
                {$this->content}
            </body>
            </html>";
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

}
?>
