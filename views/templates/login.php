<?php $title = $title ?? 'Login'; ?>

<h1>Connexion</h1>


<!-- Afficher un message d'erreur si il existe -->

<?php if (!empty($errorMessage)): ?>

    <p style="color: red;"><?= htmlspecialchars($errorMessage) ?></p>

<?php endif; ?>


<!-- Formulaire de connexion -->
<form method="post" action="index.php?action=loginSubmit">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required>
    <button type="submit">Se connecter</button>
</form>
