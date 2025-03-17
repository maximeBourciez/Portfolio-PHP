<?php

/**
 * 
 * @brief Controller des projets - Gère les projets
 * 
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 * 
 * @date 12 Novembre 2024
 */
class ControllerProjets extends Controller
{
    /**
     * 
     * @brief Méthode pour afficher la liste des projets
     * 
     * @details Méthode qui récupère la liste de tous les projets et les technologies dans la BD. 
     *          La liste des projets sert pour l'affichage, et la liste des technologies pour les filtres. 
     * 
     * @return void
     */
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
            'technologies' => $technologies,
            'user' => $_SESSION['user'] ?? null
        ]);
    }

    /**
     * @brief Méthode pour afficher un projet en particulier
     * 
     * @details Méthode qui récupère un Projet en particulier et ses items associés, puis rend le template avec les infos nécessaires.
     * 
     * @return void
     */
    public function show(?string $messageErreur = null)
    {
        // Récupérer les données 
        $idProjet = $this->getGet()['id_projet'];

        // Création & chargement du template
        $template = $this->getTwig()->load('projet.html.twig');

        // Récupérer le projet
        $projetDAO = new ProjetDAO($this->getPdo());
        $projet = $projetDAO->getById($idProjet);

        // Récupérer les items du projet
        $itemDAO = new ItemsProjetDAO($this->getPdo());
        $items = $itemDAO->findByProjetId($idProjet);

        // Affichage du rendu du template avec les variables
        echo $template->render([
            'projet' => $projet,
            'items' => $items,
            'user' => $_SESSION['user'] ?? null,
            'messageErreur' => $messageErreur
        ]);
    }

    /**
     * 
     * @brief Méthode de modification d'un projet
     * 
     * @details Méthode qui récupère les infos du projet à modifier, les technologies disponibles, et les items associés au projet. 
     *         Puis elle rend le template avec les infos nécessaires pour l'édition.
     * 
     * @return void
     */
    public function edit(){
        // Récupérer l'id du projet
        $idProjet = $this->getGet()['id_projet'];

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
            'items' => $items,
            'user' => $_SESSION['user'] ?? null
        ]);
    }

    /**
     * 
     * @brief Méthode de mise à jour d'un projet
     * 
     * @details Méthode qui récupère les infos du projet à modifier, les technologies disponibles, et les items associés au projet.
     *          puis appelle la méthode update() du ProjetDAO pour mettre à jour le projet.
     * 
     * @return void
     */
    public function update(){
        // Récupérer les données du formulaire
        $id = $this->getPost()['id'];
        $titre = $this->getPost()['titre'];
        $description = $this->getPost()['description'];
        $annee = $this->getPost()['annee'];
        $type = $this->getPost()['type'];
        $technologies = $this->getPost()['technologies'];

        // Récupérer l'image
        $image = $_FILES['imageCover'];

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
            move_uploaded_file($image['tmp_name'], 'assets/coversProjets/' . $image['name']);
            $imageCover = 'assets/coversProjets/' . $image['name'];
        } else {
            $imageCover = '';
        }

        // Créer le projet
        $projet = new Projet($id, $titre, $description, $imageCover, $annee, $type, $technologies);

        // Mettre à jour le projet
        $projetDAO = new ProjetDAO($this->getPdo());
        $projetDAO->update($projet);

        // Rediriger vers la liste des projets
        header('Location: index.php?controller=projets&methode=index');
    }

    /**
     * 
     * @brief Méthode de création d'un projet
     * 
     * @details Méthode qui récupère les saisies du formulaire et déplace l'image dans le bon dossier afin de créer un projet en BD
     * 
     * @attention Cette méthode n'est pas complète, il manque la gestion des items
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

        // Récupérer les saisies du formulaire
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $annee = $_POST['annee'];
        $type = $_POST['type'];
        $technologies = $_POST['technologies'];
        // $items = $_POST['items'];
        $imageCover = $_FILES['imageCover'];

        // Vérifier si l'image a été uploadée
        if ($imageCover['size'] > 0) {
            // Déplacer l'image
            move_uploaded_file($imageCover['tmp_name'], 'assets/coversProjets/' . $imageCover['name']);
            $imageCover = 'assets/coversProjets/' . $imageCover['name'];
        } else {
            $imageCover = '';
        }

        // Gérer les technologies

        // Créer le projet
        $projet = new Projet(null, $titre, $description, $imageCover, $annee, $type, $technologies);

        // Ajouter le projet
        $projetDAO = new ProjetDAO($this->getPdo());
        $projetDAO->insert($projet);

        // Récupérer l'id du projet
        $idProjet = $projetDAO->getLastId();

        // Récupérer les technologies et créer les associations
        foreach ($technologies as $techno) {
            $projetDAO->addTechnologie($idProjet, $techno);
        }    

        header('Location: index.php?controller=projets&methode=index');
    }

    /**
     * 
     * @brief Méthode de suppression d'un projet
     * 
     * @details Méthode qui récupère l'id du projet à supprimer, puis appelle la méthode delete() du ProjetDAO pour supprimer le projet
     * 
     * @return void
     */
    public function delete(){
        // Récupérer l'id du projet
        $id = $this->getGet()['id_projet'];

        // Supprimer le projet
        $projetDAO = new ProjetDAO($this->getPdo());
        $projetDAO->delete($id);

        // Rediriger vers la liste des projets
        header('Location: index.php?controller=dashboard&methode=index');
    }


    /**
     * @brief Méthode de mise à jour d'un item d'un projet
     * 
     * @details Méthode qui récupère les infos de l'item à modifier, puis appelle la méthode update() de l'ItemsProjetDAO pour mettre à jour l'item
     * 
     * @return void
     */
    public function updateItem(){
        // Récupérer les données saisies
        $id = $this->getPost()['itemId'];
        $idProjet = $this->getPost()['projetId'];
        $titre = $this->getPost()['titre'];
        $description = $this->getPost()['description'];
        $image = $_FILES['imageCover'];

        // Vérifier si l'image a été uploadée
        if ($image['size'] > 0) {
            // Récupérer l'extension de l'image
            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);

            // Vérifier si l'extension est autorisée
            if (!in_array($extension, ['jpg', 'jpeg', 'png'])) {
                $this->show('L\'image n\'est pas valide');
                return;
            }

            // Déplacer l'image
            move_uploaded_file($image['tmp_name'], 'assets/itemsProjets/' . $image['name']);
            $imageCover = 'assets/itemsProjets/' . $image['name'];
        } else {
            $imageCover = '';
        }

        // Mettre l'item a jour par rapport à l'id
        $item = new ItemsProjet($id, $idProjet, $titre, $description, $imageCover);
        $itemDAO = new ItemsProjetDAO($this->getPdo());
        $itemDAO->update($item);

        // Rediriger vers la page du projet
        header('Location: index.php?controller=projets&methode=show&id_projet=' . $this->getPost()['projet_id']);
    }
}
