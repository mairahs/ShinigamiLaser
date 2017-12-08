-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 08 déc. 2017 à 13:11
-- Version du serveur :  10.1.22-MariaDB
-- Version de PHP :  7.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `shinigamilaser_test`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'test', 'test@test.com', '$2y$13$AZy/ombkToGecCtZ3O270OqXB/p.JJL2tl2.lRkS3Ap77YmNK9dWK');

-- --------------------------------------------------------

--
-- Structure de la table `avatar`
--

CREATE TABLE `avatar` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `extension` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `card`
--

CREATE TABLE `card` (
  `id` int(11) NOT NULL,
  `player_id` int(11) DEFAULT NULL,
  `command_id` int(11) NOT NULL,
  `number` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `card`
--

INSERT INTO `card` (`id`, `player_id`, `command_id`, `number`, `status`) VALUES
(1, 1, 1, '1234567891', 'active'),
(2, 2, 1, '1234567892', 'active');

-- --------------------------------------------------------

--
-- Structure de la table `command`
--

CREATE TABLE `command` (
  `id` int(11) NOT NULL,
  `etablishment_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `date_of_order` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `command`
--

INSERT INTO `command` (`id`, `etablishment_id`, `quantity`, `price`, `date_of_order`) VALUES
(1, 1, 2, 20, '2017-12-08 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `etablishment`
--

CREATE TABLE `etablishment` (
  `id` int(11) NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `etablishment`
--

INSERT INTO `etablishment` (`id`, `city`, `name`, `code`) VALUES
(1, 'ville', 'etablishment1', 123);

-- --------------------------------------------------------

--
-- Structure de la table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `game_type_id` int(11) DEFAULT NULL,
  `time_slot_id` int(11) DEFAULT NULL,
  `etablishment_id` int(11) DEFAULT NULL,
  `played_at` datetime DEFAULT NULL,
  `booking` tinyint(1) DEFAULT NULL,
  `nb_max` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `game`
--

INSERT INTO `game` (`id`, `game_type_id`, `time_slot_id`, `etablishment_id`, `played_at`, `booking`, `nb_max`) VALUES
(1, 1, 1, 1, '2017-12-08 00:00:00', 1, 12);

-- --------------------------------------------------------

--
-- Structure de la table `game_type`
--

CREATE TABLE `game_type` (
  `id` int(11) NOT NULL,
  `type` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `team` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `game_type`
--

INSERT INTO `game_type` (`id`, `type`, `team`) VALUES
(1, 'team', 1);

-- --------------------------------------------------------

--
-- Structure de la table `player`
--

CREATE TABLE `player` (
  `id` int(11) NOT NULL,
  `avatar_id` int(11) DEFAULT NULL,
  `firstname` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `phone_number` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_birth` datetime NOT NULL,
  `email` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_activate` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `player`
--

INSERT INTO `player` (`id`, `avatar_id`, `firstname`, `lastname`, `address`, `username`, `phone_number`, `date_of_birth`, `email`, `password`, `token`, `is_activate`) VALUES
(1, NULL, 'prenom', 'nom', 'adresse', 'username', '067100000', '2017-12-08 00:00:00', 'test@test.fr', '$2y$13$AZy/ombkToGecCtZ3O270OqXB/p.JJL2tl2.lRkS3Ap77YmNK9dWK', '', 1),
(2, NULL, 'prenom2', 'nom2', 'adresse2', 'username2', '060000000', '2017-12-08 00:00:00', 'test@test.com', '$2y$13$AZy/ombkToGecCtZ3O270OqXB/p.JJL2tl2.lRkS3Ap77YmNK9dWK', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `provider`
--

CREATE TABLE `provider` (
  `id` int(11) NOT NULL,
  `adress` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `score`
--

CREATE TABLE `score` (
  `id` int(11) NOT NULL,
  `cards_id` int(11) DEFAULT NULL,
  `games_id` int(11) DEFAULT NULL,
  `result` int(11) NOT NULL,
  `team` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `time_slot`
--

CREATE TABLE `time_slot` (
  `id` int(11) NOT NULL,
  `type` varchar(55) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `time_slot`
--

INSERT INTO `time_slot` (`id`, `type`) VALUES
(1, '8h-10h');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `avatar`
--
ALTER TABLE `avatar`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_161498D396901F54` (`number`),
  ADD KEY `IDX_161498D399E6F5DF` (`player_id`),
  ADD KEY `IDX_161498D333E1689A` (`command_id`);

--
-- Index pour la table `command`
--
ALTER TABLE `command`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8ECAEAD416BE0BCF` (`etablishment_id`);

--
-- Index pour la table `etablishment`
--
ALTER TABLE `etablishment`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_232B318C508EF3BC` (`game_type_id`),
  ADD KEY `IDX_232B318CD62B0FA` (`time_slot_id`),
  ADD KEY `IDX_232B318C16BE0BCF` (`etablishment_id`);

--
-- Index pour la table `game_type`
--
ALTER TABLE `game_type`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_98197A65F85E0677` (`username`),
  ADD UNIQUE KEY `UNIQ_98197A6586383B10` (`avatar_id`);

--
-- Index pour la table `provider`
--
ALTER TABLE `provider`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `score`
--
ALTER TABLE `score`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_32993751DC555177` (`cards_id`),
  ADD KEY `IDX_3299375197FFC673` (`games_id`);

--
-- Index pour la table `time_slot`
--
ALTER TABLE `time_slot`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `avatar`
--
ALTER TABLE `avatar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `card`
--
ALTER TABLE `card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `command`
--
ALTER TABLE `command`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `etablishment`
--
ALTER TABLE `etablishment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `game_type`
--
ALTER TABLE `game_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `provider`
--
ALTER TABLE `provider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `score`
--
ALTER TABLE `score`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `time_slot`
--
ALTER TABLE `time_slot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `FK_161498D333E1689A` FOREIGN KEY (`command_id`) REFERENCES `command` (`id`),
  ADD CONSTRAINT `FK_161498D399E6F5DF` FOREIGN KEY (`player_id`) REFERENCES `player` (`id`);

--
-- Contraintes pour la table `command`
--
ALTER TABLE `command`
  ADD CONSTRAINT `FK_8ECAEAD416BE0BCF` FOREIGN KEY (`etablishment_id`) REFERENCES `etablishment` (`id`);

--
-- Contraintes pour la table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `FK_232B318C16BE0BCF` FOREIGN KEY (`etablishment_id`) REFERENCES `etablishment` (`id`),
  ADD CONSTRAINT `FK_232B318C508EF3BC` FOREIGN KEY (`game_type_id`) REFERENCES `game_type` (`id`),
  ADD CONSTRAINT `FK_232B318CD62B0FA` FOREIGN KEY (`time_slot_id`) REFERENCES `time_slot` (`id`);

--
-- Contraintes pour la table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `FK_98197A6586383B10` FOREIGN KEY (`avatar_id`) REFERENCES `avatar` (`id`);

--
-- Contraintes pour la table `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `FK_3299375197FFC673` FOREIGN KEY (`games_id`) REFERENCES `game` (`id`),
  ADD CONSTRAINT `FK_32993751DC555177` FOREIGN KEY (`cards_id`) REFERENCES `card` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
