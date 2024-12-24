<?php
require_once 'models/Playlist.php';
require_once 'views/View.php';


class PlaylistController
{

    // Méthode pour afficher la bibliothèque de playlists
    public function index()
    {
        $playlists = Playlist::getAll(); // Récupérer toutes les playlists depuis le modèle

        //Verifier si une playlist specificque à été sélectionner
        if (isset($_GET['playlist_id'])) {
            $playlistId = $_GET['playlist_id'];
            //Récuperer la playlist avec es vidéos
            $playlist = Playlist::getPlaylistWithVideos($playlistId);
        } else {
            //Si aucune playlist n'est selectionner
            $playlist = null;
        }
        require_once 'views/templates/home.php';
    }

    // Méthode pour créer une nouvelle playlist
    public function create()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();  // Démarre la session si ce n'est pas déjà fait
        }

        //Verifiez si l'utilisateur est connecté
        if (!isset($_SESSION['user']['id'])) {
            echo "Erreur : aucun utilisateur connecté";
            exit();
        }

        $userId = $_SESSION['user']['id'];


        // Exemple de création de la playlist
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);

            //Verifier si une playlist existe deja
            if (Playlist::exists($name, $userId)) {
                $erreur = "Le nom de playlist est déjà utilisé.";
            } else {
                if (Playlist::create($name, $userId)) {
                    //echo "Playlist créée avec succès.";
                    header("Location: index.php?action=home");
                    exit();
                } else {
                    echo "Erreur lors de la création de la playlist.";
                }

            }
        }

        $playlists = Playlist::getByUserId($userId);
        require_once 'views/templates/home.php';
    }

    public function delete()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();  // Démarre la session si ce n'est pas déjà fait
        }
        //Verifiez si l'utilisateur est connecté
        if (!isset($_SESSION['user']['id'])) {
            echo "Erreur : aucun utilisateur connecté";
            exit();
        }

        $userId = $_SESSION['user']['id'];

        //Verifier que la méthode post et que la playlits-id est fournie
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['playlist_id'])) {
            $playlistId = intval($_POST['playlist_id']);

            // Vérifiez si la playlist appartient à l'utilisateur
            if (!Playlist::belongsToUser($playlistId, $userId)) {
                header("Location: index.php?action=home&error=not_authorized");
                exit();
            }

            try {
                // Supprimer les vidéos associées à la playlist
            $pdo = connect_to_db();
            $sql = "DELETE FROM playlist_videos WHERE playlist_id = :playlist_id";
            $query = $pdo->prepare($sql);
            $query->bindParam(':playlist_id', $playlistId, PDO::PARAM_INT);
            $query->execute();

            // Supprimer la playlist elle-même
            if (Playlist::delete($playlistId)) {
                header("Location: index.php?action=home&success=playlist_deleted");
                exit();
            } else {
                throw new Exception("Erreur lors de la suppression de la playlist.");
            }
                
            } catch (Exception $e) {
                // Redirection avec un message d'erreur
                header("Location: index.php?action=home&error=" . urlencode($e->getMessage()));
                exit();

            }

        }

    }

    public function addVideoToPLaylist()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();  // Démarre la session si ce n'est pas déjà fait
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['video_id'], $_POST['playlist_id'])) {
                $videoId = intval($_POST['video_id']);
                $playlistId = intval($_POST['playlist_id']);


                $success = Playlist::addVideoToPlaylist($videoId, $playlistId);

                if ($success) {
                    header("Location: index.php?action=home&message=video_added");
                } else {
                    header("Location: index.php?action=home&message=error");
                }
                exit();
            }
        }
    }

}







?>