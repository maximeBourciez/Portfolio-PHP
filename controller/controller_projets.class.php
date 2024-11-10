<?php

// Controller pour les projets
class ControllerProjets extends Controller
{
    // Méthode pour afficher la liste des projets
    public function index()
    {
        // Import twig
        require_once("config/twig.php");

        // Création & chargement du template
        $template = $this->getTwig()->load('projets.html.twig');

        // Récupérer les éventuels filtres
        $type = isset($this->getGet()['type']) ? $this->getGet()['type'] : '';
        $techno = isset($this->getGet()['techno']) ? $this->getGet()['techno'] : '';

        // Récupérer tous les projets
        $projetDAO = new ProjetDAO($this->getPdo());
        $projets = $projetDAO->findAll($type, $techno);

        // Récupérer toutes les technologies disponibles
        $technologieDAO = new TechnologieDAO($this->getPdo());
        $technologies = $technologieDAO->findAll();

        // Affichage du rendu du template avec les variables
        echo $template->render([
            'title' => 'Projets',
            'description' => 'Liste des projets',
            'projets' => $projets,
            'technologies' => $technologies
        ]);
    }

    // Méthode pour afficher un projet
    public function show()
    {
        // Import twig
        require_once("config/twig.php");

        // Création & chargement du template
        $template = $this->getTwig()->load('projet.html.twig');

        // Récupérer le projet
        $projetDAO = new ProjetDAO($this->getPdo());
        $projet = $projetDAO->getById($this->getGet()['id_projet']);

        // Récupérer les items du projet
        $items = $projetDAO->getItems($this->getGet()['id']);

        // Affichage du rendu du template avec les variables
        echo $template->render(context: [
            'title' => $projet->getTitre(),
            'description' => $projet->getDescription(),
            'projet' => $projet,
            'items' => $items
        ]);
    }

    // Méthode de mofiication d'un projet
    public function edit(){
        require_once("config/twig.php");

        // Récupérer l'id du projet
        $idProjet = $this->getGet()['id'];

        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?controller=dashboard&methode=login');
            return;
        }

        // Récupérer le projet
        $projetDAO = new ProjetDAO($this->getPdo());
        $projet = $projetDAO->getById($idProjet);

        // Récupérer les technologies
        $technologieDAO = new TechnologieDAO($this->getPdo());
        $technologies = $technologieDAO->findAll();

        // Récupérer les items
        $itemDAO = new ItemsProjetDAO($this->getPdo());
        $items = $itemDAO->findByProjetId($idProjet);

        $template = $this->getTwig()->load('edit.html.twig');
        echo $template->render([
            'title' => 'Edition du projet',
            'description' => 'Modifier un projet',
            'projet' => $projet,
            'technologies' => $technologies,
            'items' => $items
        ]);
    }

    // Méthode pour mettre à jour un projet
    public function update(){
        // Récupérer les données du formulaire
        $id = $this->getPost()['id'];
        $titre = $this->getPost()['titre'];
        $description = $this->getPost()['description'];
        $annee = $this->getPost()['annee'];
        $type = $this->getPost()['type'];
        $technologies = $this->getPost()['technologies'];

        // Récupérer les items
        $items = $this->getPost()['items'];

        // Récupérer l'image
        $image = $_FILES['image'];

        // Vérifier si l'image a été uploadée
        if ($image['size'] > 0) {
            // Récupérer l'extension de l'image
            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);

            // Vérifier si l'extension est autorisée
            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                header('Location: index.php?controller=projets&methode=edit&id=' . $id);
                return;
            }

            // Déplacer l'image
            move_uploaded_file($image['tmp_name'], 'assets/images/' . $image['name']);
            $imageCover = 'assets/images/' . $image['name'];
        } else {
            $imageCover = '';
        }

        // Créer le projet
        $projet = new Projet($id, $titre, $description, $imageCover, $annee, $type, $technologies);

        // Mettre à jour le projet
        $projetDAO = new ProjetDAO($this->getPdo());
        $projetDAO->update($projet);

        // Mettre à jour les items
        $itemDAO = new ItemsProjetDAO($this->getPdo());
        $itemDAO->update($items);

        // Rediriger vers la liste des projets
        header('Location: index.php?controller=projets&methode=index');
    }
}
