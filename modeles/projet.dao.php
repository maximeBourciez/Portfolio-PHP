<?php

// Classe pour les projets - DAO
class ProjetDAO{
    // Attributs
    private PDO|null $pdo; // Base de données

    // Constructeur
    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    // Méthode pour récupérer tous les projets
    public function getAll(): array{
        $stmt = $this->pdo->prepare('SELECT * FROM projet');
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        $projets = [];
        foreach($result as $row){
            $projet = new Projet($row['id'], $row['titre'], $row['description'], $row['imageCover'], $row['annee']);
            array_push($projets, $projet);
        }
        return $projets;
    }

    // Méthode pour récupérer un projet par son id
    public function getById(int $id): Projet|null{
        $stmt = $this->pdo->prepare('SELECT * FROM projet WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        if($result){
            return new Projet($result['id'], $result['titre'], $result['description'], $result['imageCover'], $result['annee']);
        }
        return null;
    }

    // Méthode pour récupérer les items d'un projet
    public function getItems(int $id): array{
        $stmt = $this->pdo->prepare('SELECT * FROM itemsProjet WHERE projet_id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        $items = [];
        foreach($result as $row){
            $item = new ItemsProjet($row['id'], $row['projet_id'], $row['titre'], $row['description'], $row['image']);
            array_push($items, $item);
        }
        return $items;
    }

    // Méthode pour récupérer les 3 derniers projets
    public function getLastThree(): array{
        $stmt = $this->pdo->prepare('SELECT * FROM projet ORDER BY id DESC LIMIT 3');
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        $projets = [];
        foreach($result as $row){
            $projet = new Projet($row['id'], $row['titre'], $row['description'], $row['imageCover'], $row['annee']);
            array_push($projets, $projet);
        }
        return $projets;
    }

    // Méthode hydrate()
    public function hydrate(array $data): Projet
    {
        $projet = new Projet($data['id'], $data['titre'], $data['description'], $data['imageCover'], $data['annee']);

        return $projet;
    }

    // Fonction hydrateAll()
    public function hydrateAll(array $data): array
    {
        $projets = [];
        foreach($data as $row){
            $projet = $this->hydrate($row);
            array_push($projets, $projet);
        }
        return $projets;
    }

}