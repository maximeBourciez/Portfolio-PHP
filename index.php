<?php

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

    // Affichage des variables
    echo 'controllerName : '.$controllerName.'<br>';
    echo 'methode : '.$methode.'<br>';

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