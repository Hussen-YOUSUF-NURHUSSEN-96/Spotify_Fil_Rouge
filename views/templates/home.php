
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Spotifeux</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/home.css">
</head>
<body>
<header class="header">
    <?php  if (isset($_SESSION['user'])): ?>
        <a href="index.php?action=logout">Déconnexion</a>
    <?php endif; ?>
    <!-- Recherche -->
    <div class="search">
        <form method="GET" action="index.php">
            <input type="hidden" name="action" value="search">
            <input type="text" name="query" placeholder="Rechercher" value="<?= htmlspecialchars($searchTerm ?? '') ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>

        <?php
            // Vérifier s'il y a des resultats de recherche dans la session
            if (isset($_SESSION['search_results'])) 
            {
                $videos     = $_SESSION['search_results']['videos'];
                $searchTerm = $_SESSION['search_results']['searchTerm'];

                // Supprimer les résultats de la session après les avoir récupérés
                unset($_SESSION['search_results']);
            }
        ?>
        <!-- Pour tester -->
        <?php if (isset($videos)): ?>

            <div class="search-results-container">
                <span class="search-results">
                    <?= count($videos) ?> résultat(s) trouvé(s)      
                </span>

                <ul class="search-results-list">
                    <?php foreach ($videos as $video): ?>
                        <li class="search-result-item">
                            <h4><?= htmlspecialchars($video['title']) ?></h3>
                            <p>Artiste : <?= htmlspecialchars($video['artist']) ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
    <div class="icon">
        <a href="index.php?action=home"><i class="fas fa-home"></i></a>
    </div>
</header>
   <section>

<!--BIBLIOTHÈQUE-->
    <div class="library">
    <!--Playlist favoris par defaut-->
        <div class="logo">
            <img src="assets/css/etagere-a-livres.png" alt="">
            <button class="add-playlist" onclick="openPopup()">+</button>
        </div>
        <div class="favoris">
            <a href="#"><i class="fa-solid fa-heart"></i></a>
        </div>
            <div id="playlistContainer"class="cont-playlist">

                <ul>
                
                    <?php if (!empty($playlists)): ?>
                    <!--<?php print_r($playlists); ?>-->
                        <?php foreach ($playlists as $playlist): ?>
                         <li>
                            <a href="index.php?action=home&playlist_id=<?= htmlspecialchars($playlist['id'])?>">
                                <?= htmlspecialchars($playlist['name']) ?>
                            </a>
                        </li>
                        <?php endforeach; ?>
                     <?php else: ?>
                        <p>Aucune playlist</p>
                    <?php endif; ?>
                    
                </ul>
                    
            </div>
        <!-- pour créer une playlist-->
        <div id="popUp" class="popUp">
        <div class="popUp-content">
        <h3>Créer une playlist</h3>
        <form action="index.php?action=create" method="POST">
            <input type="text" name="name" id="playlistName" placeholder="Titre de la playlist" required>
            <button type="submit">Valider</button>
            <button type="button" onclick="closePopup()">Annuler</button>
        </form>
    </div>
 </div>

    </div>
    <div class="video-lecture">
  <!--Parti Majdoline-->
    <?php if ($selectedPlaylist): ?>
            <h2><?= htmlspecialchars(($selectedPlaylist['name'])) ?></h2>
            <p><?= htmlspecialchars(($selectedPlaylist['description'])) ?> </p>
            <ul>
                <?php foreach ($videos as $video): ?>
                    <li>
                        <h3><?= htmlspecialchars($video['title']) ?></h3>
                        <iframe src="<?= htmlspecialchars($video['url']) ?>" width="560" height="315" frameborder="0" allowfullscreen></iframe>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
        <!-- Liste video pour Masihulah-->

        <p>Liste de titre</p>

        <!--Fin liste video-->
        <!-- Hussen-->
        <?php elseif:?>

        <?php endif; ?>
    </div>
    <div class="suggestion">

    </div>
    <div class="artiste-en-cours">
        <div class="artiste">
            <img src="assets/css/babymetal-album.jpeg" alt="">
            <h2>Gimme Chocolate</h2>
            <p>Baby Metal</p>

        </div>
        
    </div>

    </div>

   </section>

   <script>
        function openPopup(){
            document.getElementById("popUp").style.display ="flex";
        }

        function closePopup(){
            document.getElementById("popUp").style.display ="none";
        }
   </script>
</body>
</html>


