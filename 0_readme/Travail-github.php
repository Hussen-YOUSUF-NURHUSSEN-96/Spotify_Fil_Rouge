<?php

    /*


    Guide de Collaboration :


    1. Avant de commencer une nouvelle tâche :


            Téléchargez les dernières modifications ========>  git pull origin main



    2. Créer une nouvelle branche pour travailler


            Ne travaillez jamais directement sur la branche principale (main). 
            
            Créez une branche spécifique pour chaque tâche ou fonctionnalité.    =======>     git checkout -b  nom_de_la_fonctionnalite




    3. Envoyer votre branche sur GitHub   =======>   git push -u origin  nom_de_la_fonctionnalite




    4. Soumettre une Pull Request (PR) : 


        -   Rendez-vous sur le dépôt GitHub Spotify_Fil_Rouge

        -   Cliquez sur "Pull requests" dans le menu principal.

        -   Cliquez sur "New pull request".   

        -   Sélectionnez la branche sur laquelle vous avez travaillé   puis cliquez sur "Create pull request".

        -   Revoir : Une fois validée, votre Pull Request sera fusionnée dans main.





    // ######################################################################


    Pour exclure certains fichiers :


    Le fichier .gitignore est un fichier texte spécial dans lequel vous listez les fichiers et dossiers que Git doit ignorer.


    Utilisez la commande suivante pour créer le  fichier =====>   touch .gitignore


    Puis editer le fichier, par example : 

        # Ignorer les dossiers de dépendances
        /vendor/
        /node_modules/

        # Ignorer les fichiers d'environnement
        *.env


?>

