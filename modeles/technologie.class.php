<?php 

// Classe pour les technologies
class Technologie{
    // Attributs 
    private ?int $id; // Identifiant
    private ?string $nom; // Nom de la technologie
    
    private ?string $niveauMaitrise; // Niveau de maitrise de la technologie
    private ?string $logo; // Logo de la technologie


    // Constructeur
    public function __construct(?int $id = null, ?string $nom = null, ?string $logo = null, ?string $niveauMaitrise = null){
        $this->id = $id;
        $this->nom = $nom;
        $this->logo = $logo;
        $this->niveauMaitrise = $niveauMaitrise;
    }


    // Encapsulation
    // Getter
    public function getId(): ?int{
        return $this->id;
    }

    public function getNom(): ?string{
        return $this->nom;
    }

    public function getLogo(): ?string{
        return $this->logo;
    }

    public function getNiveauMaitrise(): ?string{
        return $this->niveauMaitrise;
    }


    // Setter
    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function setNom(?string $nom): void{
        $this->nom = $nom;
    }

    public function setLogo(?string $logo): void{
        $this->logo = $logo;
    }

    public function setNiveauMaitrise(?string $niveauMaitrise): void{
        $this->niveauMaitrise = $niveauMaitrise;
    }
}