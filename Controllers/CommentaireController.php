<?php


require_once '../Controllers/Controller.php';
require_once '../Models/CommentaireModels.php';
require_once '../Entities/Commentaire.php';
require_once '../Models/EvenementModels.php';
require_once '../Entities/Evenement.php';



// Classe CommentaireController gérant les fonctionnalités relatives aux commentaires
class CommentaireController extends Controller
{
    // Méthode pour ajouter un commentaire
    public function addCommentaireAction()
    {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['id_user'])) {
?>
            <meta http-equiv="refresh" content="0;index.php?controller=Login&action=connexion">
            <?php
            //header('Location: index.php?controller=Login&action=connexion'); // Redirige vers la page de connexion si non connecté
            exit();
        }

        $id_user = $_SESSION['id_user']; // ID de l'utilisateur connecté
        $id_evenement = $_POST['id_evenement']; // ID de l'événement ciblé
        $message = $_POST['message']; // Message du commentaire

        // Validation du champ message
        if (!empty($message)) {
            // Création d'une nouvelle instance de Commentaire
            $commentaire = new Commentaire();
            $commentaire->setId_user($id_user);
            $commentaire->setId_evenement($id_evenement);
            $commentaire->setMessage($message);

            // Utilisation du modèle pour ajouter le commentaire à la base de données
            $commentaireModel = new CommentaireModels();
            $success = $commentaireModel->addCommentaire($commentaire);

            if ($success) {
            ?>
                <meta http-equiv="refresh" content="0;index.php?controller=Evenement&action=displayEvenement&id_evenement=<?php $id_evenement ?>">
            <?php
                // Redirection vers la page de l'événement après ajout réussi
                //header("Location: index.php?controller=Evenement&action=displayEvenement&id_evenement=$id_evenement");
                exit();
            } else {
                echo "Erreur lors de l'ajout du commentaire."; // Message en cas d'échec
            }
        } else {
            echo "Veuillez saisir un message."; // Message en cas de champ vide
        }
    }

    // Méthode pour supprimer un commentaire
    public function deleteCommentaireAction()
    {
        // Vérifie si l'utilisateur est connecté
        if (isset($_SESSION['id_user'])) {
            if (!empty($_GET['id_commentaire'])) { // Vérifie que l'ID du commentaire est présent
                $id_commentaire = $_GET['id_commentaire'];
                $id_user = $_SESSION['id_user']; // Récupère l'ID de l'utilisateur connecté

                $commentaireModel = new CommentaireModels();
                $success = $commentaireModel->deleteCommentaire($id_commentaire, $id_user);

                if ($success) {
                    echo "Commentaire supprimé avec succès."; // Confirmation de suppression
                } else {
                    echo "Erreur : impossible de supprimer ce commentaire."; // Message en cas d'échec
                }
            } else {
                echo "Erreur : données manquantes."; // Message si les données sont absentes
            }
        } else {
            echo "Erreur : utilisateur non connecté."; // Message si l'utilisateur n'est pas connecté
        }
    }

    // Méthode pour récupérer et afficher les commentaires pour un événement donné
    public function getCommentairesAction($id_evenement)
    {
        $commentaireModel = new CommentaireModels();
        $commentaires = $commentaireModel->getCommentaires($id_evenement); // Récupération des commentaires
        return $commentaires; // Retourne la liste des commentaires
    }

    // Méthode pour afficher le formulaire de mise à jour d'un commentaire
    public function displayUpdateAction()
    {
        // Vérifie la présence des IDs nécessaires dans l'URL
        if (isset($_GET['id_commentaire']) && isset($_GET['id_evenement'])) {
            $id_commentaire = $_GET['id_commentaire'];
            $id_evenement = $_GET['id_evenement'];

            // Récupération du commentaire à mettre à jour
            $commentaireModel = new CommentaireModels();
            $commentaire = $commentaireModel->getCommentaireById($id_commentaire);

            if (!$commentaire) {
                echo "Erreur : commentaire introuvable."; // Message si le commentaire n'existe pas
                return;
            }

            // Récupération des informations de l'événement
            $evenementModel = new EvenementModels();
            $evenement = $evenementModel->findEvenement($id_evenement);

            if (!$evenement) {
                echo "Erreur : événement introuvable."; // Message si l'événement n'existe pas
                return;
            }

            // Rendu de la vue avec les données du commentaire et de l'événement
            $this->render('updateCommentaire', [
                'commentaire' => $commentaire,
                'evenement' => $evenement
            ]);
        } else {
            echo "Erreur : ID du commentaire ou de l'événement manquant."; // Message si les IDs sont absents
        }
    }

    // Méthode pour mettre à jour un commentaire
    public function updateCommentaireAction()
    {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['id_user'])) {
            ?>
            <meta http-equiv="refresh" content="0;index.php?controller=Login&action=connexion">
            <?php
            //  header("Location: index.php?controller=Login&action=connexion"); // Redirection vers la connexion
            exit();
        }

        // Vérifie la présence des données nécessaires en POST
        if (isset($_POST['id_commentaire'], $_POST['message'], $_POST['id_evenement'])) {
            $id_commentaire = $_POST['id_commentaire']; // ID du commentaire
            $message = $_POST['message']; // Nouveau message
            $id_evenement = $_POST['id_evenement']; // ID de l'événement
            $id_user = $_SESSION['id_user']; // ID de l'utilisateur connecté

            $commentaireModel = new CommentaireModels();

            // Mise à jour du commentaire via le modèle
            $success = $commentaireModel->updateCommentaire($id_commentaire, $id_user, $message);

            if ($success) {

            ?>
<?php
                echo '<meta http-equiv="refresh" content="0;url=index.php?controller=Evenement&action=displayEvenement&id_evenement=' . $id_evenement . '">';



                // Redirection après mise à jour réussie
                //header("Location: index.php?controller=Evenement&action=displayEvenement&id_evenement=" . $id_evenement);
                exit();
            } else {
                echo "Erreur : impossible de mettre à jour ce commentaire."; // Message en cas d'échec
            }
        } else {
            echo "Erreur : données manquantes."; // Message si des données sont absentes
        }
    }
}
