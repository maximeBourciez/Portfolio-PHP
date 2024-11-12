<?php

/**
 * 
 * @brief Classe ControllerDashboard - Controller pour le dashboard
 * 
 * @details Classe qui contient les méthodes pour afficher le dashboard. Contient aussi les méthodes pour la connexion et la déconnexion de l'utilisateur,
 *         et pour la création/modification/suppression d'un projet.
 * 
 * @date 12 Novembre 2024      
 * 
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 *  */
class ControllerDashboard extends Controller
{
    /**
     * @brief Méthode pour afficher le dashboard
     * 
     * @details Méthode qui récupère la liste de tous les projets et les technologies dans la BD et les passe au template de rendu.
     * 
     * @return void
     */
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

    /**
     * @brief Méthode pour afficher le formulaire de connexion si l'utilisateur n'est pas connecté
     * 
     * @return void
     */
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

    /**
     * @brief Méthode pour déconnecter l'utilisateur
     * 
     * @return void
     */
    public function logout()
    {
        session_destroy();
        header('Location: index.php?action=login');
    }

    /**
     * @brief Méthode pour vérifier les identifiants de connexion
     * 
     * @details Méthode qui vérifie si les identifiants de connexion sont corrects, et redirige l'utilisateur vers le dashboard si c'est le cas.
     * 
     * @return void
     */
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

    /**
     * @brief Méthode pour afficher le formulaire de création d'un projet
     * 
     * @details Méthode qui récupère les technologies dans la BD et les passe au template de rendu pour que l'utilisateur ait un large choix.
     * 
     * @return void
     */
    public function create(){
        require_once("config/twig.php");

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=dashboard&methode=login');
            return;
        }

        // Récupérer les technologies
        $technologieDAO = new TechnologieDAO($this->getPdo());
        $technologies = $technologieDAO->findAll();

        $template = $this->getTwig()->load('create.html.twig');
        echo $template->render([
            'title' => 'Créer un projet',
            'description' => 'Créer un nouveau projet',
            'technologies' => $technologies,
            'user' => $_SESSION['user'] ?? null
        ]);
    }
    
}
