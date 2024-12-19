<?php
session_start();


require_once '../Core/Router.php';


$router = new Router();
$router->routes();
