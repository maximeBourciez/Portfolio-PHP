<?php

// Classe projet
class Projet{
    // Attributs
    private int|null $id; // Id du projet
    private string|null $titre; // titre du projet
    private string|null $description; // description du projet
    private string|null $imageCover; // image de couverture du projet
    private string|null $annee; // Année du projet


    // Constructeur
    function __construct(?int $id, ?string $titre, ?string $description, ?string $imageCover, ?string $annee){
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->imageCover = $imageCover;
        $this->annee = $annee;
    }


    // Encapsulation
    // Getters
    public function getId(): int|null{
        return $this->id;
    }

    public function getTitre(): string|null{    
        return $this->titre;
    }

    public function getDescription(): string|null{
        return $this->description;
    }

    public function getImageCover(): string|null{
        return $this->imageCover;
    }

    public function getAnnee(): string|null{
        return $this->annee;
    }


    // Setters 
    public function setId(int $id): void{
        $this->id = $id;
    }

    public function setTitre(string|null $titre): void{
        $this->titre = $titre;
    }

    public function setDescription(string|null $description): void{
        $this->description = $description;
    }

    public function setImageCover(string|null $imageCover): void{
        $this->imageCover = $imageCover;
    }

    public function setAnnee(string|null $annee): void{
        $this->annee = $annee;
    }
}