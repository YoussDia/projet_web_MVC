<?php
require_once 'model/AnimalStorage.php';
require_once 'model/Animal.php';

class AnimalStorageMySQL implements AnimalStorage {
    protected $connection;
    // Constructeur qui initialise l'instance PDO pour la connexion à la base de données
    public function __construct(PDO $connection) {
        $this->connection = $connection;
    }

    // Lire un animal par son identifiant
    public function read($id) {
        try {
            // j'utilise une requette preparer pour recuperer un animal à partir de son id
            $query = 'SELECT * FROM animals WHERE id = :id';
            $statement = $this->connection->prepare($query);
    
            $statement->bindValue(':id', $id);// lier les parametres 
            // execution de la requête
            $statement->execute();
            $row = $statement->fetch(PDO::FETCH_ASSOC);
    
            if ($row) {
                //cree un animal à partir des données recuperé
                $nom = key_exists('name',$row)? $row['name']:'';
                $espece = key_exists('species',$row) ?$row['species'] :'';
                $age = key_exists('age',$row)? $row['age']: 0;
                $image = key_exists('imagePath',$row)?$row['imagePath']:null;
    
                return new Animal($nom,$espece,$age,$image);
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // Gérer les erreurs SQL
            echo "Erreur pendant la recuperation de l'animal: " . $e->getMessage();
            return null;
        }
    }
    

    // Lire tous les animaux
    public function readAll() {
    try {
        // Requête SQL pour récupérer tous les animaux
        $query = 'SELECT * FROM animals';
        $statement = $this->connection->query($query); // Exécute la requête
        // Tableau pour stocker les instances de la classe Animal
        $animaux = [];

        // Parcours des résultats et création des objets Animal
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            // Vérifie et récupère les données nécessaires
            $nom = key_exists('name',$row) ? $row['name'] : '';
            $espece = key_exists('species',$row) ? $row['species'] : '';
            $age = key_exists('age',$row) ? (int)$row['age'] : 0;
            $image = key_exists('imagePath',$row)?$row['imagePath']:null;

            // Crée une instance de la classe Animal
            $animal = new Animal($nom, $espece, $age,$image);

            // Ajoute l'animal au tableau avec son identifiant comme clé
            $animaux[$row['id']] = $animal;
        }

        return $animaux; // Retourne le tableau des animaux

    } catch (PDOException $e) {
        // Gère les erreurs éventuelles
        echo "Erreur lors de l'exécution de la requête : " . $e->getMessage();
        return []; // Retourne un tableau vide en cas d'erreur
    }
}

    // Ajouter un nouvel animal
    public function create(Animal $a) {
        try {
            // requette preparer
            $query = 'INSERT INTO animals (name, species, age, imagePath) VALUES (:name, :species, :age , :imagePath)';
            $statement = $this->connection->prepare($query);

            $statement->bindValue(':name', $a->getNom());
            $statement->bindValue(':species',$a->getEspece());
            $statement->bindValue(':age', $a->getAge());
            $statement->bindValue(':imagePath', $a->getImagePath());
    
            // execution de la requette 
            $statement->execute();
            // Retourner l'ID de l'animal nouvellement inséré
            return $this->connection->lastInsertId();
        } catch (PDOException $e) {
            // Gérer les erreurs SQL
            echo "Erreur de l'insertion de l'animal :".$e->getMessage();
            return null;
        }
    }
    

    // Supprimer un animal
    public function delete(Animal $a) {
        throw new Exception('Method not yet implemented: delete');
    }

    // Mettre à jour un animal
    public function update($id, Animal $a) {
        throw new Exception('Method not yet implemented: update');
    }
}


?>