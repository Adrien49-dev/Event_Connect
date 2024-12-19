<?php

require_once '../Controllers/Controller.php';
require_once '../Entities/Utilisateur.php';
require_once '../Models/UtilisateurModels.php';
require_once '../Entities/Evenement.php';
require_once '../Entities/Categorie.php';
require_once '../Models/EvenementModels.php';
require_once '../Models/CategorieModels.php';

// Déclaration de la classe AdminController qui gère les actions administratives (CRUD)
class AdminController extends Controller
{

    // ------------------------------- UTILISATEUR ---------------------------------------------- // 


    // Fonction privée pour vérifier si l'utilisateur connecté est un administrateur
    private function checkAdmin()
    {
        if (!isset($_SESSION['statut']) || $_SESSION['statut'] !== 'admin') {
            echo "<p>Accès interdit. Vous devez être administrateur pour accéder à cette page.</p>";

?>
            <meta http-equiv="refresh" content="0;index.php?controller=Accueil&action=home">
        <?php

            // header("Location: index.php?controller=Accueil&action=home"); // Redirection vers la page d'accueil si non admin
            exit();
        }
    }

    // Action pour afficher le tableau de bord de l'administrateur
    public function dashboardAction()
    {
        $this->checkAdmin(); // Vérifie que l'utilisateur est admin
        $this->render('admin/dashboard'); // Rendu de la vue du dashboard
    }

    // Action pour afficher la gestion des utilisateurs
    public function gestionUtilisateursAction()
    {
        $this->checkAdmin(); // Vérifie que l'utilisateur est admin
        $UtilisateurModels = new UtilisateurModels(); // Création d'une instance du modèle Utilisateur
        $utilisateurs = $UtilisateurModels->getAllUtilisateurs(); // Récupère tous les utilisateurs
        $this->render('admin/gestionUtilisateurs', ['utilisateurs' => $utilisateurs]); // Rendu de la vue avec la liste des utilisateurs
    }

    // Action pour afficher le formulaire de modification d'un utilisateur
    public function modifierUtilisateurAction()
    {
        $this->checkAdmin(); // Vérifie que l'utilisateur est admin
        $id = isset($_GET['id']) ? $_GET['id'] : null; // Récupère l'id de l'utilisateur à modifier
        if ($id) {
            $UtilisateurModels = new UtilisateurModels(); // Instantiation du modèle Utilisateur
            $utilisateur = $UtilisateurModels->findUtilisateurById($id); // Récupère l'utilisateur par son id
            $this->render('admin/modifierUtilisateur', ['utilisateur' => $utilisateur]); // Affiche le formulaire avec les informations de l'utilisateur
        } else {
            echo "<p>Utilisateur introuvable.</p>"; // Message d'erreur si l'utilisateur n'existe pas
        }
    }

    // Action pour sauvegarder les modifications d'un utilisateur
    public function saveModificationUtilisateurAction()
    {
        $this->checkAdmin(); // Vérifie que l'utilisateur est admin
        $id = isset($_GET['id']) ? $_GET['id'] : null; // Récupère l'id de l'utilisateur à modifier
        $nom = $_POST['nom']; // Récupère le nom du formulaire
        $prenom = $_POST['prenom']; // Récupère le prénom du formulaire
        $statut = $_POST['statut']; // Récupère le statut du formulaire

        if ($id) {
            $UtilisateurModels = new UtilisateurModels(); // Instantiation du modèle Utilisateur
            $UtilisateurModels->updateUtilisateur($id, $nom, $prenom, $statut); // Met à jour les informations de l'utilisateur
        ?>
            <meta http-equiv="refresh" content="0;index.php?controller=Admin&action=gestionUtilisateurs">
        <?php
            // header("Location: index.php?controller=Admin&action=gestionUtilisateurs"); // Redirection vers la gestion des utilisateurs
            exit();
        } else {
            echo "<p>Erreur : L'utilisateur n'existe pas.</p>"; // Message d'erreur si l'utilisateur n'est pas trouvé
        }
    }

    // Action pour supprimer un utilisateur
    public function supprimerUtilisateurAction()
    {
        $this->checkAdmin(); // Vérifie que l'utilisateur est admin
        $id = isset($_GET['id']) ? $_GET['id'] : null; // Récupère l'id de l'utilisateur à supprimer

        if ($id) {
            $UtilisateurModels = new UtilisateurModels(); // Instantiation du modèle Utilisateur
            $UtilisateurModels->deleteUtilisateur($id); // Supprime l'utilisateur par son id
        ?>
            <meta http-equiv="refresh" content="0;index.php?controller=Admin&action=gestionUtilisateurs">
            <?php
            // header("Location: index.php?controller=Admin&action=gestionUtilisateurs"); // Redirection vers la gestion des utilisateurs
            exit();
        } else {
            echo "<p>Erreur : L'utilisateur n'existe pas.</p>"; // Message d'erreur si l'utilisateur n'est pas trouvé
        }
    }



    // ------------------------------------- EVENEMENTS ----------------------------------------- //

    // Action pour afficher tous les événements
    public function displayAllEvenementAction()
    {
        $EvenementModels = new EvenementModels(); // Instantiation du modèle Evenement
        $evenements = $EvenementModels->findAllEvenement(); // Récupère tous les événements
        $this->render('admin/listEvenement', ['evenements' => $evenements]); // Affiche la liste des événements
    }


