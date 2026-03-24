-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 24 mars 2026 à 19:14
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `cyber`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$5PApFw.PqHqjDEJI/PkmkOkKgkb/pP0RhPPCbtFO68bnY5S2B27Py');

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `date_inscription` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom`, `telephone`, `email`, `date_inscription`) VALUES
(1, 'Oumar Mahadjir', '690000001', 'oumar@gmail.com', '2026-03-22 17:02:29'),
(2, 'Ali Moussa', '690000002', 'ali@gmail.com', '2026-03-22 17:02:29'),
(3, 'Fatima Bello', '690000003', 'fatima@gmail.com', '2026-03-22 17:02:29'),
(4, 'oumar', '655925433', NULL, '2026-03-22 19:01:09'),
(6, 'oumar', '56787655567', NULL, '2026-03-23 11:47:36'),
(7, 'oumar', '56787655567', NULL, '2026-03-23 14:46:15'),
(8, 'ibra', '655887766', NULL, '2026-03-23 22:08:37'),
(9, 'El Umari', '567889477', NULL, '2026-03-23 23:40:42');

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

CREATE TABLE `paiements` (
  `id` int(11) NOT NULL,
  `reservation_id` int(11) DEFAULT NULL,
  `montant` decimal(10,2) DEFAULT NULL,
  `mode_paiement` varchar(50) DEFAULT NULL,
  `date_paiement` timestamp NOT NULL DEFAULT current_timestamp(),
  `statut` varchar(50) DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `paiements`
--

INSERT INTO `paiements` (`id`, `reservation_id`, `montant`, `mode_paiement`, `date_paiement`, `statut`) VALUES
(1, 1, 600.00, 'cash', '2026-03-22 17:04:26', 'payé'),
(2, 2, 300.00, 'MTN Mobile Money', '2026-03-22 17:04:26', 'payé'),
(3, 3, 50.00, 'Orange Money', '2026-03-22 17:04:26', 'payé'),
(4, 5, 900.00, 'cash', '2026-03-23 11:47:36', 'payé'),
(5, 6, 0.00, 'Orange Money', '2026-03-23 14:46:15', 'payé'),
(6, 7, 9000.00, 'MTN Mobile Money', '2026-03-23 22:08:37', 'payé'),
(7, 8, 500.00, 'MTN Mobile Money', '2026-03-23 23:40:42', 'payé');

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `service_id` int(11) DEFAULT NULL,
  `date_reservation` date DEFAULT NULL,
  `heure_debut` time DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `statut` varchar(50) DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`id`, `client_id`, `service_id`, `date_reservation`, `heure_debut`, `duree`, `statut`) VALUES
(1, 1, 1, '2026-03-23', '08:00:00', 2, 'validée'),
(2, 2, 1, '2026-03-23', '10:00:00', 1, 'en attente'),
(3, 3, 2, '2026-03-23', '11:30:00', 1, 'terminée'),
(4, 4, 8, '2026-03-03', '00:00:00', 2, 'en attente'),
(5, 6, 1, '2026-03-24', '15:50:00', 3, 'en attente'),
(6, 7, 8, '2026-03-11', '17:50:00', 7, 'en attente'),
(7, 8, 8, '2026-03-24', '02:14:00', 9, 'en attente'),
(8, 9, 7, '2026-03-24', '00:42:00', 1, 'en attente');

-- --------------------------------------------------------

--
-- Structure de la table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `nom_service` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `services`
--

INSERT INTO `services` (`id`, `nom_service`, `description`) VALUES
(1, 'Internet', 'Navigation rapide'),
(2, 'Impression', 'Impression de documents'),
(3, 'Scan', 'Numérisation de documents'),
(7, 'Jeux', 'Jeux vidéo sur PC'),
(8, 'Formation', 'Formation bureautique');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `client_id` int(11) DEFAULT NULL,
  `heure_debut` datetime DEFAULT NULL,
  `heure_fin` datetime DEFAULT NULL,
  `duree` int(11) DEFAULT NULL,
  `statut` varchar(50) DEFAULT 'en cours'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `client_id`, `heure_debut`, `heure_fin`, `duree`, `statut`) VALUES
(1, 8, '2026-03-23 23:10:54', '2026-03-24 00:10:54', 1, 'terminée'),
(2, 1, '2026-03-23 23:11:18', '2026-03-24 04:11:18', 5, 'terminée'),
(3, 1, '2026-03-23 23:21:09', '2026-03-24 00:21:09', 1, 'terminée'),
(4, 1, '2026-03-23 23:39:45', '2026-03-24 00:39:45', 1, 'terminée'),
(5, 1, '2026-03-23 23:48:35', '2026-03-24 00:48:35', 1, 'terminée'),
(6, 3, '2026-03-23 23:49:17', '2026-03-24 00:49:17', 1, 'terminée'),
(7, 2, '2026-03-23 23:49:34', '2026-03-24 00:49:34', 1, 'terminée'),
(8, 2, '2026-03-23 23:50:03', '2026-03-24 04:50:03', 5, 'terminée'),
(9, 1, '2026-03-24 00:22:43', '2026-03-24 01:22:43', 1, 'terminée'),
(10, 1, '2026-03-24 17:02:43', '2026-03-24 18:02:43', 1, 'en cours'),
(11, 2, '2026-03-24 17:02:52', '2026-03-24 18:02:52', 1, 'en cours'),
(12, 1, '2026-03-24 17:03:57', '2026-03-24 18:03:57', 1, 'en cours');

-- --------------------------------------------------------

--
-- Structure de la table `tarifs`
--

CREATE TABLE `tarifs` (
  `id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `unite` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `tarifs`
--

INSERT INTO `tarifs` (`id`, `service_id`, `prix`, `unite`) VALUES
(1, 1, 300.00, 'heure'),
(2, 2, 50.00, 'page'),
(3, 3, 100.00, 'document'),
(9, 7, 500.00, 'heure'),
(10, 8, 1000.00, 'heure');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reservation_id` (`reservation_id`);

--
-- Index pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Index pour la table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tarifs`
--
ALTER TABLE `tarifs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `service_id` (`service_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `paiements`
--
ALTER TABLE `paiements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `tarifs`
--
ALTER TABLE `tarifs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `paiements`
--
ALTER TABLE `paiements`
  ADD CONSTRAINT `paiements_ibfk_1` FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tarifs`
--
ALTER TABLE `tarifs`
  ADD CONSTRAINT `tarifs_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
