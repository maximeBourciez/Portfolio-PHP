<?php

// Classe pour les items du projet
class ItemsProjet{
    // Attributs
    private ?int $id; // Identifiant
    private ?Projet $projet; // Projet
    private ?string $titre; // Titre
    private ?string $description; // Description
    private ?string $image; // Image


    // Constructeur
    public function __construct(?int $id = null, ?Projet $projet = null, ?string $titre = null, ?string $description = null, ?string $image = null){
        $this->id = $id;
        $this->projet = $projet;
        $this->titre = $titre;
        $this->description = $description;
        $this->image = $image;
    }


    // Encapsulation
    // Getter
    public function getId(): ?int{
        return $this->id;
    }

    public function getProjet(): ?Projet{
        return $this->projet;
    }

    public function getTitre(): ?string{
        return $this->titre;
    }

    public function getDescription(): ?string{
        return $this->description;
    }

    public function getImage(): ?string{
        return $this->image;
    }

    
    // Setter
    public function setId(?int $id): void{
        $this->id = $id;
    }

    public function setProjet(?Projet $projet): void{
        $this->projet = $projet;
    }

    public function setTitre(?string $titre): void{
        $this->titre = $titre;
    }

    public function setDescription(?string $description): void{
        $this->description = $description;
    }

    public function setImage(?string $image): void{
        $this->image = $image;
    }
}