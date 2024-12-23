<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Spotifeux</title>
    <link rel="stylesheet" href="assets/css/register.css?v=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
    <body>
    
        <div class="login-container">

            <h1>Inscrivez-vous pour commencer à écouter.</h1>
<!--Message d'erreur si erreur-->
       <?php if(!empty($errorMessage)): ?>
       <div class="error-message">
       <?= htmlspecialchars($errorMessage); ?>
        </div>
        <?php endif; ?>
<!--Formulaire-->

            <form class="login-form"action="" method="POST">
                 <label for="username">Nom d'utilisateur</label>
                 <input type="text" name="username" placeholder=" username" required>
                
                 <label for="email">Entrez votre email</label>

                 <input type="text" name="email" placeholder=" nom@domaine.com" required>
                
                 <label for="password">Entrez un mot de passe</label>
                 <input type="text" name="password" placeholder=" Password" required>
                 <button class="login-button" type="submit">S'inscrire</button>
                <p class="register-text">Vous possédez déjà un compte chez nous ? <a href="index.php?action=login">Connectez-vous.</a></p>
            </form>
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