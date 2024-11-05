<?php

// Controller pour la page d'accueil
class ControllerIndex extends Controller{
    // Méthode pour afficher la page d'accueil
    public function index(){
        // Import twig
        require_once("config/twig.php");

        // Création & chargement du template
        $template = $this->getTwig()->load('index.html.twig');

        // Récupérer les 3 projets les + récents
        $projetDAO = new ProjetDAO($this->getPdo());
        $projets = $projetDAO->getLastThree();

        // Affichage du rendu du template avec les variables
        echo $template->render([
            'title' => 'Accueil',
            'description' => 'Bienvenue sur le site de la formation PHP',
            'projets' => $projets
        ]);
    }
}