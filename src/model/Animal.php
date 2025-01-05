<?php 
class Animal{
    public $nom;
    public $age;
    public $espece;
    public $imagePath;

    public function __construct(String $nom,String $espece,int $age,String $imagePath = null){
        $this->nom = $nom;
        $this->age = $age;
        $this->espece = $espece;
        $this->imagePath = $imagePath;
    }

    public function getNom(){
        return $this->nom;
    }
    
    public function getAge(){
        return $this->age;
    }

    public function getEspece(){
        return $this->espece;
    }
    
    public function getImagePath() {
        return $this->imagePath;
    }
}


?>