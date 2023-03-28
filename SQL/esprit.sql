-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 28 mars 2023 à 22:53
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
  `description` varchar(250) NOT NULL,
  `poids` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `id1` int(11) NOT NULL,
  `id2` int(11) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `conducteur`
--

CREATE TABLE `conducteur` (
  `id` int(11) NOT NULL,
  `b3` varchar(255) NOT NULL,
  `permis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `conducteur`
--

INSERT INTO `conducteur` (`id`, `b3`, `permis`) VALUES
(26, 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\large.png', 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\4a6da22d13921ddd495351a2cb442e65.png'),
(27, 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\large.png', 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\4a6da22d13921ddd495351a2cb442e65.png'),
(28, 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\1200px-Fiat_Punto_2012_5door_front.jpg', 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\4a6da22d13921ddd495351a2cb442e65.png');

-- --------------------------------------------------------

--
-- Structure de la table `course`
--

CREATE TABLE `course` (
  `id_course` int(11) NOT NULL,
  `point_depart` varchar(255) NOT NULL,
  `point_destination` varchar(255) NOT NULL,
  `distance` float NOT NULL,
  `prix` float NOT NULL,
  `statut_course` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `course`
--

INSERT INTO `course` (`id_course`, `point_depart`, `point_destination`, `distance`, `prix`, `statut_course`) VALUES
(1, 'Tunis', 'Ariana', 2, 10, 'en cours'),
(2, 'bard', 'm5', 5, 15, 'termine'),
(10, 'bardo', 'lac', 10, 12, 'En attente');

-- --------------------------------------------------------

--
-- Structure de la table `livraison`
--

CREATE TABLE `livraison` (
  `id_client` int(11) NOT NULL,
  `id_livreur` int(11) NOT NULL,
  `id_livraison` int(11) NOT NULL,
  `adresse_expedition` varchar(30) NOT NULL,
  `adresse_destinataire` varchar(30) NOT NULL,
  `prix` float NOT NULL,
  `etat` varchar(30) NOT NULL,
  `id_colis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `livraison`
--

INSERT INTO `livraison` (`id_client`, `id_livreur`, `id_livraison`, `adresse_expedition`, `adresse_destinataire`, `prix`, `etat`, `id_colis`) VALUES
(12, 26, 1, 'Ariana', 'Manouba', 4, 'en cours', 1),
(12, 0, 2, 'Sfax', 'Monastir', 14, 'En attente', 2),
(12, 0, 3, 'Tunis', 'Zaghouan', 6, 'En attente', 3);

-- --------------------------------------------------------

--
-- Structure de la table `location`
--

CREATE TABLE `location` (
  `id_contrat` int(255) NOT NULL,
  `id` int(11) NOT NULL,
  `id_vehicule` int(255) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `lieu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `location`
--

INSERT INTO `location` (`id_contrat`, `id`, `id_vehicule`, `date_debut`, `date_fin`, `lieu`) VALUES
(58, 2, 57, '2023-03-09', '2023-03-11', 'kef');

-- --------------------------------------------------------

--
-- Structure de la table `offre_course`
--

CREATE TABLE `offre_course` (
  `id_offre` int(11) NOT NULL,
  `matricule_vehicule` int(11) NOT NULL,
  `cin_conducteur` int(11) NOT NULL,
  `nb_passagers` int(11) NOT NULL,
  `options_offre` varchar(255) NOT NULL,
  `statut_offre` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `offre_course`
--

INSERT INTO `offre_course` (`id_offre`, `matricule_vehicule`, `cin_conducteur`, `nb_passagers`, `options_offre`, `statut_offre`) VALUES
(1, 111, 1111, 11, 'NC', 'actif');

-- --------------------------------------------------------

--
-- Structure de la table `offre_livraison`
--

CREATE TABLE `offre_livraison` (
  `id` int(11) NOT NULL,
  `prix_livraison` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE `promotion` (
  `id_promotion` int(11) NOT NULL,
  `taux` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `promotion`
--

INSERT INTO `promotion` (`id_promotion`, `taux`) VALUES
(1, 0),
(2, 5),
(3, 10),
(4, 15),
(5, 20),
(6, 25),
(7, 30),
(8, 35),
(9, 40),
(10, 45),
(11, 50),
(12, 55),
(13, 60),
(14, 65),
(15, 70),
(16, 75),
(17, 80),
(18, 85),
(19, 90);

-- --------------------------------------------------------

--
-- Structure de la table `reclamation`
--

CREATE TABLE `reclamation` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `etat` varchar(255) NOT NULL,
  `idAdmin` int(11) NOT NULL,
  `idUser` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reclamation`
--

INSERT INTO `reclamation` (`id`, `message`, `etat`, `idAdmin`, `idUser`) VALUES
(1, 'test1', 'En cours', 13, 12),
(3, 'test3', 'En cours', 13, 12),
(7, 'test4	 ', 'Ouvert', 13, 26),
(8, 'test', 'Ouvert', 13, 26),
(9, 'aaaa', 'Ouvert', 13, 26),
(10, 'test5', 'Ouvert', 13, 12);

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
  `evaluation` float(2,1) NOT NULL,
  `bloque` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `nom`, `prenom`, `mail`, `mdp`, `num_tel`, `role`, `evaluation`, `bloque`) VALUES
(0, '', '', '', '', '', 'Admin', 0.0, 0),
(12, 'khaled', 'khaled', 'khaled@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '56765345', 'Client', 0.0, 0),
(13, 'kharmachi', 'abir', 'abir.kharmachi@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '256789467', 'Admin', 0.0, 0),
(17, 'aziz', 'aziz', 'aziz@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '26786543', 'Client', 0.0, 0),
(26, 'Ben Ghorbel', 'Nourr', 'nour@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '123456', 'Conducteur', 0.0, 0),
(27, 'Ben aissa', 'Walid', 'walid@gmail.com', '5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5', '123456', 'Conducteur', 0.0, 0),
(28, 'salah', 'salah', 'abir@gmail.com', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', '125425', 'Conducteur', 0.0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `vehicule`
--

CREATE TABLE `vehicule` (
  `id_vehicule` int(255) NOT NULL,
  `nom_v` varchar(255) NOT NULL,
  `id` int(11) DEFAULT NULL,
  `id_promotion` int(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `prix` float NOT NULL,
  `disponibilite` tinyint(1) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `vehicule`
--

INSERT INTO `vehicule` (`id_vehicule`, `nom_v`, `id`, `id_promotion`, `image`, `ville`, `prix`, `disponibilite`, `description`, `type`) VALUES
(49, 'khled', 13, 1, 'bmw.png', 'kef', 100, 1, 'dd', 'voiture'),
(50, 'khled', 0, 6, 'bmw.png', 'kef', 100, 1, 'dd', 'voiture'),
(55, 'za', 0, 1, 'bmw.png', 'kef', 6, 1, 'hello', 'voiture'),
(56, 'fiesta', 13, 3, '1200px-Fiat_Punto_2012_5door_front.jpg', 'kef', 30, 1, 'oui', 'voiture'),
(57, 'TOYOTA COROLLA AUTO', 13, 1, 'png-transparent-2018-toyota-corolla-2017-toyota-corolla-2018-toyota-camry-car-toyota-compact-car-sedan-car.png', 'kef', 120, 1, 'Protection contre les dommages résultant d\'une collision ( 1400,00 EUR)Protection contre le vol ( 1400,00 EUR)La participation aux frais d\'immatriculationSurcharge Aéroport/GareTVA incluseContribution environnementale: 7,56 EUR', 'voiture');

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `id` int(11) NOT NULL,
  `immatriculation` varchar(30) NOT NULL,
  `modele` varchar(30) NOT NULL,
  `marque` varchar(30) NOT NULL,
  `etat` varchar(20) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`id`, `immatriculation`, `modele`, `marque`, `etat`, `photo`) VALUES
(27, '123Tun456', 'Fiat', 'Punto', 'neuf', 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\1200px-Fiat_Punto_2012_5door_front.jpg'),
(26, '321Tun123', 'R7', 'Audi', 'Occasion', 'C:\\Esprit\\Projet PIDEV\\PIDEVILS-Projet-PI\\src\\images\\Audi_RS_7_Sportback_(C8)_–_f_06082021.jpg');

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
  ADD PRIMARY KEY (`id1`,`id2`),
  ADD KEY `fk_utilisateur_commentaire1` (`id1`),
  ADD KEY `fk_utilisateur_commentaire2` (`id2`);

--
-- Index pour la table `conducteur`
--
ALTER TABLE `conducteur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_utilisateur_conducteur` (`id`);

--
-- Index pour la table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id_course`);

--
-- Index pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD PRIMARY KEY (`id_livraison`),
  ADD KEY `fk_livraison_colis` (`id_colis`),
  ADD KEY `fk_livraison_client` (`id_client`),
  ADD KEY `fk_livraison_conducteur` (`id_livreur`);

--
-- Index pour la table `location`
--
ALTER TABLE `location`
  ADD PRIMARY KEY (`id_contrat`),
  ADD KEY `fk_vehicule_location` (`id_vehicule`),
  ADD KEY `fk_u_veh` (`id`);

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
  ADD KEY `fk_utilisateur_reclamation1` (`idAdmin`),
  ADD KEY `fk_utilisateur_reclamation2` (`idUser`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mail` (`mail`);

--
-- Index pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD PRIMARY KEY (`id_vehicule`),
  ADD KEY `fk_u_v` (`id`),
  ADD KEY `fk_vehicule_promotion` (`id_promotion`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`immatriculation`),
  ADD KEY `fk_utilisateur_voiture` (`id`) USING BTREE;

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `colis`
--
ALTER TABLE `colis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `livraison`
--
ALTER TABLE `livraison`
  MODIFY `id_livraison` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `location`
--
ALTER TABLE `location`
  MODIFY `id_contrat` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT pour la table `offre_livraison`
--
ALTER TABLE `offre_livraison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `reclamation`
--
ALTER TABLE `reclamation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `vehicule`
--
ALTER TABLE `vehicule`
  MODIFY `id_vehicule` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `fk_utilisateur_commentaire1` FOREIGN KEY (`id1`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utilisateur_commentaire2` FOREIGN KEY (`id2`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `conducteur`
--
ALTER TABLE `conducteur`
  ADD CONSTRAINT `fk_utilisateur_conducteur` FOREIGN KEY (`id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `livraison`
--
ALTER TABLE `livraison`
  ADD CONSTRAINT `fk_livraison_client` FOREIGN KEY (`id_client`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_livraison_colis` FOREIGN KEY (`id_colis`) REFERENCES `colis` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_livraison_conducteur` FOREIGN KEY (`id_livreur`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reclamation`
--
ALTER TABLE `reclamation`
  ADD CONSTRAINT `fk_utilisateur_reclamation1` FOREIGN KEY (`idAdmin`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_utilisateur_reclamation2` FOREIGN KEY (`idUser`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `vehicule`
--
ALTER TABLE `vehicule`
  ADD CONSTRAINT `fk_vehicule_promotion` FOREIGN KEY (`id_promotion`) REFERENCES `promotion` (`id_promotion`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `fk_utilisateur_vehicule` FOREIGN KEY (`id`) REFERENCES `utilisateur` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
