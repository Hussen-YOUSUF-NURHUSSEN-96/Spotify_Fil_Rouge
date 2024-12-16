<?php

    require_once 'models/BaseModel.php';        // Inclure la classe Modele pour la connexion à la base de données
    require_once 'config/config.php';                                                                                                                                                                                                                     

    class User extends BaseModel{
        

    // Code permettant l'inscirption
        public static function create($username,$email,$password){
            try{
                $pdo = connect_to_db(); // rend pdo accessible
            
             $sql="INSERT INTO users(username, email, password) VALUES (:username, :email, :password)";
             
             $query=$pdo->prepare($sql);
             //Sécurisations de la donnée
             
             $query->bindParam(":username", $username);
             $query->bindParam(":email", $email);
             $query->bindParam(":password", $password);
             
             return $query->execute();
            }catch (PDOException $e) {
                error_log("Error in User::create: " . $e->getMessage()); // Log the error for debugging
                return false; // Return false to indicate failure
            }
        }

        // Authentifier un utilisateur à partir de son nom d'utilisateur et de son mot de passe

        public function authenticateUser($username, $password)
        {

            // Récupérer les informations de l'utilisateur par le nom d'utilisateur

            $sql = "SELECT * FROM users WHERE username = ?";
            

            // Exécuter 
            $result = $this->executeQuery($sql, [$username]);


            $user = $result->fetch(PDO::FETCH_ASSOC);

            // Si l'utilisateur existe 
            if ($user && password_verify($password, $user['password'])) 
            {
                return $user; // Retourner les données de l'utilisateur
            }

            // Sinon, retourner false 
            return false;
        }

        // ###################################################################################
    }
