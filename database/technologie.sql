-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : mysql-5.7
-- Généré le : lun. 16 déc. 2024 à 20:10
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
-- Structure de la table `technologie`
--

CREATE TABLE `technologie` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `niveauMaitrise` varchar(50) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `technologie`
--

INSERT INTO `technologie` (`id`, `nom`, `niveauMaitrise`, `logo`) VALUES
(1, 'C++', 'Intermédiaire', NULL),
(2, 'Python', 'Intermédiaire', NULL),
(3, 'Bash', 'Débutant', NULL),
(4, 'Rédaction', 'Intermédiaire', 'assets/redaction-logo.png'),
(5, 'UML', 'Confirmé', 'assets/uml-logo.png'),
(6, 'SQL', 'Confirmé', 'assets/sql-logo.png'),
(7, 'Qt', 'Intermédiaire', 'assets/qt-logo.png'),
(8, 'HTML', 'Confirmé', 'assets/html-logo.png'),
(9, 'CSS', 'Confirmé', 'assets/css-logo.png'),
(10, 'JS', 'Intermédiaire', 'assets/js-logo.png'),
(11, 'Bootstrap', 'Intermédiaire', 'assets/bootstrap-logo.png'),
(12, 'Twig', 'Confirmé', 'assets/twig-logo.png'),
(13, 'PHP', 'Confirmé', 'assets/php-logo.png');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `technologie`
--
ALTER TABLE `technologie`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `technologie`
--
ALTER TABLE `technologie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
