<?php

// C
class ControllerDashboard extends Controller
{
    public function index()
    {
        require_once("config/twig.php");

        // Vériier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=dashboard&methode=login');
            return;
        }
        
        // Chargement des projets
        $projetDAO = new ProjetDAO($this->getPdo());
        $projets = $projetDAO->findAll();
        
        $template = $this->getTwig()->load('dashboard.html.twig');
        echo $template->render([
            'title' => 'Dashboard',
            'description' => 'Bienvenue sur le dashboard',
            'projets' => $projets,
            'user' => $_SESSION['user'] ?? null
        ]);
    }

    public function login()
    {
        require_once("config/twig.php");

        if (isset($_SESSION['user'])) {
            $this->index();
            return;
        }

        $template = $this->getTwig()->load('login.html.twig');
        echo $template->render([
            'title' => 'Connexion',
            'description' => 'Connectez-vous pour accéder au dashboard'
        ]);
    }

    // Méthode logout
    public function logout()
    {
        session_destroy();
        header('Location: index.php?action=login');
    }

    public function checkLogin()
    {
        $id = $_POST['identifiant'];
        $password = $_POST['password'];

        if ($id == 'admin' && $password == 'admin') {
            $_SESSION['user'] = 'admin';
            header('Location: index.php?controller=dashboard&methode=index');
        } else {
            header('Location: index.php?controller=dashboard&methode=login');
        }
    }
}
