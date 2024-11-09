<?php

class Bd{
    // Attributs
    private static ?Bd $instance = null; // Instance de la classe
    private ?PDO $pdo; // Objet PDO


    // Constructeur
    private function __construct(){
        try {
            $this->pdo = new PDO('mysql:host='. DB_HOST . ';dbname='. DB_NAME, DB_USER, DB_PASS);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
    
            die('Connexion à la base de données échouée : ' . $e->getMessage());
        }
    }

    // Méthode propre au Singleton 
    public static function getInstance(): Bd{
        if (self::$instance == null){
            self::$instance = new Bd();
        }
        return self::$instance;
    }

    // Méthode pour récupérer la connexion
    public function getConnexion(): PDO{
        return $this->pdo;
    }

    // Empecher de cloner l'objet
    private function __clone(){

    }

    // Empecher de deserialiser l'objet
    public function __wakeup(){
            throw new Exception("Un singleton ne doit pas être deserialisé");
    }
}