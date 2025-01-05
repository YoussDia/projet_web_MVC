<?php

class AnimalBuilder{
    protected $data;
    protected $error;
    const NAME_REF = "nom";
    const SPECIES_REF = "espece";
    const AGE_REF = "age";

    public function __construct($data=null){
        if ($data === null) {
			$data = array(
				self::NAME_REF => "", // les valeurs par default
				self::SPECIES_REF => "",
                self::AGE_REF => ""
			);
		}
        $this->data = $data;
        $this->error = null;
    }
    // getter l'attribut $data
    public function getData() {
        return $this->data;
    }

    // getter l'attribut $error
    public function getError() {
        return $this->error;
    }

    // Crée et retourne une nouvelle instance de Animal 
    public function createAnimal() {
        if (!key_exists(self::NAME_REF, $this->data) || !key_exists(self::SPECIES_REF, $this->data) || !key_exists(self::AGE_REF, $this->data) || !key_exists('imagePath', $this->data)){
			throw new Exception("Missing fields for Animal creation");
        }
        return new Animal($this->data[self::NAME_REF], $this->data[self::SPECIES_REF], $this->data[self::AGE_REF],$this->data['imagePath']);
    }

    public function isValid() {
        // Vérification que les données sont valides
        if ((!key_exists(self::NAME_REF, $this->data) || $this->data[self::NAME_REF] === "")) {
            $this->error = "Le nom de l'animal est requis.";
            return false;
        }
        if ((!key_exists(self::SPECIES_REF, $this->data) || $this->data[self::SPECIES_REF] === "")) {
            $this->error = "L'espèce de l'animal est requise.";
            return false;
        }
        if ((!key_exists(self::AGE_REF, $this->data)) || !is_numeric($this->data[self::AGE_REF]) || $this->data[self::AGE_REF] < 0) {
            $this->error ="L'âge de l'animal doit être supperieur à 0.";
            return false;
        }
        return true;
    }
}


?>