
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Spotifeux</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/home.css?v=1.0">
</head>
<body>
<header class="header">
    <?php  if (isset($_SESSION['user'])): ?>
        <a href="index.php?action=logout">Déconnexion</a>
    <?php endif; ?>
    <!-- Recherche -->
    <div class="search">
        <form method="GET" action="index.php" class="search-form">
            <input type="hidden" name="action" value="search">
            <input type="text" name="query" placeholder="Rechercher" value="<?= htmlspecialchars($searchTerm ?? '') ?>" class="search-input">
            <button type="submit" class="search-button"> <i class="fas fa-search"></i> </button>
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
                            <form method="POST" action="index.php?action=delete_playlist">
                            <input type="hidden" name="playlist_id" value="<?= $playlist['id'] ?>">
                            <button type="submit" class="delete-btn" title="Supprimer cette playlist">
                            <i class="fas fa-times"></i> <!-- Icône croix -->
                            </button>
                            </form>
                        </li>
                        
                        <?php endforeach; ?>
                     <?php else: ?>
                        <p>Aucune playlist</p>
                    <?php endif; ?>
                    
                </ul>
                    
            </div>
        <!-- pour créer une playlist-->
        <?php if (isset($erreur)): ?>
<div class="alert alert-danger">
<?= htmlspecialchars($erreur) ?>
</div>
<?php endif; ?>
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
    <?php 
$selectedPlaylist = $selectedPlaylist ?? null;
?>
    <div class="video-lecture">
  <!--Parti Majdoline-->
    <?php if ($selectedPlaylist): ?>
    <!--Détails de la playlist séléctionner-->
            <h2><?= htmlspecialchars($selectedPlaylist['name'])?></h2>
            <!--<p><?= htmlspecialchars($selectedPlaylist['description']) ?> </p>-->
            <ul>
                <?php foreach ($selectedPlaylist['videos'] as $video): ?>
                    <li>
                        <h3><?= htmlspecialchars($video['title']) ?></h3>
    
                        <iframe src="<?= htmlspecialchars($video['url']) ?>" width="560" height="315" frameborder="0" allowfullscreen></iframe>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
           
            <!-- First fix the undefined variable error by initializing $selectedPlaylist -->
            <?php 
$selectedPlaylist = $selectedPlaylist ?? null;
?>

<div class="zone1">
    <?php if ($selectedPlaylist): ?>
        <h2><?= htmlspecialchars(($selectedPlaylist['name'])) ?></h2>
        <p><?= htmlspecialchars(($selectedPlaylist['description'])) ?></p>
    <?php else: ?>
        <h2>Liste de titres par catégorie</h2>
        
        <?php if (isset($videosByCategory) && !empty($videosByCategory)): ?>
            <div class="videos-container">
                <button class="scroll-button left" id="scrollLeft">&lt;</button>
                
                <div class="videos-wrapper" id="videosWrapper">
                    <div class="videos-row">
                        <?php foreach ($videosByCategory as $category => $videos): ?>
                            <div class="category-section">
                                <h3 class="category-title"><?= htmlspecialchars($category) ?></h3>
                                <?php foreach ($videos as $video): ?>
                                    <div class="video-card">
                                        <h4><?= htmlspecialchars($video['title']) ?></h4>
                                        <p>Artiste : <?= htmlspecialchars($video['artist']) ?></p>
                                        <?php if (!empty($video['video_url'])): ?>
                                            <div class="video-wrapper">
                                                <iframe 
                                                    src="<?= htmlspecialchars(Video::convertToEmbedUrl($video['video_url'])) ?>" 
                                                    frameborder="0" 
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                    allowfullscreen>
                                                </iframe>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <button class="scroll-button right" id="scrollRight">&gt;</button>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>




<!--Fin liste video-->

        <!--Fin liste video-->
        <!-- Hussen-->
        

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

        
        
        document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('videosWrapper');
    const row = wrapper.querySelector('.videos-row');
    const leftButton = document.getElementById('scrollLeft');
    const rightButton = document.getElementById('scrollRight');
    
    let currentIndex = 0;
    const sections = document.querySelectorAll('.category-section');
    
    // Hide left button initially
    leftButton.style.display = 'none';
    
    function updateButtons() {
        leftButton.style.display = currentIndex > 0 ? 'block' : 'none';
        rightButton.style.display = currentIndex < sections.length - 1 ? 'block' : 'none';
    }
    
    function scrollToSection(direction) {
        if (direction === 'left' && currentIndex > 0) {
            currentIndex--;
        } else if (direction === 'right' && currentIndex < sections.length - 1) {
            currentIndex++;
        }
        
        const scrollAmount = wrapper.clientWidth * currentIndex;
        row.style.transform = `translateX(-${scrollAmount}px)`;
        updateButtons();
    }
    
    leftButton.addEventListener('click', () => scrollToSection('left'));
    rightButton.addEventListener('click', () => scrollToSection('right'));
    
    // Update buttons visibility on window resize
    window.addEventListener('resize', updateButtons);
    
    // Initial button state
    updateButtons();
});




   </script>
</body>
</html>


