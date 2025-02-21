-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 21 fév. 2025 à 15:17
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `qcm_platform`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mis_a_jour_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `image`, `cree_le`, `mis_a_jour_le`) VALUES
(1, 'Géographie', 'https://cdn.pixabay.com/photo/2021/11/23/21/48/continents-6819704_1280.jpg', '2025-02-20 09:49:11', '2025-02-21 09:33:31'),
(2, 'Littérature', 'https://media.istockphoto.com/id/1222550815/fr/photo/ligne-de-livres-sur-une-%C3%A9tag%C3%A8re-%C3%A9pines-de-livre-multicolores-pile-au-premier-plan.jpg?s=2048x2048&w=is&k=20&c=---PZiouX9WmLVHuQOkkCCAMAgM5oCvBpRw1N4JzYlU=', '2025-02-20 09:49:11', '2025-02-21 09:38:39'),
(3, 'Mathématiques', 'https://cdn.pixabay.com/photo/2015/11/05/08/21/geometry-1023846_1280.jpg', '2025-02-20 09:49:11', '2025-02-21 09:39:18'),
(4, 'Science', 'https://cdn.pixabay.com/photo/2022/03/25/14/25/analysis-7091203_1280.jpg', '2025-02-20 09:49:11', '2025-02-21 09:34:30'),
(5, 'Histoire', 'https://cdn.pixabay.com/photo/2018/05/17/16/03/compass-3408928_1280.jpg', '2025-02-21 09:22:04', '2025-02-21 09:33:10'),
(6, 'Cinema', 'https://cdn.pixabay.com/photo/2017/09/30/10/11/camera-2801675_1280.jpg', '2025-02-21 09:22:04', '2025-02-21 09:33:54'),
(7, 'Art', 'https://cdn.pixabay.com/photo/2017/12/28/16/18/bicycle-3045580_1280.jpg', '2025-02-21 09:22:04', '2025-02-21 09:35:02'),
(8, 'Sport', 'https://cdn.pixabay.com/photo/2016/02/15/11/43/running-track-1201014_1280.jpg', '2025-02-21 09:22:04', '2025-02-21 09:34:49');

-- --------------------------------------------------------

--
-- Structure de la table `choix_utilisateur`
--

DROP TABLE IF EXISTS `choix_utilisateur`;
CREATE TABLE IF NOT EXISTS `choix_utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int DEFAULT NULL,
  `question_id` int DEFAULT NULL,
  `reponse_id` int DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  KEY `question_id` (`question_id`),
  KEY `reponse_id` (`reponse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `choix_utilisateur`
--

INSERT INTO `choix_utilisateur` (`id`, `utilisateur_id`, `question_id`, `reponse_id`, `cree_le`) VALUES
(1, 1, 1, 1, '2025-02-20 09:52:00'),
(2, 1, 2, 2, '2025-02-20 09:52:00');

-- --------------------------------------------------------

--
-- Structure de la table `niveaux_difficulte`
--

DROP TABLE IF EXISTS `niveaux_difficulte`;
CREATE TABLE IF NOT EXISTS `niveaux_difficulte` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `niveaux_difficulte`
--

INSERT INTO `niveaux_difficulte` (`id`, `nom`, `description`) VALUES
(1, 'Facile', 'Niveau de difficulté facile.'),
(2, 'Moyen', 'Niveau de difficulté moyen.'),
(3, 'Difficile', 'Niveau de difficulté difficile.');

-- --------------------------------------------------------

--
-- Structure de la table `qcm`
--

