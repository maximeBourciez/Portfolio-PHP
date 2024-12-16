<?php

/**
 * 
 * @brief Classe Controller - Classe mère des controllers
 * 
 * @details Classe qui contient les attributs et méthodes communs à tous les controllers
 * 
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 * 
 * @date 5 Novembre 2024
 * 
 */
class Controller{
    private PDO $pdo;
    private \Twig\Loader\FilesystemLoader $loader;
    private \Twig\Environment $twig;
    private ?array $get = null;
    private ?array $post =null;
    private ?array $files = null;

   public function __construct(\Twig\Environment $twig, \Twig\Loader\FilesystemLoader $loader) {
        $db = Bd::getInstance();
        $this->pdo = $db->getConnexion();

        $this->loader = $loader;    
        $this->twig = $twig;

        if (isset($_GET) && !empty($_GET)){
            $this->get = $_GET;
        }
        if (isset($_POST) && !empty($_POST)){
            $this->post = $_POST;
        }
        if (isset($_FILES) && !empty($_FILES)){
            $this->files = $_FILES;
        }

        // Vérifier la session
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function call(string $methode): mixed{

        if (!method_exists($this, $methode)){
            throw new Exception("La méthode $methode n'existe pas dans le controller ". __CLASS__ ); 
        }
        return $this->$methode();
        
    }

    


    /**
     * Get the value of pdo
     */ 
    public function getPdo(): ?PDO
    {
        return $this->pdo;
    }

    /**
     * Set the value of pdo
     *
     */ 
    public function setPdo(?PDO $pdo):void
    {
        $this->pdo = $pdo;


    }

    /**
     * Get the value of loader
     */ 
    public function getLoader(): \Twig\Loader\FilesystemLoader
    {
        return $this->loader;
    }

    /**
     * Set the value of loader
     *
     */ 
    public function setLoader(\Twig\Loader\FilesystemLoader $loader) :void
    {
        $this->loader = $loader;

    }

    

    /**
     * Get the value of twig
     */ 
    public function getTwig(): \Twig\Environment
    {
        return $this->twig;
    }

    /**
     * Set the value of twig
     *
     */ 
    public function setTwig(\Twig\Environment $twig): void
    {
        $this->twig = $twig;

    }

    

    /**
     * Get the value of get
     */ 
    public function getGet(): ?array
    {
        return $this->get;
    }

    /**
     * Set the value of get
     *
     */ 
    public function setGet(?array $get): void
    {
        $this->get = $get;

    }

    /**
     * Get the value of post
     */ 
    public function getPost(): ?array
    {
        return $this->post;
    }

    /**
     * Set the value of post
     *

     */ 
    public function setPost(?array $post): void
    {
        $this->post = $post;


    }

    /**
     * Get the value of files
     */
    public function getFiles(): ?array
    {
        return $this->files;
    }

    /**
     * Set the value of files
     *
     */
    public function setFiles(?array $files): void
    {
        $this->files = $files;

    }
}







