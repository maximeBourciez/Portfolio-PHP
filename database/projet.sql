-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql-5.7
-- Généré le : lun. 16 déc. 2024 à 20:09
-- Version du serveur : 5.7.28
-- Version de PHP : 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `mbourciez_bd`
--

-- --------------------------------------------------------

--
-- Structure de la table `projet`
--

CREATE TABLE `projet` (
  `id` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` text,
  `descriptionLongue` text,
  `imageCover` varchar(255) DEFAULT NULL,
  `annee` year(4) DEFAULT NULL,
  `type` enum('Universitaire','Personnel','Professionnel') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `projet`
--

INSERT INTO `projet` (`id`, `titre`, `description`, `descriptionLongue`, `imageCover`, `annee`, `type`) VALUES
(1, 'Lecteur de diaporamas', 'Ce projet consistait à réaliser le développement d\'un lecteur de diaporamas.', 'Ce projet Qt est une application conçue pour afficher et gérer des diaporamas. Développée dans le cadre d\'une projet Universitaire, elle offre une interface simple permettant de parcourir, visualiser et organiser des images sous forme de présentations. Ce lecteur intègre des fonctionnalités de navigation, de gestion des transitions, et d’ajout de contenu personnalisé pour s’adapter aux besoins des utilisateurs. Les images sont stockées dans une base de données.', 'assets/coversProjets/lecteur_diapo.png', 2024, 'Universitaire'),
(2, 'Exploitation de graphes', 'Dans ce projet universitaire, nous devions en binôme exploiter des algorithmes de graphes.', 'Ce projet Python est une application développée pour explorer et résoudre un problème algorithmique spécifique. Elle propose des outils d’analyse et d’expérimentation permettant de tester et d’optimiser des algorithmes en fonction de divers paramètres, tout en offrant une interface claire pour visualiser les résultats et les comparer. nous aovns eu à coder des algorithmes tels que Djikstra ou Floyd-Warshall et montrer leurs résultats via une interface.', 'assets/coversProjets/algo_graphes.PNG', 2024, 'Universitaire'),
(3, 'Installation d\'un réseau', 'Lors de ce projet universitaire, nous devions mettre en place un réseau complet.', 'Lors de ce projet universitaire, nous devions créer une environnement communiquant de 0. Nous sommes passés par le plan d\'adressage, les configurations des routes, des services DHCP et SFTP pour finalement avoir un réseau conforme aux requis du sujet.', 'assets/coversProjets/reseau.png', 2024, 'Universitaire'),
(4, 'Graphiques en python', 'Lors de ce projet, nous avons eu à exploiter des données pour créer des graphiques en Python.', 'Ce projet Python & SQL est une application en terminal dédiée à la gestion et à l’exploitation de bases de données. Il permet de manipuler, interroger et analyser les données grâce à des outils intuitifs et des fonctionnalités adaptées, tout en respectant les principes fondamentaux de la modélisation et des requêtes SQL.', 'assets/coversProjets/algo_graphes.png', 2024, 'Universitaire'),
(5, 'Création et exploitation d\'une BDD', 'Lors de ce projet universitaire, nous avons par trois créé et exploité une base de données.', 'Ce projet universitaire consistait en l\'élaboration d\'une base de données pour une chaîne de magasin fictive. Nous devions, en binômes, concecoir une base de données complexe et ensuite la créer sur un SGBD puis l\'exploiter via MySQL WorkBench.', 'assets/coversProjets/conception_BD.png', 2023, 'Universitaire'),
(6, 'Gestion d\'un projet', 'Lors de ce projet universitaire, nous avons par groupe géré un projet complet de A à Z.', 'Ce projet universitaire consistait à la rédaction d\'un cahier des charges complet pour une application web responsive, que nous développons l\'anée suivante. Nous avions, par équipe de 5, le choix du sujet de notre application et devions rédiger les scénarion UML, fait les maquettes du site et établi tous les tenants et aboutissants de notre application', 'assets/coversProjets/conception_UML.png', 2024, 'Universitaire'),
(7, 'Bataille Navale', 'Lors de ce projet universitaire, nous avons eu à créer une version numérique du jeu Bataille Navale.', 'Ce projet C++ consistait en l\'élaboration d\'algorithmes permettant la mise en place du jeu de la Bataille Navale en terminal dans une version un peu adaptée. Nous devions, par 2, trouver des solutions aux problèmes ciblés par le sujet pour développer une application en terminal en C++. ', 'assets/coversProjets/bataille_navale.png', 2024, 'Universitaire'),
(8, 'Video Home Share', 'VHS est une application web combinant forum, réseau social et visionnage synchronisé pour permettre aux cinéphiles de débattre, jouer et partager leurs films et séries favoris.', 'Le projet \"VHS - Video Home Share\" est une application web qui vise à recréer la convivialité du visionnage partagé de films et de séries. Elle combine les fonctionnalités d\'un forum thématique, d\'un réseau social et d\'un service \"Watch Together\". Les utilisateurs peuvent discuter, débattre, jouer à des mini-jeux, créer des listes de visionnage personnalisées et participer à des quiz, le tout dans une ambiance interactive et communautaire. L\'application cible les cinéphiles et sériephiles, avec un accent sur la modération et l\'accessibilité pour garantir une expérience utilisateur positive et inclusive.', 'assets/coversProjets/vhs.png', 2024, 'Universitaire'),
(9, 'War.net', 'Ce site web était un projet final d\'apprentissage du PHP, qui consistait en un site de vente de matériel militaire en ligne', NULL, 'assets/coversProjets/warnet.png', 2024, 'Universitaire');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `projet`
--
ALTER TABLE `projet`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `projet`
--
ALTER TABLE `projet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
