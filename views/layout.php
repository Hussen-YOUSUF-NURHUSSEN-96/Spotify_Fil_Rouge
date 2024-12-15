<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8">

        <title> <?= $title ?? 'Project-Spotify' ?> </title>

        <link rel="stylesheet" href="assets/css/style.css">
    </head>

    <body>
        <header>
            <h1>Project-Spotify</h1>
            <nav>
                <a href="index.php?action=home"> Home </a>
                <a href="index.php?action=login"> Login </a>
                <a href="index.php?action=register"> Register </a>
            </nav>
        </header>

        <main>
            <?= $contenu ?>    <!-- Le contenu specifique à chaque page sera insere ici  -->
        </main>

        <footer>
            <p>&copy; 2024 Project-Spotify</p>
        </footer>
    </body>

</html>
