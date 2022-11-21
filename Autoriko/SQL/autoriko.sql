-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : db
-- Généré le : lun. 21 nov. 2022 à 13:25
-- Version du serveur :  10.5.8-MariaDB-1:10.5.8+maria~focal
-- Version de PHP : 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `autoriko`
--

-- --------------------------------------------------------

--
-- Structure de la table `achat`
--

CREATE TABLE `achat` (
  `id_achat` int(11) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `date_confirmation_mail` date DEFAULT NULL,
  `date_validation_vente` date DEFAULT NULL,
  `id_vente` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `achat`
--

INSERT INTO `achat` (`id_achat`, `uuid`, `nom`, `date_confirmation_mail`, `date_validation_vente`, `id_vente`, `id_utilisateur`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'regetzhgtzhyejefvfff', 'Achat Fiat 500', NULL, NULL, 3, 1, '2021-04-13 00:00:00', '2021-04-22 12:37:03', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id_admin` int(11) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `super_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id_admin`, `uuid`, `nom`, `mail`, `mdp`, `super_admin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'adminfgzauyfgz', 'JohnDoe', 'john@local.dev', '$2y$10$/cXT6xLLTt6AvR2azE4pMOWb0fJN2tVXi7.4xv9EwliS6292u8i7m', 1, '2021-04-22 12:30:57', '2021-04-22 12:31:21', NULL),
(2, 'vtycytcvhjvgcvjytcytrc', 'PORTARO Lucas', 'portaro.lucas@local.dev', '$2y$10$/cXT6xLLTt6AvR2azE4pMOWb0fJN2tVXi7.4xv9EwliS6292u8i7m', 0, '2021-04-28 09:54:04', '2021-04-28 09:54:04', '2021-04-28 09:53:33');

-- --------------------------------------------------------

--
-- Structure de la table `alerte`
--

CREATE TABLE `alerte` (
  `id_alerte` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `lien` varchar(255) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `alerte`
--

INSERT INTO `alerte` (`id_alerte`, `message`, `lien`, `id_admin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Noël 2033 réduction -40% sur tous les accès aux ventes, profitez en !', '', 1, '2021-04-22 12:32:13', '2021-04-22 12:34:20', NULL),
(2, 'L\'équipe EnchèreAuto vous souihaite de jouyeuses pâques', '', 1, '2021-04-22 12:32:13', '2021-04-22 12:34:20', NULL),
(3, 'Toute l\'équipe de EnchèreAuto vous souhaite la bienvenue sur EnchèreAuto.fr', '', 1, '2021-04-22 12:32:13', '2021-04-22 12:34:20', NULL),
(4, 'EnchèreAuto sera exceptionelement fermé entre le 22 et 24 janvier 2034 pour une grosse mise à jour du site.', '', 1, '2021-04-22 12:32:13', '2021-04-22 12:34:20', NULL),
(5, 'Un utilisateur a ajouté 50€ à la vente <b>TEST-TEST</b> a commencé !<br>Faites une offre.', 'https://www.youtube.com/', NULL, '2022-11-18 12:37:35', '2022-11-18 12:37:35', NULL),
(6, 'Un utilisateur a ajouté 1000€ à la vente <b>TEST-TEST</b> a commencé !<br>Faites une offre.', 'https://www.youtube.com/', NULL, '2022-11-18 12:37:45', '2022-11-18 12:37:45', NULL),
(7, 'Un utilisateur a ajouté 250€ à la vente <b>TEST-TEST</b> a commencé !<br>Faites une offre.', 'https://www.youtube.com/', NULL, '2022-11-18 12:37:57', '2022-11-18 12:37:57', NULL),
(8, 'Un utilisateur a ajouté 100€ à la vente <b>TEST-TEST</b> a commencé !<br>Faites une offre.', 'https://www.youtube.com/', NULL, '2022-11-18 14:21:14', '2022-11-18 14:21:14', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_categorie` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_categorie`, `libelle`) VALUES
(1, 'Compact'),
(2, 'Coupe'),
(3, '4x4'),
(4, 'Berline'),
(5, 'Cabriolet');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_photo`
--

CREATE TABLE `categorie_photo` (
  `id_categorie_photo` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categorie_photo`
--

INSERT INTO `categorie_photo` (`id_categorie_photo`, `libelle`) VALUES
(1, 'Intérieur'),
(2, 'Moteur'),
(3, 'Extérieur'),
(7, 'Extérieur jantes');

-- --------------------------------------------------------

--
-- Structure de la table `contact_page`
--

CREATE TABLE `contact_page` (
  `title_page` varchar(255) NOT NULL,
  `text` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `contact_page`
--

INSERT INTO `contact_page` (`title_page`, `text`) VALUES
('Contact', 'Ici vous retrouverez les moyens de nous contacter...');

-- --------------------------------------------------------

--
-- Structure de la table `conversation`
--

CREATE TABLE `conversation` (
  `id_conversation` int(11) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `conversation_vu` int(11) NOT NULL DEFAULT 0,
  `id_admin` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `conversation`
--

INSERT INTO `conversation` (`id_conversation`, `uuid`, `titre`, `conversation_vu`, `id_admin`, `id_utilisateur`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'rhgztrhsgfsd', 'Problème participation vente 6465765327', 1, 1, 1, '2021-04-22 12:42:23', '2022-11-13 22:33:18', NULL),
(2, 'frehgerthrtjurjr', 'Test conv', 1, 1, 1, '2021-04-22 12:42:23', '2022-11-13 22:33:16', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE `entreprise` (
  `id_utilisateur` int(11) NOT NULL,
  `raison_sociale` varchar(255) NOT NULL,
  `siren` varchar(255) DEFAULT NULL,
  `numero_tva` varchar(255) DEFAULT NULL,
  `url_photocopie_kabis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `entreprise`
--

INSERT INTO `entreprise` (`id_utilisateur`, `raison_sociale`, `siren`, `numero_tva`, `url_photocopie_kabis`) VALUES
(3, 'Lucas Sloy', 'EN07fsgrds654372457', '7629', ''),
(52, 'Francois Pavage', NULL, NULL, NULL),
(53, 'EnchereAuto', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `equiper`
--

CREATE TABLE `equiper` (
  `id_option` int(11) NOT NULL,
  `id_voiture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `equiper`
--

INSERT INTO `equiper` (`id_option`, `id_voiture`) VALUES
(1, 2),
(2, 2);

-- --------------------------------------------------------

--
-- Structure de la table `faq`
--

CREATE TABLE `faq` (
  `id_faq` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `reponse` varchar(255) NOT NULL,
  `introduction` varchar(255) NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `faq`
--

INSERT INTO `faq` (`id_faq`, `question`, `reponse`, `introduction`, `id_admin`) VALUES
(1, 'Comment participer à une vente ?', 'Pour participer à une vente il vous suffit juste d\'en sélectionner une, acheter votre place pour participer à celle-ci puis vous serez automatiquement accepté à participer.', 'Participer à une vente', 1),
(2, 'Comment supprimer mon compte ?', 'Pour supprimer vos comptes ainsi que toutes vos données bancaire, adresse etc... rendez-vous sur votre espace Mon Compte puis vous pourrez cliquer sur \"Supprimer définitivement mon compte\"', 'Supprimer mon compte', 1);

-- --------------------------------------------------------

--
-- Structure de la table `faq_page`
--

CREATE TABLE `faq_page` (
  `title_page` varchar(255) NOT NULL,
  `text` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `faq_page`
--

INSERT INTO `faq_page` (`title_page`, `text`) VALUES
('Foire aux questions', 'Ici vous retrouverez les questions les plus fréquentes...');

-- --------------------------------------------------------

--
-- Structure de la table `guide_page`
--

CREATE TABLE `guide_page` (
  `title_page` varchar(255) NOT NULL,
  `text` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `guide_page`
--

INSERT INTO `guide_page` (`title_page`, `text`) VALUES
('Guide', 'Ici vous retrouverez le guide du site...');

-- --------------------------------------------------------

--
-- Structure de la table `information_api`
--

CREATE TABLE `information_api` (
  `secret` varchar(255) NOT NULL,
  `heure_limite_session` float NOT NULL,
  `heure_limite_refresh` float NOT NULL,
  `heure_limite_reset_mdp` float NOT NULL,
  `heure_limite_confirmation_mail` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `information_api`
--

INSERT INTO `information_api` (`secret`, `heure_limite_session`, `heure_limite_refresh`, `heure_limite_reset_mdp`, `heure_limite_confirmation_mail`) VALUES
('FCtyfv#7dVYT097eD#E5Vez@vytzv45L3o4', 4, 4.5, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `information_site`
--

CREATE TABLE `information_site` (
  `nom` varchar(255) NOT NULL,
  `prix_entrer_vente` float NOT NULL,
  `mail` varchar(255) NOT NULL,
  `numero_tel` varchar(20) NOT NULL,
  `horaire_hotline` varchar(255) NOT NULL,
  `code_postale_agence` varchar(5) NOT NULL,
  `ville_agence` varchar(255) NOT NULL,
  `adresse_agence` varchar(255) NOT NULL,
  `comp_adresse_agence` varchar(255) NOT NULL,
  `lien_youtube` varchar(255) NOT NULL,
  `lien_instagram` varchar(255) NOT NULL,
  `lien_facebook` varchar(255) NOT NULL,
  `lien_twitter` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `information_site`
--

INSERT INTO `information_site` (`nom`, `prix_entrer_vente`, `mail`, `numero_tel`, `horaire_hotline`, `code_postale_agence`, `ville_agence`, `adresse_agence`, `comp_adresse_agence`, `lien_youtube`, `lien_instagram`, `lien_facebook`, `lien_twitter`) VALUES
('EnchereAuto', 19.9, 'contact@autoriko.fr', '0613425367', 'Vous pouvez nous contacter du lundi au vendredi de 9h à 19h.', '57000', 'Thionville', '689 rue de la commune de paris', '', 'https://www.youtube.com/channel/UCsTK8xMZKkrbTeWc8REbn8Q', 'https://www.instagram.com/loris.giuliano/', 'https://www.facebook.com/GiulianoLoris/', 'https://twitter.com/Loris_Giuliano');

-- --------------------------------------------------------

--
-- Structure de la table `lien_disponible`
--

CREATE TABLE `lien_disponible` (
  `id_lien` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lien_disponible`
--

INSERT INTO `lien_disponible` (`id_lien`) VALUES
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(29),
(30),
(31),
(32),
(33),
(34),
(35);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

CREATE TABLE `marque` (
  `id_marque` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `lien` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id_marque`, `nom`, `lien`) VALUES
(1, 'Fiat', 'fiat.png'),
(2, 'Renault', 'renault.png'),
(3, 'BMW', 'bmw.png'),
(4, 'Seat', 'seat.png'),
(5, 'Opel', 'opel.png'),
(6, 'Porsche', 'porsche.png'),
(7, 'Volkswagen', 'vw.png');

-- --------------------------------------------------------

--
-- Structure de la table `mention_legale_page`
--

CREATE TABLE `mention_legale_page` (
  `title_page` varchar(255) NOT NULL,
  `text` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mention_legale_page`
--

INSERT INTO `mention_legale_page` (`title_page`, `text`) VALUES
('Mention légale', 'Ici vous retrouverez les mentions légales...');

-- --------------------------------------------------------

--
-- Structure de la table `message`
--

CREATE TABLE `message` (
  `id_message` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT 0,
  `id_conversation` int(11) NOT NULL,
  `id_utilisateur` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `message`
--

INSERT INTO `message` (`id_message`, `message`, `type`, `id_conversation`, `id_utilisateur`, `id_admin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Bonjour j\'ai un problème une vente j\'ai besoin d\'aide', 0, 1, 1, NULL, '0000-00-00 00:00:00', '2021-04-22 12:36:10', NULL),
(2, 'Bonjour Lucas, quel est le numéro de la vente et quel est votre problème ?', 0, 1, NULL, 1, '0000-00-00 00:00:00', '2021-04-22 12:36:10', NULL),
(3, 'Le numéro est le : 375T67 je rencontre un problème lorsque je veux accéder au paiement pour pouvoir enchérir par la suite.', 0, 1, 1, NULL, '2021-04-14 00:00:00', '2021-04-22 12:36:10', NULL),
(7, 'salut', 0, 1, 1, NULL, '2021-04-21 00:00:00', '2021-04-22 12:36:10', NULL),
(29, 'dsfdsf', 0, 1, 1, NULL, '2021-05-06 10:03:14', '2021-05-06 10:03:14', NULL),
(30, 'gfhfg', 0, 1, 1, NULL, '2021-05-06 10:14:37', '2021-05-06 10:14:37', NULL),
(31, 'bonjour', 0, 1, 1, NULL, '2021-05-06 10:15:59', '2021-05-06 10:15:59', NULL),
(32, 'tdtdyt', 0, 1, 1, NULL, '2021-05-06 10:21:58', '2021-05-06 10:21:58', NULL),
(33, 'gdtrdrdtr', 0, 1, 1, NULL, '2021-05-06 10:22:33', '2021-05-06 10:22:33', NULL),
(34, 'ytfytfy', 0, 1, 1, NULL, '2021-05-06 10:22:41', '2021-05-06 10:22:41', NULL),
(35, 'bonjur', 0, 1, 1, NULL, '2021-05-06 10:22:48', '2021-05-06 10:22:48', NULL),
(36, 'sqrfes', 0, 1, 1, NULL, '2021-05-06 10:39:28', '2021-05-06 10:39:28', NULL),
(37, 'defr', 0, 1, 1, NULL, '2021-05-06 13:13:24', '2021-05-06 13:13:24', NULL),
(38, 'yo', 0, 1, 1, NULL, '2021-05-18 14:41:09', '2021-05-18 14:41:09', NULL),
(39, 'salut', 0, 1, 1, NULL, '2021-05-22 15:09:14', '2021-05-22 15:09:14', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `offre`
--

CREATE TABLE `offre` (
  `id_offre` int(11) NOT NULL,
  `uuid` varchar(255) DEFAULT NULL,
  `montant` float NOT NULL,
  `id_vente` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `offre`
--

INSERT INTO `offre` (`id_offre`, `uuid`, `montant`, `id_vente`, `id_utilisateur`, `created_at`, `updated_at`) VALUES
(1, 'dqzfrezgrez', 100, 3, 1, '2021-04-01 00:00:00', '2021-04-22 12:40:38'),
(2, 'regezgzeg', 200, 3, 2, '2021-04-02 00:00:00', '2021-04-22 12:40:38'),
(3, 'dsgrezgrezgz', 500, 3, 1, '2021-04-03 00:00:00', '2021-04-22 12:40:38'),
(4, NULL, 10400, 5, 1, '2022-11-18 12:33:39', '2022-11-18 14:21:14');

-- --------------------------------------------------------

--
-- Structure de la table `option`
--

CREATE TABLE `option` (
  `id_option` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `option`
--

INSERT INTO `option` (`id_option`, `libelle`) VALUES
(1, 'GPS'),
(2, 'Siège chauffant');

-- --------------------------------------------------------

--
-- Structure de la table `participation`
--

CREATE TABLE `participation` (
  `id_vente` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `participation`
--

INSERT INTO `participation` (`id_vente`, `id_utilisateur`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 2, '2021-04-22 12:46:38', '2021-04-22 12:46:51', NULL),
(3, 2, '2021-04-22 12:46:38', '2021-04-22 12:46:51', NULL),
(3, 4, '2021-04-22 12:46:38', '2021-04-22 12:46:51', NULL),
(5, 1, '2021-04-22 12:46:38', '2021-04-22 12:46:51', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `particulier`
--

CREATE TABLE `particulier` (
  `id_utilisateur` int(11) NOT NULL,
  `date_naissance` date DEFAULT NULL,
  `url_photocopie_piece_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `particulier`
--

INSERT INTO `particulier` (`id_utilisateur`, `date_naissance`, `url_photocopie_piece_id`) VALUES
(1, '1998-05-12', 'photo_portaro'),
(2, '2021-04-05', ''),
(54, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `photo_voiture`
--

CREATE TABLE `photo_voiture` (
  `id_photo` int(11) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `lien` varchar(255) NOT NULL,
  `id_voiture` int(11) NOT NULL,
  `id_categorie_photo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `photo_voiture`
--

INSERT INTO `photo_voiture` (`id_photo`, `titre`, `description`, `lien`, `id_voiture`, `id_categorie_photo`) VALUES
(1, 'Photo de devant', 'Voici une photo de la clio 4 de devant', 'devantegrhnrshignfdgiudfsggtrs.jpeg', 2, 3),
(2, 'Photo de derrière', 'Voici une photo de la clio 4 de derrière', 'derriereergrsdhsdthdtrsdfvwsdf.jpeg', 2, 3),
(3, 'Photo du coté droit', 'Photo du coté droit de la clio 4, avec une petite rayure sur la porte avant', 'coteregrezgfesqs.jpeg', 2, 3),
(4, 'Photo du coffre', 'Coffre avec beaucoup d\'espace', 'coffreibfuyerzbgser.jpeg', 2, 1),
(5, 'Photo tableau de bord', 'Voici une photo du tableau de bord', 'interieurdsgvbufydsenrkgtztg.jpeg', 2, 1),
(6, 'Photo des sièges avant', 'Siège avant avec une petite coupure sur le siège passager', 'interieurfygsdfuygbsufyg.jpeg', 2, 1),
(7, 'Photo siège avant', '', 'interieursuqbfnqsugbenrksugrez.jpeg', 2, 1),
(8, 'Photo jantes avant gauche', 'Jantes avant gauche un peu usé', 'jantedfbHVykuvhbezfjbqiffergsh.jpeg', 2, 7),
(9, 'Photo du moteur', 'Photo du moteur nettoyé et révisé', 'moteurriifgheruzgfyb.jpeg', 2, 2),
(10, 'Arrière de la voiture', 'Voici l\'arrière de la voiture BMW M3 CS', 'arriereJKNIURBCCREQE.jpeg', 3, 3),
(11, 'Derrière du véhicule', 'Voici le derrière du véhicule BMW M3 CS', 'derriereHVCUGVCZERA.jpeg', 3, 3),
(12, 'Devant l\'auto', 'Voici le devant de la voiture', 'devantHJBZUYCBUZYCZRE.jpeg', 3, 3),
(13, 'Intérieur de la voiture', 'Voici l\'intérieur de la voiture avec tableau de bord semi-cuir', 'interrieurhVBIYVZCZCAZ.jpeg', 3, 1),
(14, 'Siège de la voiture', 'Voici les sièges de la voiture en alcantara', 'siegejHBAZUYVBCR.jpeg', 3, 1),
(15, 'Volant alcantara, fond de compteur digital', 'Photo du volant alcantara avec fond de compteur digital', 'volantTYFVYVEZZ.jpeg', 3, 1),
(16, 'Derrière', 'Derrière de la voiture', 'derriereHBUYVACAERC.jpeg', 4, 3),
(17, 'Arrière', 'Arrière de la voiture', 'derriereHCUYBEYGREACE.jpeg', 4, 3),
(18, 'Devant', 'Devant de la voiture', 'devantJKHBEUYFBRZUB.jpeg', 4, 3),
(19, 'Extérieur droite', 'Extérieur droite de la voiture', 'exterieurDROITEjbnuBUYCRER.jpeg', 4, 3),
(20, 'Siège avant', 'Siège avant de la voiture', 'interrieurGVZYVCEUQYV.jpeg', 4, 1),
(21, 'Volant', 'Volant semi-cuir', 'interrieurHGVYKVBCRZ.jpeg', 4, 1),
(22, 'Compteur', 'Compteur digitale', 'interrieurHJBUIYBCZDZE.jpeg', 4, 1),
(23, 'Intérieur côté conducteur', 'Une photo du côté gauche (conducteur)', 'interrieurHVBUZVBCZ.jpeg', 4, 1),
(24, 'Photo de derrière', 'Photo de l\'arièere de la Mokka', 'derriereGVDYEGHBYGAZBEUYB.jpeg', 5, 3),
(25, 'Photo d\'en haut', 'Photo vu du dessus', 'derriereHJBEDHBZECRZZ.jpeg', 5, 3),
(26, 'Logo arrière', 'Logo arrière sur le coffre', 'derriereJHFEBUBQZCZ.jpeg', 5, 3),
(27, 'Photo de devant', 'Photo du devant de la voiture', 'devantGYGCVzytVYTVytvcgvq.jpeg', 5, 3),
(28, 'Photo de l\'intérieur', 'Photo de l\'intérieur de la Mokka', 'interrieurFCVDYUTVDEYEV.jpeg', 5, 1),
(29, 'Volant', 'Voici le volant', 'compteurBHUYBCZAAZ.jpeg', 6, 1),
(30, 'Côté gauche', 'Voici le côté extérieur gauche', 'coteGaucheJBUAYBCBAAECA.jpeg', 6, 3),
(31, 'Derrière', 'Le derrière de la porsche', 'derriereHBKUYBCUYBE.jpeg', 6, 3),
(32, 'Avant', 'Avant de la porsche 911', 'devantHVYTAZVDBYAU.jpeg', 6, 3),
(33, 'Intérieur tableau de bord', 'Voici le tableau de bord vu de derrière', 'interrieurHBCUCBREER.jpeg', 6, 1),
(34, 'Jantes arrière gauche', 'Jantes arrière gauche un peu rayé au milieu', 'janteHBYUVCBEYAE.jpeg', 6, 7),
(35, 'Siège avant', 'Voici les sièges en bon état', 'siegeHBAEZBCEA.jpeg', 6, 1),
(36, 'Arrière', 'Photo de l\'arrière', 'arriereHBEYUVZBCEZZE.jpeg', 7, 3),
(37, 'Côté gauche', 'Voici le côté gauche avec minuscule rayure', 'avantHJBCYVBERAxqhB.jpeg', 7, 3),
(53, 'Cabriolet titre', 'Cabriolet description', 'ca49636002f020f023d996847233371d.svg', 48, 3),
(54, 'Electrique titre', 'Electrique description', '4d63fbf4d5ffb9980a74905faea9044a.svg', 48, 1);

-- --------------------------------------------------------

--
-- Structure de la table `recevoir_alerte`
--

CREATE TABLE `recevoir_alerte` (
  `id_utilisateur` int(11) NOT NULL,
  `id_alerte` int(11) NOT NULL,
  `alerte_vu` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `recevoir_alerte`
--

INSERT INTO `recevoir_alerte` (`id_utilisateur`, `id_alerte`, `alerte_vu`) VALUES
(1, 3, 1),
(1, 4, 1),
(2, 2, 0);

-- --------------------------------------------------------

--
-- Structure de la table `representation_voiture`
--

CREATE TABLE `representation_voiture` (
  `id_representation` int(11) NOT NULL,
  `lien` varchar(255) NOT NULL,
  `id_voiture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `token_jwt`
--

CREATE TABLE `token_jwt` (
  `id_jwt` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `adresse_ip` varchar(255) NOT NULL,
  `agent_utilisateur` varchar(255) NOT NULL,
  `etat` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `token_liste_noir`
--

CREATE TABLE `token_liste_noir` (
  `session_token_xsrf` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `token_liste_noir`
--

INSERT INTO `token_liste_noir` (`session_token_xsrf`) VALUES
('b277f9474e7f2cf3c6c87e04acb909860343e71ad669e2f5dcfa0b6e7f8266e12a540a0b7562d79a4ee2df0bf70fd54481b1144f8dda24f7d76a3d8a8f5a8b68'),
('9f3d522c54fa6f312051983596807440e3c693f449f076160bacf7cf09a975ae1daa13c9dd7508367177b1c9f6309897a0b7400ebf845090f4cf7009f507a88e'),
('3a62084c6a7e15efefb125b247e62d85fec771bc9b7d965e6d197d5071e594a33be04f1f92e44a6bc06bc689c932eba58a6fbd82c2942dd750a71028d117d412'),
('de7525f3f94b85826d752961a5554a92d5f016d987259510ec186172f22bc4a7c2c3ccd1ca09888feb17d32363ddf7c704e43d91e216735477b38798d4f8dad6'),
('90f353869c7f653ca9f215e06f4eca37a10bdeead007cb3cbf765a7236ddce57c6bb80278a058cc4b6f438ebd867fe8188e05e566be70af00ac542cb1bf5cbf9'),
('7de3ee737c0b5f20aa70802a20754c473367998e82df9aa2ee7c98a41053dcd17dfdcade0b21ab0faaf50b831177a689cf41fd5fb230e536ca126bc0006449a5'),
('1acf9c644cad12101cd1fc699830aebc6a7da75ea057e5e7c8a62f0c111242ea3720cbeda145ef8b94aba011240eeb3285f92e0e6d2e5b379467c1cce6fa00aa'),
('048e1925c726cf18bff365cbcb81c290d95b0f0d7b6f60668ae64e8b736170180aa227acb52f827ec581548f26884b1401bff3a59e5b252ad67908c28ad8d794'),
('23a34324d63a56ddc9bcea980d59e52050be4dfaa2ca40888720a4a48b330e0bf102d869bfc271a00b106747fa288d259d48bbe09d0d0ca41d7b5a3b7791edd7'),
('096ca0302c5e18e71495015417d82f63cdfc194a03297a050834070bdf67ba9ab280747ea6885f17c2040df7faba41d25f4c3d112cd5526059d56fd743a17652'),
('9af96c36010a0fef4f84ee515ada0a499da576776bc5553186d7c29622f7a5c8f03eed59d1eb1cb7fe89aaa21af8163e2b6d51345425e31fe7b79feef5ea3e23'),
('b9592f89b3dd271b92577887026c30ebac2da65d4c4d4d10f7ab130bb4ed7c8e41b99b0a829668c408790fed904dcef52f6cf49d0cdc90c2ba2c2b9f12421260'),
('595e64e5de3b4e6282aa72d4380dd979d2438db374c9e31fe99793492934f844a6985363402642d010a840eaa01b3855f0b94e7a4f135a616fa257217a1f5333'),
('87b431e40acd0c1fafb2df86f000e2fb4863a06eeafc8f65ec45f55986da1987159b12528cc899bbf351b63146cd426a360fa508e6f3e2b8d55624dcabb63ce8'),
('db59b7bdbaa7c30b202b560f7d36b4be56bed17a2da86710e37c77ae069db0c3ebe8d53f29090abdd8e49eb50a941ad30c1859d7f2117d1e355d4e8d0d2bf147'),
('9aabec22a0ce396e2258f88b6050c3eff367d6b40c75202e41ba4dec3aa48bc79bf176b668f7b28ad4d4b32dc6f205549c31868781ea331d99ff1525285f7e46'),
('f4727344313bc6dde21e451ed412c5486023091d0a9c2e0fa981a6f93301cb697d73555f52706b31efb3c5df402a21e3eca86bfe2e81119146cf8570c84c249f'),
('c33254c0ba9a0dc10b6545af50d9d6fb4c8c9140069d4fa65c8b90a577636af5ef81f7fbf5d692db483dbb0f97b7e620dcd75a55a7d680018517a2c7fdf12767'),
('4b30b63ff695f45bcb846ebd1bb627035344321f03aebcd659f9167567b20e0a7c1d21c0bef59862e8005764a132c56a8da47c712e498e52aee6710e624ddb19'),
('3c02a59645e6b73d5147553b616d234f947e3d0a3083b5b47b6aeb75e6164feae6110d132a73b3d4f7ab23e620db3fb6f4ee1e5badce723f426a6c6916e02725'),
('7c0ee5ec562b6cbccd6cefb4c70681aeed28f1a4f976760ecdcda80932b0308017e77964cadff6b60503932b677e4ca9796498e572cab65372212994cb14398f'),
('80af6de845c65ead2f65788d6fb7c6f0ad7cc80661d5b2970518d1b1eb35c822a9c9217ce0343e82a4c859d12f50aeaf7de9d5630624b9f97cc4a7220d392c19'),
('91d2cc44d3c1b1c1d0f3d19e60c6583c50b4bcd0288df5aa749154f24321490efd905edb001f16bb32a396b17f5c59d93f295155858ddb03b8ccae4d89df17bd'),
('32a19a8e0f77639aa5aa507dbba323495872048b83b9b6fd9172a1bdcd12a026a8b0ee663f40c5125dfc15f5817ae861b9a4b80ede08ab5cf66ab2895957ed66'),
('fc2a15020e8eee2c2eaa8b6710944a1c04f4a12724a0d672f2603da83940a784cb745c389fd2f7a84bd9b457bea88cbf3c50bf7bdd02109fee7ffdbeb4487b4d'),
('7dce586df3705db7de720d4eba420f58342671149e02ee1bc55feb91de72ed26f1abb088ade3fdffdf31f1b588609ed277a42a562beccaa6658a477fefd71cd0'),
('bf9dbaf3591bab3576b8c4ab3a0a0d76ee46bd5f34b88ddde2750895826b7b96c9f038bebf1a7203196f1bc8a31170f42e880d89a013116ee17bf7e7bc5dc011'),
('718d46ac35ab1a173ab5482c4966d485583e346b69d35132579c6b9019d21a0b266d8639bef59d2d9375ad78d13604e1a5b1c0d78e0d1b07781bd1b02f9b6134'),
('5e05c1f295453292513bcd67985fdb32f418efb9777fa34539af8f76eb3fbf7d57127348ebdbfb46f49c2064e9a8cf06b4e3e77f7ed743d7f7b24f9b0967d06c'),
('1e723fd8affec0cabbcd5cb93406c8605b9dce560b47788584acdc9b46a9fbc72606ad8f401b6247e4c054a781d07c64e8d48564e782eb00f29c877cc84db577'),
('657ffafae5704a4656e60eb27fd6f1c98dfcd76b8c2941a0bf3e91b7358ea7b6ab656d7649093b6a722e03ea1bfe3a84a336c6a161877cc5a6b9a281c920c3d6'),
('3867ed28bdcbe17e9a95dc503b495239108ca64d7688075fe661ca796a04c577abb7fcbe2e3973d1253d0a77aa395aaababe434c52f6c39d6ce170740a46bc96'),
('458e47d8d169638c98be65dcc4bd0f32a8d43dae67894e23c209eb4af9bdbe2f3eac3b67c896f8cd063ec9097c1717d52e5deed43706a52feda8d5bc392bfdb7'),
('e410a2d55a08111ebb45fb949d177f02b8ccf30fc76b5cbc9a2051ad69464a12db7b38a2c635d04f9224a5c0a237e8994de65509f2648a709e285b6b53ff0a79'),
('e647c7ac78b2ec9150526a78370548969085c239f649e5530b590de0075669505b11e35233b0fac0fda336321f52becaf5a74a6a57a712c2941c81bd266d2587'),
('8d85fbf64a7e8a2861e4122597016af2559a3b380934a154229d31c4de4dbf1213119289b87fa19fa996f33cf2ee0e768c8ff6a16b907c80349a4cb4fe457adf'),
('9f5c9ffa0479787c8503288238a941f0b28286ca421b149b3a675a013e28f324fbe2df7a6882d616957ad4cb4b0a7a3c2acab8e14960f4ecdf74cc9fe81afb1f'),
('28276ade28c847e39bf69a1db57308d91ecd20ed80a0aaf8b52f8e0db703d884e793ed652d00dc0ea69bb4dae4ef2b96a5098c50bd11428e0da6b1a7daf7d45b'),
('4ae210a7041dc7d0f21652f3a7237d093e94f46801bae2565c04fc36d521da9fb0c20c6c4010aa53452659d8283b7c576ca4c4273a3794dc59025fdebf2525be'),
('b6adcf2ba4281d161b624c51e4ad47f548169d86375971d2c0d4b5787f815e230be2c190e9a09f4faa2e8629124723798b59b62261db5934fb16050e6e6faf29'),
('71666abe270e55ccbe7f721a373acb8c63b245c61cfeda8975d59ba5929200c90468c289b93534cdad8045c20e1878215de2cc445c9d1c107abd299bbf1f30f2'),
('14d33e01201db04b9a0dfed882ec522c3a262b90e732e8c7d277692a15c90f5fc81e3782dd9a392253c6fdbe3b7f18c9e407223df3c8b270c2ef2e411979374a'),
('cc907c13136411dc0059fb3bbaa977dfd8be2ad06f45c2c8de01365207e3a4e1422300646540f2bcc3ded43b2e7454e140db6d08b555895190ae1e450c519f35'),
('1c1a1edd3478591f0f8381f018570d65b42bf60df1457b925840028a6f45fb1dcff16d45bcb59bf5d7f4dacddbb768dd62b6f0fdcf19580aceb35c3cda0afc91'),
('14547094a74917370686eab8856caba825a611d2224d494a4a5228d9bea88af4ecc7da803c681d1c8b4682035d22e45ed26a623e0caff14001b3ea3b0c3e336d'),
('465697001920f22d005e74f5818c9f30860db61c46102c6c6aff18410c33437eb300fc06a97ad2ddd4e5807844e0d65033e8a73754a4720405913e9862dc1f97'),
('7eaee83a78b90f83ba16d4e5f23dda23cd711ed627116bf9c2e45e68e06b4894af24dd027299bb65b23371880bb028d6070c18d5273ce0cf99fedecbe81bc709'),
('ec8a0cdf9b318339bb7c5c1c3e72ab52bf071c63c2c805beaaa1e834f0deb455bd98a2f44257c3e36cda90a13f36587da302dad2f3bde103747b63b09be8e5d7'),
('eae185ec7a8807bebb61b7856e8c40f3585aacab98974c73caa4ca26cf06c1a29e132cd0f72a18d6ffddf9b4aa6a472fd573fa15ec8a7c5d33c60465e3e1908d'),
('aca3358a3277f6153f5ffde88495a95be31f3bbdcb26a1094d06ad31bc61f029b7ef5f8ff1471ffbb770e7a3b9fa0f6ec81c00983d0bbcfd79aa8e558c6d8f37');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `mail` varchar(255) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `pays` varchar(255) DEFAULT NULL,
  `code_postal` varchar(5) DEFAULT NULL,
  `ville` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `comp_adresse` varchar(255) DEFAULT NULL,
  `telephone_fixe` varchar(20) DEFAULT NULL,
  `telephone_mobile` varchar(20) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `etat_confirmation_mail` tinyint(1) NOT NULL DEFAULT 0,
  `etat_validation_compte` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `uuid`, `nom`, `prenom`, `mail`, `mdp`, `pays`, `code_postal`, `ville`, `adresse`, `comp_adresse`, `telephone_fixe`, `telephone_mobile`, `type`, `etat_confirmation_mail`, `etat_validation_compte`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'sgrezgtrzh', 'PORTARO', 'Lucas', 'portaro.lucas@gmail.com', '$2y$10$/cXT6xLLTt6AvR2azE4pMOWb0fJN2tVXi7.4xv9EwliS6292u8i7m', 'FRANCE', '57855', 'Saint privat la montagne', '5 impasse du rond navet', '', '', '0683104167', 0, 1, 0, '2021-04-22 12:50:58', '2021-05-19 08:13:49', NULL),
(2, 'hdfhgdhfgdh', 'BESANCON', 'Francois', 'besancon7890@hotmail.com', '$2y$10$/cXT6xLLTt6AvR2azE4pMOWb0fJN2tVXi7.4xv9EwliS6292u8i7m', 'FRANCE', '57380', 'Faulquemont', '3 rue du grand près', '', '', '0619333186', 0, 0, 0, '2021-04-22 12:50:58', '2021-04-22 12:51:44', NULL),
(3, 'hdfhdfghdhd', 'BESANCON', 'Didier', 'obesacon@gmail.com', '$2y$10$/cXT6xLLTt6AvR2azE4pMOWb0fJN2tVXi7.4xv9EwliS6292u8i7m', 'FRANCE', '57380', 'FAULQUEMONT', '3 rue de la quattrematic', '', '', '0619333186', 1, 0, 0, '2021-04-22 12:50:58', '2021-04-22 12:51:44', NULL),
(4, 'fdcezfzrg', 'TESTDELETE', 'TEST', 'test@fr.fr', 'test', 'FRANCE', '57077', 'Metz', '', '', '', '', 0, 0, 0, '2021-04-22 12:50:58', '2021-04-22 12:51:44', '2021-04-20 08:32:31'),
(52, 'feb0aa0c2a04eeab2823e8e56c9481dd', 'Hollande', 'Francois', 'francois.hollande@hotmail.fr', '$2y$10$gZbmM3VKao0bhP5k6f7nkefEUlmD4baDMgUUBXNVKB0IlULdA.7Bm', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '2021-05-05 12:36:56', '2021-05-05 12:36:56', NULL),
(53, 'b2715b33c42071e32e7d879180c0cb70', 'Youm', 'Babacar', 'babacar@fr.fr', '$2y$10$rydMucryyakLl4dF0H6yIO2RLDWLzfOXNl2t3eKm4BZxNGacbWTUq', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 0, '2021-05-05 12:45:44', '2021-05-06 10:38:57', NULL),
(54, 'a89bb7bbe1c6a1de0ddd344ccdf4911f', 'fdgfd', 'sdfdsg', 'vgytucv@gmail.com', '$2y$10$eJwIROEIBIAu6k60YzOkPeblDO9NzAbRs/B1T/DCsoYMDmUQhnX..', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, '2021-05-06 10:40:48', '2021-05-06 10:40:48', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `vente`
--

CREATE TABLE `vente` (
  `id_vente` int(11) NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `titre` varchar(255) NOT NULL,
  `photo_thumbnail` int(11) DEFAULT NULL,
  `prix` float NOT NULL,
  `nombre_offre` int(11) NOT NULL DEFAULT 0,
  `enable` tinyint(1) NOT NULL DEFAULT 1,
  `id_voiture` int(11) DEFAULT NULL,
  `id_achat` int(11) DEFAULT NULL,
  `id_admin` int(11) NOT NULL,
  `date_debut` datetime DEFAULT NULL,
  `date_fin` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `vente`
--

INSERT INTO `vente` (`id_vente`, `uuid`, `titre`, `photo_thumbnail`, `prix`, `nombre_offre`, `enable`, `id_voiture`, `id_achat`, `id_admin`, `date_debut`, `date_fin`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'hgvhgchgkcfgcvgfcgfxfcxerchdcvhkgyukv', 'Clio 4 - Etat neuf', 1, 6700, 0, 1, 2, NULL, 1, '2022-11-11 11:50:06', '2022-11-23 18:08:13', '2021-04-22 12:38:45', '2021-04-22 12:38:58', NULL),
(3, 'bgfu§tyfrtdrtdfytertfrt', 'Fiat 500', NULL, 0, 0, 1, 1, 1, 1, '2021-03-09 11:50:18', '2021-04-05 16:40:54', '2021-04-22 12:38:45', '2021-04-22 12:38:58', NULL),
(4, 'rsfgdrghdghdtrfdjfxhfgh', 'BMW M3 CS', 12, 35000, 0, 1, 3, NULL, 1, '2021-05-16 17:34:10', '2021-08-17 17:34:10', '2021-05-20 15:40:25', '2021-05-20 15:40:25', NULL),
(5, 'gyeqzfyugqfhèyqzegfyusf', 'Seat Cupra', 18, 10400, 4, 1, 4, NULL, 2, '2021-05-02 17:41:07', '2022-11-23 17:41:07', '2021-05-20 15:41:59', '2022-11-18 14:21:14', NULL),
(6, 'dvfergredsqfogvinreogn', 'Opel Mokka', 18, 0, 0, 0, 5, NULL, 2, '2022-05-17 17:42:03', '2021-11-25 17:42:03', '2021-05-20 15:44:03', '2021-05-20 15:44:03', NULL),
(7, 'qefbezlbfuirsbghuejdgresh', 'Porsche 911', 32, 89000, 0, 1, 6, NULL, 1, '2022-11-24 17:44:06', '2023-12-05 17:44:06', '2021-05-20 15:45:08', '2021-05-20 15:45:08', NULL),
(8, 'qzfenfiubehfubqedsdfdsq', 'Volkswagen Turan', 37, 20900, 0, 1, 7, NULL, 1, '2022-11-12 17:45:10', '2022-11-24 17:45:10', '2021-05-20 15:46:37', '2021-05-20 15:46:37', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `video_voiture`
--

CREATE TABLE `video_voiture` (
  `id_video` int(11) NOT NULL,
  `lien` varchar(255) NOT NULL,
  `id_voiture` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `voiture`
--

CREATE TABLE `voiture` (
  `id_voiture` int(11) NOT NULL,
  `modele` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `prix_argus` float NOT NULL,
  `couleur` varchar(255) NOT NULL,
  `kilometrage` int(11) NOT NULL,
  `puissance` int(11) NOT NULL,
  `energie` varchar(255) NOT NULL,
  `annee` int(11) NOT NULL,
  `transmission` varchar(255) NOT NULL,
  `mise_en_circulation` date NOT NULL,
  `numero_identification` varchar(255) NOT NULL,
  `co2` int(11) NOT NULL,
  `nombre_de_cle` int(11) NOT NULL,
  `nombre_siege` int(11) NOT NULL,
  `nombre_porte` int(11) NOT NULL,
  `bruit_moteur` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `nombre_proprietaire` int(11) NOT NULL,
  `moteur` varchar(50) NOT NULL,
  `description_interieur` varchar(255) NOT NULL,
  `id_marque` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `id_vente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `voiture`
--

INSERT INTO `voiture` (`id_voiture`, `modele`, `description`, `prix_argus`, `couleur`, `kilometrage`, `puissance`, `energie`, `annee`, `transmission`, `mise_en_circulation`, `numero_identification`, `co2`, `nombre_de_cle`, `nombre_siege`, `nombre_porte`, `bruit_moteur`, `video`, `nombre_proprietaire`, `moteur`, `description_interieur`, `id_marque`, `id_categorie`, `id_vente`) VALUES
(1, '500', 'Fiat 500', 5000, 'Rouge', 5456, 100, 'Diesel', 2010, 'Manuelle', '2013-05-13', 'T76T467TR', 1, 4, 4, 4, '12volt', NULL, 3, '200Cc', 'une desc', 1, 1, 3),
(2, 'Clio 4', 'Magnifique Clio 4 sport, avec jantes alu', 6750, 'Gris', 123600, 110, 'Diesel', 2017, 'Manuelle', '2017-05-18', 'TYDFEYUFGDUYVFBUBFF', 90, 2, 5, 5, '135', NULL, 3, '1.5 dCI', 'Intérieur noir', 2, 1, 2),
(3, 'BMW M3 CS', 'La BMW M3 CS plus puissante que jamais', 67000, 'Bleu', 13900, 400, 'Essence', 2021, 'Manuelle', '2021-03-16', '', 90, 2, 4, 3, '135', NULL, 1, '2.0 TCi', 'Intérieur sport, siège alcantara', 3, 2, 4),
(4, 'Seat Cupra', 'Voici la toute nouvelle Seat Cupra, 2021 magnifique', 17500, 'Gris', 5000, 230, 'Diesel', 2021, 'Manuelle', '2021-01-13', '', 90, 4, 5, 5, '135', NULL, 1, '2.0 TDi', 'Magnifique intérieur tout récent', 4, 1, 5),
(5, 'Opel Mokka', 'Le nouveau Mokka et l\'audace de son esthétique ouvrent la voie au futur d\'Opel.', 39000, 'Vert', 0, 270, 'Electrique', 2021, 'Automatique', '2020-11-17', '', 20, 2, 5, 5, '65', NULL, 1, '2.0 Elec', 'Intérieur magnifique avec toit ouvrant', 5, 1, NULL),
(6, '911', 'Porsche 911 voiture la plus rapide du monde', 110000, 'Gris', 7456, 700, 'Essence', 2019, 'Automatique', '2019-02-11', '', 190, 1, 2, 3, '635', NULL, 1, '2.0 Biturbo', 'Intérieur full alcantara', 6, 2, 7),
(7, 'Turan', 'Volkswagen Turan comme neuf', 43000, 'Bleu', 77456, 300, 'Essence', 2018, 'Automatique', '2018-05-13', 'TYFVEYDUVDCUE7YUVGHAEFUYUAZEF', 190, 2, 5, 5, '135', NULL, 1, '3 dCI', 'Intérieur spacieux avec toit ouvrant et siège chauffant ', 7, 3, 8),
(43, 'ozent', 'Une description globale', 1000, 'ozent', 1000, 100, 'ozent', 2021, 'ozent', '2021-06-21', 'ozent', 108, 2, 3, 3, NULL, NULL, 4, '1.5L', 'Une description intérieur', 1, 1, NULL),
(44, 'ozent', 'Une description globale', 1000, 'ozent', 1000, 100, 'ozent', 2021, 'ozent', '2021-06-17', 'ozent', 108, 2, 3, 3, NULL, NULL, 4, '1.5L', 'Une description intérieur', 1, 1, NULL),
(45, 'ozent', 'Une description globale', 1000, 'ozent', 1000, 100, 'ozent', 2021, 'ozent', '2021-06-17', 'ozent', 108, 2, 3, 3, NULL, NULL, 4, '1.5L', 'Une description intérieur', 1, 1, NULL),
(46, 'ozent', 'Une description globale', 1000, 'ozent', 1000, 100, 'ozent', 2021, 'ozent', '2021-06-17', 'ozent', 108, 2, 3, 3, NULL, NULL, 4, '1.5L', 'Une description intérieur', 1, 1, NULL),
(47, 'ozent', 'Une description globale', 1000, 'ozent', 1000, 100, 'ozent', 2021, 'ozent', '2021-06-17', 'ozent', 108, 2, 3, 3, NULL, NULL, 4, '1.5L', 'Une description intérieur', 1, 1, NULL),
(48, 'ozent', 'Une description globale', 1000, 'ozent', 1000, 100, 'ozent', 2021, 'ozent', '2021-06-16', 'ozent', 108, 2, 3, 3, '366e06ddbd59d9885127667097322e6f.mp3', '1b7f5b8ba324638a458dd954db915394.mp4', 4, '1.5L', 'Une description intérieur', 1, 1, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achat`
--
ALTER TABLE `achat`
  ADD PRIMARY KEY (`id_achat`),
  ADD UNIQUE KEY `achat_vente0_AK` (`id_vente`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `achat_utilisateur1_FK` (`id_utilisateur`);

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Index pour la table `alerte`
--
ALTER TABLE `alerte`
  ADD PRIMARY KEY (`id_alerte`),
  ADD KEY `id_admin` (`id_admin`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_categorie`);

--
-- Index pour la table `categorie_photo`
--
ALTER TABLE `categorie_photo`
  ADD PRIMARY KEY (`id_categorie_photo`);

--
-- Index pour la table `conversation`
--
ALTER TABLE `conversation`
  ADD PRIMARY KEY (`id_conversation`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `conversation_administrateur0_FK` (`id_admin`),
  ADD KEY `conversation_utilisateur1_FK` (`id_utilisateur`);

--
-- Index pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- Index pour la table `equiper`
--
ALTER TABLE `equiper`
  ADD PRIMARY KEY (`id_option`,`id_voiture`),
  ADD KEY `equiper_voiture1_FK` (`id_voiture`);

--
-- Index pour la table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id_faq`),
  ADD KEY `faq_administrateur0_FK` (`id_admin`);

--
-- Index pour la table `lien_disponible`
--
ALTER TABLE `lien_disponible`
  ADD PRIMARY KEY (`id_lien`);

--
-- Index pour la table `marque`
--
ALTER TABLE `marque`
  ADD PRIMARY KEY (`id_marque`);

--
-- Index pour la table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id_message`),
  ADD KEY `message_utilisateur0_FK` (`id_utilisateur`),
  ADD KEY `message_conversation1_FK` (`id_conversation`),
  ADD KEY `message_administrateur2_FK` (`id_admin`);

--
-- Index pour la table `offre`
--
ALTER TABLE `offre`
  ADD PRIMARY KEY (`id_offre`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD KEY `offre_vente0_FK` (`id_vente`),
  ADD KEY `offre_utilisateur1_FK` (`id_utilisateur`);

--
-- Index pour la table `option`
--
ALTER TABLE `option`
  ADD PRIMARY KEY (`id_option`);

--
-- Index pour la table `participation`
--
ALTER TABLE `participation`
  ADD PRIMARY KEY (`id_vente`,`id_utilisateur`),
  ADD KEY `participation_utilisateur1_FK` (`id_utilisateur`);

--
-- Index pour la table `particulier`
--
ALTER TABLE `particulier`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- Index pour la table `photo_voiture`
--
ALTER TABLE `photo_voiture`
  ADD PRIMARY KEY (`id_photo`),
  ADD KEY `photo_voiture_FK` (`id_voiture`),
  ADD KEY `photo_categorie_photo0_FK` (`id_categorie_photo`);

--
-- Index pour la table `recevoir_alerte`
--
ALTER TABLE `recevoir_alerte`
  ADD PRIMARY KEY (`id_utilisateur`,`id_alerte`),
  ADD KEY `recevoir_alerte_alerte1_FK` (`id_alerte`);

--
-- Index pour la table `representation_voiture`
--
ALTER TABLE `representation_voiture`
  ADD PRIMARY KEY (`id_representation`),
  ADD KEY `representation_voiture_voiture0_FK` (`id_voiture`);

--
-- Index pour la table `token_jwt`
--
ALTER TABLE `token_jwt`
  ADD PRIMARY KEY (`id_jwt`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Index pour la table `vente`
--
ALTER TABLE `vente`
  ADD PRIMARY KEY (`id_vente`),
  ADD UNIQUE KEY `uuid` (`uuid`),
  ADD UNIQUE KEY `vente_voiture0_AK` (`id_voiture`),
  ADD KEY `vente_administrateur0_FK` (`id_admin`),
  ADD KEY `id_achat` (`id_achat`),
  ADD KEY `photo_thumbnail` (`photo_thumbnail`);

--
-- Index pour la table `video_voiture`
--
ALTER TABLE `video_voiture`
  ADD PRIMARY KEY (`id_video`),
  ADD KEY `video_voiture_voiture0_FK` (`id_voiture`);

--
-- Index pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD PRIMARY KEY (`id_voiture`),
  ADD KEY `voiture_marque0_FK` (`id_marque`),
  ADD KEY `voiture_categorie1_FK` (`id_categorie`),
  ADD KEY `id_vente` (`id_vente`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `achat`
--
ALTER TABLE `achat`
  MODIFY `id_achat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `alerte`
--
ALTER TABLE `alerte`
  MODIFY `id_alerte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `categorie_photo`
--
ALTER TABLE `categorie_photo`
  MODIFY `id_categorie_photo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `conversation`
--
ALTER TABLE `conversation`
  MODIFY `id_conversation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `faq`
--
ALTER TABLE `faq`
  MODIFY `id_faq` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `lien_disponible`
--
ALTER TABLE `lien_disponible`
  MODIFY `id_lien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `marque`
--
ALTER TABLE `marque`
  MODIFY `id_marque` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `message`
--
ALTER TABLE `message`
  MODIFY `id_message` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `offre`
--
ALTER TABLE `offre`
  MODIFY `id_offre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `option`
--
ALTER TABLE `option`
  MODIFY `id_option` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `photo_voiture`
--
ALTER TABLE `photo_voiture`
  MODIFY `id_photo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `representation_voiture`
--
ALTER TABLE `representation_voiture`
  MODIFY `id_representation` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `token_jwt`
--
ALTER TABLE `token_jwt`
  MODIFY `id_jwt` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `vente`
--
ALTER TABLE `vente`
  MODIFY `id_vente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `video_voiture`
--
ALTER TABLE `video_voiture`
  MODIFY `id_video` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `voiture`
--
ALTER TABLE `voiture`
  MODIFY `id_voiture` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `achat`
--
ALTER TABLE `achat`
  ADD CONSTRAINT `achat_utilisateur1_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `achat_vente0_FK` FOREIGN KEY (`id_vente`) REFERENCES `vente` (`id_vente`);

--
-- Contraintes pour la table `alerte`
--
ALTER TABLE `alerte`
  ADD CONSTRAINT `alerte_administrateur0_FK` FOREIGN KEY (`id_admin`) REFERENCES `administrateur` (`id_admin`),
  ADD CONSTRAINT `alerte_ibfk_1` FOREIGN KEY (`id_admin`) REFERENCES `administrateur` (`id_admin`);

--
-- Contraintes pour la table `conversation`
--
ALTER TABLE `conversation`
  ADD CONSTRAINT `conversation_administrateur0_FK` FOREIGN KEY (`id_admin`) REFERENCES `administrateur` (`id_admin`),
  ADD CONSTRAINT `conversation_utilisateur1_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `entreprise`
--
ALTER TABLE `entreprise`
  ADD CONSTRAINT `entreprise_utilisateur0_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `equiper`
--
ALTER TABLE `equiper`
  ADD CONSTRAINT `equiper_option0_FK` FOREIGN KEY (`id_option`) REFERENCES `option` (`id_option`),
  ADD CONSTRAINT `equiper_voiture1_FK` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

--
-- Contraintes pour la table `faq`
--
ALTER TABLE `faq`
  ADD CONSTRAINT `faq_administrateur0_FK` FOREIGN KEY (`id_admin`) REFERENCES `administrateur` (`id_admin`);

--
-- Contraintes pour la table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_administrateur0_FK` FOREIGN KEY (`id_admin`) REFERENCES `administrateur` (`id_admin`),
  ADD CONSTRAINT `message_administrateur2_FK` FOREIGN KEY (`id_admin`) REFERENCES `administrateur` (`id_admin`),
  ADD CONSTRAINT `message_conversation1_FK` FOREIGN KEY (`id_conversation`) REFERENCES `conversation` (`id_conversation`),
  ADD CONSTRAINT `message_conversation2_FK` FOREIGN KEY (`id_conversation`) REFERENCES `conversation` (`id_conversation`),
  ADD CONSTRAINT `message_utilisateur0_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `offre`
--
ALTER TABLE `offre`
  ADD CONSTRAINT `offre_utilisateur1_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `offre_vente0_FK` FOREIGN KEY (`id_vente`) REFERENCES `vente` (`id_vente`);

--
-- Contraintes pour la table `participation`
--
ALTER TABLE `participation`
  ADD CONSTRAINT `participation_utilisateur1_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`),
  ADD CONSTRAINT `participation_vente0_FK` FOREIGN KEY (`id_vente`) REFERENCES `vente` (`id_vente`);

--
-- Contraintes pour la table `particulier`
--
ALTER TABLE `particulier`
  ADD CONSTRAINT `particulier_utilisateur0_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `photo_voiture`
--
ALTER TABLE `photo_voiture`
  ADD CONSTRAINT `photo_categorie_photo0_FK` FOREIGN KEY (`id_categorie_photo`) REFERENCES `categorie_photo` (`id_categorie_photo`),
  ADD CONSTRAINT `photo_voiture_FK` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

--
-- Contraintes pour la table `recevoir_alerte`
--
ALTER TABLE `recevoir_alerte`
  ADD CONSTRAINT `recevoir_alerte_alerte1_FK` FOREIGN KEY (`id_alerte`) REFERENCES `alerte` (`id_alerte`),
  ADD CONSTRAINT `recevoir_alerte_utilisateur0_FK` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `representation_voiture`
--
ALTER TABLE `representation_voiture`
  ADD CONSTRAINT `representation_voiture_voiture0_FK` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

--
-- Contraintes pour la table `token_jwt`
--
ALTER TABLE `token_jwt`
  ADD CONSTRAINT `token_jwt_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `vente`
--
ALTER TABLE `vente`
  ADD CONSTRAINT `vente_administrateur0_FK` FOREIGN KEY (`id_admin`) REFERENCES `administrateur` (`id_admin`),
  ADD CONSTRAINT `vente_ibfk_1` FOREIGN KEY (`id_achat`) REFERENCES `achat` (`id_achat`),
  ADD CONSTRAINT `vente_ibfk_2` FOREIGN KEY (`photo_thumbnail`) REFERENCES `photo_voiture` (`id_photo`),
  ADD CONSTRAINT `vente_voiture1_FK` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

--
-- Contraintes pour la table `video_voiture`
--
ALTER TABLE `video_voiture`
  ADD CONSTRAINT `video_voiture_voiture0_FK` FOREIGN KEY (`id_voiture`) REFERENCES `voiture` (`id_voiture`);

--
-- Contraintes pour la table `voiture`
--
ALTER TABLE `voiture`
  ADD CONSTRAINT `voiture_categorie1_FK` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id_categorie`),
  ADD CONSTRAINT `voiture_ibfk_1` FOREIGN KEY (`id_vente`) REFERENCES `vente` (`id_vente`),
  ADD CONSTRAINT `voiture_marque0_FK` FOREIGN KEY (`id_marque`) REFERENCES `marque` (`id_marque`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
