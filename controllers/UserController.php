<?php

    require_once 'models/User.php';  // Inclure le modèle User
    require_once 'views/View.php';   // Inclure le gestionnaire des vues


    # Le UserController gère les actions liees aux utilisateurs, comme la connexion ou l'inscription.

    class UserController 
    {

        
        
        // Affiche le formulaire de connexion

        public function login()  
        {
            $ViewLogin = new View('templates/login');            // charge  login.php  
            $ViewLogin->generer([]);  
        }

        // ---------------------------------------------------------------


        // Traiter la soumission du formulaire de connexion

        public function loginSubmit() 
        {
            // Recuperer les donnees du formulaire
            $username = $_POST['username'] ?? ''; 
            $password = $_POST['password'] ?? '';  

            // Instancier le modèle User
            $userModel = new User();

            // Verifier les informations de connexion
            $user = $userModel->authenticateUser($username, $password);

            if ($user) 
            {
                 // Si la connexion est reussie, demarrer une session
                session_start();

                $_SESSION['user'] = $user;    // Stocker les donnees de l'utilisateur dans la session


                // Rediriger vers la page d'accueil
                header('Location: index.php?action=home');

                exit();
            }
            else
            {
                // Si la connexion echoue, afficher un message d'erreur

                $viewLogin = new View('templates/login');
                
                $viewLogin->generer(['errorMessage' => "Nom d'utilisateur ou mot de passe incorrect."]);
            }
        }

        // ##################################################################


//  public function register()  // Affiche le formulaire d'inscription
//  {
//      $ViewRegister = new View('templates/register');      // charge  register.php  
//      $ViewRegister->generer([]);       
//  }

        //Formulaire d'inscription
        public function registrer(){
            if($_SERVER['REQUEST_METHOD']=='POST'){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = password_hash($_POST['password'],PASSWORD_BCRYPT);
                //Appel du modèle pour créer l'utilisateur
                if(User::create($username,$email,$password)){
                    header("Location: /success"); //Redirection apès succes
                    
                    exit();
                } else {
                    echo"Erreur lors de l'inscriptions.";
                }
            }
            //Charger la vue
            require_once 'views/templates/register.php';
          }
          
    }

?>