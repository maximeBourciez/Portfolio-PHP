<?php

/**
 * 
 * @brief Classe ItemsProjet - Gestion des items d'un projet
 * 
 * @details Classe pour gérer les items d'un projet (titre, description, image)
 * 
 * @date 12 Novembre 2024
 * 
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 */
class ItemsProjet{
    // Attributs
    /**
     * @brief Identifiant
     * @var int|null
     */
    private ?int $id; 
    /**
     * @brief Projet
     * @var Projet|null
     */
    private ?Projet $projet;
    /**
     * @brief Titre
     * @var string|null
     */
    private ?string $titre; 
    /**
     * @brief Description
     * @var string|null
     */
    private ?string $description; 
    /**
     * @brief Image
     * @var string|null
     */
    private ?string $image; 


    // Constructeur
    /**
     * @brief Constructeur de la classe
     * 
     * @details Constructeur avec des valeurs par défaut pour les attributs permettant de créer un objet sans paramètres
     * 
     * @param int|null $id Identifiant
     * @param int|Projet $projet Projet
     * @param string|null $titre Titre
     * @param string|null $description Description
     * @param string|null $image Image
     */
    public function __construct(?int $id = null, int $projet = null, ?string $titre = null, ?string $description = null, ?string $image = null){
        $this->id = $id;
        if(is_int($projet)){
            $this->projet = new Projet($projet);
        }else{
            $this->projet = $projet;
        }
        $this->titre = $titre;
        $this->description = $description;
        $this->image = $image;
    }


    // Encapsulation
    // Getters
    /**
     * @brief Getter pour l'identifiant
     * 
     * @return int|null
     */
    public function getId(): ?int{
        return $this->id;
    }

    /**
     * @brief Getter pour le projet
     * 
     * @return Projet|null
     */
    public function getProjet(): ?Projet{
        return $this->projet;
    }

    /**
     * @brief Getter pour le titre
     * 
     * @return string|null
     */
    public function getTitre(): ?string{
        return $this->titre;
    }

    /**
     * @brief Getter pour la description
     * 
     * @return string|null
     */
    public function getDescription(): ?string{
        return $this->description;
    }

    /**
     * @brief Getter pour l'image
     * 
     * @return string|null
     */
    public function getImage(): ?string{
        return $this->image;
    }

    
    // Setters
    /**
     * @brief Setter pour l'identifiant
     * 
     * @param int|null $id Identifiant
     * 
     * @return void
     */
    public function setId(?int $id): void{
        $this->id = $id;
    }

    /**
     * @brief Setter pour le projet
     * 
     * @param Projet|null $projet Projet
     * 
     * @return void
     */
    public function setProjet(?Projet $projet): void{
        $this->projet = $projet;
    }

    /**
     * @brief Setter pour le titre
     * 
     * @param string|null $titre Titre
     * 
     * @return void
     */
    public function setTitre(?string $titre): void{
        $this->titre = $titre;
    }

    /**
     * @brief Setter pour la description
     * 
     * @param string|null $description Description
     * 
     * @return void
     */
    public function setDescription(?string $description): void{
        $this->description = $description;
    }

    /**
     * @brief Setter pour l'image
     * 
     * @param string|null $image Image
     * 
     * @return void
     */
    public function setImage(?string $image): void{
        $this->image = $image;
    }
}