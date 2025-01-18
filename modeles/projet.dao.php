<?php

/**
 * 
 * @brief Classe ProjetDAO - Gestion des projets
 * 
 * @details Classe pour gérer les projets (titre, description, image, annee, type) en base de données
 * 
 * @date 12 Novembre 2024
 * 
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 */
class ProjetDAO 
{
    // Attributs
    /**
     * @brief Instance de PDO pour la connexion à la base de données
     * @var PDO|null $pdo Instance de PDO
     */
    private PDO|null $pdo;

    // Constructeur
    /**
     * @brief Constructeur de la classe
     * 
     * @details Constructeur avec une valeur par défaut pour l'attribut permettant de créer un objet sans paramètres
     * 
     * @param PDO|null $pdo Instance de PDO
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Méthodes d'hydratation
    /**
     * @brief Méthode pour hydrater un objet Projet
     * 
     * @details Méthode qui prend un tableau de données contenant les infos d'un Projet SEUL et retourne un objet Projet
     * 
     * @param array $data
     * 
     * @return Projet
     */
    public function hydrate(array $data): Projet
    {
        $projet = new Projet();
        $projet->setId($data['id']);
        $projet->setTitre($data['titre']);
        $projet->setDescription($data['description']);
        $projet->setDesclongue($data['descriptionLongue']);
        $projet->setImageCover($data['imageCover']);
        $projet->setAnnee($data['annee']);
        $projet->setType($data['type']);
        $projet->setLienGit($data['lienGit']);

        // Récupérer les technologies associées
        $technologiesDAO = new TechnologieDAO($this->pdo);
        $technologies = $technologiesDAO->getTechnologiesByProjectId($data['id']);
        $projet->setTechnologies($technologies);

        return $projet;
    }

    /**
     * @brief Méthode pour hydrater un tableau d'objets Projet
     * 
     * @details Méthode qui prend un tableau de données contenant les infos de 0..* projets et retourne un tableau d'objets Projet
     * 
     * @param array $datas
     * 
     * @return array<Projet>|null
     */
    public function hydrateAll(array $datas): array
    {
        $projets = [];
        foreach ($datas as $data) {
            $projet = $this->hydrate($data);
            $projets[] = $projet;
        }
        return $projets;
    }


