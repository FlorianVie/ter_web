-- --------------------------------------------------------
-- Hôte :                        localhost
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour ter
CREATE DATABASE IF NOT EXISTS `ter` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `ter`;

-- Listage de la structure de la table ter. 1_back
CREATE TABLE IF NOT EXISTS `1_back` (
  `id_1_back` int(11) DEFAULT NULL,
  `0` text,
  `1` text,
  `2` text,
  `3` text,
  `4` text,
  `5` text,
  `6` text,
  `7` text,
  `8` text,
  `9` text,
  `10` text,
  `11` text,
  `12` text,
  `13` text,
  `14` text,
  `15` text,
  `16` text,
  `17` text,
  `18` text,
  `19` text,
  `20` text,
  `21` text,
  `22` text,
  `23` text,
  `24` text,
  `25` text,
  `26` text,
  `27` text,
  `28` text,
  `29` text,
  `30` text,
  `31` text,
  `32` text,
  `33` text,
  `34` text,
  `35` text,
  `36` text,
  `37` text,
  `38` text,
  `39` text,
  `40` text,
  `41` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table ter. 2_back
CREATE TABLE IF NOT EXISTS `2_back` (
  `id_2_back` int(11) DEFAULT NULL,
  `0` text,
  `1` text,
  `2` text,
  `3` text,
  `4` text,
  `5` text,
  `6` text,
  `7` text,
  `8` text,
  `9` text,
  `10` text,
  `11` text,
  `12` text,
  `13` text,
  `14` text,
  `15` text,
  `16` text,
  `17` text,
  `18` text,
  `19` text,
  `20` text,
  `21` text,
  `22` text,
  `23` text,
  `24` text,
  `25` text,
  `26` text,
  `27` text,
  `28` text,
  `29` text,
  `30` text,
  `31` text,
  `32` text,
  `33` text,
  `34` text,
  `35` text,
  `36` text,
  `37` text,
  `38` text,
  `39` text,
  `40` text,
  `41` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table ter. back_0
CREATE TABLE IF NOT EXISTS `back_0` (
  `view_history` text,
  `rt` text,
  `part` text,
  `trial_type` text,
  `trial_index` int(11) DEFAULT NULL,
  `time_elapsed` int(11) DEFAULT NULL,
  `internal_node_id` text,
  `subject` text,
  `stimulus` text,
  `key_press` text,
  `letter` text,
  `trial_id` text,
  `correct` text,
  `is_target` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table ter. back_1
CREATE TABLE IF NOT EXISTS `back_1` (
  `view_history` text,
  `rt` double DEFAULT NULL,
  `part` text,
  `trial_type` text,
  `trial_index` int(11) DEFAULT NULL,
  `time_elapsed` int(11) DEFAULT NULL,
  `internal_node_id` text,
  `id_subject` int(11) DEFAULT NULL,
  `id_1_back` int(11) DEFAULT NULL,
  `stimulus` text,
  `key_press` text,
  `letter` text,
  `trial_id` int(11) DEFAULT NULL,
  `prev_letter` text,
  `is_target` int(11) DEFAULT NULL,
  `correct` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table ter. back_2
CREATE TABLE IF NOT EXISTS `back_2` (
  `view_history` text,
  `rt` double DEFAULT NULL,
  `part` text,
  `trial_type` text,
  `trial_index` int(11) DEFAULT NULL,
  `time_elapsed` int(11) DEFAULT NULL,
  `internal_node_id` text,
  `id_subject` int(11) DEFAULT NULL,
  `id_2_back` int(11) DEFAULT NULL,
  `stimulus` text,
  `key_press` text,
  `letter` text,
  `trial_id` int(11) DEFAULT NULL,
  `prev_letter` text,
  `is_target` int(11) DEFAULT NULL,
  `correct` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table ter. configs
CREATE TABLE IF NOT EXISTS `configs` (
  `langue` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table ter. data
CREATE TABLE IF NOT EXISTS `data` (
  `view_history` text,
  `rt` text,
  `part` text,
  `trial_type` text,
  `trial_index` int(11) DEFAULT NULL,
  `time_elapsed` int(11) DEFAULT NULL,
  `internal_node_id` text,
  `subject` text,
  `stimulus` text,
  `key_press` text,
  `responses` text,
  `correct_letters` text,
  `letters_recalled` text,
  `correct` text,
  `button_pressed` text,
  `make_sense` text,
  `timeout_var` text,
  `set_number` text,
  `size` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table ter. entrainement
CREATE TABLE IF NOT EXISTS `entrainement` (
  `id_practice` int(11) NOT NULL AUTO_INCREMENT,
  `pracSentence` text,
  `correct` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_practice`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table ter. letters
CREATE TABLE IF NOT EXISTS `letters` (
  `id_letters` int(11) NOT NULL AUTO_INCREMENT,
  `letter` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id_letters`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table ter. phrases
CREATE TABLE IF NOT EXISTS `phrases` (
  `id_sentences` int(11) NOT NULL AUTO_INCREMENT,
  `sentence` text,
  `correct` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_sentences`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table ter. practice
CREATE TABLE IF NOT EXISTS `practice` (
  `id_practice` int(11) NOT NULL AUTO_INCREMENT,
  `pracSentence` text,
  `correct` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_practice`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table ter. sentences
CREATE TABLE IF NOT EXISTS `sentences` (
  `id_sentences` int(11) NOT NULL AUTO_INCREMENT,
  `sentence` text,
  `correct` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_sentences`)
) ENGINE=InnoDB AUTO_INCREMENT=82 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

-- Listage de la structure de la table ter. subjects
CREATE TABLE IF NOT EXISTS `subjects` (
  `id_subject` int(11) NOT NULL AUTO_INCREMENT,
  `back_1_level` int(11) NOT NULL DEFAULT '0',
  `back_2_level` int(11) NOT NULL DEFAULT '0',
  `oxford` int(11) DEFAULT NULL,
  `typing_speed` int(11) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sexe` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_subject`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Les données exportées n'étaient pas sélectionnées.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
