<?php

    require_once 'BaseModel.php';        // Inclure la classe Modele pour la connexion à la base de données


    class User extends BaseModel
    {

    // Code permettant l'inscirption
        public static function create($username,$email,$password){
            global $dsn; //Utilisation de la connexion globale
            $sql="INSERT INTO users(username, email, password) VALUES (:username, :email, :password)";
            $stmt=$dsn->prepare($sql);
            //Sécurisations de la donnée
            $stmt->bindParam(":username", $username);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);
            return $stmt->execute();
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
