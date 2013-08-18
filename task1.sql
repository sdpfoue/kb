-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2013 at 10:22 PM
-- Server version: 5.5.29
-- PHP Version: 5.3.15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `task1`
--

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_city_id` int(10) unsigned NOT NULL,
  `x` tinyint(3) unsigned NOT NULL,
  `y` tinyint(3) unsigned NOT NULL,
  `city_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city_id` (`city_id`),
  UNIQUE KEY `parent_city_id` (`parent_city_id`,`x`,`y`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `gold` int(10) unsigned NOT NULL DEFAULT '0',
  `population` int(10) unsigned NOT NULL DEFAULT '0',
  `food` int(10) unsigned NOT NULL,
  `tax` decimal(3,2) unsigned NOT NULL,
  `player_id` int(10) unsigned NOT NULL,
  `is_capital` tinyint(3) unsigned NOT NULL,
  `created_at` int(11) NOT NULL,
  `last_food_checked_out_at` int(11) NOT NULL COMMENT '上次食物结算时间',
  `last_gold_checked_out_at` int(11) NOT NULL COMMENT '上次金币结算时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=123 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
