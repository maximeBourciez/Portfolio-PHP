<?php

/**
 * 
 * @brief Classe Projet - Gestion des projets
 * 
 * @details Classe pour gérer les projets (titre, description, image de couverture, année, type, technologies) en base de données
 * 
 * @date 12 Novembre 2024
 * 
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 */
class Projet{
    // Attributs
    /**
     * @var int|null Identifiant du projet
     */
    private int|null $id; 
    /**
     * @var string|null Titre du projet
     */
    private string|null $titre; 
    /**
     * @var string|null Description du projet
     */
    private string|null $description; 
    /**
     * @var string|null Image de couverture du projet
     */
    private string|null $imageCover; 
    /**
     * @var string|null Année du projet
     */
    private string|null $annee;
    /**
     * @var string|null Type du projet (personnel, professionnel, universitaire)
     */
    private string|null $type; 
    /**
     * @var array|null Technologies utilisées dans le projet
     */
    private array|null $technologies; 


    // Constructeur
    /**
     * @brief Constructeur de la classe
     * 
     * @details Constructeur avec des valeurs par défaut pour les attributs permettant de créer un objet sans paramètres
     * 
     * @param int|null $id Identifiant
     * @param string|null $titre Titre
     * @param string|null $description Description
     * @param string|null $imageCover Image de couverture
     * @param string|null $annee Année
     * @param string|null $type Type
     * @param array|null $technologies Technologies
     */
    function __construct(?int $id = null, ?string $titre = null, ?string $description = null, ?string $imageCover = null, ?string $annee = null,?string $type = null, ?array $technologies = null){
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->imageCover = $imageCover;
        $this->annee = $annee;
        $this->type = $type;
        $this->technologies = $technologies;
    }


    // Encapsulation
    // Getters
    /**
     * @brief Getter pour l'identifiant
     * @return int|null
     */
    public function getId(): int|null{
        return $this->id;
    }

    /**
     * @brief Getter pour le titre
     * @return string|null
     */
    public function getTitre(): string|null{    
        return $this->titre;
    }

    /**
     * @brief Getter pour la description
     * @return string|null
     */
    public function getDescription(): string|null{
        return $this->description;
    }

    /**
     * @brief Getter pour l'image de couverture
     * @return string|null
     */
    public function getImageCover(): string|null{
        return $this->imageCover;
    }

    /**
     * @brief Getter pour l'année
     * @return string|null
     */
    public function getAnnee(): string|null{
        return $this->annee;
    }

    /**
     * @brief Getter pour le type
     * @return string|null
     */
    public function getType(): string|null{
        return $this->type;
    }

    /**
     * @brief Getter pour les technologies
     * @return array|null
     */
    public function getTechnologies(): array|null{
        return $this->technologies;
    }


    // Setters 
    /**
     * @brief Setter pour l'identifiant
     * @param int $id Identifiant
     * @return void
     */
    public function setId(int $id): void{
        $this->id = $id;
    }

    /**
     * @brief Setter pour le titre
     * @param string|null $titre Titre
     * @return void
     */
    public function setTitre(string|null $titre): void{
        $this->titre = $titre;
    }

    /**
     * @brief Setter pour la description
     * @param string|null $description Description
     * @return void
     */
    public function setDescription(string|null $description): void{
        $this->description = $description;
    }

    /**
     * @brief Setter pour l'image de couverture
     * @param string|null $imageCover Image de couverture
     * @return void
     */
    public function setImageCover(string|null $imageCover): void{
        $this->imageCover = $imageCover;
    }

    /**
     * @brief Setter pour l'année
     * @param string|null $annee Année
     * @return void
     */
    public function setAnnee(string|null $annee): void{
        $this->annee = $annee;
    }

    /**
     * @brief Setter pour le type
     * @param string|null $type Type
     * @return void
     */
    public function setType(string|null $type): void{
        $this->type = $type;
    }

    /**
     * @brief Setter pour les technologies
     * @param array|null $technologies Technologies
     * @return void
     */
    public function setTechnologies(array|null $technologies): void{
        $this->technologies = $technologies;
    }
}