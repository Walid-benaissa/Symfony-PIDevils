-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 12 avr. 2023 à 17:26
-- Version du serveur : 10.4.27-MariaDB
-- Version de PHP : 8.2.0

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
  `description` varchar(150) NOT NULL,
  `poids` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `colis`
--

INSERT INTO `colis` (`id`, `nb_items`, `description`, `poids`) VALUES
(1, 3, 'Articles de décoration', 2.5),
(2, 8, 'Achats', 3),
(3, 7, 'Objets', 3);

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE `commentaire` (
  `id` int(11) NOT NULL,
  `id1_id` int(11) NOT NULL,
  `id2_id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `conducteur`
--

CREATE TABLE `conducteur` (
  `utilisateur_id` int(11) NOT NULL,
  `b3` varchar(150) NOT NULL,
  `permis` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `conducteur`
--

INSERT INTO `conducteur` (`utilisateur_id`, `b3`, `permis`) VALUES
(26, 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\large.png', 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\4a6da22d13921ddd495351a2cb442e65.png'),
(27, 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\large.png', 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\4a6da22d13921ddd495351a2cb442e65.png'),
(28, 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\1200px-Fiat_Punto_2012_5door_front.jpg', 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\4a6da22d13921ddd495351a2cb442e65.png');

-- --------------------------------------------------------

--
-- Structure de la table `course`
--

CREATE TABLE `course` (
  `id_course` int(11) NOT NULL,
  `point_depart` varchar(150) NOT NULL,
  `point_destination` varchar(150) NOT NULL,
  `distance` double NOT NULL,
  `prix` double NOT NULL,
  `statut_course` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `course`
--

INSERT INTO `course` (`id_course`, `point_depart`, `point_destination`, `distance`, `prix`, `statut_course`) VALUES
(1, 'Tunis', 'Ariana', 2, 10, 'en cours'),
(2, 'bard', 'm5', 5, 15, 'termine'),
(10, 'bardo', 'lac', 10, 12, 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
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
('DoctrineMigrations\\Version20230409135740', '2023-04-09 15:57:44', 109),
('DoctrineMigrations\\Version20230409161327', '2023-04-11 13:47:50', 35),
('DoctrineMigrations\\Version20230411111404', '2023-04-11 14:18:39', 8),
('DoctrineMigrations\\Version20230411114740', '2023-04-11 14:20:03', 7),
('DoctrineMigrations\\Version20230411122243', '2023-04-11 14:22:48', 22);

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

CREATE TABLE `livraison` (
  `id_livraison` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `id_colis` int(11) DEFAULT NULL,
  `id_livreur` int(11) DEFAULT NULL,
  `adresse_expedition` varchar(150) NOT NULL,
  `adresse_destinataire` varchar(150) NOT NULL,
  `prix` double NOT NULL,
  `etat` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `livraison`
--

INSERT INTO `livraison` (`id_livraison`, `id_client`, `id_colis`, `id_livreur`, `adresse_expedition`, `adresse_destinataire`, `prix`, `etat`) VALUES
(1, 12, 1, 26, 'Ariana', 'Manouba', 4, 'en cours'),
(2, 12, 2, 0, 'Sfax', 'Monastir', 14, 'En attente'),
(3, 12, 3, 0, 'Tunis', 'Zaghouan', 6, 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

CREATE TABLE `location` (
  `id_contrat` varchar(255) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `id_vehicule` int(11) DEFAULT NULL,
  `date_debut` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_fin` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `lieu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `location`
--

INSERT INTO `location` (`id_contrat`, `id`, `id_vehicule`, `date_debut`, `date_fin`, `lieu`) VALUES
('58', 2, 57, '2023-03-09 00:00:00', '2023-03-11 00:00:00', 'kef');

-- --------------------------------------------------------

--
-- Structure de la table `offre_course`
--

CREATE TABLE `offre_course` (
  `id_offre` varchar(255) NOT NULL,
  `matricule_vehicule` int(11) DEFAULT NULL,
  `cin_conducteur` int(11) DEFAULT NULL,
  `nb_passagers` int(11) DEFAULT NULL,
  `options_offre` varchar(255) DEFAULT NULL,
  `statut_offre` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `offre_course`
--

INSERT INTO `offre_course` (`id_offre`, `matricule_vehicule`, `cin_conducteur`, `nb_passagers`, `options_offre`, `statut_offre`) VALUES
('1', 111, 1111, 11, 'NC', 'actif');

-- --------------------------------------------------------

--
-- Structure de la table `offre_livraison`
--

CREATE TABLE `offre_livraison` (
  `id` varchar(255) NOT NULL,
  `prix_livraison` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE `promotion` (
  `id_promotion` varchar(255) NOT NULL,
  `taux` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `promotion`
--

INSERT INTO `promotion` (`id_promotion`, `taux`) VALUES
('1', 0),
('10', 45),
('11', 50),
('12', 55),
('13', 60),
('14', 65),
('15', 70),
('16', 75),
('17', 80),
('18', 85),
('19', 90),
('2', 5),
('3', 10),
('4', 15),
('5', 20),
('6', 25),
('7', 30),
('8', 35),
('9', 40);

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `id` int(11) NOT NULL,
  `message` varchar(150) NOT NULL,
  `etat` varchar(150) NOT NULL,
  `idUser` int(11) DEFAULT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reclamation`
--

INSERT INTO `reclamation` (`id`, `message`, `etat`, `idUser`, `type`) VALUES
(1, 'test1', 'En cours', 12, 'Livraison'),
(3, 'test3', 'En cours', 12, 'Livraison'),
(7, 'test4	 ', 'Ouvert', 26, 'Livraison'),
(8, 'test', 'Ouvert', 26, 'Livraison'),
(9, 'aaaa', 'Ouvert', 26, 'Livraison'),
(10, 'test5', 'Ouvert', 12, 'Livraison');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `num_tel` varchar(20) NOT NULL,
  `role` varchar(30) NOT NULL,
  `evaluation` double NOT NULL,
  `bloque` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `mail`, `mdp`, `num_tel`, `role`, `evaluation`, `bloque`) VALUES
