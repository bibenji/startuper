-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : devtools_database
-- Généré le :  jeu. 25 oct. 2018 à 17:33
-- Version du serveur :  10.3.9-MariaDB-1:10.3.9+maria~bionic
-- Version de PHP :  7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `startuper_database`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updatedAt` datetime DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `categories` varchar(255) NOT NULL,
  `resume` mediumtext DEFAULT NULL,
  `content` text NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`id`, `createdAt`, `updatedAt`, `title`, `categories`, `resume`, `content`, `published`) VALUES
(1, '2018-10-15 10:41:59', NULL, 'Migrer vers Symfony 4', 'PHP,Symfony', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sollicitudin mauris magna, vitae vehicula diam ullamcorper a. Maecenas scelerisque nec quam in pellentesque. Mauris semper sapien justo, et scelerisque erat pulvinar in. Aenean a efficitur est, et bibendum mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per. ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sollicitudin mauris magna, vitae vehicula diam ullamcorper a. Maecenas scelerisque nec quam in pellentesque. Mauris semper sapien justo, et scelerisque erat pulvinar in. Aenean a efficitur est, et bibendum mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per. ', 1),
(2, '2018-10-15 10:42:45', NULL, 'Déployer son application sur un Orange Pi', 'Serveur,Pi,Ops', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sollicitudin mauris magna, vitae vehicula diam ullamcorper a. Maecenas scelerisque nec quam in pellentesque. Mauris semper sapien justo, et scelerisque erat pulvinar in. Aenean a efficitur est, et bibendum mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per. ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sollicitudin mauris magna, vitae vehicula diam ullamcorper a. Maecenas scelerisque nec quam in pellentesque. Mauris semper sapien justo, et scelerisque erat pulvinar in. Aenean a efficitur est, et bibendum mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per. ', 1),
(3, '2018-10-15 10:43:58', NULL, 'La récursivité en PHP', 'PHP,Algorithme', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sollicitudin mauris magna, vitae vehicula diam ullamcorper a. Maecenas scelerisque nec quam in pellentesque. Mauris semper sapien justo, et scelerisque erat pulvinar in. Aenean a efficitur est, et bibendum mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per. ', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse sollicitudin mauris magna, vitae vehicula diam ullamcorper a. Maecenas scelerisque nec quam in pellentesque. Mauris semper sapien justo, et scelerisque erat pulvinar in. Aenean a efficitur est, et bibendum mi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per. ', 0);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `comment_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `comment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `comment_id`, `user_id`, `date`, `comment`) VALUES
(1, 2, NULL, 1, '2018-10-18 00:00:00', 'Franchement c\'est pas simple avec un Orange Pi Zero...');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `password` varchar(255) NOT NULL DEFAULT '123',
  `startuper` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `firstname`, `lastname`, `birthdate`, `sex`, `description`, `password`, `startuper`) VALUES
(1, 'benjix', 'benjamin.billette@hotmail.fr', 'Benjamin', 'Billette', '1987-03-26', 0, 'Bonjour, je suis Benjamin !', '123', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_ARTICLE_ID` (`article_id`),
  ADD KEY `FK_COMMENT_ID` (`comment_id`),
  ADD KEY `FK_USER_ID` (`user_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_ARTICLE_ID` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  ADD CONSTRAINT `FK_COMMENT_ID` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `FK_USER_ID` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
