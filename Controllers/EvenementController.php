<?php

require_once '../Controllers/Controller.php';
require_once '../Entities/Evenement.php';
require_once '../Entities/Categorie.php';
require_once '../Models/EvenementModels.php';
require_once '../Models/CategorieModels.php';
require_once '../Entities/Commentaire.php';
require_once '../Models/CommentaireModels.php';


class EvenementController extends Controller
{

    /**
     * Affiche tous les événements par catégorie
     */
    public function displayAllEvenementByCategorieAction()
    {


        // Instancier le modèle
        $evenementModel = new EvenementModels();

        // Récupérer l'ID de la catégorie depuis l'URL ou utiliser une valeur par défaut
        $id_categorie = isset($_GET['id_categorie']) ? intval($_GET['id_categorie']) : null;


        // Récupérer les événements par ID de catégorie
        $evenements = $evenementModel->getEvenementsByCategorie($id_categorie);



        // Transmettre les données à la vue
        $this->render('listByCategorie', [
            'evenements' => $evenements,
            'id_categorie' => $id_categorie,
        ]);
    }

    public function displayEvenementAction()
    {


        $id_evenement = $_GET['id_evenement'] ?? null;
        $evenementModel = new EvenementModels();
        $commentaireModel = new CommentaireModels();

        $evenement = $evenementModel->findEvenement($id_evenement);
        $commentaires = $commentaireModel->getCommentaires($id_evenement);

        $this->render('showEvenement', [
            'evenement' => $evenement,
            'commentaires' => $commentaires,
        ]);
    }
}
