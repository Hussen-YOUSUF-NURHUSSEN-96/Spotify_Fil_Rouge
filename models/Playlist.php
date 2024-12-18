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
        

    }
