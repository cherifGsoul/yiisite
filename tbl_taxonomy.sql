-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Lun 10 Octobre 2011 à 00:03
-- Version du serveur: 5.1.54
-- Version de PHP: 5.3.5-1ubuntu7.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `yiisite`
--

-- --------------------------------------------------------

--
-- Structure de la table `tbl_taxonomy`
--

CREATE TABLE IF NOT EXISTS `tbl_taxonomy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `description` text,
  `type` varchar(60) NOT NULL DEFAULT 'category',
  `slug` varchar(128) NOT NULL,
  `lft` int(3) NOT NULL,
  `rgt` int(3) NOT NULL,
  `level` int(3) NOT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `fk_tbl_taxonomy_user1` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `tbl_taxonomy`
--

INSERT INTO `tbl_taxonomy` (`id`, `title`, `description`, `type`, `slug`, `lft`, `rgt`, `level`, `parent_id`, `create_time`, `update_time`, `update_user_id`, `user_id`) VALUES
(6, 'Php', 'eaze', 'category', 'php', 0, 0, 0, NULL, '2011-10-09 20:24:39', '2011-10-09 20:24:39', 2, 2),
(7, 'Php', '', 'category', 'php', 0, 0, 0, NULL, '2011-10-09 21:29:34', '2011-10-09 21:29:34', 2, 2),
(8, 'Php', 'hjhkj', 'category', 'php', 0, 0, 0, NULL, '2011-10-09 22:32:42', '2011-10-09 22:32:42', 2, 2);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `tbl_taxonomy`
--
ALTER TABLE `tbl_taxonomy`
  ADD CONSTRAINT `fk_tbl_taxonomy_tbl_user1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