    // Action pour afficher le formulaire d'ajout d'un événement
    public function addEvenementFormAction()
    {
        // Récupérer les catégories pour afficher dans le formulaire
        $CategorieModels = new CategorieModels();
        $categories = $CategorieModels->findAllCategorie(); // Récupère toutes les catégories

        // Affiche le formulaire d'ajout d'événement
        $this->render('admin/createEvenementForm', ['categories' => $categories]);
    }


    // Action pour ajouter un nouvel événement dans la base de données
    public function addEvenementAction()
    {
        try {
            // Récupérer les catégories
            $categorieModel = new CategorieModels();
            $categories = $categorieModel->findAllCategorie();

            if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Si le formulaire est soumis
                // Récupération des données du formulaire
                $evenement = new Evenement();
                $evenement->setId_categorie($_POST['id_categorie']);
                $evenement->setNom($_POST['nom']);
                $evenement->setDate($_POST['date']);
                $evenement->setHeure($_POST['heure']);
                $evenement->setDescription($_POST['description']);
                $evenement->setPlace($_POST['place']);

                // Gestion de l'upload de la photo
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
                    $photo = $_FILES['photo']['name'];
                    move_uploaded_file($_FILES['photo']['tmp_name'], "../Public/Images/" . $photo);
                    $evenement->setPhoto("../Public/Images/" . $photo); // Sauvegarde du chemin de la photo
                }

                // Ajouter l'événement dans la base de données
                $EvenementModels = new EvenementModels();
                $EvenementModels->addEvenement($evenement);

            ?>
                <meta http-equiv="refresh" content="0;index.php?controller=Admin&action=displayAllEvenement">
            <?php

                // Redirection vers la liste des événements
                //header("Location: index.php?controller=Admin&action=displayAllEvenement");
                exit();
            }

            // Affiche le formulaire d'ajout avec les catégories
            $this->render('admin/createEvenementForm', ['categories' => $categories]);
        } catch (Exception $e) {
            // Gérer les erreurs
            $this->render('admin/createEvenementForm', ['error' => $e->getMessage()]);
        }
    }


    // Action pour supprimer un événement
    public function deleteEvenementAction()
    {
        $id = isset($_GET['id_evenement']) ? $_GET['id_evenement'] : ''; // Récupère l'id de l'événement à supprimer
        $evenement = new Evenement();
        $evenement->setId_evenement($id); // Associe l'id de l'événement

        $evenementModel = new EvenementModels();
        $success = $evenementModel->deleteEvenement($evenement); // Supprime l'événement

        // Récupérer la liste des événements pour l'afficher
        $evenements = $evenementModel->findAllEvenement(); // Méthode pour récupérer tous les événements

        // Afficher la vue avec la liste des événements et un message de succès/échec
        $this->render('admin/listEvenement', [
            'evenements' => $evenements,
            'message' => $success ? "L'événement a été supprimé avec succès." : "La suppression de l'événement a échoué."
        ]);
    }



    // Action pour afficher le formulaire de mise à jour d'un événement
    public function updateEvenementFormAction()
    {
        $id_evenement = $_GET['id_evenement']; // Récupère l'id de l'événement

        // Récupérer les catégories pour le formulaire
        $CategorieModels = new CategorieModels();
        $categories = $CategorieModels->findAllCategorie();

        // Récupérer les données de l'événement à mettre à jour
        $EvenementModels = new EvenementModels();
        $evenement = $EvenementModels->findEvenement($id_evenement);

        // Affiche le formulaire avec les données de l'événement
        $this->render('admin/updateEvenementForm', [
            'categories' => $categories,
            'evenement' => $evenement
        ]);
    }


    // Action pour mettre à jour un événement dans la base de données
    public function updateEvenementAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Récupération des données du formulaire
                $evenement = new Evenement();
                $evenement->setId_evenement($_POST['id_evenement']);
                $evenement->setId_categorie($_POST['id_categorie']);
                $evenement->setNom($_POST['nom']);
                $evenement->setDate($_POST['date']);
                $evenement->setHeure($_POST['heure']);
                $evenement->setDescription($_POST['description']);
                $evenement->setPlace($_POST['place']);

                // Gestion de l'upload de la photo si nécessaire
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $targetDir = "../Public/Images/";
                    $targetFile = $targetDir . basename($_FILES['photo']['name']);
                    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                        $evenement->setPhoto($targetFile); // Mise à jour du chemin de la photo
                    } else {
                        throw new Exception("Erreur lors de l'upload de la photo.");
                    }
                } else {
                    // Si aucune nouvelle photo, conserver l'ancienne
                    $EvenementModels = new EvenementModels();
                    $existingEvent = $EvenementModels->findEvenement($_POST['id_evenement']);
                    $evenement->setPhoto($existingEvent->photo);
                }

                // Mise à jour de l'événement dans la base de données
                $EvenementModels = new EvenementModels();
                $EvenementModels->updateEvenement($evenement);

            ?>
                <meta http-equiv="refresh" content="0;index.php?controller=Admin&action=displayAllEvenement">
        <?php

                // Redirection après la mise à jour
                // header("Location: index.php?controller=Admin&action=displayAllEvenement");
                exit();
            } catch (Exception $e) {
                // Gérer les erreurs
                $this->render('admin/updateEvenementForm', ['error' => $e->getMessage()]);
            }
        }
        ?>
        <meta http-equiv="refresh" content="0;index.php?controller=Admin&action=displayAllEvenement">
<?php
        // Redirection si la requête n'est pas POST
        // header("Location: index.php?controller=Admin&action=displayAllEvenement");
        exit();
    }
}
