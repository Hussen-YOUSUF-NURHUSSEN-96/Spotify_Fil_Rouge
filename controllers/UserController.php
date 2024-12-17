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


     // public function register()  // Affiche le formulaire d'inscription
     // {
     //     $ViewRegister = new View('templates/register');      // charge  register.php  
     //     $ViewRegister->generer([]);       
     // }

     public function register(){
        //Vérification de la methode http
        if($_SERVER['REQUEST_METHOD']=='POST'){
            //Récupérations des données du formulaires
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            //Vérifications si le pseudo est déjà utilisé
            if(User::userNameExist($username)){
                $errorMessage = "Le nom d'utilisateur est déjà pris.";
            }

            //Si l'email existe déjà
            elseif(User::emailExist($email)){
                $errorMessage = "L'adresse email est déjà utilisée.";

            }else{
                //Si l'email et le pseudo sont disponible cryptage du mot de passe
                $passwordHash=password_hash($password,PASSWORD_BCRYPT);

                //Créationd de l'utilisateur
            if(User::create($username,$email,$password)){
                header("Location: views/templates/home.php"); //Redirection apès succes
    
                exit();
            } else {
                 echo"Erreur lors de l'inscriptions.";
            }
            }
        }
        //Charger la vue
        require_once 'views/templates/register.php';
      }
      
    }

?>