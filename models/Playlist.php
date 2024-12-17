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

        public static function create($name){
            $pdo = connect_to_db(); // rend pdo accessible
            $query=$pdo->prepare('INSERT INTO playlists (name) VALUES(:name)');
            $query->bindParam(':name',$name);
            $query->execute();

        }
        

    }
