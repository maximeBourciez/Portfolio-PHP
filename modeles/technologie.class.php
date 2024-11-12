<?php 

/**
 * 
 * @brief Classe Technologie - Gestion des technologies
 * 
 * @details Classe pour gérer les technologies (nom, logo, niveau de maitrise) en base de données
 * 
 * @date 12 Novembre 2024
 * 
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 */
class Technologie{
    // Attributs 
    /**
     * @var int|null $id Identifiant
     */
    private ?int $id; 
    /**
     * @var string|null $nom Nom de la technologie
     */
    private ?string $nom; 
    /**
     * @var string|null $niveauMaitrise Niveau de maitrise de la technologie
     */
    
    private ?string $niveauMaitrise; 
    /**
     * @var string|null $logo lien relatif vers le logo technologie
     */
    private ?string $logo; 


    // Constructeur
    /**
     * @brief Constructeur de la classe
     * 
     * @details Constructeur avec des valeurs par défaut pour les attributs permettant de créer un objet sans paramètres
     * 
     * @param int|null $id Identifiant
     * @param string|null $nom Nom de la technologie
     * @param string|null $logo Lien relatif vers le logo de la technologie
     * @param string|null $niveauMaitrise Niveau de maitrise de la technologie
     */
    public function __construct(?int $id = null, ?string $nom = null, ?string $logo = null, ?string $niveauMaitrise = null){
        $this->id = $id;
        $this->nom = $nom;
        $this->logo = $logo;
        $this->niveauMaitrise = $niveauMaitrise;
    }


    // Encapsulation
    // Getter
    /**
     * @brief Getter pour l'identifiant
     * 
     * @return int|null
     */
    public function getId(): ?int{
        return $this->id;
    }

    /**
     * @brief Getter pour le nom
     * 
     * @return string|null
     */
    public function getNom(): ?string{
        return $this->nom;
    }

    /**
     * @brief Getter pour le logo
     * 
     * @return string|null
     */
    public function getLogo(): ?string{
        return $this->logo;
    }

    /**
     * @brief Getter pour le niveau de maitrise
     * 
     * @return string|null
     */
    public function getNiveauMaitrise(): ?string{
        return $this->niveauMaitrise;
    }


    // Setter
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
     * @brief Setter pour le nom
     * 
     * @param string|null $nom Nom de la technologie
     * 
     * @return void
     */
    public function setNom(?string $nom): void{
        $this->nom = $nom;
    }

    /**
     * @brief Setter pour le logo
     * 
     * @param string|null $logo Lien relatif vers le logo de la technologie
     * 
     * @return void
     */
    public function setLogo(?string $logo): void{
        $this->logo = $logo;
    }

    /**
     * @brief Setter pour le niveau de maitrise
     * 
     * @param string|null $niveauMaitrise Niveau de maitrise de la technologie
     * 
     * @return void
     */
    public function setNiveauMaitrise(?string $niveauMaitrise): void{
        $this->niveauMaitrise = $niveauMaitrise;
    }
}