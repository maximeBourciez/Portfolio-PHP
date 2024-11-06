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

    // Méthode pour récupérer tous les projets
    public function getAll(): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM projet');
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        $projets = [];
        foreach ($result as $row) {
            $projet = $this->hydrate($row);
            array_push($projets, $projet);
        }
        return $projets;
    }

    // Méthode pour récupérer un projet par son id
    public function getById(int $id): Projet|null
    {
        $stmt = $this->pdo->prepare('SELECT * FROM projet WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        if ($result) {
            return $this->hydrate($result);
        }
        return null;
    }

    // Méthode pour récupérer les items d'un projet
    public function getItems(int $id): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM itemsProjet WHERE projet_id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        $items = [];
        foreach ($result as $row) {
            $item = new ItemsProjet($row['id'], $row['projet_id'], $row['titre'], $row['description'], $row['image']);
            array_push($items, $item);
        }
        return $items;
    }

    // Méthode pour récupérer les 3 derniers projets
    public function getLastThree(): array {
        // Étape 1 : Récupère les trois derniers projets avec leurs informations de base
        $stmt = $this->pdo->prepare('SELECT * FROM projet ORDER BY id DESC LIMIT 3');
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
    
        $projets = [];
        foreach ($result as $row) {
            // Étape 2 : Récupère les technologies pour ce projet
            $technologiesStmt = $this->pdo->prepare(
                'SELECT T.id, T.nom, T.niveauMaitrise, T.logo 
                 FROM projet_technologie PT 
                 JOIN technologies T ON PT.technologie_id = T.id 
                 WHERE PT.projet_id = :projet_id'
            );
            $technologiesStmt->execute(['projet_id' => $row['id']]);
            $technologiesResult = $technologiesStmt->fetchAll();
            $technologiesStmt->closeCursor();
    
            // Hydrate les objets Technologie pour ce projet
            $technologies = [];
            foreach ($technologiesResult as $techRow) {
                $technologie = new Technologie();
                $technologie->setId($techRow['id']);
                $technologie->setNom($techRow['nom']);
                $technologie->setNiveauMaitrise($techRow['niveauMaitrise']);
                $technologie->setLogo($techRow['logo']);
                $technologies[] = $technologie;
            }
    
            // Utilise hydrate pour créer l'objet Projet avec ses technologies
            $data = [
                'id_projet' => $row['id'],
                'titre' => $row['titre'],
                'description' => $row['description'],
                'imageCover' => $row['imageCover'],
                'annee' => $row['annee'],
                'technologies' => $technologies
            ];
    
            $projet = $this->hydrate($data);
            $projets[] = $projet;
        }
    
        return $projets;
    }
    

    // Méthode hydrate()
    public function hydrate(array $data): Projet
    {

        $projet = new Projet($data['id_projet'], $data['titre'], $data['description'], $data['imageCover'], $data['annee'], $data['technologies']);

        return $projet;
    }

    // Fonction hydrateAll()
    public function hydrateAll(array $data): array
    {
        $projets = [];
        foreach ($data as $row) {
            $projet = $this->hydrate($row);
            array_push($projets, $projet);
        }
        return $projets;
    }
}
