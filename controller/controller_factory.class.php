<?php

/**
 * 
 * @brief Classe ControllerFactory - Factory pour les controllers
 * 
 * @details Classe qui contient la méthode pour récupérer un controller en fonction de son nom
 * 
 * @warning C'est une version simplifiée du design pattern Factory
 * 
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 * 
 * @date 5 Novembre 2024
 */
class ControllerFactory
{
    /**
     * @brief Méthode pour récupérer un controller
     * @param mixed $controleur
     * @param Twig\Loader\FilesystemLoader $loader
     * @param Twig\Environment $twig
     * @throws \Exception
     * @return mixed - Controller enfant
     */
    public static function getController($controleur, \Twig\Loader\FilesystemLoader $loader, \Twig\Environment $twig)
    {
        $controllerName="Controller".ucfirst($controleur);
        if (!class_exists($controllerName)) {
            throw new Exception("Le controleur $controllerName n'existe pas");
        }
        return new $controllerName($twig, $loader);

    }
}