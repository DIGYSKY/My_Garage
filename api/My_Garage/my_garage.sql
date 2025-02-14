-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Hôte : MySQL:3306
-- Généré le : mar. 11 fév. 2025 à 15:13
-- Version du serveur : 8.0.41
-- Version de PHP : 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "Europe/Paris";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `my_garage`
--
CREATE DATABASE IF NOT EXISTS `my_garage` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `my_garage`;

-- --------------------------------------------------------

--
-- Structure de la table `persos`
--

CREATE TABLE `cars` (
  `id` int NOT NULL,
  `litle_name` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `model` varchar(255) NOT NULL,
  `first_registration_date` date NOT NULL,
  `price` int NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Structure de la table `Documents`
--

CREATE TABLE `documents` (
  `id` int NOT NULL,
  `id_cars` int NOT NULL REFERENCES `cars`(`id`),
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
--
-- Index pour les tables déchargées
--

--
-- Index pour la table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

-- --------------------------------------------------------

-- Fake data

INSERT INTO `cars` (`id`, `litle_name`, `brand`, `model`, `first_registration_date`, `price`, `updated_at`, `created_at`) VALUES
(1, 'Clio', 'Renault', 'Clio 3', '2010-01-01', 10000, '2021-01-01 00:00:00', '2021-01-01 00:00:00'),
(2, '308', 'Peugeot', '308', '2012-01-01', 15000, '2021-01-01 00:00:00', '2021-01-01 00:00:00'),
(3, 'A4', 'Audi', 'A4', '2015-01-01', 20000, '2021-01-01 00:00:00', '2021-01-01 00:00:00');

INSERT INTO `documents` (`id`, `id_cars`, `name`, `description`, `type`, `path`, `updated_at`, `created_at`) VALUES
(1, 1, 'Certificat de propriété', 'Certificat de propriété', 'image', 'certificat_propriete.jpg', '2021-01-01 00:00:00', '2021-01-01 00:00:00'),
(2, 1, 'Carte grise', 'Carte grise', 'image', 'carte_grise.jpg', '2021-01-01 00:00:00', '2021-01-01 00:00:00'),
(3, 1, 'Contrôle technique', 'Contrôle technique', 'image', 'controle_technique.jpg', '2021-01-01 00:00:00', '2021-01-01 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
