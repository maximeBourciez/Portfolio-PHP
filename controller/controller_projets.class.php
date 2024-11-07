<?php

// Controller pour les projets
class ControllerProjets extends Controller{
    // Méthode pour afficher la liste des projets
    public function index(){
        // Import twig
        require_once("config/twig.php");

        // Création & chargement du template
        $template = $this->getTwig()->load('projets.html.twig');

        // Récupérer tous les projets
        $projetDAO = new ProjetDAO($this->getPdo());
        $projets = $projetDAO->getLastThree();

        // Affichage du rendu du template avec les variables
        echo $template->render([
            'title' => 'Projets',
            'description' => 'Liste des projets',
            'projets' => $projets
        ]);
    }

    // Méthode pour afficher un projet
    /*public function show(){
        // Import twig
        require_once("config/twig.php");

        // Création & chargement du template
        $template = $this->getTwig()->load('projet.html.twig');

        // Récupérer le projet
        $projetDAO = new ProjetDAO($this->getPdo());
        $projet = $projetDAO->getById($this->getGet()['id']);

        // Récupérer les items du projet
        $items = $projetDAO->getItems($this->getGet()['id']);

        // Affichage du rendu du template avec les variables
        echo $template->render([
            'title' => $projet->getTitre(),
            'description' => $projet->getDescription(),
            'projet' => $projet,
            'items' => $items
        ]);
    }*/
}