    /**
     * @brief Méthode pour récupérer les 3 derniers projets
     * 
     * @details Méthode qui récupère les 3 derniers projets ajoutés en base de données afin de les afficher sur la page d'accueil
     * 
     * @return array<Projet>|null
     */
    public function getLastX(int $X): array
{
    $stmt = $this->pdo->prepare('
        SELECT * FROM projet
        ORDER BY id ASC
        LIMIT ?
    ');
    $stmt->bindValue(1, $X, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    // Utilisation de hydrateAll pour créer et retourner les objets Projet
    return $this->hydrateAll($result);
}

    /**
     * @brief Méthode pour récupérer un projet par son identifiant
     * 
     * @details Méthode qui récupère un projet en base de données en fonction de son identifiant - Utile pour l'affichage d'un projet en particulier
     * 
     * @param int $id
     * 
     * @return Projet
     */
    public function getById(int $id): Projet
    {
        $stmt = $this->pdo->prepare('
            SELECT * FROM projet
            WHERE id = :id
        ');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $this->hydrate($result);
    }

    /**
     * @brief Méthode pour récupérer les items d'un projet par son identifiant
     * 
     * @param int $id
     * 
     * @return array<ItemsProjet>
     */
    public function getItems(int $id): array
    {
        $stmt = $this->pdo->prepare('
            SELECT * FROM itemsProjet
            WHERE projet_id = :id
        ');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        // Utilisation de hydrateAll pour créer et retourner les objets ItemsProjet
        $itemsProjetDAO = new ItemsProjetDAO($this->pdo);
        return $itemsProjetDAO->hydrateAll($result);
    }

    /**
     * @brief Méthode pour récupérer tous les projets
     * 
     * @details Méthode qui récupère tous les projets en base de données - Les récupère aussi avec les filtres si besoin ( <=> non nuls )
     * 
     * @param mixed $type
     * 
     * @param mixed $techno
     * 
     * @return array<Projet>|null
     */
    public function findAll($type = '', $techno = ''): array
    {
        // Création de la requête en fonction des filtres
        $sql = 'SELECT * FROM projet';
        if ($type != '' || $techno != '') {
            $sql .= ' WHERE ';
            if ($type != '') {
                $sql .= 'type = :type';
            }
            if ($techno != '') {
                if ($type != '') {
                    $sql .= ' AND ';
                }
                $sql .= 'id IN (SELECT projet_id FROM projet_technologie WHERE technologie_id = :techno)';
            }
        }

        // Préparation de la requête
        $stmt = $this->pdo->prepare($sql);

        // Ajout des valeurs des filtres
        if ($type != '') {
            $stmt->bindValue(':type', $type, PDO::PARAM_STR);
        }
        if ($techno != '') {
            $stmt->bindValue(':techno', $techno, PDO::PARAM_INT);
        }

        // Exécution de la requête
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        // Utilisation de hydrateAll pour créer et retourner les objets Projet
        return $this->hydrateAll($result);
    }

    /**
     * @brief Méthode pour mettre à jour un projet
     * 
     * @details Méthode qui met à jour un projet en base de données en fonction de l'objet Projet passé en paramètre
     * 
     * @param Projet $projet
     * 
     * @return void
     * 
     * @warning Non terminée - Il manque la gestion des technologies & réfléchir l'implémentation des items
     */
    public function update(Projet $projet): void
    {
        // Récupérer toutes les technologies associées
        $technologies = $projet->getTechnologies();

        // Supprimer les associations actuelles avec les technologies
        $stmt = $this->pdo->prepare('
        DELETE FROM projet_technologie
        WHERE projet_id = :id
        ');
        $stmt->bindValue(':id', $projet->getId(), PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        foreach ($technologies as $techno) {
            // Ajouter les nouvelles associations avec les technologies
            $stmt = $this->pdo->prepare('
            INSERT INTO projet_technologie (projet_id, technologie_id)
            VALUES (:projet_id, :technologie_id)
        ');
            $stmt->bindValue(':projet_id', $projet->getId(), PDO::PARAM_INT);
            $stmt->bindValue(':technologie_id', $techno, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->closeCursor();
        }

        // Vérifier si une nouvelle image a été uploadée
        if ($projet->getImageCover() != '') {
            // Supprimer l'ancienne image
            $stmt = $this->pdo->prepare('
                    SELECT imageCover FROM projet
                    WHERE id = :id
            ');
            $stmt->bindValue(':id', $projet->getId(), PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $stmt->closeCursor();
            if (file_exists($result['imageCover'])) {
                unlink($result['imageCover']);
            }
        }

        // Mettre à jour le projet
        $stmt = $this->pdo->prepare('
        UPDATE projet
        SET titre = :titre, description = :description, imageCover = :imageCover, annee = :annee, type = :type, lienGit = :lienGit
        WHERE id = :id
    ');
        $stmt->bindValue(':id', $projet->getId(), PDO::PARAM_INT);
        $stmt->bindValue(':titre', $projet->getTitre(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $projet->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':imageCover', $projet->getImageCover(), PDO::PARAM_STR);
        $stmt->bindValue(':annee', $projet->getAnnee(), PDO::PARAM_INT);
        $stmt->bindValue(':type', $projet->getType(), PDO::PARAM_STR);
        $stmt->bindValue(':lienGit', $projet->getLienGit(), PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }

    /**
     * @brief Méthode pour insérer un projet
     * 
     * @details Méthode qui insère un projet en base de données en fonction de l'objet Projet passé en paramètre 
     * 
     * @param Projet $projet
     * 
     * @return void
     */
    public function insert(Projet $projet): void
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO projet (titre, description, imageCover, annee, type)
            VALUES (:titre, :description, :imageCover, :annee, :type)
        ');
        $stmt->bindValue(':titre', $projet->getTitre(), PDO::PARAM_STR);
        $stmt->bindValue(':description', $projet->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(':imageCover', $projet->getImageCover(), PDO::PARAM_STR);
        $stmt->bindValue(':annee', $projet->getAnnee(), PDO::PARAM_INT);
        $stmt->bindValue(':type', $projet->getType(), PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }

    /**
     * @brief Méthode pour récupérer le dernier identifiant inséré
     * 
     * @return int
     */
    public function getLastId(): int
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * @brief Méthode pour ajouter une technologie à un projet par les id de l'un et de l'autre
     * 
     * @param int $idProjet
     * 
     * @param int $idTechno
     * 
     * @return void
     */
    public function addTechnologie(int $idProjet, int $idTechno): void
    {
        $stmt = $this->pdo->prepare('
            INSERT INTO projet_technologie (projet_id, technologie_id)
            VALUES (:projet_id, :technologie_id)
        ');
        $stmt->bindValue(':projet_id', $idProjet, PDO::PARAM_INT);
        $stmt->bindValue(':technologie_id', $idTechno, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    /**
     * @brief Méthode pour supprimer un projet
     * 
     * @details Méthode qui supprime un projet en base de données en fonction de son identifiant. Supprime également les images en dur et les liens avec les technologies, ainsi que les items associés.
     * 
     * @param int $id - Identifiant du projet a supprimer
     * 
     * @return void
     */
    public function delete(int $id): void
    {

        // Supprimer la couverture du projet
        $stmt = $this->pdo->prepare('
         SELECT imageCover FROM projet
         WHERE id = :id
        ');

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if (file_exists($result['imageCover'])) {
            unlink($result['imageCover']);
        }

        // Supprimer les images des items du projet du dossier
        $stmt = $this->pdo->prepare('
         SELECT imageCover FROM itemsProjet
         WHERE projet_id = :id
     ');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach ($result as $item) {
            if (file_exists($item['image'])) {
                unlink($item['image']);
            }
        }

        // Supprimer dans la BD
        $stmt = $this->pdo->prepare('
            DELETE FROM projet
            WHERE id = :id
        ');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        // Supprimer les associations avec les technologies
        $stmt = $this->pdo->prepare('
            DELETE FROM projet_technologie
            WHERE projet_id = :id
        ');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        // Supprimer les items
        $stmt = $this->pdo->prepare('
            DELETE FROM itemsProjet
            WHERE projet_id = :id
        ');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();
    }

    public function create($projet) {
        $req = "INSERT INTO projet (nom, description, image, lienGit) 
                VALUES (:nom, :description, :image, :lienGit)";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":nom", $projet->getNom(), PDO::PARAM_STR);
        $stmt->bindValue(":description", $projet->getDescription(), PDO::PARAM_STR);
        $stmt->bindValue(":image", $projet->getImage(), PDO::PARAM_STR);
        $stmt->bindValue(":lienGit", $projet->getLienGit(), PDO::PARAM_STR);
        $stmt->execute();
    }
}
