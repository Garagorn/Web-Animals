<?php
class View{
    public $title;
    public $content;

    public function ___construct($title, $content) {
        $this->title = $title;
        $this->content = $content;
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

    public function prepareAnimalPage($name,$species){
        $this->title = "Page sur {$name}";
        $this->content = "<p> {$name} est un animal de l'espèce {$species} </p>";
    }

	public function main(){
		
	}

}
?>
