-- phpMyAdmin SQL Dump
-- version 3.3.10deb1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 11 Octobre 2011 à 19:48
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
-- Structure de la table `tbl_comment`
--

CREATE TABLE IF NOT EXISTS `tbl_comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL,
  `create_time` int(11) DEFAULT NULL,
  `author` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `content_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_content_id` (`content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Contenu de la table `tbl_comment`
--


-- --------------------------------------------------------

--
-- Structure de la table `tbl_content`
--

CREATE TABLE IF NOT EXISTS `tbl_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'post',
  `content` text,
  `excerpt` text,
  `slug` varchar(128) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `lft` int(3) DEFAULT NULL,
  `rgt` int(3) DEFAULT NULL,
  `level` int(3) DEFAULT NULL,
  `status` tinyint(1) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `update_user_id` int(11) NOT NULL,
  `meta_description` text,
  `meta_keys` text,
  `meta_robots` varchar(128) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_tbl_content_tbl_user1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `tbl_content`
--


-- --------------------------------------------------------

--
-- Structure de la table `tbl_content_taxonomy`
--

CREATE TABLE IF NOT EXISTS `tbl_content_taxonomy` (
  `tbl_content_id` int(11) NOT NULL,
  `tbl_taxonomy_id` int(11) NOT NULL,
  PRIMARY KEY (`tbl_content_id`,`tbl_taxonomy_id`),
  KEY `fk_tbl_content_has_tbl_taxonomy_tbl_taxonomy1` (`tbl_taxonomy_id`),
  KEY `fk_tbl_content_has_tbl_taxonomy_tbl_content1` (`tbl_content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `tbl_content_taxonomy`
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
  `lft` int(3) DEFAULT NULL,
  `rgt` int(3) DEFAULT NULL,
  `level` int(3) DEFAULT NULL,
  `parent_id` int(10) DEFAULT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `fk_tbl_taxonomy_user1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `tbl_taxonomy`
--


-- --------------------------------------------------------

--
-- Structure de la table `tbl_user`
--

CREATE TABLE IF NOT EXISTS `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(60) NOT NULL,
  `password` varchar(40) NOT NULL,
  `full_name` text NOT NULL,
  `email` varchar(128) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `full_name`, `email`, `create_time`, `update_time`, `create_user_id`, `update_user_id`, `status`) VALUES
(2, 'admin', 'e841fd2479295626c38cc15d5da8ce1e008928f6', 'Cherif', 'user@site.com', '2011-10-09 00:01:55', '0000-00-00 00:00:00', 0, 0, 1);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `tbl_comment`
--
ALTER TABLE `tbl_comment`
  ADD CONSTRAINT `fk_content_id` FOREIGN KEY (`content_id`) REFERENCES `tbl_content` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tbl_content`
--
ALTER TABLE `tbl_content`
  ADD CONSTRAINT `fk_tbl_content_tbl_user1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `tbl_content_taxonomy`
--
ALTER TABLE `tbl_content_taxonomy`
  ADD CONSTRAINT `tbl_content_taxonomy_ibfk_1` FOREIGN KEY (`tbl_content_id`) REFERENCES `tbl_content` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tbl_content_taxonomy_ibfk_2` FOREIGN KEY (`tbl_taxonomy_id`) REFERENCES `tbl_taxonomy` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tbl_taxonomy`
--
ALTER TABLE `tbl_taxonomy`
  ADD CONSTRAINT `fk_tbl_taxonomy_tbl_user1` FOREIGN KEY (`user_id`) REFERENCES `tbl_user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
