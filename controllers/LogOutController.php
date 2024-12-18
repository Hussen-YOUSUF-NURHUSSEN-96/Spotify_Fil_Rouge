<?php   
class LogoutController {
    public function logout() {
        // Démarre la session si ce n'est pas déjà fait
        if (session_status() === PHP_SESSION_NONE) {
        session_start();
}


        // Supprime toutes les variables de session
        session_unset();
        
        // Détruit la session
        session_destroy();
        
        // Redirige l'utilisateur vers la page de connexion
        header("Location: index.php?action=login");
        exit;
    }
}
?>