<?php

/**
 * Class Controller
 * Classe abstraite pour les contrôleurs
 */
abstract class Controller
{
    /**
     * Rend une vue
     * @param string $view Le nom de la vue à rendre
     * @param array $data Les données à passer à la vue
     */
    public function render($view, $data = [])
    {
        extract($data);



        require_once '../Views/header.php';


        require_once '../Views/' . $view . '.php';
        require_once '../Views/footer.php';
    }
}
