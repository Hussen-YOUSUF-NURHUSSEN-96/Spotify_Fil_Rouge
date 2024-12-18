<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Spotifeux</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
</head>
<body>
<header class="header">
    <?php  if (isset($_SESSION['user_id'])): ?>
        <a href="index.php?action=logout">Déconnexion</a>
    <?php endif; ?>
    <div class="search">
        <input type="text" placeholder=" Rechercher">
        <button type="submit"><i class="fas fa-search"></i></button>
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
            
        </div>
        <button class="add-playlist" onclick="openPopup()">+</button>
        <div class="favoris">
            <a href="#"><i class="fa-solid fa-heart"></i></a>
        </div>
            <div id="playlistContainer"class="cont-playlist">
                <?php if (isset($playlists) && is_array($playlists)): ?>
            <?php foreach ($playlists as $playlist): ?>
                <div class="playlist">
                    <p><?= htmlspecialchars($playlist['name']) ?></p>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                 <p>Aucune playlist</p>
                <?php endif; ?>
                    
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
            <!--<div class="video-lecture">
    </div>-->
    <div class="suggestion">

    </div>
    <div class="artiste-en-cours">
        
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


