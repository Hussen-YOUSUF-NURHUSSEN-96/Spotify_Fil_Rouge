<?php
    require_once 'models/Playlist.php';
    require_once 'views/View.php'; 
                                                                                             
       
        class PlaylistController {
    
            // Méthode pour afficher la bibliothèque de playlists
            public function index() {
                $playlists = Playlist::getAll(); // Récupérer toutes les playlists depuis le modèle

                //Verifier si une playlist specificque à été sélectionner
                if(isset($_GET['playlist_id'])){
                    $playlistId =$_GET['playlist_id'];
                    //Récuperer la playlist avec es vidéos
                    $playlist =Playlist::getPlaylistWithVideos($playlistId);
                }else{
                    //Si aucune playlist n'est selectionner
                    $playlist = null;
                }
                require_once 'views/templates/home.php';
            }
        
            // Méthode pour créer une nouvelle playlist
            public function create() {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();  // Démarre la session si ce n'est pas déjà fait
                }

                //Verifiez si l'utilisateur est connecté
                if(!isset($_SESSION['user']['id'])){
                    echo "Erreur : aucun utilisateur connecté";
                    exit();
                }

                $userId = $_SESSION['user']['id'];

                  // Exemple de création de la playlist
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $name = trim($_POST['name']);

                    //Verifier si une playlist existe deja
                    if(Playlist::exists($name,$userId)){
                        echo "<p style='color:red;'>Erreur : une playlist avec ce nom existe déjà.</p>";
                        error_log("Erreur : tentative de création d'une playlist déjà existante.");
                        return;
                    }

                    if (Playlist::create($name,$userId )) {
//echo "Playlist créée avec succès.";
                        header("Location: index.php?action=home");
                        exit();
                    } 
                    else {
                        echo "Erreur lors de la création de la playlist.";
                    }
    
                }
            }

        }
        
       
    

?>