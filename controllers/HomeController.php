
<?php

    require_once 'views/View.php';


    # Le HomeController gère la logique de la page d'accueil.

    class HomeController 
    {

        
        public function home() 
        {
            try
            {
                $View = new View('templates/home');                            // charge  home.php dans views/templates/home.php ;     

                $View->generer( ['title' => 'Page d\'Accueil'] );              // afficher la vue sans donne. 
            }
            catch (Exception $e) 
            {
                echo 'Erreur : ' . $e->getMessage();
            }
        }
    }

?>