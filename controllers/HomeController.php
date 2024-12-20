
<?php

    require_once 'views/View.php';
    require_once 'models/Playlist.php';
    


    # Le HomeController gère la logique de la page d'accueil.

    class HomeController 
    {

        
        public function home() 
        {
            //Verifier si une session est active
            if (session_status()===PHP_SESSION_NONE){
                session_start();
            }


            //Vérifiez si l'utilisateur est connecté
            if(!isset($_SESSION['user']['id'])){
                header("Location: index.php?action=login");
                exit();
            }

            $userId = $_SESSION['user']['id'];

            $playlists = Playlist::getByUserId($userId);

            //Initialiser des variables pour la playlist selectionner
            $selectedPlaylist = null;
            

            //Si la playlist est séléctionner
            if(isset($_GET['playlist_id'])){
                $playlistsId = intval($_GET['playlist_id']);
                $selectedPlaylist = Playlist::getPlaylistWithVideos($playlistsId);
            }

            
//var_dump($playlists);

            if($_SERVER['REQUEST_METHOD']==='POST'){
                $playlistName =trim($_POST['name']);

                if(Playlist::exists($playlistName,$userId)){
                    $error = "Le nom de la playlist existe déjà.";
                }else {
                    Playlist::create($playlistName,$userId);
                    header("Location: index.php?action=home");
                    exit();
                }
            }

            try
            {
                $View = new View('templates/home');                            // charge  home.php dans views/templates/home.php ;     

                $View->generer( [
                    'title' => 'Page d\'Accueil',
                    'playlists' =>$playlists, //Passez les playlists à la vue
                    'selectedPlaylist'=>$selectedPlaylist, //Playlist séléctionnées
                    'error'=> isset($error)?$error :null
                    ]);              // 
            }
            catch (Exception $e) 
            {
                echo 'Erreur : ' . $e->getMessage();
            }
        }
    }

?>