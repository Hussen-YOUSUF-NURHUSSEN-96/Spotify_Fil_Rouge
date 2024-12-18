<!DOCTYPE html>

<html lang="fr">

    <head>
        <meta charset="UTF-8">

        <title> <?= $title ?? 'Project-Spotify' ?> </title>

        <link rel="stylesheet" href="assets/css/styles.css">

        <!-- Page de login -->
        <link rel="stylesheet" href="assets/css/login.css">
        <link rel="stylesheet" href="assets/css/home.css">
        <link rel="stylesheet" href="assets/css/register.css">
        <link rel="stylesheet" href="assets/css/layout.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>

    <body>
<!--    <header>
            <h1>Project-Spotify</h1>
            <nav>
                <a href="index.php?action=home"> Home </a>
                <a href="index.php?action=login"> Login </a>
                <a href="index.php?action=register"> Register </a>
            </nav>
        </header>-->

        <main>
            <?= $contenu ?>    <!-- Le contenu specifique à chaque page sera insere ici  -->
        </main>

       <!-- <footer>
            <p>&copy; 2024 Project-Spotify</p>
        </footer>-->
    </body>

</html>
