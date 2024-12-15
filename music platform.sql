-- Supprimer les tables si elles existent déjà
DROP TABLE IF EXISTS playlist_videos;
DROP TABLE IF EXISTS user_video_interactions;
DROP TABLE IF EXISTS playlists;
DROP TABLE IF EXISTS videos;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;

-- Créer les tables

-- Table des utilisateurs : Cette table stocke les informations des utilisateurs inscrits sur la plateforme.
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,  -- Nom d'utilisateur unique
    email VARCHAR(100) NOT NULL UNIQUE,    -- Adresse e-mail unique
    password VARCHAR(255) NOT NULL,         -- Mot de passe de l'utilisateur
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Date de création de l'utilisateur
) ENGINE=InnoDB;

-- Table des catégories : Cette table contient les différentes catégories de vidéos disponibles sur la plateforme.
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,   
    name VARCHAR(50) NOT NULL UNIQUE      -- Nom de la catégorie
) ENGINE=InnoDB;

-- Table des vidéos : Cette table contient les informations relatives aux vidéos, telles que le titre, l'artiste, la catégorie, et les liens vers les vidéos et leurs vignettes.
CREATE TABLE videos (
    id INT AUTO_INCREMENT PRIMARY KEY,   -- Identifiant unique de la vidéo
    title VARCHAR(100) NOT NULL,          -- Titre de la vidéo
    artist VARCHAR(100) NOT NULL,         -- Artiste ou créateur de la vidéo
    category_id INT,                      -- Référence à l'ID de la catégorie de la vidéo
    video_url VARCHAR(255) NOT NULL,      
    thumbnail_url VARCHAR(255),           -- URL de la vignette de la vidéo
    duration INT,                         -- Durée de la vidéo en secondes
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Date de création de la vidéo
    FOREIGN KEY (category_id) REFERENCES categories(id)  
) ENGINE=InnoDB;

-- Table des playlists : Cette table contient les playlists créées par les utilisateurs. Chaque playlist est associée à un utilisateur spécifique.
CREATE TABLE playlists (
    id INT AUTO_INCREMENT PRIMARY KEY,    -- Identifiant unique de la playlist
    user_id INT NOT NULL,                  -- Référence à l'ID de l'utilisateur ayant créé la playlist
    name VARCHAR(100) NOT NULL,            -- Nom de la playlist
    description TEXT,                      -- Description de la playlist
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Date de création de la playlist
    FOREIGN KEY (user_id) REFERENCES users(id)  
) ENGINE=InnoDB;

-- Table playlist_videos (pour la relation plusieurs-à-plusieurs entre playlists et vidéos) : Cette table fait le lien entre les vidéos et les playlists. Elle permet à une vidéo d'être ajoutée à plusieurs playlists.
CREATE TABLE playlist_videos (
    id INT AUTO_INCREMENT PRIMARY KEY,    
    playlist_id INT NOT NULL,              -- Référence à l'ID de la playlist
    video_id INT NOT NULL,                 -- Référence à l'ID de la vidéo
    position INT,                          -- Position de la vidéo dans la playlist
    FOREIGN KEY (playlist_id) REFERENCES playlists(id),  
    FOREIGN KEY (video_id) REFERENCES videos(id) 
) ENGINE=InnoDB;

-- Table des interactions utilisateur-vidéo : Cette table enregistre les interactions des utilisateurs avec les vidéos, comme le visionnage, les recommandations, les évaluations et les critiques.
CREATE TABLE user_video_interactions (
    id INT AUTO_INCREMENT PRIMARY KEY,    -- Identifiant unique de l'interaction
    user_id INT NOT NULL,                  -- Référence à l'ID de l'utilisateur
    video_id INT NOT NULL,                 -- Référence à l'ID de la vidéo
    watched BOOLEAN DEFAULT FALSE,         -- Indique si l'utilisateur a regardé la vidéo
    recommended BOOLEAN DEFAULT FALSE,     -- Indique si l'utilisateur a recommandé la vidéo
    rating INT,                            -- Note donnée à la vidéo (par exemple, de 1 à 5)
    review TEXT,                           -- Critique ou commentaire de l'utilisateur sur la vidéo
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  -- Date de l'interaction
    FOREIGN KEY (user_id) REFERENCES users(id),  -- Clé étrangère vers la table des utilisateurs
    FOREIGN KEY (video_id) REFERENCES videos(id), -- Clé étrangère vers la table des vidéos
    UNIQUE KEY (user_id, video_id)         -- Garantit qu'un utilisateur ne peut interagir avec une vidéo qu'une seule fois
) ENGINE=InnoDB;

