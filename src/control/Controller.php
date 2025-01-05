<?php
require_once ("model/AnimalBuilder.php");

class Controller{
    public  $view;
    //public $animalsTab = array();
    public $animalStorage;

    public function __construct(View $view,AnimalStorage $animalStorage){
        $this->view = $view;
        // $this->animalsTab = array('medor'=> new Animal('Médor', 'chien', 2),
        //                           'felix'=> new Animal('Félix', 'chat', 4),
        //                           'denver' =>  new Animal('Denver', 'dinosaure', 100));
        $this->animalStorage = $animalStorage;
    }

    public function showInformation($id) {
        if (array_key_exists(htmlspecialchars($id), $this->animalStorage->readAll())) {
            // je recupere l'animal ayant l'identifiant donnee
            $animal = $this->animalStorage->read($id);
            // je prepare un animal ayant les informations concenant l'identifiant qu'il a fourni 
            $this->view->prepareAnimalPage($animal);
            //$this->view->render();
        } else {
            $this->view->prepareUnknownAnimalPage();
            //$this->view->render();
        }
    }

    public function showPageAccueil(){
        $this->view->preparePageAccueil();
        //$this->view->render();
    }
    public function showList(){
        $this->view->prepareListPage($this->animalStorage->readAll());
        //$this->view->render();
    }
    
    public function createNewAnimal(){
        $animalBuilder = new AnimalBuilder();
        $this->view->prepareAnimalCreationPage($animalBuilder);
    }
    
    // cette methode cree et enregiste l'animal dans la session
    public function saveNewAnimal(array $data){
        // je dis que le chemin de l'image est null 
        // comme ca si je n'ai pas d'image ,la vans la bdd est null
        $data['imagePath'] = null;
        
        $animal = new AnimalBuilder($data);
        // si l'annimal n'est pas valide ,je reaffiche le formulaire avec les données precedente
        if (!$animal->isValid()) {
            $this->view->prepareAnimalCreationPage($animal);
            return;
        }

        
        if (key_exists('image',$_FILES) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // les format autorisé
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];
            //je verifie si le format de l'image est autoriser 
            $fileType = mime_content_type($_FILES['image']['tmp_name']);
            if (in_array($fileType, $allowedMimeTypes)) {
                // le repertoire de mes images 
                $uploadsDir = './uploads';
                // si mon repertoire n'existe pas je le cree
                if (!is_dir($uploadsDir)) {
                    mkdir($uploadsDir, 0755, true); // Créer le dossier si nécessaire
                }
                // permet de generer un identifiant unique 
                $filename = uniqid().basename($_FILES['image']['name']);
                // le chemin de l'image
                $targetFilePath = $uploadsDir .'/'. $filename;
                // je deplace l'image de tmp vers mon chemin
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $data['imagePath'] = $filename;
                } else {
                    $this->view->prepareAnimalCreationPage($animal);
                    return;
                }
            } else {
                $this->view->prepareErrorCreationPage();
                return;
            }
        }

        $animal = new AnimalBuilder($data);
        if ($animal->isValid()){
            $animal = $animal->createAnimal();
            $animalID = $this->animalStorage->create($animal);
            $this->view->displayAnimalCreationSuccess($animalID);
            //$this->view->prepareErrorCreationPage();
            
        }
        else{
            $this->view->prepareAnimalCreationPage($animal);
            
        }

    }
}
?>