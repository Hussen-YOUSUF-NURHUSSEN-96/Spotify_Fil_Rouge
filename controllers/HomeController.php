
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

            
//var_dump($playlists);

            try
            {
                $View = new View('templates/home');                            // charge  home.php dans views/templates/home.php ;     

                $View->generer( [
                    'title' => 'Page d\'Accueil',
                    'playlists' =>$playlists //Passez les playlists à la vue
                    ]);              // afficher la vue sans donne. 
            }
            catch (Exception $e) 
            {
                echo 'Erreur : ' . $e->getMessage();
            }
        }
    }

?>