(0, '', '', '', '', '', 'Admin', 0, 0),
(12, 'khaled', 'khaled', 'khaled@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '56765345', 'Client', 0, 0),
(13, 'kharmachi', 'abir', 'abir.kharmachi@gmail.com', '123', '256789467', 'Admin', 0, 0),
(17, 'aziz', 'aziz', 'aziz@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '26786543', 'Client', 0, 0),
(26, 'Ben Ghorbel', 'Nourr', 'nour@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '123456', 'Conducteur', 0, 0),
(27, 'Ben aissa', 'Walid', 'walid@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '123456', 'Conducteur', 0, 0),
(28, 'salah', 'salah', 'abir@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '125425', 'Conducteur', 0, 0),
(29, 'client', 'client', 'client@gmail.com', '$2y$13$qQ06m5aCO4pcLahTGgIphen4MFdbRW9/EOtHvoqP3IzN7b1YyPuoq', 'client', 'Client', 0, 0),
(30, 'admin', 'admin', 'admin@gmail.com', '$2y$13$qQ06m5aCO4pcLahTGgIphen4MFdbRW9/EOtHvoqP3IzN7b1YyPuoq', '25463456', 'Admin', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE `vehicule` (
  `id_vehicule` int(11) NOT NULL,
  `nom_v` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `prix` double NOT NULL,
  `disponibilite` tinyint(1) NOT NULL,
  `description` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`id_vehicule`, `nom_v`, `id`, `image`, `ville`, `prix`, `disponibilite`, `description`, `type`) VALUES
(49, 'khled', 13, 'bmw.png', 'kef', 100, 1, 'dd', 'voiture'),
(50, 'khled', 0, 'bmw.png', 'kef', 100, 1, 'dd', 'voiture'),
(55, 'za', 0, 'bmw.png', 'kef', 6, 1, 'hello', 'voiture'),
(56, 'fiesta', 13, '1200px-Fiat_Punto_2012_5door_front.jpg', 'kef', 30, 1, 'oui', 'voiture'),
(57, 'TOYOTA COROLLA AUTO', 13, 'png-transparent-2018-toyota-corolla-2017-toyota-corolla-2018-toyota-camry-car-toyota-compact-car-sedan-car.png', 'kef', 120, 1, 'Protection contre les dommages résultant d\'une collision ( 1400,00 EUR)Protection contre le vol ( 1400,00 EUR)La participation aux frais d\'immatriculationSurcharge Aéroport/GareTVA incluseContribution environnementale: 7,56 EUR', 'voiture');

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `immatriculation` varchar(30) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `modele` varchar(30) NOT NULL,
  `marque` varchar(30) NOT NULL,
  `etat` varchar(20) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`immatriculation`, `id`, `modele`, `marque`, `etat`, `photo`) VALUES
('123Tun456', 27, 'Fiat', 'Punto', 'neuf', 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\1200px-Fiat_Punto_2012_5door_front.jpg'),
('321Tun123', 26, 'R7', 'Audi', 'Occasion', 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\Audi_RS_7_Sportback_(C8)_–_f_06082021.jpg');

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
  ADD UNIQUE KEY `UNIQ_A60C9F1FA98E9EC9` (`id_colis`),
  ADD KEY `IDX_A60C9F1FE173B1B8` (`id_client`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `commentaire`
--
ALTER TABLE `commentaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `course`
--
ALTER TABLE `course`
  MODIFY `id_course` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `livraison`
--
ALTER TABLE `livraison`
  MODIFY `id_livraison` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `vehicule`
--
ALTER TABLE `vehicule`
  MODIFY `id_vehicule` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

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
