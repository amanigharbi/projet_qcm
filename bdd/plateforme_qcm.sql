-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 17, 2025 at 04:17 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plateforme_qcm`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp(),
  `mis_a_jour_le` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `choix_utilisateur`
--

CREATE TABLE `choix_utilisateur` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `reponse_id` int(11) DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `niveaux_difficulte`
--

CREATE TABLE `niveaux_difficulte` (
  `id` int(11) NOT NULL,
  `nom` varchar(20) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qcm`
--

CREATE TABLE `qcm` (
  `id` int(11) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `createur_id` int(11) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `difficulte_id` int(11) DEFAULT NULL,
  `limite_temps` int(11) DEFAULT NULL COMMENT 'Limite de temps en secondes',
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp(),
  `mis_a_jour_le` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `qcm_tags`
--

CREATE TABLE `qcm_tags` (
  `qcm_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `qcm_id` int(11) DEFAULT NULL,
  `texte_question` text NOT NULL,
  `type_question` enum('qcm','qcs') NOT NULL DEFAULT 'qcm',
  `feedback` text DEFAULT NULL,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp(),
  `mis_a_jour_le` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reponses_utilisateur`
--

CREATE TABLE `reponses_utilisateur` (
  `id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `texte_reponse` text NOT NULL,
  `est_correcte` tinyint(1) NOT NULL DEFAULT 0,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp(),
  `mis_a_jour_le` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resultats_utilisateur_qcm`
--

CREATE TABLE `resultats_utilisateur_qcm` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `qcm_id` int(11) DEFAULT NULL,
  `score` int(11) NOT NULL,
  `complete_le` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `nom_utilisateur` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `code_confirmation` varchar(255) DEFAULT NULL,
  `est_confirme` tinyint(1) DEFAULT 0,
  `code_reinitialisation` varchar(255) DEFAULT NULL,
  `expiration_code_reinitialisation` timestamp NULL DEFAULT NULL,
  `est_reinitialise` tinyint(1) DEFAULT 0,
  `cree_le` timestamp NOT NULL DEFAULT current_timestamp(),
  `mis_a_jour_le` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `choix_utilisateur`
--
ALTER TABLE `choix_utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `question_id` (`question_id`),
  ADD KEY `reponse_id` (`reponse_id`);

--
-- Indexes for table `niveaux_difficulte`
--
ALTER TABLE `niveaux_difficulte`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qcm`
--
ALTER TABLE `qcm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `createur_id` (`createur_id`),
  ADD KEY `categorie_id` (`categorie_id`),
  ADD KEY `difficulte_id` (`difficulte_id`);

--
-- Indexes for table `qcm_tags`
--
ALTER TABLE `qcm_tags`
  ADD PRIMARY KEY (`qcm_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `qcm_id` (`qcm_id`);

--
-- Indexes for table `reponses_utilisateur`
--
ALTER TABLE `reponses_utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_id` (`question_id`);

--
-- Indexes for table `resultats_utilisateur_qcm`
--
ALTER TABLE `resultats_utilisateur_qcm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `utilisateur_id` (`utilisateur_id`),
  ADD KEY `qcm_id` (`qcm_id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `choix_utilisateur`
--
ALTER TABLE `choix_utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `niveaux_difficulte`
--
ALTER TABLE `niveaux_difficulte`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `qcm`
--
ALTER TABLE `qcm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reponses_utilisateur`
--
ALTER TABLE `reponses_utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resultats_utilisateur_qcm`
--
ALTER TABLE `resultats_utilisateur_qcm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `choix_utilisateur`
--
ALTER TABLE `choix_utilisateur`
  ADD CONSTRAINT `choix_utilisateur_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `choix_utilisateur_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`),
  ADD CONSTRAINT `choix_utilisateur_ibfk_3` FOREIGN KEY (`reponse_id`) REFERENCES `reponses_utilisateur` (`id`);

--
-- Constraints for table `qcm`
--
ALTER TABLE `qcm`
  ADD CONSTRAINT `qcm_ibfk_1` FOREIGN KEY (`createur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `qcm_ibfk_2` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `qcm_ibfk_3` FOREIGN KEY (`difficulte_id`) REFERENCES `niveaux_difficulte` (`id`);

--
-- Constraints for table `qcm_tags`
--
ALTER TABLE `qcm_tags`
  ADD CONSTRAINT `qcm_tags_ibfk_1` FOREIGN KEY (`qcm_id`) REFERENCES `qcm` (`id`),
  ADD CONSTRAINT `qcm_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`);

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_ibfk_1` FOREIGN KEY (`qcm_id`) REFERENCES `qcm` (`id`);

--
-- Constraints for table `reponses_utilisateur`
--
ALTER TABLE `reponses_utilisateur`
  ADD CONSTRAINT `reponses_utilisateur_ibfk_1` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`);

--
-- Constraints for table `resultats_utilisateur_qcm`
--
ALTER TABLE `resultats_utilisateur_qcm`
  ADD CONSTRAINT `resultats_utilisateur_qcm_ibfk_1` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `resultats_utilisateur_qcm_ibfk_2` FOREIGN KEY (`qcm_id`) REFERENCES `qcm` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
