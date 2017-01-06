-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 06, 2017 at 10:09 PM
-- Server version: 5.6.33
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aizan_local`
--

-- --------------------------------------------------------

--
-- Table structure for table `module_fields_group`
--

DROP TABLE IF EXISTS `module_fields_group`;
CREATE TABLE `module_fields_group` (
  `id` int(11) NOT NULL,
  `group_name` varchar(100) NOT NULL DEFAULT '',
  `group_display_order` tinyint(4) NOT NULL,
  `type` varchar(100) NOT NULL,
  `module_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `module_fields_group`
--

INSERT INTO `module_fields_group` (`id`, `group_name`, `group_display_order`, `type`, `module_name`) VALUES
(1, '', 1, 'default', ''),
(19, 'Display setting', 4, 'custom', 'initiative'),
(20, 'Display11', 5, 'custom', 'customer'),
(21, 'Setting', 4, 'custom', 'campaign');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `module_fields_group`
--
ALTER TABLE `module_fields_group`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type` (`type`),
  ADD KEY `group_display_order` (`group_display_order`,`module_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `module_fields_group`
--
ALTER TABLE `module_fields_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

ALTER TABLE `module_settings` ADD `field_group_id` INT NOT NULL AFTER `formulafield`;
