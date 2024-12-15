<?php $title = $title ?? 'Erreur'; ?>

<h1>Une erreur est survenue</h1>

<p><?= htmlspecialchars($errorMessage) ?></p>


<p>
    <a href="index.php?action=home">Retour à l'accueil</a> ou <a href="index.php?action=login"> Connexion </a>
</p>

