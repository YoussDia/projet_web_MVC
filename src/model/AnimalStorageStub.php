<?php
require_once 'model/AnimalStorage.php';

class AnimalStorageStub implements AnimalStorage{
    protected $animalTab = array();

    public function __construct(){
        $this->animalTab = array('medor'=> new Animal('Médor', 'chien', 2),
                                'felix'=> new Animal('Félix', 'chat', 4),
                                'denver' =>  new Animal('Denver', 'dinosaure', 100));
    }

    //renvoyer l'instance de Animal ayant pour identifiant celui passé en argument
    // ou null si aucun animal n'a cet identifiant
    public function read($id){
        if(key_exists($id,$this->animalTab)){
            return $this->animalTab[$id];
        }
        else{
            return null;
        }
    }
    //renvoyer un tableau associatif identifiant ⇒ animal contenant tous les animaux de la « base »
    public function readAll(){
        return $this->animalTab;
    }
    //ajoute à la base l'animal donné en argument, et retourne l'identifiant de l'animal ainsi créé. 
    public function create(Animal $a){
        throw new BadMethodCallException("La méthode n'est pas encore definit");
    }
    //supprime de la base l'animal correspondant à l'identifiant donné en argument ;
    // retourne true si la suppression a été effectuée et false si l'identifiant ne correspond à aucun animal. 
    public function delete(Animal $a){
        throw new BadMethodCallException("La méthode n'est pas encore definit");
    }

    //met à jour dans la base l'animal d'identifiant donné, en le remplaçant par l'animal donné
    //return true si la mise à jour est effectuer et false si l'identifant n'existe pas 
    public function update($id, Animal $a){
        throw new BadMethodCallException("La méthode n'est pas encore definit");
    }






    
}

?>