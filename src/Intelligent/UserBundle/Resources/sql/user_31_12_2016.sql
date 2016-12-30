-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 30, 2016 at 08:07 PM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `aizan`
--

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
`id` int(10) unsigned NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `description`, `status`, `create_datetime`, `update_datetime`) VALUES
(1, 'Admin', 'This is the admin role.', 1, '2016-12-17 02:29:35', '2016-12-17 02:29:35'),
(2, 'Sales', 'Users with sales rep role', 1, '2016-12-21 21:47:34', '2016-12-21 21:47:34'),
(11, 'Merketing', 'This is marketing role description', 1, '2016-12-21 17:47:51', '2016-12-21 17:47:51');

-- --------------------------------------------------------

--
-- Table structure for table `role_global_permission`
--

DROP TABLE IF EXISTS `role_global_permission`;
CREATE TABLE IF NOT EXISTS `role_global_permission` (
`id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `manage_user_app_permission` tinyint(1) NOT NULL,
  `edit_app_structure_permission` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `role_global_permission`
--

INSERT INTO `role_global_permission` (`id`, `role_id`, `manage_user_app_permission`, `edit_app_structure_permission`) VALUES
(1, 1, 1, 1),
(2, 2, 0, 0),
(8, 11, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_module_field_permission`
--

DROP TABLE IF EXISTS `role_module_field_permission`;
CREATE TABLE IF NOT EXISTS `role_module_field_permission` (
`id` int(10) unsigned NOT NULL,
  `module_permission_id` int(10) unsigned NOT NULL,
  `field_name_id` varchar(100) NOT NULL,
  `permission` tinyint(4) NOT NULL COMMENT '1=> view, 2=> edit'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `role_module_field_permission`
--

INSERT INTO `role_module_field_permission` (`id`, `module_permission_id`, `field_name_id`, `permission`) VALUES
(1, 1, 'field13', 2),
(2, 4, 'customer_name', 1),
(4, 4, 'customer_manager', 1),
(5, 4, 'field13', 2),
(6, 5, 'project_manager', 1),
(7, 4, 'enumfield1', 2),
(8, 4, 'name', 2),
(9, 7, 'field2', 0),
(10, 7, 'email_id', 0);

-- --------------------------------------------------------

--
-- Table structure for table `role_module_permission`
--

DROP TABLE IF EXISTS `role_module_permission`;
CREATE TABLE IF NOT EXISTS `role_module_permission` (
`id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `module` varchar(50) NOT NULL,
  `view_permission` tinyint(3) unsigned NOT NULL,
  `modify_permission` tinyint(3) unsigned NOT NULL,
  `add_permission` tinyint(1) NOT NULL,
  `delete_permission` tinyint(1) NOT NULL,
  `field_permission` tinyint(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `role_module_permission`
--

INSERT INTO `role_module_permission` (`id`, `role_id`, `module`, `view_permission`, `modify_permission`, `add_permission`, `delete_permission`, `field_permission`) VALUES
(2, 1, 'MarketingMailers', 1, 1, 1, 1, 0),
(4, 1, 'customer', 0, 0, 0, 1, 1),
(5, 1, 'marketing_projects', 0, 0, 0, 0, 0),
(6, 1, 'campaign', 0, 1, 0, 0, 0),
(7, 1, 'psuedo_email_accounts', 0, 0, 0, 0, 1),
(8, 11, 'customer', 1, 0, 1, 0, 1),
(9, 11, 'assign_psuedo', 0, 0, 0, 0, 0),
(10, 11, 'psuedo_email_accounts', 0, 0, 0, 0, 1),
(11, 2, 'psuedo_email_accounts', 1, 1, 0, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) unsigned NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `verification_id` varchar(100) DEFAULT NULL,
  `password_reset_id` varchar(100) DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL COMMENT '1=>''registered'', 2=>''unregistered'', 3=>''unverified'', 4=>''deactivated'',5=>''denied'',6=>password_reset ',
  `before_disable_status` tinyint(4) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `current_customer` int(11) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `name`, `verification_id`, `password_reset_id`, `status`, `before_disable_status`, `role_id`, `current_customer`, `last_login`, `create_datetime`, `update_datetime`) VALUES
(1, 'teja.nri@gmail.com', '12345', 'Hello', '12345', NULL, 1, NULL, 1, 5, '2016-12-29 18:59:48', '2016-12-16 00:00:39', '2016-12-28 13:34:47'),
(2, 'teja@hi.com', '12345', 'Tej Sharma', '123456', NULL, 1, 1, 2, NULL, NULL, '2016-12-21 00:16:15', '2016-12-30 12:04:50'),
(3, 'tejaswi@intelligent.com', NULL, NULL, '585a9c1abb49a', NULL, 1, 3, 11, NULL, NULL, '2016-12-21 15:13:30', '2016-12-30 12:05:22'),
(4, 'tej.nri@gmail.com', '12345', NULL, '585a9c9d26651', NULL, 1, 3, 1, NULL, '2016-12-28 13:37:39', '2016-12-21 15:15:41', '2016-12-28 13:40:53');

-- --------------------------------------------------------

--
-- Table structure for table `user_allowed_customers`
--
DROP TABLE IF EXISTS `role_allowed_customers`;
DROP TABLE IF EXISTS `user_allowed_customers`;
CREATE TABLE IF NOT EXISTS `user_allowed_customers` (
`id` int(10) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `user_allowed_customers`
--

INSERT INTO `user_allowed_customers` (`id`, `user_id`, `customer_id`, `is_active`) VALUES
(3, 1, 1, 1),
(4, 1, 2, 1),
(5, 1, 3, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `role`
--
ALTER TABLE `role`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_global_permission`
--
ALTER TABLE `role_global_permission`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_module_field_permission`
--
ALTER TABLE `role_module_field_permission`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_module_permission`
--
ALTER TABLE `role_module_permission`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_allowed_customers`
--
ALTER TABLE `user_allowed_customers`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `role_global_permission`
--
ALTER TABLE `role_global_permission`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `role_module_field_permission`
--
ALTER TABLE `role_module_field_permission`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `role_module_permission`
--
ALTER TABLE `role_module_permission`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_allowed_customers`
--
ALTER TABLE `user_allowed_customers`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;