DROP TABLE IF EXISTS `qcm`;
CREATE TABLE IF NOT EXISTS `qcm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `createur_id` int DEFAULT NULL,
  `categorie_id` int DEFAULT NULL,
  `difficulte_id` int DEFAULT NULL,
  `limite_temps` int DEFAULT NULL COMMENT 'Limite de temps en secondes',
  `cree_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mis_a_jour_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `createur_id` (`createur_id`),
  KEY `categorie_id` (`categorie_id`),
  KEY `difficulte_id` (`difficulte_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `qcm`
--

INSERT INTO `qcm` (`id`, `titre`, `description`, `image`, `createur_id`, `categorie_id`, `difficulte_id`, `limite_temps`, `cree_le`, `mis_a_jour_le`) VALUES
(1, 'Test de Géographie', 'Ce QCM teste vos connaissances en géographie.', 'https://img.icons8.com/ios/100/europe.png', 1, 1, 1, 300, '2025-02-20 09:52:00', '2025-02-21 09:56:54'),
(2, 'Test de Littérature', 'Ce QCM teste vos connaissances en littérature.', 'https://img.icons8.com/?size=100&id=1767&format=png&color=000000', 1, 2, 1, 300, '2025-02-20 09:52:00', '2025-02-21 10:01:19'),
(3, 'Test de Mathématiques', 'Ce QCM teste vos connaissances en mathématiques.', 'https://img.icons8.com/?size=100&id=77479&format=png&color=000000', 1, 3, 1, 300, '2025-02-20 09:52:00', '2025-02-21 10:01:48'),
(4, 'Test de Science', 'Ce QCM teste vos connaissances en sciences.', 'https://img.icons8.com/ios/100/microscope.png', 1, 4, 1, 300, '2025-02-20 09:52:00', '2025-02-21 09:57:51'),
(5, 'Histoire', 'Ce QCM teste vos connaissances en Histoire.', 'https://img.icons8.com/dotty/100/museum.png', 1, 5, 1, NULL, '2025-02-21 09:52:17', '2025-02-21 09:57:29'),
(6, 'Cinéma', 'Ce QCM teste vos connaissances en Cinéma.', 'https://img.icons8.com/fluency-systems-regular/100/clapperboard.png', 1, 6, 2, NULL, '2025-02-21 09:52:17', '2025-02-21 09:58:14'),
(7, 'Art', 'Ce QCM teste vos connaissances en art.', 'https://img.icons8.com/ios/100/exhibition.png', 1, 7, 2, NULL, '2025-02-21 09:53:04', '2025-02-21 09:58:40'),
(8, 'Sport', 'Ce QCM teste vos connaissances en sport.', 'https://img.icons8.com/fluency-systems-regular/100/sports.png', 1, 8, 3, NULL, '2025-02-21 09:53:04', '2025-02-21 10:00:20');

-- --------------------------------------------------------

--
-- Structure de la table `qcm_tags`
--

DROP TABLE IF EXISTS `qcm_tags`;
CREATE TABLE IF NOT EXISTS `qcm_tags` (
  `qcm_id` int NOT NULL,
  `tag_id` int NOT NULL,
  PRIMARY KEY (`qcm_id`,`tag_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `qcm_id` int DEFAULT NULL,
  `texte_question` text COLLATE utf8mb4_general_ci NOT NULL,
  `type_question` enum('qcm','qcs') COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'qcm',
  `feedback` text COLLATE utf8mb4_general_ci,
  `cree_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mis_a_jour_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `qcm_id` (`qcm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `questions`
--

INSERT INTO `questions` (`id`, `qcm_id`, `texte_question`, `type_question`, `feedback`, `cree_le`, `mis_a_jour_le`) VALUES
(1, 1, 'Quelle est la capitale de la France ?', 'qcm', 'La capitale de la France est Paris.', '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(2, 1, 'Quel est le plus long fleuve du monde ?', 'qcm', 'Le plus long fleuve du monde est l\'Amazone.', '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(3, 2, 'Qui a écrit \"Hamlet\" ?', 'qcm', 'L\'auteur de \"Hamlet\" est William Shakespeare.', '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(4, 2, 'Quel est le nom du héros de \"L\'Odyssée\" ?', 'qcm', 'Le héros de \"L\'Odyssée\" est Ulysse.', '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(5, 3, 'Quel est 5 + 3 ?', 'qcm', 'La somme de 5 et 3 est égale à 8.', '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(6, 3, 'Résoudre l\'équation x^2 - 4 = 0', 'qcm', 'La solution de l\'équation x^2 - 4 = 0 est x = ±2.', '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(7, 4, 'Quelle planète est connue sous le nom de planète rouge ?', 'qcm', 'La planète rouge est Mars.', '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(8, 4, 'Qu\'est-ce que la photosynthèse ?', 'qcm', 'La photosynthèse est le processus par lequel les plantes transforment l\'énergie solaire.', '2025-02-20 09:52:00', '2025-02-20 09:52:00');

-- --------------------------------------------------------

--
-- Structure de la table `reponses_utilisateur`
--

DROP TABLE IF EXISTS `reponses_utilisateur`;
CREATE TABLE IF NOT EXISTS `reponses_utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_id` int DEFAULT NULL,
  `texte_reponse` text COLLATE utf8mb4_general_ci NOT NULL,
  `est_correcte` tinyint(1) NOT NULL DEFAULT '0',
  `cree_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mis_a_jour_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `question_id` (`question_id`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `reponses_utilisateur`
--

INSERT INTO `reponses_utilisateur` (`id`, `question_id`, `texte_reponse`, `est_correcte`, `cree_le`, `mis_a_jour_le`) VALUES
(1, 1, 'Paris', 1, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(2, 1, 'Londres', 0, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(3, 1, 'Berlin', 0, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(4, 1, 'Madrid', 0, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(5, 2, 'Nil', 0, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(6, 2, 'Amazone', 1, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(7, 2, 'Yangtze', 0, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(8, 2, 'Mississippi', 0, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(9, 3, 'Shakespeare', 1, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(10, 3, 'Hemingway', 0, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(11, 3, 'Tolkien', 0, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(12, 3, 'Rowling', 0, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(13, 4, 'Achille', 0, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(14, 4, 'Ulysse', 1, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(15, 4, 'Hercule', 0, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(16, 4, 'Jason', 0, '2025-02-20 09:52:00', '2025-02-20 09:52:00'),
(66, 5, '8', 1, '2025-02-20 18:10:40', '2025-02-20 18:10:40'),
(67, 5, '10', 0, '2025-02-20 18:10:40', '2025-02-20 18:10:40'),
(68, 5, '6', 0, '2025-02-20 18:10:40', '2025-02-20 18:10:40'),
(69, 5, '9', 0, '2025-02-20 18:10:40', '2025-02-20 18:10:40'),
(70, 6, 'x = 2 ou x = -2', 1, '2025-02-20 18:11:18', '2025-02-20 18:11:18'),
(71, 6, 'x = 4 ou x = -4', 0, '2025-02-20 18:11:18', '2025-02-20 18:11:18'),
(72, 6, 'x = 0', 0, '2025-02-20 18:11:18', '2025-02-20 18:11:18'),
(73, 6, 'x = -2', 0, '2025-02-20 18:11:18', '2025-02-20 18:11:18'),
(74, 7, 'Mars', 1, '2025-02-20 18:11:47', '2025-02-20 18:11:47'),
(75, 7, 'Jupiter', 0, '2025-02-20 18:11:47', '2025-02-20 18:11:47'),
(76, 7, 'Saturne', 0, '2025-02-20 18:11:47', '2025-02-20 18:11:47'),
(77, 7, 'Vénus', 0, '2025-02-20 18:11:47', '2025-02-20 18:11:47'),
(78, 8, 'Un processus de conversion de l\'énergie solaire en nourriture', 1, '2025-02-20 18:12:15', '2025-02-20 18:12:15'),
(79, 8, 'Un type de gaz présent sur Mars', 0, '2025-02-20 18:12:15', '2025-02-20 18:12:15'),
(80, 8, 'Une réaction chimique dans les moteurs de voiture', 0, '2025-02-20 18:12:15', '2025-02-20 18:12:15'),
(81, 8, 'Un phénomène météorologique', 0, '2025-02-20 18:12:15', '2025-02-20 18:12:15');

-- --------------------------------------------------------

--
-- Structure de la table `resultats_utilisateur_qcm`
--

DROP TABLE IF EXISTS `resultats_utilisateur_qcm`;
CREATE TABLE IF NOT EXISTS `resultats_utilisateur_qcm` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int DEFAULT NULL,
  `qcm_id` int DEFAULT NULL,
  `score` int NOT NULL,
  `complete_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`),
  KEY `qcm_id` (`qcm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `resultats_utilisateur_qcm`
--

INSERT INTO `resultats_utilisateur_qcm` (`id`, `utilisateur_id`, `qcm_id`, `score`, `complete_le`) VALUES
(1, 1, 1, 0, '2025-02-20 15:19:18'),
(2, 1, 1, 1, '2025-02-20 15:21:26'),
(3, 1, 1, 1, '2025-02-20 15:22:54'),
(4, 1, 1, 1, '2025-02-20 15:29:27'),
(5, 1, 1, 1, '2025-02-20 15:38:57'),
(6, 1, 1, 1, '2025-02-20 15:44:00'),
(7, 1, 1, 1, '2025-02-20 15:45:39'),
(8, 1, 1, 1, '2025-02-20 15:49:53'),
(9, 1, 1, 1, '2025-02-20 16:02:48'),
(10, 1, 1, 1, '2025-02-20 16:07:32'),
(11, 1, 1, 1, '2025-02-20 16:07:54'),
(12, 1, 2, 1, '2025-02-20 16:15:17'),
(13, 1, 1, 0, '2025-02-20 16:16:59'),
(14, 1, 4, 0, '2025-02-20 16:33:57'),
(15, 1, 4, 0, '2025-02-20 16:36:12'),
(16, 1, 4, 0, '2025-02-20 16:39:57'),
(17, 1, 4, 0, '2025-02-20 17:25:29'),
(18, 1, 3, 0, '2025-02-20 17:27:46'),
(19, 1, 3, 0, '2025-02-20 17:29:13'),
(20, 1, 4, 0, '2025-02-20 17:30:01'),
(21, 1, 3, 0, '2025-02-20 17:33:45'),
(22, 1, 1, 2, '2025-02-20 17:45:18'),
(23, 1, 3, 0, '2025-02-20 17:46:01'),
(24, 1, 3, 0, '2025-02-20 17:53:28'),
(25, 1, 3, 0, '2025-02-20 17:56:27'),
(26, 1, 3, 0, '2025-02-20 17:58:44'),
(27, 1, 4, 2, '2025-02-20 18:07:33'),
(28, 1, 3, 1, '2025-02-20 18:12:45'),
(29, 1, 4, 1, '2025-02-20 18:12:58'),
(30, 1, 1, 0, '2025-02-21 08:20:22'),
(31, 1, 1, 0, '2025-02-21 10:36:41'),
(32, 1, 2, 0, '2025-02-21 10:37:24'),
(33, 1, 1, 1, '2025-02-21 11:08:26'),
(34, 1, 1, 1, '2025-02-21 12:36:49'),
(35, 1, 1, 1, '2025-02-21 14:44:12');

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `nom_utilisateur` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `mot_de_passe` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `code_confirmation` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `est_confirme` tinyint(1) DEFAULT '0',
  `code_reinitialisation` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `expiration_code_reinitialisation` timestamp NULL DEFAULT NULL,
  `est_reinitialise` tinyint(1) DEFAULT '0',
  `cree_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `mis_a_jour_le` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `prenom`, `nom`, `nom_utilisateur`, `email`, `mot_de_passe`, `code_confirmation`, `est_confirme`, `code_reinitialisation`, `expiration_code_reinitialisation`, `est_reinitialise`, `cree_le`, `mis_a_jour_le`) VALUES
(1, 'Test', 'test', 'test123', 'pateyih553@kytstore.com', '$2y$10$CkI..6qBU8tVZIkV2zyKWeMX5aYzpd1DihByR9IiRhbYdPSp2qKF.', NULL, 1, NULL, NULL, 1, '2025-02-18 14:30:35', '2025-02-19 16:03:42'),
(11, 'Amani', 'GHARBI', 'abd123', 'amanigharbi676@gmail.com', '$2y$10$FzCLPJWFUk1joX7hzXA/AuvjN7Te631RsSS.bTeb3SVIx43/AGhx.', NULL, 1, NULL, NULL, 0, '2025-02-21 15:07:19', '2025-02-21 15:07:28');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `choix_utilisateur`
--
ALTER TABLE `choix_utilisateur`
  ADD CONSTRAINT `choix_utilisateur_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `choix_utilisateur_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `choix_utilisateur_ibfk_3` FOREIGN KEY (`reponse_id`) REFERENCES `reponses_utilisateur` (`id`);

--
-- Contraintes pour la table `qcm`
--
ALTER TABLE `qcm`
  ADD CONSTRAINT `qcm_ibfk_1` FOREIGN KEY (`createur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `qcm_ibfk_2` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `qcm_ibfk_3` FOREIGN KEY (`difficulte_id`) REFERENCES `niveaux_difficulte` (`id`);

--
-- Contraintes pour la table `qcm_tags`
--
ALTER TABLE `qcm_tags`
  ADD CONSTRAINT `qcm_tags_ibfk_1` FOREIGN KEY (`qcm_id`) REFERENCES `qcm` (`id`),
  ADD CONSTRAINT `qcm_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

--
-- Contraintes pour la table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`qcm_id`) REFERENCES `qcm` (`id`);

--
-- Contraintes pour la table `reponses_utilisateur`
--
ALTER TABLE `reponses_utilisateur`
  ADD CONSTRAINT `reponses_utilisateur_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Contraintes pour la table `resultats_utilisateur_qcm`
--
ALTER TABLE `resultats_utilisateur_qcm`
  ADD CONSTRAINT `resultats_utilisateur_qcm_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `resultats_utilisateur_qcm_ibfk_2` FOREIGN KEY (`qcm_id`) REFERENCES `qcm` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
