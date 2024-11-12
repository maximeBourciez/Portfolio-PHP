<?php

/**
 * 
 * @brief Classe ItemsProjetDAO - Gestion des items d'un projet
 * 
 * @details Classe pour gérer les items d'un projet (titre, description, image) en base de données
 * 
 * @date 12 Novembre 2024
 * 
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 */
class ItemsProjetDAO{
    // Attributs
    /**
     * @brief Instance de PDO
     * @var PDO|null $pdo Instance de PDO
     */
    private ?PDO $pdo; // Instance de PDO
    
    // Constructeur
    /**
     * @brief Constructeur de la classe
     * 
     * @details Constructeur avec une valeur par défaut pour l'attribut permettant de créer un objet sans paramètres
     * 
     * @param PDO|null $pdo Instance de PDO
     */
    public function __construct(?PDO $pdo = null){
        $this->pdo = $pdo;
    }

    /**
     * @brief Méthode pour hydrater un objet ItemsProjet
     * 
     * @param array $donnees
     *
     * @warning Cette méthode devrait peut-être utiliser un objet ProjetDAO pour récupérer le projet associé à l'item
     * 
     * @return ItemsProjet
     */
    public function hydrate(array $donnees): ItemsProjet{
        $id = $donnees['id'];
        $projet_id = $donnees['projet_id'];
        $titre = $donnees['titre'];
        $description = $donnees['description'];
        $image = $donnees['imageCover'];
        return new ItemsProjet($id, $projet_id, $titre, $description, $image);
    }

    /**
     * @brief Méthode pour hydrater un tableau d'objets ItemsProjet
     * 
     * @details Méthode qui prend un tableau de données et retourne un tableau d'objets ItemsProjet
     * 
     * @param array $donnees
     * 
     * @return array<ItemsProjet>|null
     */
    public function hydrateAll(array $donnees): array{
        $itemsProjets = [];
        foreach($donnees as $row){
            $itemProjet = $this->hydrate($row);
            array_push($itemsProjets, $itemProjet);
        }
        return $itemsProjets;
    }

    /**
     * @brief Méthode pour recherhce un item par son identifiant
     * 
     * @param int $id
     * 
     * @return ItemsProjet|null
     */
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

    /**
     * @brief Méthode pour récupérer tous les items
     * 
     * @param ItemsProjet $itemProjet
     * 
     * @return array<ItemsProjet>|null (null si aucun item n'est trouvé)
     */
    public function findAll(): array{
        $stmt = $this->pdo->prepare('SELECT * FROM itemsProjet');
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $this->hydrateAll($result);
    }

    /**
     * @brief Méthode pour récupérer les items d'un projet
     * 
     * @param int $projet_id
     * 
     * @return array<ItemsProjet>
     */
    public function findByProjetId(int $projet_id): array{
        $stmt = $this->pdo->prepare('SELECT * FROM itemsProjet WHERE projet_id = :projet_id');
        $stmt->bindParam(':projet_id', $projet_id);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $this->hydrateAll($result);
    }

    /**
     * @brief Méthode de mise à jour d'un item
     * 
     * @param ItemsProjet $itemProjet
     * 
     * @return void
     * 
     * @warning Cette méthode devrait peut-être utiliser un objet ProjetDAO pour récupérer le projet associé à l'item + N'est jamais utilisée pour le moment
     */
    public function update(ItemsProjet $itemProjet): void{
        $stmt = $this->pdo->prepare('UPDATE itemsProjet SET titre = :titre, description = :description, imageCover = :imageCover WHERE id = :id');
        $stmt->bindParam(':id', $itemProjet->getId());
        $stmt->bindParam(':titre', $itemProjet->getTitre());
        $stmt->bindParam(':description', $itemProjet->getDescription());
        $stmt->bindParam(':imageCover', $itemProjet->getImage());
        $stmt->execute();
        $stmt->closeCursor();
    }
}