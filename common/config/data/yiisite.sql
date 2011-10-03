-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Sam 01 Octobre 2011 à 23:40
-- Version du serveur: 5.5.8
-- Version de PHP: 5.3.5

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
-- Structure de la table `tbl_category`
--

CREATE TABLE IF NOT EXISTS `tbl_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `lft` int(3) NOT NULL,
  `rgt` int(3) NOT NULL,
  `level` int(3) NOT NULL,
  `root` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `rght` (`rgt`),
  KEY `level` (`level`),
  KEY `lft` (`lft`),
  KEY `root` (`root`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `tbl_category`
--

INSERT INTO `tbl_category` (`id`, `title`, `content`, `lft`, `rgt`, `level`, `root`) VALUES
(1, 'fgdfgdfg', '', 1, 2, 1, 1),
(2, 'general', '', 1, 2, 1, 2),
(3, 'pop', '', 1, 2, 1, 3),
(4, '7878piopiop', '', 1, 2, 1, 4),
(5, 'erzerzer', '', 1, 2, 1, 5);

-- --------------------------------------------------------

--
-- Structure de la table `tbl_page`
--

CREATE TABLE IF NOT EXISTS `tbl_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `slug` varchar(128) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `lft` int(3) NOT NULL,
  `rght` int(3) NOT NULL,
  `level` int(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `update_user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `tbl_page`
--

INSERT INTO `tbl_page` (`id`, `title`, `content`, `slug`, `parent_id`, `lft`, `rght`, `level`, `status`, `create_time`, `update_time`, `user_id`, `update_user_id`) VALUES
(1, 'About', 'About page', 'about', 1, 1, 2, 1, 2, '2011-09-30 22:33:55', '2011-09-30 22:33:55', 1, 1),
(2, 'Services', 'Services page', 'services', 2, 1, 6, 1, 2, '2011-09-30 22:34:52', '2011-09-30 22:34:52', 1, 1),
(3, 'Webdesign', 'Webdesign page', 'webdesign', 2, 2, 3, 2, 2, '2011-09-30 22:35:20', '2011-09-30 22:35:20', 1, 1),
(4, 'Web Dev', 'web dev page updated', 'web-dev', 2, 4, 5, 2, 2, '2011-09-30 22:45:52', '2011-09-30 23:04:00', 1, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `tbl_user`
--

INSERT INTO `tbl_user` (`id`, `username`, `password`, `full_name`, `email`, `create_time`, `update_time`, `create_user_id`, `update_user_id`, `status`) VALUES
(1, 'admin', 'e841fd2479295626c38cc15d5da8ce1e008928f6', 'Cherif BOUCHELAGHEM', 'cherifbouchelaghem@yahoo.fr', '2011-06-17 18:32:00', '0000-00-00 00:00:00', 0, 0, 1);
