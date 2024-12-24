<?php

require_once 'views/View.php';
require_once 'models/Playlist.php';
require_once 'models/Video.php';





# Le HomeController gère la logique de la page d'accueil.

class HomeController
{


    public function home()
    {
        //Verifier si une session est active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        //Vérifiez si l'utilisateur est connecté
        if (!isset($_SESSION['user']['id'])) {
            header("Location: index.php?action=login");
            exit();
        }
        //var_dump($_SESSION['user']['id']);
        $userId = $_SESSION['user']['id'];

        $playlists = Playlist::getByUserId($userId);

        //Initialiser des variables pour la playlist selectionner
        $selectedPlaylist = null;
        $erreur = null;

        //Si la playlist est séléctionner
        if (isset($_GET['playlist_id'])) {
            $playlistsId = intval($_GET['playlist_id']);
            $selectedPlaylist = Playlist::getPlaylistWithVideos($playlistsId);

            //Vérifiez si la playlist appartient bien à l'utilisateur
            if (!$selectedPlaylist || $selectedPlaylist['user_id'] !== $userId) {
                $erreur = "Vous n'avez pas accès à cette playlist.";
                $selectedPlaylist = null; // Réinitialisez en cas d'erreur
            }
        }


        //var_dump($playlists);
        //Gestion de la créations des playlists
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
            $name = trim($_POST['name']);

            if (Playlist::exists($name, $userId)) {
                $erreur = "Le nom de la playlist existe déjà.";
            } else {
                Playlist::create($name, $userId);
                header("Location: index.php?action=home");
                exit();
            }
        }
        try {
            // Hussen  -------------------------------------------

            // Récupérer les catégories pour le filtre

            $categories = Video::getCategories();                           // Récupérer toutes les catégories
            $category_id = $_SESSION['search_results']['categoryId'] ?? null;
            $videosByCategory = Video::getVideosByCategory();  // Catégorie sélectionnée, s'il y en a



            // Fin     -------------------------------------------




            $View = new View('templates/home');                            // charge  home.php dans views/templates/home.php ;     

            $View->generer([
                'title' => 'Page d\'Accueil',
                'playlists' => $playlists, //Passez les playlists à la vue
                'selectedPlaylist' => $selectedPlaylist,
                'videosByCategory' => $videosByCategory, //Playlist séléctionnées
                'erreur' => $erreur,

                // Hussen
                'categories' => $categories,  // Catégories pour le filtre
                'category_id' => $category_id  // ID de la catégorie sélectionnée
            ]);           // 
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    }
}
?>