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
        $image = $donnees['imageCover'];
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

    // Méthode de récupération des items d'un projet
    public function findByProjetId(int $projet_id): array{
        $stmt = $this->pdo->prepare('SELECT * FROM itemsProjet WHERE projet_id = :projet_id');
        $stmt->bindParam(':projet_id', $projet_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $this->hydrateAll($result);
    }

    // Méthode de mise à jour
    public function update(ItemsProjet $itemProjet): void{
        $stmt = $this->pdo->prepare('UPDATE itemsProjet SET titre = :titre, description = :description, imageCover = :imageCover WHERE id = :id');
        $stmt->bindParam(':id', $itemProjet->getId());
        $stmt->bindParam(':titre', $itemProjet->getTitre());
        $stmt->bindParam(':description', $itemProjet->getDescription());
        $stmt->bindParam(':imageCover', $itemProjet->getImage());
        $stmt->execute();
        $stmt->closeCursor();
    }

    // Méhode d'ajout
    public function add(ItemsProjet $itemProjet): void{

        // Récupérer les informations
        $imageCover = $itemProjet->getImage();
        $titre = $itemProjet->getTitre();
        $description = $itemProjet->getDescription(); 
        $projet_id = $itemProjet->getProjet();

        // Si ce n'ets pas un entier, on le convertit
        if (!is_int($projet_id)) {
            $projet_id = $projet_id->getId();
        }

        // Ajouter l'item
        $stmt = $this->pdo->prepare('INSERT INTO itemsProjet (titre, description, imageCover, projet_id) VALUES (:titre, :description, :imageCover, :projet_id)');
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':imageCover', $imageCover);
        $stmt->bindParam(':projet_id', $projet_id);
        $stmt->execute();
    }

}