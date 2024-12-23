<?php


require_once 'views/View.php';  // Inclure la classe View


class Router
{
    public function routeRequest()
    {
        try {
            session_start();

            // Vérifier si une action est définie dans l'URL
            $action = $_GET['action'] ?? 'login';                // Action par défaut : home


            // Déterminer le contrôleur à appeler en fonction de l'action
            switch ($action) {

                case 'home':
                    require_once 'controllers/HomeController.php';
                    $controller = new HomeController();
                    $controller->home();
                    break;

                case 'login':
                    require_once 'controllers/UserController.php';
                    $controller = new UserController();
                    $controller->login();
                    break;

                case 'loginSubmit':
                    require_once 'controllers/UserController.php';
                    $controller = new UserController();
                    $controller->loginSubmit();
                    break;

                case 'register':
                    require_once 'controllers/UserController.php';
                    $controller = new UserController();
                    $controller->register();
                    break;

                case 'index':
                    require_once 'controllers/PlaylistController.php';
                    $controller = new PlaylistController();
                    $controller->index();
                    break;
                //Créer une nouvelle playlist
                case 'create':
                    require_once 'controllers/PlaylistController.php';
                    $controller = new PlaylistController();
                    $controller->create();
                    break;

                case 'logout':
                    require_once 'controllers/LogOutController.php';
                    $controller = new LogoutController();
                    $controller->logout();
                    break;
                // Rechercher une video
                case 'search':
                    require_once 'controllers/VideoController.php';
                    $controller = new VideoController();
                    $controller->search();
                    break;
                //Supprimer une Playlist
                case 'delete_playlist':
                    require_once 'controllers/PlaylistController.php';
                    $controller = new PlaylistController();
                    $controller->delete();
                    break;
                case 'video':
                    require_once 'controllers/VideoController.php';
                    $controller = new VideoController();
                    $controller->home();
                    break;
                case 'addVideoToPlaylist':
                    require_once 'controllers/PlaylistController.php';
                    $controller = new PlaylistController();
                    $controller->addVideoToPLaylist();
                    break;
                default:
                    // Action non reconnue
                    $this->handleError("Action inconnue : $action");
                    break;
            }
        } catch (Exception $e) {
            // Gérer les erreurs globales
            $this->handleError($e->getMessage());
        }
    }

    private function handleError($message)
    {
        // Charger une vue d'erreur générique
        require_once 'views/templates/error.php';

        $view = new View('templates/error');
        $view->generer(['errorMessage' => $message]);
    }
}
?>