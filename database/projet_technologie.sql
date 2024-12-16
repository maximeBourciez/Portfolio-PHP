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
-- Structure de la table `projet_technologie`
--

CREATE TABLE `projet_technologie` (
  `projet_id` int(11) NOT NULL,
  `technologie_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `projet_technologie`
--

INSERT INTO `projet_technologie` (`projet_id`, `technologie_id`) VALUES
(1, 1),
(7, 1),
(2, 2),
(4, 2),
(3, 3),
(6, 4),
(6, 5),
(5, 6),
(1, 7),
(8, 8),
(8, 9),
(8, 10),
(8, 11),
(9, 11),
(8, 12),
(9, 13);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `projet_technologie`
--
ALTER TABLE `projet_technologie`
  ADD PRIMARY KEY (`projet_id`,`technologie_id`),
  ADD KEY `technologie_id` (`technologie_id`);

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `projet_technologie`
--
ALTER TABLE `projet_technologie`
  ADD CONSTRAINT `projet_technologie_ibfk_1` FOREIGN KEY (`projet_id`) REFERENCES `projet` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projet_technologie_ibfk_2` FOREIGN KEY (`technologie_id`) REFERENCES `technologie` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
