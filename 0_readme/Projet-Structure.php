
<?php



##########################################################################################

    # Description globale du projet :

##########################################################################################


/*
    Ce projet simule un site comme Spotify, où les utilisateurs peuvent se connecter, s'inscrire, voir des videos

        gerer des playlists et ajouter des videos favorites.
*/



##########################################################################################

    # Structure des fichiers et dossiers :

##########################################################################################


/*
    1. /models       : Logique d'interaction avec la base de donnees (BDD)

    2. /views        : Fichiers pour afficher les pages web.

    3. /controllers  : Gestion des requêtes utilisateurs.    et appellent les bons models et views pour repondre à ces requêtes.

    4. /assets       : Contient CSS, JS et images.

    5. index.php     : Point d'entree principal du projet.
*/



Project-Spotify
│
├── /models                
│       ├── database/
│           ├── database.sql             # Script SQL pour creer la base de donnees
│       BaseModel.php                    # Classe generique pour l'acces à la BDD
│       User.php                         # Modele utilisateur ( Ajouter un utilisateur ou verifier un login dans la base de donnees )
│       Video.php                        # Modele video  ( Ajouter une video ou recuperer toutes les videos dans la base de donnees )
│       Playlist.php                     # Modele playlist  
│
│
├── /views                 
│       ├── templates/          
│           ├── login.php                # Formulaire de connexion
│           ├── register.php             # Formulaire d'inscription
│           ├── home.php                 # Page d'accueil (tableau de bord)
│           ├── videos.php               # Liste des videos
│           ├── playlists.php            # Liste des playlist
│           ├── favorites.php            # Liste des videos favorites
│           ├── error.php                # Page d'erreur generique
│           
│       layout.php                       # Gabarit global pour toutes les pages
│       View.php                         # Classe pour generer et gerer les vues
│
│
├── /controllers           
│       ├── Router.php                   # Analyse l'URL et redirige la requête vers le bon contrôleur.
│       ├── UserController.php           # Gere les actions liees aux utilisateurs (connexion, inscription, deconnexion)
│       ├── HomeController.php           # Gere les elements affiches sur la page d'accueil.   
│       ├── VideoController.php          # Gestion des videos Exemple : Afficher une video ou gerer les favoris.
│       ├── PlaylistController.php       # Gestion des playlists
│
│
├── /assets                              # Fichiers statiques   ( style.css, script.js, images/ )
│
└── index.php                            # Point d'entree principal qui initialise le routeur






##########################################################################################


    # Analogie pour comprendre l'ordre des Actions :


    /*

        Imaginons que { index.php } joue le rôle de l'entraîneur, un peu comme Carlo Ancelotti pour le Real Madrid. 


        Lorsque l'utilisateur fait une demande,    index.php transmet cette requête à son assistant ==> { controllers/router.php }


            -   Si la requête ne contient pas de paramètres, comme "www.index.php.com"  : 


                    -   L'assistant router.php appelle le contrôleur et maestro de la page d'accueil { controllers/HomeController.php } 
                    
                        Ce contrôleur, interagit avec le modèle et avec les views. 

                        Par example, il recupere des videos de { models/Video.php } et l'envoie a la page { views/home.php }



            -   Si la requête contient un paramètres, comme "www.index.php?action=login.com"  : 


                    -   L'assistant router.php appelle le contrôleur et maestro de la page de connexion { controllers/UserController.php } 

                        Ce contrôleur, va verifier les donnees avec { models/User.php }  pour gerer la logique de connexion

                                        et transmettra ensuite les informations necessaires à { views/login.php } 
                    
                        

    */









##########################################################################################

    # Fonctionnement des fichiers principaux :

##########################################################################################




##***##**##**##**##---->>     /views/ View.php         <<----##***##**##**##**## 

<?php

    
    class View        # Permet de charger une View specifique et de l'inclure dans un gabarit global. 
    {
        
        private $fichier;    // Chemin vers le fichier View
        

        // Le constructeur prend l'action (nom de la vue) et construit le chemin vers le fichier correspondant

        public function __construct($action) 
        {
            $this->fichier = "views/" . $action . ".php";        // Exemple : views/templates/login.php
        }

        
        // Methode pour generer et afficher le contenu de la vue
        public function generer($donnees) 
        {
            // ...
        }
        
    }
?>

// -- -------------------------------------

// Exemple d'utilisation   : 

$ViewLogin = new View('templates/login');                  // Charge le fichier 'views/templates/home.php'; 

$ViewLogin->generer([]);                                   // Aucun paramètre specifique n'est envoye à la vue.

$ViewLogin->generer( ['login_Key' => $stagiaire] );        // Envoie les donnees 'stagiaire' à la vue avec la cle 'login_Key'.






##***##**##**##**##---->>     index.php        <<----##***##**##**##**## 


