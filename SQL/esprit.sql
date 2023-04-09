-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 09 avr. 2023 à 15:59
-- Version du serveur : 10.4.22-MariaDB
-- Version de PHP : 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `esprit`
--

-- --------------------------------------------------------

--
-- Structure de la table `colis`
--

CREATE TABLE `colis` (
  `id` int(11) NOT NULL,
  `nb_items` int(11) NOT NULL,
  `description` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `poids` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `id1_id` int(11) NOT NULL,
  `id2_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `conducteur`
--

CREATE TABLE `conducteur` (
  `utilisateur_id` int(11) NOT NULL,
  `b3` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `permis` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `course`
--

CREATE TABLE `course` (
  `id_course` int(11) NOT NULL,
  `point_depart` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `point_destination` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `distance` double NOT NULL,
  `prix` double NOT NULL,
  `statut_course` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230409135410', '2023-04-09 15:54:12', 537),
('DoctrineMigrations\\Version20230409135530', '2023-04-09 15:55:34', 11),
('DoctrineMigrations\\Version20230409135623', '2023-04-09 15:56:26', 28),
('DoctrineMigrations\\Version20230409135740', '2023-04-09 15:57:44', 109);

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

CREATE TABLE `livraison` (
  `id_livraison` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `id_colis` int(11) DEFAULT NULL,
  `id_livreur` int(11) DEFAULT NULL,
  `adresse_expedition` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse_destinataire` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `etat` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

CREATE TABLE `location` (
  `id_contrat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id` int(11) DEFAULT NULL,
  `id_vehicule` int(11) DEFAULT NULL,
  `date_debut` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_fin` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `lieu` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offre_course`
--

CREATE TABLE `offre_course` (
  `id_offre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `matricule_vehicule` int(11) DEFAULT NULL,
  `cin_conducteur` int(11) DEFAULT NULL,
  `nb_passagers` int(11) DEFAULT NULL,
  `options_offre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut_offre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `offre_livraison`
--

CREATE TABLE `offre_livraison` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix_livraison` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE `promotion` (
  `id_promotion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taux` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `id` int(11) NOT NULL,
  `message` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdp` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `num_tel` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `evaluation` double NOT NULL,
  `bloque` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE `vehicule` (
  `id_vehicule` int(11) NOT NULL,
  `nom_v` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id` int(11) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` double NOT NULL,
  `disponibilite` tinyint(1) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `immatriculation` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id` int(11) DEFAULT NULL,
  `modele` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `marque` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `etat` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `colis`
--
ALTER TABLE `colis`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_67F068BC231CAD5A` (`id1_id`),
  ADD KEY `IDX_67F068BC31A902B4` (`id2_id`);

--
-- Index pour la table `conducteur`
--
ALTER TABLE `conducteur`
  ADD PRIMARY KEY (`utilisateur_id`);

--
-- Index pour la table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id_course`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD PRIMARY KEY (`id_livraison`),
  ADD KEY `IDX_A60C9F1FE173B1B8` (`id_client`),
  ADD KEY `IDX_A60C9F1FA98E9EC9` (`id_colis`),
  ADD KEY `IDX_A60C9F1F35E7E71D` (`id_livreur`);

--
-- Index pour la table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id_contrat`);

--
-- Index pour la table `offre_course`
--
ALTER TABLE `offre_course`
  ADD PRIMARY KEY (`id_offre`);

--
-- Index pour la table `offre_livraison`
--
ALTER TABLE `offre_livraison`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `promotion`
--
ALTER TABLE `promotion`
  ADD PRIMARY KEY (`id_promotion`);

--
-- Index pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_CE606404FE6E88D7` (`idUser`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`id_vehicule`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`immatriculation`),
  ADD KEY `IDX_E9E2810FBF396750` (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `colis`
--
ALTER TABLE `colis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `course`
--
ALTER TABLE `course`
  MODIFY `id_course` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `livraison`
--
ALTER TABLE `livraison`
  MODIFY `id_livraison` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `vehicule`
--
ALTER TABLE `vehicule`
  MODIFY `id_vehicule` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BC231CAD5A` FOREIGN KEY (`id1_id`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_67F068BC31A902B4` FOREIGN KEY (`id2_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `conducteur`
--
ALTER TABLE `conducteur`
  ADD CONSTRAINT `FK_23677143FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD CONSTRAINT `FK_A60C9F1F35E7E71D` FOREIGN KEY (`id_livreur`) REFERENCES `utilisateur` (`id`),
  ADD CONSTRAINT `FK_A60C9F1FA98E9EC9` FOREIGN KEY (`id_colis`) REFERENCES `colis` (`id`),
  ADD CONSTRAINT `FK_A60C9F1FE173B1B8` FOREIGN KEY (`id_client`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `FK_CE606404FE6E88D7` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `FK_E9E2810FBF396750` FOREIGN KEY (`id`) REFERENCES `utilisateur` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
