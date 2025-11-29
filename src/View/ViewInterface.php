<?php
/**
 * Interface de la vue pour Site et API
 */
interface ViewInterface {
    //Méthodes communes
    public function prepareAnimalPage(Animal $animal): void;

    public function prepareListPage(array $listeAnimaux): void;

    public function prepareUnknownAnimalPage(): void;
    
    public function render(): void;
}
?>
