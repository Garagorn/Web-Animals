<?php

require_once("model/Animal.php");

class AnimalBuilder{

	public const NAME_REF = "NOM";
	public const SPECIES_REF = "ESPECE";
	public const AGE_REF = "AGE";

	protected $error;
	protected $data;

	public function __construct($data=null) {
		$this->data = $data;
		$this->error = array();
	}
	
	public function getData(){
		return $this->data;
	}
	
	public function getError(){
		return $this->error;
	}
	
	public function createAnimal() {
		if (!$this->isValid()){
			return null;
		}
		$nom = trim($this->data[SELF::NAME_REF]);
		$espece = trim($this->data[SELF::SPECIES_REF]);
		$age = $this->data[SELF::AGE_REF];
		return new Animal($nom,$espece,$age);
	}
	
    public function isValid() {
        $nom = trim($this->data[SELF::NAME_REF] ?? '');
        $espece = trim($this->data[SELF::SPECIES_REF] ?? '');
        $age = $this->data[SELF::AGE_REF] ?? '';

        if ($nom === '' || $espece === '') {
            $this->error = "Le nom et l'espèce ne peuvent pas être vides.";
            return false;
        }
        if (!is_numeric($age) || $age < 0) {
            $this->error = "L'âge doit être un nombre positif.";
            return false;
        }
        return true;
    }

}
