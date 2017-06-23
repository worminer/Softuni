-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 
-- Версия на сървъра: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `album`
--

-- --------------------------------------------------------

--
-- Структура на таблица `albums`
--

CREATE TABLE IF NOT EXISTS `albums` (
`id` int(11) NOT NULL,
  `albumName` varchar(50) NOT NULL,
  `albumCategories` varchar(50) NOT NULL,
  `albumTags` varchar(50) NOT NULL,
  `albumRating` varchar(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `albums`
--

INSERT INTO `albums` (`id`, `albumName`, `albumCategories`, `albumTags`, `albumRating`) VALUES
(4, 'My Family', 'Family', 'cool, happy', ''),
(5, 'New Album', 'Season', 'with, different, tags', ''),
(6, 'Album1', 'Family', 'ds', ''),
(7, 'MyExtraNewAlbum', 'Season', 'ops, ops, ops', '');

-- --------------------------------------------------------

--
-- Структура на таблица `photos`
--

CREATE TABLE IF NOT EXISTS `photos` (
`id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `tags` varchar(50) NOT NULL,
  `comments` varchar(300) NOT NULL,
  `album_Id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `rating` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

--
-- Схема на данните от таблица `photos`
--

INSERT INTO `photos` (`id`, `name`, `tags`, `comments`, `album_Id`, `url`, `rating`) VALUES
(42, 'picture1', '', '', 5, '30778.jpeg', ''),
(43, 'picture2', '', '', 5, '3307.jpeg', ''),
(44, 'picture3', '', '', 6, '19016.jpeg', ''),
(45, 'picture4', '', '', 7, '16609.jpeg', ''),
(46, 'picture5', '', '', 4, '15608.jpeg', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=47;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
