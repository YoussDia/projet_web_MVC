<?php
class View {
    public $title;
    public $content;
    public $routeur;
    public $menu;
    public $feedback;

    public function __construct($title,$content, $routeur,$feedback){
        $this->title = $title;
        $this->content = $content;
        $this->routeur = $routeur; 
        $this->menu = array(
            $this->routeur->getAccueilURL() => "Accueil",
            $this->routeur->getListeURL() => "Liste des animaux",
            $this->routeur->getAnimalCreationURL()=> "Creation d'animal",
        );
        $this->feedback = $feedback;
            
    }

    public function render(){
        echo '<!doctype html>
            <html lang="fr">
                <head>
                    <meta charset="utf-8">
                    <title>'.$this->title.'</title>
                    <link rel="stylesheet" href="style.css">
                    <script src="script.js"></script>
                </head>
                <body>';

                echo '<ul>';
                foreach ($this->menu as $url => $label) {
                    echo '<li><a href="' . $url . '">' . $label . '</a></li>';
                }
                echo '</ul>';

                if ($this->feedback) {
                    echo '<p>' . htmlspecialchars($this->feedback) . '</p>';
                }
                
                echo '<h1>'.$this->title.'</h1>'.
                    '<div>'.$this->content.'</div>'.
        
                
                '</body>
            </html>';
    
    }

    public function prepareTestPage(){
        $this->title = "je suis le titre ";
        $this->content = "<p>Lorem Ipsum is simply dummy 
            text of the printing and typesetting industry. Lorem 
            Ipsum has been the industry's standard dummy text ever 
            since the 1500s, when an unknown printer took a galley of 
            type and scrambled it to make a type specimen book. It has survived 
            not only five centuries, but also the leap into electronic typesetting, </p>";
    }

    public function prepareAnimalPage($animal){
        $this->title = "page sur ".htmlspecialchars($animal->getNom());
        $this->content =  htmlspecialchars($animal->getNom())." est un animal de l'espèce ".$animal->getEspece()." son age est : ".$animal->getAge()."ans"."<br>";
        
        if ($animal->getImagePath() != null) {
            $img = $animal->getImagePath();
            $nom = $animal->getNom();
            //echo "<img src='./uploads/{$img}' alt='Image de {$nom}'>";

            // Ajout dans le contenu avec $this->content
            $this->content .= "<img src='../uploads/{$img}' alt='Image de {$nom}'>";
        }
        else{
            $this->content .= "<p>cet animal n'a pas d'image </p>";
        }
    }
    
    public function prepareUnknownAnimalPage(){
        $this->title = "Animal inconnu";
        $this->content = "";
    }

    public function preparePageAccueil(){
        $this->title = "page d'accueil";
        $this->content ="<p>Vous etes sur la page d'accueille </p>";
    }
    public function prepareListPage($tableauAnimal){
        $this->title = " Liste d'animaux ";
        $this->content = "<ul>";
        foreach ($tableauAnimal as $k => $v) {
            $page = $this->routeur->getAnimalURL($k);
            $this->content .= "<li>"."<a href='".$page."'>".htmlspecialchars($v->getNom())."</a>"."</li>";
        }
        $this->content .= "</ul>";
        //echo $this->content;


    }
    public function prepareDebugPage($variable) {
        $this->title = 'Debug';
        $this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
    }

    public function prepareAnimalCreationPage($animalBuilder){
        $data = $animalBuilder->getData();
        $error = $animalBuilder->getError();

        $nom = key_exists(AnimalBuilder::NAME_REF,$data)? trim($data[AnimalBuilder::NAME_REF]) : '';
        $espece = key_exists(AnimalBuilder::SPECIES_REF,$data) ? trim($data[AnimalBuilder::SPECIES_REF]) : '';
        $age = key_exists(AnimalBuilder::AGE_REF,$data) ? ($data[AnimalBuilder::AGE_REF]) : '';

        $errorMessage = '';
        if ($error) {
            $errorMessage = '<p style="color: red;">' . htmlspecialchars($error) . '</p>';
        }

        
        

        $this->title = "Formulaire de creation d'animal";
        $this->content = '
        <form enctype="multipart/form-data" action="'.$this->routeur->getAnimalSaveURL().'" method="POST">
            <label for="nom">Nom de l\'animal :</label><br>
            <input type="text" id="nom" name="' . htmlspecialchars(AnimalBuilder::NAME_REF) . '" value ="'.$nom.'"><br><br>

            <label for="espece">Espece :</label><br>
            <input type="text" id="espece" name="' . htmlspecialchars(AnimalBuilder::SPECIES_REF) . '" value ="'.$espece.'"><br><br>

            <label for="age">Age :</label><br>
            <input type="number" id="age" name="' . htmlspecialchars(AnimalBuilder::AGE_REF) . '" value ="'.$age.'"><br><br>

            <input type="file" name="image"><br>
            <input type="submit" value="Creer l\'animal">
        </form> 
        <br>'.
        $error;
    }
    public function prepareErrorCreationPage(){
        $this->title = "Erreur de creation ";
        $this->content = "<p>erreur lors de la creation de l'animal ,verifier le format de l'image </p>";
    }
    public function displayAnimalCreationSuccess($id){
        $url = $this->routeur->getAnimalURL($id);
        $this->routeur->POSTredirect($url, "L'animal a été créé avec succès !");
    }
    

}

?>