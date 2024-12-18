
<?php

    require_once 'config/config.php';     


    class Video
    {

        // Méthode pour rechercher des vidéos par titre ou artiste

        public static function searchVideos($searchTerm) 
        {
            try 
            {
                $pdo = connect_to_db(); // Connexion à la base de données

                $sql = "SELECT * FROM videos WHERE title LIKE :searchTerm  OR artist LIKE :searchTerm";

                $query    = $pdo->prepare($sql);
                $likeTerm = '%' . $searchTerm . '%';

                $query->bindParam(':searchTerm', $likeTerm, PDO::PARAM_STR);

                $query->execute();

                return $query->fetchAll(PDO::FETCH_ASSOC);
            } 
            catch (PDOException $e) 
            {
                error_log("Error in Video::searchVideos: " . $e->getMessage());
                
                return false;
            }
        }
    }