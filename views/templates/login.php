<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/login.css?v=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- Afficher un message d'erreur si il existe -->

<?php if (!empty($errorMessage)): ?>

<p class="error-message"> <?= htmlspecialchars($errorMessage) ?> </p>

<?php endif; ?>



<div class="login-container">

<!-- Formulaire de connexion -->
<form method="post" action="index.php?action=loginSubmit" class="login-form" >
    
    <label for="username">Nom d'utilisateur :</label>
    <input type="text" id="username" name="username" required>
    
    <label for="password">Mot de passe :</label>
    <input type="password" id="password" name="password" required>
    
    <button type="submit" class="login-button"> Se connecter </button>
</form>

<a href="#" class="forgot-password">Mot de passe oublié ?</a>

<p class="register-text">
    Vous n'avez pas de compte ? <a href="index.php?action=register">S'inscrire à Spotify</a>
</p>
</div>
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
