<?php

    require 'controllers/Router.php';     // Chargement du routeur 

    $router  = new Router();             // Creation et execution du router 
    
    $router->routeRequest();            // Analyse l'URL et redirige vers le bon contrôleur

?>


