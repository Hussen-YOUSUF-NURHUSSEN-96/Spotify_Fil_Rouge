
<?php

    // Gerer la connexion à la base de donnes et l'execution des requêtes SQL

    class BaseModel 
    {

        // Stocker l'objet de connexion à la base de donnes 
        private $bdd;


        // Cette fonction etablit une connexion à la base de donnees MySQL et retourne la connexion

        private function getBdd() 
        {
            // Si la connexion à la base de donnees n'a pas encore ete creee, on la cree

            if ($this->bdd === null)
            {
                try 
                {
                    /*
                        Creation de la connexion : 

                        -   'localhost'   : adresse du serveur
                        -   'spotifyDB'   : nom de la base de donnees
                        -   'root'        : nom d'utilisateur pour se connecter à la base de donnees      '' : mot de passe (ici vide)
                    
                        -   PDO::ERRMODE_EXCEPTION : permet d'afficher les erreurs si la connexion echoue

                    */
                    $this->bdd = new PDO(
                                            'mysql:host=localhost;dbname=spotifyDB;charset=utf8',  
                                            'root', '',
                                            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                                        );
                } 
                // Si la connexion echoue
                catch (PDOException $e) 
                {
                    die("Erreur de connexion : " . $e->getMessage());
                }
            }
            return $this->bdd;
        }

        // - -------------------------------------------------------


        // Execute une requête SQL
        protected function executeQuery($sql, $params = null) 
        {
            try 
            {
                if ($params === null) 
                {
                    $resultat = $this->getBdd()->query($sql);
                } 
                else 
                {
                    $resultat = $this->getBdd()->prepare($sql);

                    $resultat->execute($params);
                }


                /*
                    Retourne le resultat de la requête :

                        Si c'est une requête SELECT, ça renverra les resultats sous forme d'objet PDOStatement.

                        Si c'est une requête INSERT, UPDATE, DELETE, ça renverra le nombre de lignes affectes
                */
                return $resultat;    
            } 

            // Si une erreur SQL se produit,
            catch (PDOException $e) 
            {
                die("Erreur SQL : " . $e->getMessage());
            }
        }
    }
