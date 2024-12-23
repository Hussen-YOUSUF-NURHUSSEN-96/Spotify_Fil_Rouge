
<?php
    require_once 'models/BaseModel.php';
    require_once 'config/config.php';     


    class Video
    {

        // Méthode pour rechercher des vidéos par titre ou artiste

        public static function searchVideos($searchTerm) 
        {
            try 
            {
                $pdo = connect_to_db(); // Connexion à la base de données

                if (trim($searchTerm) === '') {
                    // Si le terme de recherche est vide, retourner un tableau vide
                    return [];
                }

                $sql = "SELECT * FROM videos WHERE title LIKE :searchTerm  OR artist LIKE :searchTerm";

                $query    = $pdo->prepare($sql);
                $likeTerm = '%' . $searchTerm . '%';

                $query->bindParam(':searchTerm', $likeTerm, PDO::PARAM_STR);

                $query->execute();

                $results= $query->fetchAll(PDO::FETCH_ASSOC);
                var_dump($results);
                
                return $results;
                
            } 
            catch (PDOException $e) 
            {
                echo"Error in Video::searchVideos: ";
                
                return false;
            }
        } 


         /**
     * Convertit une URL YouTube en URL d'intégration
     * @param string $url L'URL de la vidéo YouTube
     * @return string L'URL d'intégration
     */
    public static function convertToEmbedUrl($url) {
        $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/';
        if (preg_match($pattern, $url, $matches)) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        return $url; // Retourne l'URL originale si ce n'est pas une URL YouTube valide
    }
        
        /**
     * Récupère les vidéos groupées par catégorie
     * @return array Un tableau associatif des vidéos groupées par catégorie
     */
    public static function getVideosByCategory()
    {
        try 
        {
            $pdo = connect_to_db(); // Connexion à la base de données

            $sql = "SELECT v.*, c.name AS category_name 
                    FROM videos v 
                    JOIN categories c ON v.category_id = c.id 
                    ORDER BY c.name, v.title";

            $query = $pdo->prepare($sql);
            $query->execute();

            $results = $query->fetchAll(PDO::FETCH_ASSOC);

            // Grouper les vidéos par catégorie
            $videosByCategory = [];
            foreach ($results as $video) {
                $videosByCategory[$video['category_name']][] = $video;
            }

            return $videosByCategory;
        } 
        catch (PDOException $e) 
        {
            error_log("Error in Video::getVideosByCategory: " . $e->getMessage());
            return false;
        }
    }
}

    