<?php

require_once '../Core/DbConnect.php';
require_once '../Entities/Commentaire.php';

class CommentaireModels extends DbConnect
{
    // Ajouter un commentaire
    public function addCommentaire(Commentaire $commentaire)
    {
        $query = "INSERT INTO commentaire (id_user, id_evenement, message, date_commentaire) 
                  VALUES (:id_user, :id_evenement, :message, NOW())";
        $stmt = $this->connection->prepare($query);

        // Créer des variables pour les passer à bindParam
        $id_user = $commentaire->getId_user();
        $id_evenement = $commentaire->getId_evenement();
        $message = $commentaire->getMessage();

        $stmt->bindParam(':id_user', $id_user);
        $stmt->bindParam(':id_evenement', $id_evenement);
        $stmt->bindParam(':message', $message);

        return $stmt->execute();
    }

    // Récupérer les commentaires d'un événement
    public function getCommentaires($id_evenement)
    {
        $query = "SELECT commentaire.id_commentaire, commentaire.id_user, commentaire.message, commentaire.date_commentaire, 
                         utilisateur.prenom, utilisateur.nom 
                  FROM commentaire
                  JOIN utilisateur ON commentaire.id_user = utilisateur.id_user
                  WHERE commentaire.id_evenement = :id_evenement 
                  ORDER BY commentaire.date_commentaire DESC";
        $stmt = $this->connection->prepare($query);

        // Liaison du paramètre
        $stmt->bindParam(':id_evenement', $id_evenement);
        $stmt->execute();

        // Récupération des données
        $commentairesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $commentaires = [];
        foreach ($commentairesData as $data) {
            $commentaire = new Commentaire();
            $commentaire->setId_commentaire($data['id_commentaire']);
            $commentaire->setMessage($data['message']);
            $commentaire->setDate_commentaire($data['date_commentaire']);
            $commentaire->setPrenom($data['prenom']);
            $commentaire->setNom($data['nom']);
            $commentaire->setId_user($data['id_user']);

            $commentaires[] = $commentaire;
        }

        return $commentaires;
    }


    public function updateCommentaire($id_commentaire, $id_user, $nouveauMessage)
    {
        $query = "UPDATE commentaire 
              SET message = :message 
              WHERE id_commentaire = :id_commentaire AND id_user = :id_user";
        $stmt = $this->connection->prepare($query);

        $stmt->bindParam(':message', $nouveauMessage);
        $stmt->bindParam(':id_commentaire', $id_commentaire);
        $stmt->bindParam(':id_user', $id_user);

        return $stmt->execute();
    }

    public function deleteCommentaire($id_commentaire, $id_user)
    {
        $requete = "DELETE FROM commentaire 
              WHERE id_commentaire = :id_commentaire AND id_user = :id_user";
        $delete = $this->connection->prepare($requete);

        $delete->bindParam(':id_commentaire', $id_commentaire);
        $delete->bindParam(':id_user', $id_user);

        return $delete->execute();
    }

    // La méthode pour récupérer un commentaire par son ID
    public function getCommentaireById($id_commentaire)
    {
        //l'ID est valide (non vide et un entier)
        if (empty($id_commentaire) || !is_numeric($id_commentaire)) {
            return null;
        }

        // Préparez la requête SQL pour récupérer le commentaire en fonction de son ID
        $query = "SELECT * FROM commentaire WHERE id_commentaire = :id_commentaire";

        // Préparez la connexion à la base de données
        $stmt = $this->connection->prepare($query);

        // Lie la valeur de l'ID du commentaire à la requête
        $stmt->bindParam(':id_commentaire', $id_commentaire, PDO::PARAM_INT);

        // Exécute la requête
        $stmt->execute();

        // Vérifie si le commentaire existe
        if ($stmt->rowCount() > 0) {
            // Récupère le résultat sous forme d'objet
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            // Crée un objet Commentaire et le remplit avec les données récupérées
            $commentaire = new Commentaire();
            $commentaire->setId_commentaire($result->id_commentaire);
            $commentaire->setId_user($result->id_user);
            $commentaire->setMessage($result->message);
            $commentaire->setDate_commentaire($result->date_commentaire);

            return $commentaire;  // Retourne l'objet Commentaire
        } else {
            // Si aucun commentaire n'est trouvé, retourne null
            return null;
        }
    }
}
