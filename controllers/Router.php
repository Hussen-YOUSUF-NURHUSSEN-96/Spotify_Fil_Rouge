<?php


    require_once 'views/View.php';  // Inclure la classe View


    class Router
    {
        public function routeRequest()
        {
            try 
            {
                // Vérifier si une action est définie dans l'URL
                $action = $_GET['action'] ?? 'home';                // Action par défaut : home


                // Déterminer le contrôleur à appeler en fonction de l'action
                switch ($action) 
                {
                    case 'login':
                        require_once 'controllers/UserController.php';
                        $controller = new UserController();
                        $controller->login();
                        break;

                    case 'register':
                        require_once 'controllers/UserController.php';
                        $controller = new UserController();
                        $controller->register();
                        break;

                    case 'home':
                        require_once 'controllers/HomeController.php';
                        $controller = new HomeController();
                        $controller->home();
                        break;

                    default:
                        // Action non reconnue
                        $this->handleError("Action inconnue : $action");
                        break;
                }
            } 
            catch (Exception $e) 
            {
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
