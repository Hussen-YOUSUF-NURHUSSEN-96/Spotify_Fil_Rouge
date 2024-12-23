<?php

    require_once 'models/Video.php'; // Inclure le modèle Video
    require_once 'views/View.php';   // Inclure le gestionnaire des vues


    class VideoController 
    {

        // Methode pour afficher les resultats de recherche
        public function search() { 
            
            if (session_status() === PHP_SESSION_NONE) 
            {
                session_start();
            }
        
            // Verifier si une recherche a ete effectue
            $searchTerm = $_GET['query'] ?? '';
            $categoryId = $_GET['category_id'] ?? '';
    
            // Rechercher les videos avec ou sans filtre de catégorie
            $videos_search = Video::searchVideos($searchTerm, $categoryId);
            

             // Stocker les résultats de recherche dans la session
            $_SESSION['search_results'] = 
            [
                'videos_search'  => $videos_search,
                'searchTerm'     => $searchTerm,
                'categoryId'     => $categoryId,
            ];

            // Rediriger vers la page home
            header('Location: index.php?action=home');
            exit();
            
        }

        // ############################################################


        public function getVideosByCategory(){   
            if (session_status() === PHP_SESSION_NONE) {
            session_start();
            }
        
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
    public function home(){   
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
        }
    
        // Si les vidéos par catégorie ne sont pas dans la session, les récupérer
        if (!isset($_SESSION['videos_by_category'])) {
            $this->getVideosByCategory();
        }

        $videosByCategory = $_SESSION['videos_by_category'];

        var_dump($videosByCategory); // Vérifier que les vidéos sont bien récupérées
    
        if (empty($videosByCategory)) {
            echo "Aucune vidéo par catégorie disponible."; // Message de débogage
        }
         

        require_once  'views/templates/home.php';
    }
}
?>