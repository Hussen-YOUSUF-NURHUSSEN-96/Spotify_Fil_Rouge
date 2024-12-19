<?php $title = $title ?? 'Login'; ?>


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