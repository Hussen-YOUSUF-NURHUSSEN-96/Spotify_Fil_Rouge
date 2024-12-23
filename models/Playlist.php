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
                echo"Erreur dans Playlist::create";
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
                echo"Erreur dans Playlist::getByUserId";
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
                echo"Erreur dans Playlist::GetPlaylistWithVideos: ";
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
                
                $query->bindParam(':playlist_id', $playlistId,PDO::PARAM_INT);

                //Executer la requete de suppression
                $result = $query->execute();
                if($result){
                    return true;
                } else{
                    echo "Erreur lors de la suppression de la playlist (pas de lignes affectées";
                    return false;
                }


            }catch (PDOException $e){
                echo"Exception lros de la suppression de la playlist";
                return false;
            }
        }

        public static function belongsToUser($playlistId, $userId){
                $pdo = connect_to_db(); // rend pdo accessible

                $sql = "SELECT COUNT(*) FROM playlists WHERE id = :playlist_id AND user_id = :user_id";
                $query = $pdo->prepare($sql);
                $query->bindParam(':playlist_id', $playlistId, PDO::PARAM_INT);
                $query->bindParam(':user_id', $userId, PDO::PARAM_INT);
                $query->execute();

                //Retourne true si la playlist apparient à l'utilisateur

                return $query->fetchColumn()>0;

        }

        public static function addVideoToPLaylist($videoId, $playlistId){
            try{

                $pdo = connect_to_db(); // rend pdo accessible

                $checksql="SELECT COUNT(*) FROM playlist_videos WHERE playlist_id = :playlist_id AND video_id = :video_id";
                $checkquery = $pdo->prepare($checksql);
                $checkquery->execute([
                    ':playlist_id'=>$playlistId,
                    ':video_id'=>$videoId,
                ]);

                if($checkquery->fetchColumn()>0){
                    return false;
                }

                //Ajouter la vidéo à la playlist

                $sql = "INSERT INTO playlist_videos (playlist_id, video_id) VALUES (:playlist_id, :video_id)";
                $query = $pdo->prepare($sql);
                return $query->execute([
                    ':playlist_id'=>$playlistId,
                    ':video_id'=>$videoId,
                ]);
            } catch(PDOException $e){
                echo "Erreur dans le Playlist::AddVideoToPlaylist : ";
                return false;
            }
        }

        public static function clearVideoFromPlaylist($playlistId){
            try{
                $pdo = connect_to_db(); // rend pdo accessible

                //Vérifiez si des vidéos existent dans la playlist
                $sqlCheck = "SELECT COUNT(*) FROM videos WHERE playlist_id = :playlist_id";
                $queryCheck =$pdo->prepare($sqlCheck);
                $queryCheck->execute(['playlist_id' => $playlistId]);
                $count = $queryCheck->fetchColumn();

                if($count >0){
                    //Si les vidéos existent supprimez-les
                    $sql = "DELETE FROM videos WHERE playlist_id = :playlist_id";
                    $query = $pdo->prepare($sql);

                    if($query->execute(['playlist_id' => $playlistId])){
                        return true;
                    } else{
                        echo"Errreur lors de la suppression des videos";
                        return false;
                    }
                } else{
                    //Aucune vidéos à supprimer
                    return true;
                }

        
            }catch(PDOException $e){
                echo "exception lors de la suppression des vidéos ";
                return false;
            }

        }
    }
        
?>
