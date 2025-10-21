<?php
class View{
    public $title;
    public $content;

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

    public function prepareAnimalPage($name,$species):void{
        $this->title = "Page sur {$name}";
        $this->content = "<p> {$name} est un animal de l'espèce {$species} </p>";
    }

	public function prepareUnknownAnimalPage(): void{
		$this->title = "Animal inconnu";
        $this->content = "<p>  Animal inconnu est un animal de l'espèce inconnue </p>";
	}

    public function prepareAccueilPage(): void{
		$this->title = "Page d'accueil";
        $this->content = "<p>  Vous êtes sur la page d'accueil </p>";
	}

}
?>
