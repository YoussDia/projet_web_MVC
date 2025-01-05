<?php
require_once 'view/View.php';
require_once 'control/Controller.php';
require_once 'model/Animal.php';
require_once 'model/AnimalStorageStub.php';
    
 class PathInfoRouter{
    public function main(AnimalStorage $animalStorage){
        $feedback = isset($_SESSION['feedback']) ? $_SESSION['feedback'] : null;
        $v = new View("","",$this,$feedback);
        unset($_SESSION['feedback']);

        $controller = new Controller($v,$animalStorage);
        if(key_exists ('PATH_INFO',$_SERVER)){
            $id = substr($_SERVER['PATH_INFO'],1);
            if($id === 'liste'){
                $controller->showList();
            }
            else if ($id === 'nouveau') {
                $controller->createNewAnimal();
            }
            else if ($id === 'sauverNouveau') {
                $controller->saveNewAnimal($_POST);
            }
            else if(empty($id)){
                $controller->showPageAccueil();
            }
            else{
                $controller->showInformation($id);
            }
        }
        else{
            $controller->showPageAccueil();
        }
        $v->render();
    
    }
    public function getAccueilURL(){
        return $_SERVER['SCRIPT_NAME'];
    }

    public function getAnimalURL($id){
        return $id;
    }
    
    public function getListeURL(){
        return $_SERVER['SCRIPT_NAME']."/liste";
    }
    
    public function getAnimalCreationURL(){
        return $_SERVER['SCRIPT_NAME']."/nouveau";
    }

    public function getAnimalSaveURL(){
        return $_SERVER['SCRIPT_NAME']."/sauverNouveau";
    }
    
    public function POSTredirect($url, $feedback){
        // Enregistrer le feedback dans la session
        $_SESSION['feedback'] = $feedback;
        //permet d'envoyer l'en-tête HTTP pour rediriger vers l'URL
        header("Location: ".$url,true,303);
        die;//pour s'assurer que le scrip s'arrete après la redirection

    }
}

?>