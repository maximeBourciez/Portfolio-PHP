<?php

// Import twig
require_once("config/twig.php");

// Création & chargement du template
$template = $twig->load('index.html.twig');

// Affichage du rendu du template avec les variables
echo $template->render([
    'title' => 'Accueil',
    'description' => 'Bienvenue sur le site de la formation PHP',
    'content' => 'Ceci est le contenu de la page d\'accueil'
]);
