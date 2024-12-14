<?php $title = $title ?? 'Login'; ?>

<h1>Connexion</h1>

<form method="post" action="#">
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required>
    <button type="submit">Se connecter</button>
</form>
