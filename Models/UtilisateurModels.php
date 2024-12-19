<?php
require_once '../Core/DbConnect.php';
require_once '../Entities/Utilisateur.php';


class UtilisateurModels extends DbConnect
{

    public function findUtilisateur($mail)
    {

        $this->request = $this->connection->prepare("SELECT * FROM utilisateur WHERE mail = :mail");
        $this->request->bindParam(":mail", $mail);
        $this->request->execute();
        $utlisateur = $this->request->fetch();
        return $utlisateur;
    }

    public function createUtilisateur($nom, $prenom, $mail, $mdp, $statut)
    {
        // Requête SQL pour insérer un nouvel utilisateur
        $query = $this->connection->prepare('
            INSERT INTO utilisateur (nom, prenom, mail, mdp, statut) 
            VALUES (:nom, :prenom, :mail, :mdp, :statut)
        ');

        // Liaison des paramètres à la requête
        $query->bindParam(':nom', $nom);
        $query->bindParam(':prenom', $prenom);
        $query->bindParam(':mail', $mail);
        $query->bindParam(':mdp', $mdp);  // On insère le mot de passe haché
        $query->bindParam(':statut', $statut); // Statut est toujours "visiteur"

        // Exécution de la requête
        $query->execute();
    }


    public function getAllUtilisateurs()
    {
        $query = $this->connection->prepare('SELECT * FROM utilisateur');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);  // Retourne un tableau d'objets utilisateurs
    }

    public function findUtilisateurById($id)
    {
        $query = $this->connection->prepare('SELECT * FROM utilisateur WHERE id_user = :id');
        $query->bindParam(':id', $id);
        $query->execute();
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function updateUtilisateur($id, $nom, $prenom, $statut)
    {
        $query = $this->connection->prepare('
            UPDATE utilisateur 
            SET nom = :nom, prenom = :prenom, statut = :statut 
            WHERE id_user = :id
        ');
        $query->bindParam(':id', $id);
        $query->bindParam(':nom', $nom);
        $query->bindParam(':prenom', $prenom);
        $query->bindParam(':statut', $statut);
        $query->execute();
    }

    public function deleteUtilisateur($id)
    {
        $query = $this->connection->prepare('DELETE FROM utilisateur WHERE id_user = :id');
        $query->bindParam(':id', $id);
        $query->execute();
    }
}