<?php

    require 'Controleur/Routeur.php';     // Chargement du routeur 

    $routeur = new Routeur();             // Creation et execution du routeur
    
    $routeur->routerRequete();            // Analyse l'URL et redirige vers le bon contrôleur
?>




##***##**##**##**##---->>     controllers/ Router.php       <<----##***##**##**##**## 


<?php

    # Analyse l'URL et redirige la requête vers le bon contrôleur

    class Router            
    {

        public function routeRequest()     // Methode pour router les requetes en fonction de l'action
        {

            // Verifier si une action est definie dans l'URL

            if ( isset( $_GET['action'] ) ) 
            {

                switch ( $_GET['action'] ) 
                {

                    case 'login':
                        require_once 'controllers/UserController.php';      // Charger le contrôleur pour la connexion utilisateur

                        $controller = new UserController();                 // Creer une instance du contrôleur
                        $controller->login();

                        break;
                } 
            }
            // Si aucune action n'est specifiee, charger la page d'accueil
            else
            {
                require_once 'controllers/HomeController.php';           // Charger le contrôleur pour la page d'accueil

                $controller = new HomeController();                      // Creer une instance du contrôleur
                $controller->home();
            }
        }
    }
?>




##***##**##**##**##---->>     controllers/ HomeController.php       <<----##***##**##**##**## 


<?php

    # Le HomeController gère la logique de la page d'accueil.
    

    class HomeController 
    {
        public function home() 
        {

            $View = new View('templates/home');            // charge  home.php dans views/templates/home.php ;     

            $View->generer([]);                            // afficher la vue sans donne. 
        }
    }

?>




##***##**##**##**##---->>     controllers/ UserController.php       <<----##***##**##**##**## 


<?php

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





##***##**##**##**##---->>     /views/ layout.php       <<----##***##**##**##**## 



#  Le modèle de base pour les pages


<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">

        <title> <?= $title ?? 'Project-Spotify' ?> </title>

        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body>
        <header>
            <h1>Project-Spotify</h1>
            <nav>
                <a href="index.php?action=home"> Home </a>
                <a href="index.php?action=login"> Login </a>
                <a href="index.php?action=register"> Register </a>
            </nav>
        </header>

        <main>
            <?= $content ?? '' ?>     # Le contenu specifique à chaque page sera insere ici
        </main>

        <footer>
            <p>&copy; 2024 Project-Spotify</p>
        </footer>
    </body>

</html>



# Comment tout fonctionne ensemble ?

/*

    Lorsque l'utilisateur clique sur le lien de connexion = =====>  <a  href = "index.php ? action = login "> Login </a>


    -   Le { Routeur.php } analyse l'URL pour determiner l'action à executer.     Ici, l'action est "login".


    -   Le Routeur constate que $_GET['action'] est defini avec "login", et il choisit donc la case correspondante et appele { controllers/UserController.php } 


    -   Le UserController.php    charge { views/login.php } 


*/






##########################################################################################

    # Que faire si une personne souhaite developper un fichier comme login.php ?

##########################################################################################



# 1. Preparer la View :


#======> { views/templates/ login.php }       ------------------------------------------------------


    <?php $title = "Login"; ?>

    <h2>Login</h2>

    <form action="index.php?action=login" method="POST">        # Parce que l'action est login, Router.php va appeler UserController.php

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>



    
# 2.  Preparer La controlleur  :   Creer la methode login() dans UserController.php


class UserController 
{
    public function login() 
    {   

        if ($_SERVER['REQUEST_METHOD'] === 'POST')               // Si le formulaire a ete soumis  
        { 

            // Recuperer les donnees du formulaire
            $username = $_POST['username'] ?? '';  
            // ... etc


             // Appeler la classe   User.php  dans { models/User.php } pour verifier les informations dans la base de donnees
            $userModel = new User();
            // ...  


            // Si la connexion est reussie  rediriger vers la page d'accueil
            header('Location: index.php?action=home');
        }

        // Par defaut, afficher la page de connexion 
        else
        {
            $ViewLogin = new View('templates/login');   
            $ViewLogin->generer([]);  
        }
    }

    // ...
}




# 3.   Preparer le Modèle :     /models/ User.php    


<?php

    require_once 'modele/BaseModel.php';


    class User extends BaseModel 
    {

         // Fonction pour verifier le login

        public function checkLogin($usernameParam, $passwordParam) 
        {

            $sql = "SELECT * FROM users WHERE username = :username";


            // La methode 'executerRequete' de BaseModel.php       gère l'execution de la requête SQL

            $resultat = $this->executerRequete($sql, ['username' => $usernameParam]);


            $user = $resultat->fetch();        // Verifier si un utilisateur a ete trouve


            // Si l'utilisateur existe et que le mot de passe est correct    return $user;

            // Si les informations de connexion sont incorrectes     return false;
        }
    }
?>





#  Preparer fichers avec git.