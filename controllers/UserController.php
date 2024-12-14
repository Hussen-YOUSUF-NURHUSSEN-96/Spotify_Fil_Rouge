<?php

    require_once 'views/View.php';


    # Le UserController gère les actions liees aux utilisateurs, comme la connexion ou l'inscription.

    class UserController 
    {

        public function login()  // Affiche le formulaire de connexion
        {
            $ViewLogin = new View('templates/login');            // charge  login.php  
            $ViewLogin->generer([]);  
        }

        
        public function register()  // Affiche le formulaire d'inscription
        {
            $ViewRegister = new View('templates/register');      // charge  register.php  
            $ViewRegister->generer([]);       
        }
    }

?>