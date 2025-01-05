<?php
require_once 'view/View.php';
require_once 'control/Controller.php';
require_once 'model/Animal.php';
require_once 'model/AnimalStorageStub.php';

 class Router{
    public function main(AnimalStorage $animalStorage){


        // On initialise la vue, avec le feedback venant de la session
        $feedback = isset($_SESSION['feedback']) ? $_SESSION['feedback'] : null;

        $v = new View("","",$this,$feedback);
        unset($_SESSION['feedback']);
        $controller = new Controller($v,$animalStorage);
        if(isset($_GET['id'])){
            $id = $_GET['id'];
            $controller->showInformation($id);
            // $v->render();
        }
        else if(key_exists('action',$_GET) && $_GET['action']==='liste'){
            $controller->showList();
        }
        else if(key_exists('action',$_GET) && $_GET['action']==='nouveau'){
            $controller->createNewAnimal();
        }
        else if(key_exists('action',$_GET) && $_GET['action']==='sauverNouveau'){
            $controller->saveNewAnimal($_POST);
        }
        else{
            $controller->showPageAccueil();
        }
        $v->render();
    
    }
    public function POSTredirect($url, $feedback){
        // Enregistrer le feedback dans la session
        $_SESSION['feedback'] = $feedback;
        //permet d'envoyer l'en-tête HTTP pour rediriger vers l'URL
        header("Location: ".$url,true,303);
        die;//pour s'assurer que le scrip s'arrete après la redirection

    }
    // recuper l'url de la page d'accueil
    public function getAccueilURL(){
        return "./site.php";
    }
    // la page d'un animal
    public function getAnimalURL($id){
        return "?id=".htmlspecialchars($id);
    }
    // l'url de la page pour la liste des animaux 
    public function getListeURL() {
        return "?action=liste";
    }
    // l'url de la page pour la 
    public function getAnimalCreationURL(){
        return "?action=nouveau";
    }

    public function getAnimalSaveURL(){
        return "?action=sauverNouveau";
    }   
 }
?>