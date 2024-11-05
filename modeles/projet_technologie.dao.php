<?php

// Classe lien Porjets - Technos  - DAO
class ProjetTechnologieDAO {
    // Attributs
    private ?PDO $pdo; // Instance de PDO
    private ?int $idProjet; // Id du projet
    private ?int $idTechnologie; // Id de la technologie

    // Constructeur
    public function __construct(?PDO $pdo,?int $idProjet = null, ?int $idTechnologie = null){
        $this->pdo = $pdo;
        $this->idProjet = $idProjet;
        $this->idTechnologie = $idTechnologie;
    }

    // Méthode d'hydratation
    public function hydrate(array $donnees): ProjetTechnologie{
        $idProjet = $donnees['projet_id'];
        $idTechnologie = $donnees['technologie_id'];
        return new ProjetTechnologie($idProjet, $idTechnologie);
    }

    // Fonction hydrateAll()
    public function hydrateAll(array $donnees): array{
        $projetsTechnologies = [];
        foreach($donnees as $row){
            $projetTechnologie = $this->hydrate($row);
            array_push($projetsTechnologies, $projetTechnologie);
        }
        return $projetsTechnologies;
    }

    // Méthode pour récupérer les technologies d'un projet
    public function getTechnologies(int $idProjet): array{
        $stmt = $this->pdo->prepare('SELECT * FROM projet_technologie WHERE projet_id = :idProjet');
        $stmt->bindParam(':idProjet', $idProjet);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $this->hydrateAll($result);
    }
}