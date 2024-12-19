<?php

require_once '../Core/DbConnect.php';
require_once '../Entities/Categorie.php';

class CategorieModels extends DbConnect
{

    public function findAllCategorie()
    {
        $this->request = "SELECT * FROM categorie";
        $categories = $this->connection->query($this->request);
        return $categories->fetchAll();
    }
}
