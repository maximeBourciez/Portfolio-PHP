<?php

/**
 * @file index.php
 * 
 * @brief Point d'entrée de l'application
 * 
 * @details Ce fichier est le point d'entrée de l'application. Il permet de rediriger les requêtes vers les bons contrôleurs et méthodes.
 * 
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 */

//Ajout du code commun à toutes les pages
require_once 'include.php';

try  {
    if (isset($_GET['controller'])){
        $controllerName=$_GET['controller'];
    }else{
        $controllerName='';
    }

    if (isset($_GET['methode'])){
        $methode=$_GET['methode'];
    }else{
        $methode='';
    }


    //Gestion de la page d'accueil par défaut
    if ($controllerName == '' && $methode ==''){
        $controllerName='index';
        $methode='index';
    }

    if ($controllerName == '' ){
        throw new Exception('Le controleur n\'est pas défini');
    }

    if ($methode == '' ){
        throw new Exception('La méthode n\'est pas définie');
    }

    

    $controller = ControllerFactory::getController($controllerName, $loader, $twig);
  
    $controller->call($methode);
}catch (Exception $e) {
   die('Erreur : ' . $e->getMessage());
}