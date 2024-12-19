<?php

require_once '../Controllers/Controller.php';
require_once '../Models/ReservationModels.php';
require_once '../Entities/Evenement.php';
require_once '../Entities/Reservation.php';

class ReservationController extends Controller
{


    // Vérifie si l'utilisateur est connecté
    private function checkUserSession()
    {

        if (!isset($_SESSION['id_user'])) {
?>
            <meta http-equiv="refresh" content="0;index.php?controller=Login&action=connexion">
            <?php
            // header('Location: index.php?controller=Login&action=connexion'); // Redirection si non connecté
            exit();
        }
    }

    // Action pour ajouter une réservation
    public function addReservationAction()
    {
        $this->checkUserSession(); // Vérifie la connexion utilisateur

        $id_user = $_SESSION['id_user']; // Récupère l'ID utilisateur depuis la session
        $id_evenement = $_GET['id_evenement'];

        $reservationModel = new ReservationModels();

        if ($reservationModel->hasAvailablePlaces($id_evenement)) {
            $success = $reservationModel->addReservation($id_user, $id_evenement);

            if ($success) {
                $reservationModel->decrementPlaces($id_evenement);
            ?>
                <meta http-equiv="refresh" content="0;index.php?controller=Reservation&action=getUserReservations">
            <?php
                // header("Location:index.php?controller=Reservation&action=getUserReservations");
            } else {
                echo "Erreur lors de la réservation.";
            }
        } else {
            echo "Plus de places disponibles pour cet événement.";
        }
    }


    // Action pour supprimer une réservation
    public function deleteReservationAction()
    {

        if (isset($_GET['id_reservation'])) {
            $id_reservation = $_GET['id_reservation']; // Récupère l'ID de la réservation à supprimer

            $reservationModel = new ReservationModels();
            $success = $reservationModel->deleteReservation($id_reservation); // Appelle la méthode pour supprimer la réservation

            if ($success) {
                echo "Réservation supprimée avec succès.";
            ?>
                <meta http-equiv="refresh" content="100;index.php?controller=Reservation&action=getUserReservations">
<?php
                // header('Location: index.php?controller=Reservation&action=getUserReservations'); // Redirection vers la liste des réservations
                exit();
            } else {
                echo "Erreur lors de la suppression de la réservation.";
            }
        } else {
            echo "Aucune réservation à supprimer.";
        }
    }

    // Action pour afficher les réservations d'un utilisateur
    public function getUserReservationsAction()
    {
        $this->checkUserSession(); // Vérifie la connexion utilisateur

        $id_user = $_SESSION['id_user']; // Récupère l'ID utilisateur depuis la session
        $reservationModel = new ReservationModels();
        $reservations = $reservationModel->getUserReservations($id_user);

        // Transmet les données à la vue
        $this->render('showReservation', [
            'reservations' => $reservations
        ]);
    }
}
