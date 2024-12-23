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
    <div class="burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <!-- Recherche -->
        <div class="search">
            <form method="GET" action="index.php" class="search-form">
                <input type="hidden" name="action" value="search">
                <input type="text" name="query" placeholder="Rechercher"
                    value="<?= htmlspecialchars($searchTerm ?? '') ?>" class="search-input">
                <button type="submit" class="search-button"> <i class="fas fa-search"></i> </button>
            </form>

            <?php

                // Initialisation stricte des variables
                $videos_search  = $videos_search ?? [];
                $searchTerm     = $searchTerm ?? '';

                // Vérifier s'il y a des resultats de recherche dans la session
                if (isset($_SESSION['search_results'])) 
                {
                    $videos_search  = $_SESSION['search_results']['videos_search'];
                    $searchTerm     = $_SESSION['search_results']['searchTerm'];

                    // Supprimer les résultats de la session après les avoir récupérés
                    unset($_SESSION['search_results']);
                }

            ?>

            <?php 
                // Vérifie si la variable $videos n'est pas définie ou est vide
                if ( empty($videos_search) || empty(trim($searchTerm))): ?>
                    <style>
                        
                        .zoneMasi {
                            display: block;    /* Affiche la section .zone1 */
                        }
                        .zoneHussen {
                            display: none;  
                        }
                    </style>
            <?php else: ?>
                    <style>
                        /* Si $videos est définie et contient une valeur, on cache la zone1 */
                        .zoneMasi {
                            display: none;  
                        }
                        .zoneHussen {
                            display: block;  
                        }
                    </style>
            <?php endif; ?>

            <!-- Pour tester -->
            <?php if (isset($videos_search)): ?>

                <div class="search-results-container">
                    <span class="search-results">
                        <?= count($videos_search) ?> résultat(s) trouvé(s) pour "<?= htmlspecialchars($searchTerm) ?>"
                    </span>

                    <ul class="search-results-list">
                        <?php foreach ($videos_search as $video_get): ?>
                            <li class="search-result-item">
                                <h4><?= htmlspecialchars($video_get['title']) ?></h3>
                                    <p>Artiste : <?= htmlspecialchars($video_get['artist']) ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
        <div class="icon">
            <a href="index.php?action=home"><i class="fas fa-home"></i></a>
            <?php if (isset($_SESSION['user'])): ?>
                <a href="index.php?action=logout"><i class="fa-solid fa-right-from-bracket"></i></a>
            <?php endif; ?>
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
                    <div id="playlistContainer" class="cont-playlist">

                        <ul>
                            <?php if (!empty($playlists)): ?>
                                <!--<?php print_r($playlists); ?>-->
                                <?php foreach ($playlists as $playlist): ?>
                                    <li>
                                        <a href="index.php?action=home&playlist_id=<?= htmlspecialchars($playlist['id']) ?>">
                                            <?= htmlspecialchars($playlist['name']) ?>
                                        </a>
                                        <form method="POST" action="index.php?action=delete_playlist">
                                            <input type="hidden" name="playlist_id" value="<?= $playlist['id'] ?>">
                                            <button type="submit" class="delete-btn" title="Supprimer cette playlist">
                                                <i class="fa-solid fa-xmark"></i> <!-- Icône croix -->
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
                    <div id="popUp" class="popUp <?= isset($erreur) ? 'open' : '' ?>">
                        <div class="popUp-content">
                            <h3>Créer une playlist</h3>
                            <form action="index.php?action=create" method="POST">
                                <input type="text" name="name" id="playlistName" placeholder="Titre de la playlist"
                                    required>
                                <button type="submit">Valider</button>
                                <button style="background-color:red;" type="button"
                                    onclick="closePopup()">Annuler</button>
                            </form>
                            <?php if (isset($erreur)): ?>
                                <div class="error-message">
                                    <?= htmlspecialchars($erreur) ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <!--Parti du centre-->
                <div class="video-lecture">
                    <?php if (isset($_GET['message'])): ?>
                        <div class="message">
                            <?php if ($_GET['message'] === 'video_added'): ?>
                                <p class="success">Vidéo ajoutée à la playlist avec succès !</p>
                            <?php elseif ($_GET['message'] === 'error'): ?>
                                <p class="error">Erreur lors de l'ajout de la vidéo à la playlist.</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!--Parti Majdoline-->
                    <?php if (isset($selectedPlaylist) && $selectedPlaylist !== null): ?>
                        <!--Détails de la playlist séléctionner-->
                        <h2><?= htmlspecialchars($selectedPlaylist['name']) ?></h2>
                        <!--<p><?= htmlspecialchars($selectedPlaylist['description']) ?> </p>-->
                        <ul>
                            <?php foreach ($selectedPlaylist['videos'] as $video): ?>
                                <li>
                                    <h3><?= htmlspecialchars($video['title']) ?></h3>
                                    <iframe src="<?= htmlspecialchars(Video::convertToEmbedUrl($video['video_url'])) ?>"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                    </iframe>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>

                    <div class="zoneMasi">
                        <?php if (isset($videosByCategory) && !empty($videosByCategory)): ?>
                            <h2>Liste de titres par catégorie</h2>
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
                                                        <!-- Formulaire pour ajouter une vidéo à une playlist -->
                                                        <form action="index.php?action=addVideoToPlaylist" method="POST">
                                                            <input type="hidden" name="video_id" value="<?= $video['id'] ?>">
                                                            <select name="playlist_id" required>
                                                                <option value="">Choisir une playlist</option>
                                                                <?php foreach ($playlists as $playlist): ?>
                                                                    <option value="<?= $playlist['id'] ?>">
                                                                        <?= htmlspecialchars($playlist['name']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <button type="submit" class="add-button">Ajouter à la playlist</button>
                                                        </form>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <button class="scroll-button right" id="scrollRight">&gt;</button>
                            </div>
                        <?php else: ?>
                            <p>Aucune playlist ou vidéo de disponible</p>
                        <?php endif; ?>
                    </div>



                        <!--Fin liste video-->
                        <!-- Hussen-->

                        <!-- Section des résultats de recherche -->
                        <div id="zoneHussen">
                            <?php if (count($videos_search) > 0): ?>

                                <h2>Résultats de recherche pour "<?= htmlspecialchars($searchTerm) ?>" </h2>


                                <div class="videos-container">
                                    <button class="scroll-button left" id="scrollLeft">&lt;</button>

                                    <div class="videos-wrapper" id="videosWrapper">
                                        <div class="videos-row">
                                            <?php foreach ($videos_search as $video_get): ?>
                                                <div class="video-card">
                                                    <h4><?= htmlspecialchars($video_get['title']) ?></h4>
                                                    <p>Artiste : <?= htmlspecialchars($video_get['artist']) ?></p>
                                                    <?php if (!empty($video_get['video_url'])): ?>
                                                        <div class="video-wrapper">
                                                            <iframe
                                                                src="<?= htmlspecialchars(Video::convertToEmbedUrl($video_get['video_url'])) ?>"
                                                                frameborder="0"
                                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                                allowfullscreen>
                                                            </iframe>
                                                        </div>
                                                    <?php endif; ?>


                                                    <!-- Formulaire pour ajouter une vidéo à une playlist -->
                                                    <form action="index.php?action=addVideoToPlaylist" method="POST">
                                                        <input type="hidden" name="video_id" value="<?= htmlspecialchars($video_get['id']) ?>">
                                                        <select name="playlist_id" required>
                                                            <option value="">Choisir une playlist</option>
                                                            <?php foreach ($playlists as $playlist): ?>
                                                                <option value="<?= htmlspecialchars($playlist['id']) ?>">
                                                                    <?= htmlspecialchars($playlist['name']) ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <button type="submit" class="add-button">Ajouter à la playlist</button>
                                                    </form>
                
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                    <button class="scroll-button right" id="scrollRight">&gt;</button>
                                </div>
                            <?php endif; ?>
                        </div>



                    <?php endif; ?>
                </div>






        </div>

    </section>
    <!---Fond
    <div class="background">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>-->

    <script>
        function openPopup() {
            document.getElementById("popUp").style.display = "flex";
        }

        function closePopup() {
            document.getElementById("popUp").style.display = "none";
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Vérifier si la popup doit rester ouverte
            const popUp = document.getElementById("popUp");
            if (popUp.classList.contains('open')) {
                popUp.style.display = "flex";
            }
        });
        // Sélection des éléments
        const burger = document.querySelector('.burger');
        const nav = document.querySelector('.icon');

        // Ajout de l'événement pour ouvrir/fermer le menu
        burger.addEventListener('click', () => {
            nav.classList.toggle('active');

            // Animation des lignes du burger
            burger.classList.toggle('toggle');
        });




        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.getElementById('videosWrapper');
            // const row = wrapper.querySelector('.videos-row');
            const leftButton = document.getElementById('scrollLeft');
            const rightButton = document.getElementById('scrollRight');

            let currentIndex = 0;
            const sections = document.querySelectorAll('.category-section');

            // Hide left button initially
            //leftButton.style.display = 'none';

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