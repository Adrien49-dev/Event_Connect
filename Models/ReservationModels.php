<?php

require_once '../Core/DbConnect.php';
require_once '../Entities/Reservation.php';
require '../Entities/Evenement.php';

class ReservationModels extends DbConnect
{


    public function addReservation($id_user, $id_evenement)
    {

        $query = "INSERT INTO reservation (id_user, id_evenement, date_reservation) VALUES (:id_user, :id_evenement, NOW())";
        $add = $this->connection->prepare($query);
        $add->bindParam(':id_user', $id_user);
        $add->bindParam(':id_evenement', $id_evenement);

        return $add->execute();
    }


    // Vérifie si un événement a encore des places disponibles
    public function hasAvailablePlaces($id_evenement)
    {
        $query = "SELECT place FROM evenement WHERE id_evenement = :id_evenement";
        $place = $this->connection->prepare($query);
        $place->bindParam(':id_evenement', $id_evenement);
        $place->execute();
        $result = $place->fetch(PDO::FETCH_ASSOC);

        return $result['place'] > 0;
    }

    // Diminue le nombre de places disponibles pour un événement
    public function decrementPlaces($id_evenement)
    {
        $query = "UPDATE evenement SET place = place - 1 WHERE id_evenement = :id_evenement";
        $decrement = $this->connection->prepare($query);
        $decrement->bindParam(':id_evenement', $id_evenement);

        return $decrement->execute();
    }

    // Augmente le nombre de places disponibles pour un événement
    public function incrementPlaces($id_evenement)
    {

        $query = "UPDATE evenement SET place = place + 1 WHERE id_evenement = :id_evenement";
        $increment = $this->connection->prepare($query);
        $increment->bindParam(':id_evenement', $id_evenement);

        return $increment->execute();
    }


    // Supprimer une réservation
    public function deleteReservation($id_reservation)
    {

        // Récupérer l'ID de l'événement lié à la réservation
        $querySelect = "SELECT id_evenement FROM reservation WHERE id_reservation = :id_reservation";
        $select = $this->connection->prepare($querySelect);
        $select->bindParam(':id_reservation', $id_reservation);
        $select->execute();
        $result = $select->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $id_evenement = $result['id_evenement'];

            // Supprimer la réservation
            $queryDelete = "DELETE FROM reservation WHERE id_reservation = :id_reservation";
            $delete = $this->connection->prepare($queryDelete);
            $delete->bindParam(':id_reservation', $id_reservation);

            if ($delete->execute()) {
                // Incrémenter les places disponibles
                return $this->incrementPlaces($id_evenement);
            }
        }

        return false;
    }

    // Récupérer les réservations d'un utilisateur
    public function getUserReservations($id_user)
    {
        $query = "SELECT reservation.id_reservation, reservation.date_reservation, evenement.nom, evenement.date
                  FROM reservation
                  JOIN evenement ON reservation.id_evenement = evenement.id_evenement
                  WHERE reservation.id_user = :id_user";

        $reservation = $this->connection->prepare($query);
        $reservation->bindParam(':id_user', $id_user);
        $reservation->execute();

        return $reservation->fetchAll(PDO::FETCH_ASSOC);
    }
}
