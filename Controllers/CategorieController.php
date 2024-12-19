<?php

require_once '../Controllers/Controller.php';
require_once '../Entities/Categorie.php';
require_once '../Models/CategorieModels.php';


class CategorieController extends Controller
{

    /**
     * Affiche tous les evenements
     */
    public function displayAllCategorieAction()
    {

        $CategorieModels = new CategorieModels();

        $categories = $CategorieModels->findAllCategorie();


        $this->render('listCategorie', ['categories' => $categories]);
    }
}
