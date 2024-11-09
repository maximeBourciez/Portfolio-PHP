<?php

// Classe pour les projets - DAO
class ProjetDAO
{
    // Attributs
    private PDO|null $pdo; // Base de données

    // Constructeur
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Méthodes d'hydratation
    public function hydrate(array $data): Projet
    {
        $projet = new Projet();
        $projet->setId($data['id']);
        $projet->setTitre($data['titre']);
        $projet->setDescription($data['description']);
        $projet->setImageCover($data['imageCover']);
        $projet->setAnnee($data['annee']);
        $projet->setType($data['type']);

        // Récupérer les technologies associées
        $technologiesDAO = new TechnologieDAO($this->pdo);
        $technologies = $technologiesDAO->getTechnologiesByProjectId($data['id']);
        $projet->setTechnologies($technologies);

        return $projet;
    }

    public function hydrateAll(array $datas): array
    {
        $projets = [];
        foreach ($datas as $data) {
            $projet = $this->hydrate($data);
            $projets[] = $projet;
        }
        return $projets;
    }


    // Méthode pour récupérer les 3 derniers projets
    public function getLastThree(): array
    {
        $stmt = $this->pdo->prepare('
            SELECT * FROM projet
            ORDER BY id DESC
            LIMIT 3
        ');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        // Utilisation de hydrateAll pour créer et retourner les objets Projet
        return $this->hydrateAll($result);
    }

    // Méthode pour récupérer un projet par son id
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

        // Utilisation de hydrate pour créer et retourner l'objet Projet
        return $this->hydrate($result);
    }

    // Méthode pour récupérer les items d'un projet
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

    // Méthode pour récupérer tous les projets
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
}
