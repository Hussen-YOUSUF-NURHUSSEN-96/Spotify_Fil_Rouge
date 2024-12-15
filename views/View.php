<?php

    class View 
    {
    
        private $fichier;    // Chemin vers le fichier vue
        private $titre;      // Titre de la page 


        // Example :  Si l'action est "Accueil", le chemin sera Vue/Accueil.php 
        
        public function __construct($action) 
        {
        
            $this->fichier = "views/" . $action . ".php";
        }

        // ==================================
        

        // Genère et affiche la vue avec les donnees fournies     

        public function generer($donnees) 
        {

             // Generer le contenu specifique à la vue   

            $contenu = $this->genererFichier($this->fichier, $donnees);


            // Generer le gabarit global en integrant le contenu

            $vue = $this->genererFichier('views/layout.php', [
                                                                'titre'   => $this->titre,
                                                                'contenu' => $contenu
                                                            ]
                                        );

            // Afficher le resultat final
            echo $vue;
        }
        

        // ==================================


        // Genère un fichier vue et retourne son contenu

        private function genererFichier($fichier, $donnees) 
        {
            if (file_exists($fichier)) 
            {

                extract($donnees);       // transforme un tableau associatif en variables.
                                         // Ex : ['titre' => 'Mon Blog' ]  devient   $titre = 'Mon Blog'

                                        
                ob_start();              // demarre la capture du contenu

                require $fichier;        // Inclure le fichier  ( Le contenu capture est renvoye pour être integre au gabarit )

                return ob_get_clean();   // retourne le contenu capture et arrête la capture.
            } 
            else 
            {
                // Identifier le fichier manquant
                echo "Chemin du fichier recherché : " . $fichier;
                throw new Exception("Fichier '$fichier' introuvable");
            }
        }
    }
?>