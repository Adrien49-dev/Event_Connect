<?php

require_once '../Core/DbConnect.php';
require_once '../Entities/Evenement.php';
require_once '../Entities/Categorie.php';

class EvenementModels extends DbConnect
{

    public function findAllEvenement()
    {

        $this->request = "SELECT evenement.*, categorie.nom AS category_name 
        FROM evenement 
        JOIN categorie ON evenement.id_categorie = categorie.id_categorie";
        $result = $this->connection->query($this->request);
        $evenements = $result->fetchAll(PDO::FETCH_OBJ);
        return $evenements;
    }

    public function findEvenement($id)
    {
        
        $this->request = $this->connection->prepare(
            "SELECT evenement.*, categorie.nom AS category_name 
             FROM evenement 
             JOIN categorie ON evenement.id_categorie = categorie.id_categorie
             WHERE evenement.id_evenement = :id_evenement"
        );


        $this->request->bindParam(":id_evenement", $id, PDO::PARAM_INT);


        $this->request->execute();


        $evenement = $this->request->fetch();

        return $evenement;
    }

    public function getEvenementsByCategorie($id_categorie)
    {
        $query = "
        SELECT evenement.*
        FROM evenement
        INNER JOIN categorie ON evenement.id_categorie = categorie.id_categorie
        WHERE categorie.id_categorie = :id_categorie
    ";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(':id_categorie', $id_categorie, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_OBJ);
    }



    public function addEvenement($evenement)
    {

        $this->request = $this->connection->prepare(
            "INSERT INTO evenement (id_categorie, nom, date, heure, description, place, photo) 
             VALUES (:id_categorie, :nom, :date, :heure, :description, :place, :photo)"
        );


        $this->request->bindParam(':id_categorie', $evenement->getId_categorie(), PDO::PARAM_INT);
        $this->request->bindParam(':nom', $evenement->getNom(), PDO::PARAM_STR);
        $this->request->bindParam(':date', $evenement->getDate(), PDO::PARAM_STR);
        $this->request->bindParam(':heure', $evenement->getHeure(), PDO::PARAM_STR);
        $this->request->bindParam(':description', $evenement->getDescription(), PDO::PARAM_STR);
        $this->request->bindParam(':place', $evenement->getPlace(), PDO::PARAM_INT);
        $this->request->bindParam(':photo', $evenement->getPhoto(), PDO::PARAM_STR);


        $this->request->execute();

        return $this->connection->lastInsertId(); // Retourne l'ID du dernier élément inséré
    }

    public function deleteEvenement($id)
    {
        try {
            $this->request = $this->connection->prepare("DELETE FROM evenement WHERE id_evenement = :id_evenement");

            if (is_object($id) && method_exists($id, 'getId_evenement')) {
                $id = $id->getId_evenement(); // Si on a un objet `Evenement`, récupérer l'ID
            }

            $this->request->bindParam(":id_evenement", $id, PDO::PARAM_INT);

            // Exécuter la requête
            $this->request->execute();
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la suppression de l'événement : " . $e->getMessage());
        }
    }



    public function updateEvenement($evenement)
    {
        // Récupération des valeurs des propriétés dans des variables
        $id_categorie = $evenement->getId_categorie();
        $nom = $evenement->getNom();
        $date = $evenement->getDate();
        $heure = $evenement->getHeure();
        $description = $evenement->getDescription();
        $place = $evenement->getPlace();
        $photo = $evenement->getPhoto();
        $id_evenement = $evenement->getId_evenement();

        // Préparation de la requête
        $this->request = $this->connection->prepare(
            "UPDATE evenement 
             SET id_categorie = :id_categorie, 
                 nom = :nom, 
                 date = :date, 
                 heure = :heure, 
                 description = :description, 
                 place = :place, 
                 photo = :photo 
             WHERE id_evenement = :id_evenement"
        );

        // Binding des paramètres
        $this->request->bindParam(':id_categorie', $id_categorie, PDO::PARAM_INT);
        $this->request->bindParam(':nom', $nom, PDO::PARAM_STR);
        $this->request->bindParam(':date', $date, PDO::PARAM_STR);
        $this->request->bindParam(':heure', $heure, PDO::PARAM_STR);
        $this->request->bindParam(':description', $description, PDO::PARAM_STR);
        $this->request->bindParam(':place', $place, PDO::PARAM_INT);
        $this->request->bindParam(':photo', $photo, PDO::PARAM_STR);
        $this->request->bindParam(':id_evenement', $id_evenement, PDO::PARAM_INT);

        // Exécution de la requête
        $this->request->execute();

        // Retourner le nombre de lignes affectées pour vérifier la mise à jour
        return $this->request->rowCount(); // Retourne le nombre de lignes affectées (1 si l'événement a été mis à jour)
    }



    private function executeTryCatch()
    {
        try {
            $this->request->execute();
        } catch (Exception $e) {
            die('ERREUR :' . $e->getMessage());
        }
        $this->request->closeCursor();
    }
}
