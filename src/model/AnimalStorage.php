<?php
interface AnimalStorage{
    public function read($id);
    public function readAll();
    //ajoute à la base l'animal donné en argument, et retourne l'identifiant de l'animal ainsi créé. 
    public function create(Animal $a);
    //supprime de la base l'animal correspondant à l'identifiant donné en argument ;
    // retourne true si la suppression a été effectuée et false si l'identifiant ne correspond à aucun animal. 
    public function delete(Animal $a);

    //met à jour dans la base l'animal d'identifiant donné, en le remplaçant par l'animal donné
    //return true si la mise à jour est effectuer et false si l'identifant n'existe pas 
    public function update($id, Animal $a);


}   

?>