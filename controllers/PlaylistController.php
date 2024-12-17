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
                if (isset($_POST['name'])) {
                    $name = $_POST['name'];
                    Playlist::create($name); // Créer une nouvelle playlist
                    header('Location:index.php?action=home'); // Rediriger vers la page principale après création
                }
            }
        }
        
       
    

?>