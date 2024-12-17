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

        // Vérifier si les identifiants sont corrects
        $sql = "SELECT * FROM users WHERE login = :id AND pwd = :password";
        $stmt = $this->getPdo()->prepare($sql);
        $stmt->execute(['id' => $id, 'password' => $password]);
        $user = $stmt->fetch();

        // Si les identifiants sont corrects, rediriger vers le dashboard
        if ($user) {
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


    /**
     * @brief Méthode de création d'une nouvelle techno en BD
     * 
     * @details Récupère les valeurs du formulaire pour les insérer comme un nouveau projet en BD.
     * 
     * @return void
     */
    public function createTechno(){
        // Récupérer les données du formulaire
        $nomTechno = $this->getPost()["nomTechno"];
        $niveauMaitrise = $_POST["maitriseTechno"];
        $imageCover = $_FILES['logoTechno'] ?? null;

    // Vérifier si l'image a été uploadée avec succès
    if ($imageCover && $imageCover['error'] === UPLOAD_ERR_OK) {
        // Générer un nom de fichier unique
        $extension = pathinfo($imageCover['name'], PATHINFO_EXTENSION);
        $nomFichier = $nomTechno . '.' . $extension;
        $destination = 'assets/logos/' . $nomFichier;

        // Déplacer l'image
        if (move_uploaded_file($imageCover['tmp_name'], $destination)) {
            $imageCover = $destination;
        } else {
            $imageCover = '';
        }
    } else {
        $imageCover = '';
    }

        // Créer une technologie avec un id bidon (il ets automatique en BD)
        $technoAInserer = new Technologie(0, $nomTechno, $imageCover, $niveauMaitrise);
        $managerTechno = new TechnologieDAO($this->getPdo());
        $managerTechno->insert($technoAInserer);

        // Afficher le dashboard
        $this->index();
    }
    
}
