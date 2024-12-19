<?php
    require_once 'models/BaseModel.php';        // Inclure la classe Modele pour la connexion à la base de données
    require_once 'config/config.php';

    class Playlist{
        
       /*  public static function getAllPlaylists(){
            $pdo = connect_to_db(); // rend pdo accessible

            $query = $pdo->query("SELECT *FROM playlists)");
           
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        public function addPlaylist($name){
            $pdo = connect_to_db(); // rend pdo accessible

            $query = $pdo->prepare("INSERT INTO playlists (name) VALUES(?)");
            $query->execute([$name]);
            return $pdo->lastInsertId();
        }

        public function deletePlaylist($id){
            $pdo = connect_to_db(); // rend pdo accessible

            $query=$this->pdo->prepare("DELETE FROM playlists WHERE id = :id");
            $query->bindParam(':id',$id);
            return $query->execute();
            
        }*/

        public static function getAll(){
            $pdo = connect_to_db(); // rend pdo accessible
            $query=$pdo->query("SELECT * FROM playlists");
            return $query->fetchAll(PDO::FETCH_ASSOC);

        }

        public static function create($name, $userId){
            try{
                $pdo = connect_to_db(); // rend pdo accessible

                $sql="INSERT INTO playlists (name, user_id) VALUES(:name, :user_id)";
                $query = $pdo->prepare($sql);

                $query->bindParam(':user_id',$userId);
                $query->bindParam(':name',$name);
                
                if($query->execute()){
                    return true;
                } return false;
            } catch(PDOException $e){
                error_log("Erreur dans Playlist::create".$e->getMessage());
                return false;
            }
        }

        public static function getByUserId($userId){
            try{

                $pdo = connect_to_db(); // rend pdo accessible

                $sql="SELECT *FROM playlists WHERE user_id = :user_id ORDER BY created_at DESC";
                $query = $pdo->prepare($sql); 
                
                $query->bindParam(':user_id', $userId,PDO::PARAM_INT);
                $query->execute();

                return $query->fetchAll(PDO::FETCH_ASSOC);

            }catch(PDOException $e){
                error_log("Erreur dans Playlist::getByUserId".$e->getMessage());
                return [];                                               
            }
        }

        public static function getPlaylistWithVideos($playlistId){
            try{
                $pdo = connect_to_db(); // rend pdo accessible

                $sql="SELECT * FROM playlists WHERE id = :playlist_id";
                $query = $pdo->prepare($sql);
                $query->bindParam(':playlist_id', $playlistId,PDO::PARAM_INT);
                $query->execute();
                $playlist = $query->fetch(PDO::FETCH_ASSOC);

                if(!$playlist){
                    return null; //si la playlist n'existe pas 
                }

                $sqlVideos = "SELECT v.id, v.title, v.artist, v.video_url, v.thumbnail_url
                            FROM playlist_videos pv
                            JOIN videos v ON pv.video_id = v.id
                            WHERE pv.playlist_id = :playlist_id
                            ORDER BY pv.position ASC";
                
                $queryVideos = $pdo->prepare($sqlVideos);
                $queryVideos->bindParam(':playlist_id',$playlistId,PDO::PARAM_INT);
                $queryVideos->execute();
                $videos = $queryVideos->fetchAll(PDO::FETCH_ASSOC);

                //Ajouter les vidéos à la playlist

                $playlist['videos'] = $videos;

                return $playlist;
            } catch(PDOException $e){
                error_log("Erreur dans Playlist::GetPlaylistWithVideos: ".$e->getMessage());
                return null;
            }
        }

        public static function exists($name, $userId){
           

           $pdo = connect_to_db(); // rend pdo accessible

            $sql ="SELECT COUNT(*) FROM playlists WHERE name = :name AND user_id = :user_id";
            $query = $pdo->prepare($sql);
            $query->bindParam(':name',$name,PDO::PARAM_STR);
            $query->bindParam(':user_id',$userId,PDO::PARAM_INT);
            $query->execute();

            //Retourne true si une playlist existe
            return $query->fetchColumn()>0;

        }

        public static function delete($playlistId){
            try{
                $pdo = connect_to_db(); // rend pdo accessible

                $sql="DELETE FROM playlists WHERE id= :playlist_id";
                $query=$pdo->prepare($sql);
                $query->bindparam(':playlist_id',$playlistId,PDO::PARAM_INT);

                return $query->execute();

            }catch (PDOException $e){
                error_log("Erreur dans la playlist::delete:".$e->getMessage());
                return false;
            }
        }

        public static function belongsToUser($playlistId, $userId){
            try{
                $pdo = connect_to_db(); // rend pdo accessible

                $sql = "SELECT COUNT(*) FROM playlists WHERE id = :playlist_id AND user_id";
                $query = $pdo->prepare($sql);
                $query->bindParam(':playlist_id', $playlistId, PDO::PARAM_INT);
                $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $query->execute();

                //Retourne true si la playlist apparient à l'utilisateur

                return $query->fetchColumn()>0;

            }catch(PDOException $e){
                error_log("Erreur dans la playlist::belongsToUser:".$e->getMessage());
                return false;
            }
        }


        }
        
?>
