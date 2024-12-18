<?php

    require_once 'models/Video.php'; // Inclure le modèle Video
    require_once 'views/View.php';   // Inclure le gestionnaire des vues


    class VideoController 
    {

        // Methode pour afficher les resultats de recherche
        public function search() 
        {
            // Verifier si une recherche a ete effectue
            $searchTerm = $_GET['query'] ?? '';
    
            // Rechercher les videos
            $videos = Video::searchVideos($searchTerm);
            

            // Option 1
            // Charger la vue avec les resultats
            $view = new View('templates/home');
            $view->generer(['videos' => $videos, 'searchTerm' => $searchTerm]);

            // Option 2 
            // include 'views/templates/home.php';
        }
    }