<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Feuille de style principale -->
    <link rel="stylesheet" href="assets/css/home.css?v=1.0">
</head>


<body>

    <!-- ===================== HEADER ===================== -->
    <header class="header">
        <div class="burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>

        <!-- ===== BARRE DE RECHERCHE ===== -->
        <div class="search">

            <form method="GET" action="index.php" class="search-form">

                <input type="hidden" name="action" value="search">

                <input type="text" name="query" placeholder="Rechercher"
                    value="<?= htmlspecialchars($searchTerm ?? '') ?>" class="search-input">


                <!-- Filtre par catégorie -->
                <select name="category_id" class="search-category">

                    <option value="">Choisir une catégorie</option>

                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= isset($category_id) && $category_id == $category['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>

                <!-- Bouton de recherche -->
                <button type="submit" class="search-button">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <?php
            // Vérifier s'il y a des resultats de recherche dans la session
            if (isset($_SESSION['search_results'])) {
                $videos_search = $_SESSION['search_results']['videos_search'];
                $searchTerm = $_SESSION['search_results']['searchTerm'];

                // Supprimer les résultats de la session après les avoir récupérés
                unset($_SESSION['search_results']);
            }
            ?>

            <style>
                /* Si $videos_search n'est pas défini, on affiche .zoneMasi et cache .zoneHussen */
                .zoneMasi {
                    display:
                        <?php echo isset($videos_search) ? 'none' : 'block'; ?>
                    ;
                }

                /* Si $videos_search est défini, on cache .zoneMasi et affiche .zoneHussen */
                .zoneHussen {
                    display:
                        <?php echo isset($videos_search) ? 'block' : 'none'; ?>
                    ;
                }
            </style>

        </div>


        <!-- ===== ICÔNES DE NAVIGATION ===== -->
        <div class="icon">

            <a href="index.php?action=home">
                <i class="fas fa-home"></i>
            </a>

            <?php if (isset($_SESSION['user'])): ?>
                <a href="index.php?action=logout"><i class="fa-solid fa-right-from-bracket"></i></a>
            <?php endif; ?>
        </div>
    </header>



    <!-- ===================== SECTION PRINCIPALE ===================== -->

    <section>


        <!--BIBLIOTHÈQUE-->
        <div class="library">
            <!--Playlist favoris par defaut-->
            <div class="logo">
                <img src="assets/css/etagere-a-livres.png" alt="">
                <button class="add-playlist" onclick="openPopup()">+</button>
            </div>

            <!-- Conteneur des playlists -->
            <div id="playlistContainer" class="cont-playlist">
                <ul>
                    <?php if (!empty($playlists)): ?>
                        <!--<?php print_r($playlists); ?>-->
                        <?php foreach ($playlists as $playlist): ?>
                            <li>
                                <a href="index.php?action=home&playlist_id=<?= htmlspecialchars($playlist['id']) ?>">
                                    <?= htmlspecialchars($playlist['name']) ?>
                                </a>
                                <form method="POST" action="index.php?action=delete_playlist" class="delete-form"
                                    id="delete-form-<?php echo $playlist['id']; ?>">
                                    <input type="hidden" name="playlist_id" value="<?= $playlist['id'] ?>">
                                    <button type="submit" class="delete-btn" title="Supprimer cette playlist"
                                        onclick="confirmDelete(<?php echo $playlist['id']; ?>)">
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
            <!-- Popup pour créer une nouvelle playlist -->
            <div id="popUp" class="popUp <?= isset($erreur) ? 'open' : '' ?>">
                <div class="popUp-content">
                    <h3>Créer une playlist</h3>
                    <form action="index.php?action=create" method="POST">
                        <input type="text" name="name" id="playlistName" placeholder="Titre de la playlist" required>
                        <button type="submit">Valider</button>
                        <button style="background-color:red;" type="button" onclick="closePopup()">Annuler</button>
                    </form>
                    <?php if (isset($erreur)): ?>
                        <div class="error-message">
                            <?= htmlspecialchars($erreur) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        <!-- ===== PARTIE CENTRALE : VIDÉOS ===== -->

        <div class="video-lecture">
            <?php
            // Vérification des messages de succès ou d'erreur dans l'URL
            if (isset($_GET['success'])) {
                if ($_GET['success'] === 'playlist_deleted') {
                    echo '<p class="success-message">La playlist a été supprimée avec succès.</p>';
                }
            }

            if (isset($_GET['error'])) {
                if ($_GET['error'] === 'not_authorized') {
                    echo '<p class="error-message">Vous n\'êtes pas autorisé à supprimer cette playlist.</p>';
                } elseif ($_GET['error'] === 'error_deleting_playlist') {
                    echo '<p class="error-message">Erreur lors de la suppression de la playlist.</p>';
                } else {
                    // Afficher un message d'erreur générique si aucune condition ne correspond
                    echo '<p class="error-message">Une erreur s\'est produite.</p>';
                }
            }
            ?>
            <?php if (isset($_GET['message'])): ?>
                <div class="message">
                    <?php if ($_GET['message'] === 'video_added'): ?>
                        <p class="success">Vidéo ajoutée à la playlist avec succès !</p>
                    <?php elseif ($_GET['message'] === 'error'): ?>
                        <p class="error">Votre playlist contient déjà cette vidéo.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>


            <!--Parti Majdoline :  afficher les détails d'une playlist et de ses vidéos-->
            <?php if (isset($selectedPlaylist) && $selectedPlaylist !== null): ?>
                <!--Détails de la playlist séléctionner-->
                <h2><?= htmlspecialchars($selectedPlaylist['name']) ?></h2>
                <!--<p><?= htmlspecialchars($selectedPlaylist['description']) ?> </p>-->
                <ul>
                    <?php foreach ($selectedPlaylist['videos'] as $video): ?>
                        <li>
                            <h3><?= htmlspecialchars($video['title']) ?></h3>
                            <iframe src="<?= htmlspecialchars(Video::convertToEmbedUrl($video['video_url'])) ?>" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!--Parti Masiullah  :  afficher des vidéos par catégorie -->
            <?php else: ?>
                <div class="zoneMasi">
                    <?php if (isset($videosByCategory) && !empty($videosByCategory)): ?>
                        <div class="videos-container">
                            <div class="videos-wrapper" id="videosWrapper">
                                <?php foreach ($videosByCategory as $category => $videos): ?>
                                    <div class="category-section">
                                        <h3 class="category-title"><?= htmlspecialchars($category) ?></h3>
                                        <div class="videos-row-wrapper">
                                            <div class="videos-row">
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
                                                        <form action="index.php?action=addVideoToPlaylist" method="POST">
                                                            <input type="hidden" name="video_id" value="<?= $video['id'] ?>">
                                                            <select name="playlist_id" required>
                                                                <option value="">Playlist</option>
                                                                <?php foreach ($playlists as $playlist): ?>
                                                                    <option value="<?= $playlist['id'] ?>">
                                                                        <?= htmlspecialchars($playlist['name']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                            <button type="submit" class="add-button">+</button>
                                                        </form>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                    </div>
                <?php else: ?>

                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Parti Hussen  :  RÉSULTATS RECHERCHE  -->
        <div id="zoneHussen">
            <?php if (isset($videos_search) && is_array($videos_search) && count($videos_search) > 0): ?>
                <h2 class="hussen-search-title"> Résultats de recherche pour "<?= htmlspecialchars($searchTerm) ?>" </h2>
                <div class="hussen-videos-container">
                    <?php foreach ($videos_search as $video_get): ?>

                        <div class="hussen-video-card">
                            <h4><?= htmlspecialchars($video_get['title']) ?></h4>
                            <p>Artiste : <?= htmlspecialchars($video_get['artist']) ?></p>
                            <?php if (!empty($video_get['video_url'])): ?>
                                <div class="hussen-video-wrapper">
                                    <iframe src="<?= htmlspecialchars(Video::convertToEmbedUrl($video_get['video_url'])) ?>"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen loading="lazy">
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
                                <button type="submit" class="hussen-add-button">Ajouter à la playlist</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php elseif (isset($videos_search) && count($videos_search) == 0): ?>
                <p>Aucun résultat trouvé.</p>
            <?php endif; ?>

            <!-- FIn zoneHussen -->
        </div>
        <!-- ===== FIN DE PARTIE CENTRALE :  <div class="video-lecture">  -->
        </div>
    </section>
    <!-- ===================== SCRIPTS ===================== -->
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

        // Fonction de confirmation avant suppression
        function confirmDelete(playlistId) {
            // Afficher un pop-up de confirmation
            var result = confirm("Êtes-vous sûr de vouloir supprimer cette playlist ?");

            // Si l'utilisateur clique sur "OK" (confirm), soumettre le formulaire
            if (result) {
                // Soumettre le formulaire correspondant à la playlist
                document.getElementById('delete-form-' + playlistId).submit();
            } else {
                event.preventDefault();
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Fonctionnalité de défilement pour les vidéos par catégorie
            const wrapper = document.getElementById('videosWrapper');
            const leftButton = document.getElementById('scrollLeft');
            const rightButton = document.getElementById('scrollRight');
            if (wrapper && leftButton && rightButton) {
                const row = wrapper.querySelector('.videos-row');
                const sections = wrapper.querySelectorAll('.category-section');
                let currentIndex = 0;
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
                    if (row) {
                        const scrollAmount = wrapper.clientWidth * currentIndex;
                        row.style.transform = `translateX(-${scrollAmount}px)`;
                        updateButtons();
                    }
                }
                leftButton.addEventListener('click', () => scrollToSection('left'));
                rightButton.addEventListener('click', () => scrollToSection('right'));
                window.addEventListener('resize', updateButtons);
                updateButtons();
            }
            // Fonctionnalité de défilement pour les résultats de recherche
            setupScroll('videosWrapperSearch', 'scrollLeftSearch', 'scrollRightSearch');
            // Fonction pour configurer le défilement
            function setupScroll(wrapperId, leftButtonId, rightButtonId) {
                const wrapper = document.getElementById(wrapperId);
                const leftButton = document.getElementById(leftButtonId);
                const rightButton = document.getElementById(rightButtonId);
                if (wrapper && leftButton && rightButton) {
                    const row = wrapper.querySelector('.videos-row');
                    const sections = wrapper.querySelectorAll('.category-section, .video-card');
                    let currentIndex = 0;
                    function updateButtons() {
                        leftButton.style.display = currentIndex > 0 ? 'block' : 'none';
                        rightButton.style.display = currentIndex < sections.length - 1 ? 'block' : 'none'
                    }
                    function scrollToSection(direction) {
                        if (direction === 'left' && currentIndex > 0) {
                            currentIndex--;
                        } else if (direction === 'right' && currentIndex < sections.length - 1) {
                            currentIndex++;
                        }
                        if (row) {
                            const scrollAmount = wrapper.clientWidth * currentIndex;
                            row.style.transform = `translateX(-${scrollAmount}px)`;
                            updateButtons();
                        }
                    }
                    leftButton.addEventListener('click', () => scrollToSection('left'));
                    rightButton.addEventListener('click', () => scrollToSection('right'));
                    window.addEventListener('resize', updateButtons);
                    updateButtons();
                }
            }
        });

    </script>
</body>

</html>