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


}
