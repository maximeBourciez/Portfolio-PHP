<?php 

// Classe pour les technologie - DAO
class TechnologieDAO{
    // Attributs
    private ?PDO $pdo; // Instance de PDO

    // Constructeur
    public function __construct(?PDO $pdo = null){
        $this->pdo = $pdo;
    }

    // Méthode d'hydratation
    public function hydrate(array $donnees): Technologie{
        $id = $donnees['id'];
        $nom = $donnees['nom'];
        $logo = $donnees['logo'];
        $niveauMaitrise = $donnees['niveauMaitrise'];
        return new Technologie($id, $nom, $logo, $niveauMaitrise);
    }

    // Fonction hydrateAll()
    public function hydrateAll(array $donnees): array{
        $technologies = [];
        foreach($donnees as $row){
            $technologie = $this->hydrate($row);
            array_push($technologies, $technologie);
        }
        return $technologies;
    }

    // Méthode de recherche par id
    public function findById(int $id): Technologie|null{
        $stmt = $this->pdo->prepare('SELECT * FROM technologie WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();
        if($result){
            return $this->hydrate($result);
        }
        return null;
    }

    // Méthode de récupération de toutes les technologies
    public function findAll(): array{
        $stmt = $this->pdo->prepare('SELECT * FROM technologie');
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $this->hydrateAll($result);
    }

    // Méthode de récupération des projets liés à la technologie
    public function getProjets(int $idTechnologie): array{
        $stmt = $this->pdo->prepare('SELECT * FROM projet_technologie WHERE technologie_id = :idTechnologie');
        $stmt->bindParam(':idTechnologie', $idTechnologie);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $result;
    }

    // Méthode de récupération des technologies liées à un projet
    public function getTechnologiesByProjectId(int $idProjet): array{
        $stmt = $this->pdo->prepare('
            SELECT t.* FROM technologie t
            JOIN projet_technologie pt ON t.id = pt.technologie_id
            WHERE pt.projet_id = :idProjet
        ');
        $stmt->bindParam(':idProjet', $idProjet);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        return $this->hydrateAll($result);
    }
}