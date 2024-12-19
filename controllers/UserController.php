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
        {    // Si la connexion est reussie, demarrer une session
            if (session_status() === PHP_SESSION_NONE) {
               session_start();
           }
                           
            // Recuperer les donnees du formulaire
            $username = $_POST['username'] ?? ''; 
            $password = $_POST['password'] ?? '';  

            // Instancier le modèle User
            $userModel = new User($username, " ", $password);

            // Verifier les informations de connexion
            $user = $userModel->authenticateUser($username, $password);

            if ($user) 
            {

                $_SESSION['user'] = [
                    'id'=>$user['id'],
                    'username'=>$user['username'],
                    'email'=>$user['email']
                ];// Stocker les donnees de l'utilisateur dans la session


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

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        

        if($_SERVER['REQUEST_METHOD']==='POST'){

            //Récupérations des données du formulaire
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            //Vérifications si le pseudo est dejà utilisé
            if(User::userNameExist($username)){
                $errorMessage = "Le nom d'utilisateur est déjà utiliser";

            }

            //Si l'email existe déjà
            elseif(User::emailExist($email)){
                $errorMessage = "L'email est déjà utilisé.";

            }else {
                //Si l'email et le pseudo sont disponible

               

                if(User::create($username, $email, $password)){
                   
                    $user = User::getUserByUsername($username);
                  
                    if($user){
                    $_SESSION['user'] = ['id'=>$user['id'],
                                        'username'=>$user['username'],
                                        'email'=>$user['email']];
                    
                    
                    header("Location:index.php?action=home");
                    exit();
                   } else{
                    $errorMessage="Erreur : impossible de récupérer les informations de l'utilisateur";
                   }

                }else{
                    $errorMessage = "Erreur lors de l'inscription:getbyusername";
                }
            }
        }
        //Charger la vue 
        require_once 'views/templates/register.php';
      }


   









      
    }

?>