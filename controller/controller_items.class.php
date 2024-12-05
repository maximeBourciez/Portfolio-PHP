<?php

/**
 * @file controller/controller_items.class.php
 * @brief Ce fichier définit la classe de contrôleur des items
 * @date 26/11/2024 
 * @version 1.0
 * @author Maxime Bourciez <maxime.bourciez@gmail.com>
 */
class ControllerItems extends Controller{
    /**
     * 
     * @brief Méthode pour créer un item
     * @return void
     */
    public function createItem(){
        // Vérifier que 'id_projet' existe dans $_GET
        if (!isset($this->getGet()['id_projet'])) {
            die('L\'ID du projet est manquant.');
        }
        else{
            // Récupérer l'id du projet et le transformer en entier
            $idProjet = intval($this->getGet()['id_projet']);        
        }    
    
        // Récupérer les saisies du formulaire
        $titre = $this->getPost()['titre'];
        $description = $this->getPost()['description'];
        $imageCover = $_FILES['imageCover'];

        // Modifier le nom de l'image
        $path = $idProjet . '_' . trim($titre) . '.' . pathinfo($imageCover['name'], PATHINFO_EXTENSION);
        
        // Vérifier si l'image a été uploadée
        if ($imageCover['size'] > 0) {
            // Déplacer l'image
            $path = 'assets/coversItems/' . $imageCover['name'];
            move_uploaded_file($imageCover['tmp_name'], $path);
        } else {
            $path = '';
        }
    
        // Passer les données pour la création de l'item
        $managerItem = new ItemsProjetDAO($this->getPdo());
        $itemToCreate = new ItemsProjet(0, $idProjet, $titre, $description, $path);
        $managerItem->add($itemToCreate);

        // Rediriger vers la page du projet
        header('Location: index.php?controller=projets&methode=show&id_projet=' . $idProjet);
    }

    /**
     * 
     * @brief Méthode pour supprimer un item
     * @return void
     */
    public function delete(){
        // Vérifier que 'id' existe dans $_GET
        if (!isset($this->getGet()['id_item'])) {
            die('L\'ID de l\'item est manquant.');
        }
        else{
            // Récupérer l'id de l'item et le transformer en entier
            $idItem = intval($this->getGet()['id_item']);        
        }    

        // Récupérer l'id du projet
        $idProjet = intval($this->getGet()['id_projet']);

        // Passer les données pour la suppression de l'item
        $managerItem = new ItemsProjetDAO($this->getPdo());
        $managerItem->delete($idItem);

        // Rediriger vers la page du projet
        header('Location: index.php?controller=projets&methode=show&id_projet=' . $idProjet);
    }
}