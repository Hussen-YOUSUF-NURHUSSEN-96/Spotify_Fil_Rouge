<?php
    require_once 'models/Playlist.php';

                                                                                             
       
        class PlaylistController {
    
            // Méthode pour afficher la bibliothèque de playlists
            public function index() {
                $playlists = Playlist::getAll(); // Récupérer toutes les playlists depuis le modèle
                require 'views/templates/home.php';
            }
        
            // Méthode pour créer une nouvelle playlist
            public function create() {
                session_start();

                //Verifiez si l'utilisateur est connecté
                if(isset($_SESSION['user_id'])){
                    echo "Erreur : aucun utilisateur connecté";
                    exit();
                }

                $userId = $_SESSION['user_id'];

                  // Exemple de création de la playlist
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $playlistTitle = $_POST['name'];

                    if (Playlist::create($playlistTitle,$userId )) {
                    echo "Playlist créée avec succès.";
                    } else {
                    echo "Erreur lors de la création de la playlist.";
                }
    }
            }
        }
        
       
    

?>