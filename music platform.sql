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

INSERT INTO categories (name) VALUES 
    ('City Pop'), 
    ('Funk'), 
    ('Rock'), 
    ('Anime'), 
    ('Classique'), 
    ('Hip-Hop');



INSERT INTO videos (title, artist, category_id, video_url, thumbnail_url, duration) VALUES
    -- City Pop
    ('Plastic Love', 'Mariya Takeuchi', (SELECT id FROM categories WHERE name = 'City Pop'), 'https://www.youtube.com/watch?v=T_lC2O1oIew', 'https://img.youtube.com/vi/3bNITQR4Uso/hqdefault.jpg', 512),
    ('Stay With Me', 'Miki Matsubara', (SELECT id FROM categories WHERE name = 'City Pop'), 'https://www.youtube.com/watch?v=QNYT9wVwQ8A', 'https://img.youtube.com/vi/2bALDEeFOh8/hqdefault.jpg', 438),
    
    -- Funk
    ('Uptown Funk', 'Mark Ronson ft. Bruno Mars', (SELECT id FROM categories WHERE name = 'Funk'), 'https://www.youtube.com/watch?v=OPf0YbXqDm0', 'https://img.youtube.com/vi/OPf0YbXqDm0/hqdefault.jpg', 430),
    ('Super Freak', 'Rick James', (SELECT id FROM categories WHERE name = 'Funk'), 'https://www.youtube.com/watch?v=QYHxGBH6o4M', 'https://img.youtube.com/vi/QYHxGBH6o4M/hqdefault.jpg', 323),
    
    -- Rock
    ('Bohemian Rhapsody', 'Queen', (SELECT id FROM categories WHERE name = 'Rock'), 'https://www.youtube.com/watch?v=fJ9rUzIMcZQ', 'https://img.youtube.com/vi/fJ9rUzIMcZQ/hqdefault.jpg', 555),
    ('Hotel California', 'Eagles', (SELECT id FROM categories WHERE name = 'Rock'), 'https://www.youtube.com/watch?v=EqPtz5qN7HM', 'https://img.youtube.com/vi/EqPtz5qN7HM/hqdefault.jpg', 631),
    
    -- Anime
    ('A Cruel Angel Thesis', 'Yoko Takahashi', (SELECT id FROM categories WHERE name = 'Anime'), 'https://www.youtube.com/watch?v=o6wtDPVkKqI', 'https://img.youtube.com/vi/IWJUPY-2EIM/hqdefault.jpg', 406),
    ('Gurenge', 'LiSA', (SELECT id FROM categories WHERE name = 'Anime'), 'https://www.youtube.com/watch?v=CwkzK-F0Y00', 'https://img.youtube.com/vi/CwkzK-F0Y00/hqdefault.jpg', 356),
    ('Angel Night', 'PSY.S', (SELECT id FROM categories WHERE name = 'Anime'), 'https://www.youtube.com/watch?v=2HYtSRpupig', 'https://img.youtube.com/vi/3bNITQR4Uso/hqdefault.jpg', 427),
    -- Classique
    ('Nocturne Op.9 No.2', 'Frédéric Chopin', (SELECT id FROM categories WHERE name = 'Classique'), 'https://www.youtube.com/watch?v=9E6b3swbnWg', 'https://img.youtube.com/vi/9E6b3swbnWg/hqdefault.jpg', 428),
    ('Clair de Lune', 'Claude Debussy', (SELECT id FROM categories WHERE name = 'Classique'), 'https://www.youtube.com/watch?v=CvFH_6DNRCY', 'https://img.youtube.com/vi/CvFH_6DNRCY/hqdefault.jpg', 523),
    
    -- Hip-Hop
    ('Lose Yourself', 'Eminem', (SELECT id FROM categories WHERE name = 'Hip-Hop'), 'https://www.youtube.com/watch?v=_Yhyp-_hX2s', 'https://img.youtube.com/vi/_Yhyp-_hX2s/hqdefault.jpg', 526),
    ('SICKO MODE', 'Travis Scott', (SELECT id FROM categories WHERE name = 'Hip-Hop'), 'https://www.youtube.com/watch?v=6ONRf7h3Mdk', 'https://img.youtube.com/vi/6ONRf7h3Mdk/hqdefault.jpg', 512);


