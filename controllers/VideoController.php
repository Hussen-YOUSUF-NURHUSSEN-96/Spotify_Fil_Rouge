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
            

             // Stocker les résultats de recherche dans la session
            $_SESSION['search_results'] = 
            [
                'videos'     => $videos,
                'searchTerm' => $searchTerm,
            ];

            // Rediriger vers la page home
            header('Location: index.php?action=home');
            exit();
            
            // Option 1
            // Charger la vue avec les resultats
            // $view = new View('templates/home');
            // $view->generer(['videos' => $videos, 'searchTerm' => $searchTerm]);

            // Option 2 
            // include 'views/templates/home.php';
        }

        public function getVideosByCategory()
    {
        $videosByCategory = Video::getVideosByCategory();
        
        // Stocker les vidéos par catégorie dans la session
        $_SESSION['videos_by_category'] = $videosByCategory;

        // Rediriger vers la page home
        header('Location: index.php?action=home');
        exit();
    }

    /**
     * Affiche la page d'accueil avec les vidéos par catégorie
     */
    public function home()
    {
        // Si les vidéos par catégorie ne sont pas dans la session, les récupérer
        if (!isset($_SESSION['videos_by_category'])) {
            $this->getVideosByCategory();
        }

        $videosByCategory = $_SESSION['videos_by_category'];
        require_once 'views/templates/home.php';
    }
    }