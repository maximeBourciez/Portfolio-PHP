<?php

// Classe pour les items du projet - DAO
class ItemsProjetDAO{
    // Attributs
    private ?PDO $pdo; // Instance de PDO
    
    // Constructeur
    public function __construct(?PDO $pdo = null){
        $this->pdo = $pdo;
    }

    // Méthode d'hydratation
    public function hydrate(array $donnees): ItemsProjet{
        $id = $donnees['id'];
        $projet_id = $donnees['projet_id'];
        $titre = $donnees['titre'];
        $description = $donnees['description'];
        $image = $donnees['image'];
        return new ItemsProjet($id, $projet_id, $titre, $description, $image);
    }

    // Fonction hydrateAll()
    public function hydrateAll(array $donnees): array{
        $itemsProjets = [];
        foreach($donnees as $row){
            $itemProjet = $this->hydrate($row);
            array_push($itemsProjets, $itemProjet);
        }
        return $itemsProjets;
    }

    // Méthode de recherche par id
    public function findById(int $id): ItemsProjet|null{
        $stmt = $this->pdo->prepare('SELECT * FROM itemsProjet WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        if($result){
            return $this->hydrate($result);
        }
        return null;
    }

    // Méthode de récupération de tous les items
    public function findAll(): array{
        $stmt = $this->pdo->prepare('SELECT * FROM itemsProjet');
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $this->hydrateAll($result);
    }
}