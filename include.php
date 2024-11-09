<?php

//Ajout de l'autoload de composer
require_once 'vendor/autoload.php';

//Ajout du fichier constantes qui permet de configurer le site
require_once 'config/constantes.php';

//Ajout du code pour initialiser twig
require_once 'config/twig.php';

//Ajout du modèle qui gère la connexion mysql
require_once 'modeles/bd.class.php';

// Ajout des contrôleurs
require_once 'controller/controller.class.php';
require_once 'controller/controller_index.class.php';
require_once 'controller/controller_projets.class.php';
// require_once 'controller/controller_contact.class.php';
require_once 'controller/controller_factory.class.php';
require_once 'controller\controller_dashboard.php';

// Ajout des modèles
require_once 'modeles/projet.class.php';
require_once 'modeles/projet.dao.php';
require_once 'modeles/technologie.class.php';
require_once 'modeles/technologie.dao.php';
require_once 'modeles/itemsProjet.class.php';
require_once 'modeles/itemsProjet.dao.php';