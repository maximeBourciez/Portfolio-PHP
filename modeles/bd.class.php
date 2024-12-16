<?php

/**
 * @brief Classe Bd - Singleton pour la connexion à la base de données
 * 
 * @date 5 Novembre 2024
 * 
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 */
class Bd{
    // Attributs
     /**
     * @brief Instance unique de la classe Bd
     * @var Bd|null $instance Instance de la classe 
     * @private
     */
    private static ?Bd $instance = null; 
    /**
     * @var PDO $pdo Objet PDO pour la connexion à la base de données
     */
    private ?PDO $pdo; 


    /**
     * @brief Constructeur de la classe
     * 
     * @details Constructeur privé pour empêcher l'instanciation de la classe depuis l'extérieur
     * 
     */
    private function __construct(){
        try {
            $this->pdo = new PDO('mysql:host='. DB_HOST . ';dbname='. DB_NAME . ';charset=utf8mb4', DB_USER, DB_PASS);            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
    
            die('Connexion à la base de données échouée : ' . $e->getMessage());
        }
    }

    /**
     * @brief Méthode pour récupérer l'instance de la classe
     * 
     * @return Bd
     */
    public static function getInstance(): Bd{
        if (self::$instance == null){
            self::$instance = new Bd();
        }
        return self::$instance;
    }

    /**
     * @brief Méthode pour récupérer la connexion à la base de données
     * 
     * @return PDO
     */
    public function getConnexion(): PDO{
        return $this->pdo;
    }

    /**
     * 
     * @brief Méthode pour empêcher le clonage de l'objet
     * 
     * @return void
     */
    private function __clone(){

    }

    /**
     * 
     * @brief Méthode pour empêcher la désérialisation de l'objet
     * 
     * @return void
     */
    public function __wakeup(){
            throw new Exception("Un singleton ne doit pas être deserialisé");
    }
}