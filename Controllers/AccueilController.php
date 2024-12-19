<?php
require_once 'Controller.php';

class AccueilController extends Controller
{
    /**
     * Affiche la page d'accueil
     */
    public function homeAction()
    {
        $this->render('accueil');
    }
}
