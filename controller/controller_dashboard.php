<?php 

// Controlleur pour le dashboard
class ControllerDashboard extends Controller
{
    // Méthode pour afficher le dashboard
    public function index()
    {
        // Import twig
        require_once("config/twig.php");

        // Création & chargement du template
        $template = $this->getTwig()->load('dashboard.html.twig');

        // Récupérer les 3 projets les + récents
        $projetDAO = new ProjetDAO($this->getPdo());
        $projets = $projetDAO->findAll();

        // Affichage du rendu du template avec les variables
        echo $template->render([
            'title' => 'Dashboard',
            'description' => 'Bienvenue sur le dashboard',
            'projets' => $projets
        ]);
    }
}