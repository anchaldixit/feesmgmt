# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.6.35)
# Database: feemgmt
# Generation Time: 2018-01-27 08:06:22 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table customer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(400) DEFAULT NULL,
  `modified_datetime` datetime NOT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `address` text,
  `affiliated_from` varchar(400) DEFAULT NULL,
  `affiliate_no_` varchar(100) DEFAULT NULL,
  `manager` varchar(200) DEFAULT NULL,
  `manager_mobile_no` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`),
  KEY `affiliated_from` (`affiliated_from`(255)),
  KEY `affiliate_no_` (`affiliate_no_`),
  KEY `manager` (`manager`),
  KEY `manager_mobile_no` (`manager_mobile_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;

INSERT INTO `customer` (`id`, `customer_name`, `modified_datetime`, `modified_by`, `address`, `affiliated_from`, `affiliate_no_`, `manager`, `manager_mobile_no`)
VALUES
	(2,'Soda','2017-01-11 14:30:55',NULL,NULL,NULL,NULL,NULL,NULL),
	(3,'CMN','2017-01-11 14:36:52',NULL,NULL,NULL,NULL,NULL,NULL),
	(11,'XYZ','2017-08-20 13:31:55',NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table customer_allowed_reports
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer_allowed_reports`;

CREATE TABLE `customer_allowed_reports` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned NOT NULL,
  `report_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table customer_projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer_projects`;

CREATE TABLE `customer_projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `modified_datetime` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `relationship_customer_id` int(11) DEFAULT NULL,
  `website` varchar(200) DEFAULT NULL,
  `main_contact` varchar(100) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `address` text,
  `email_address` varchar(100) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `relationship_customer_id` (`relationship_customer_id`),
  KEY `website` (`website`),
  KEY `main_contact` (`main_contact`),
  KEY `title` (`title`),
  KEY `email_address` (`email_address`),
  KEY `phone` (`phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `customer_projects` WRITE;
/*!40000 ALTER TABLE `customer_projects` DISABLE KEYS */;

INSERT INTO `customer_projects` (`id`, `modified_datetime`, `modified_by`, `linked_customer_id`, `relationship_customer_id`, `website`, `main_contact`, `title`, `address`, `email_address`, `phone`)
VALUES
	(2,'2017-01-12 16:30:55',NULL,2,2,'Reviews.com','Corry Cummings','GM',NULL,'corry@soda.com',NULL),
	(3,'2017-01-12 16:30:55',NULL,2,2,'TheSimpleDollar.com','Corry Cummings','GM',NULL,'corry@soda.com',NULL),
	(4,'2017-12-29 10:08:33',NULL,2,2,'Freshome.com','Adamm','','','',''),
	(5,'2017-01-12 16:31:48',NULL,3,3,'OnlineColleges.net',NULL,NULL,NULL,NULL,NULL),
	(6,'2017-01-12 16:31:48',NULL,3,3,'AccreditedOnlineColleges.org',NULL,NULL,NULL,NULL,NULL),
	(7,'2017-01-12 16:31:48',NULL,3,3,'OnlineSchools.org',NULL,NULL,NULL,NULL,NULL),
	(8,'2017-01-12 16:31:48',NULL,3,3,'BestColleges.com',NULL,NULL,NULL,NULL,NULL),
	(9,'2017-01-12 16:31:48',NULL,3,3,'Accounting.com',NULL,NULL,NULL,NULL,NULL),
	(10,'2017-01-12 16:31:48',NULL,3,3,'RntoBsn.org',NULL,NULL,NULL,NULL,NULL),
	(11,'2017-01-12 16:31:48',NULL,3,3,'MedicalAssistantCertification.org',NULL,NULL,NULL,NULL,NULL),
	(12,'2017-01-12 16:31:48',NULL,3,3,'PublicHealth.org',NULL,NULL,NULL,NULL,NULL),
	(13,'2017-01-12 16:31:48',NULL,3,3,'OnlineMBA',NULL,NULL,NULL,NULL,NULL),
	(14,'2017-01-12 16:31:48',NULL,3,3,'Psychology.org',NULL,NULL,NULL,NULL,NULL),
	(15,'2017-01-12 16:31:48',NULL,3,3,'CriminalJustice.com',NULL,NULL,NULL,NULL,NULL),
	(16,'2017-01-12 16:31:48',NULL,3,3,'MedicalBillingandCoding.org',NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `customer_projects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table degree_subjects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `degree_subjects`;

CREATE TABLE `degree_subjects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `modified_datetime` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `relationship_degrees_id` int(11) DEFAULT NULL,
  `relationship_customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `relationship_degrees_id` (`relationship_degrees_id`),
  KEY `relationship_customer_id` (`relationship_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `degree_subjects` WRITE;
/*!40000 ALTER TABLE `degree_subjects` DISABLE KEYS */;

INSERT INTO `degree_subjects` (`id`, `modified_datetime`, `modified_by`, `linked_customer_id`, `relationship_degrees_id`, `relationship_customer_id`)
VALUES
	(2,'2018-01-25 10:38:05',NULL,2,8,2),
	(3,'2018-01-25 09:29:59',NULL,2,9,NULL);

/*!40000 ALTER TABLE `degree_subjects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table degrees
# ------------------------------------------------------------

DROP TABLE IF EXISTS `degrees`;

CREATE TABLE `degrees` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `modified_datetime` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `degrees` WRITE;
/*!40000 ALTER TABLE `degrees` DISABLE KEYS */;

INSERT INTO `degrees` (`id`, `modified_datetime`, `modified_by`, `linked_customer_id`, `name`)
VALUES
	(7,'2017-12-29 10:16:11',NULL,2,'B.Com('),
	(8,'2017-12-29 10:06:44',NULL,2,'B.Sc'),
	(9,'2017-12-29 10:07:24',NULL,2,'MA'),
	(10,'2017-12-29 10:07:42',NULL,2,'B.Tech');

/*!40000 ALTER TABLE `degrees` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table marketing_projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `marketing_projects`;

CREATE TABLE `marketing_projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cf_projected_completion_date` date DEFAULT NULL,
  `marketing_project_status` varchar(400) DEFAULT NULL,
  `content_url` varchar(400) DEFAULT NULL,
  `relationship_customer_id` int(11) DEFAULT NULL,
  `modified_datetime` datetime NOT NULL,
  `page_name` varchar(200) DEFAULT NULL,
  `page_type` varchar(64) DEFAULT NULL,
  `project_manager` int(11) DEFAULT NULL,
  `assign_to_upsell` int(11) DEFAULT NULL,
  `assign_to_rmi` int(11) DEFAULT NULL,
  `content_launch_date` date DEFAULT NULL,
  `content_status` varchar(200) DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `projected_upsell_conversion__` float(10,2) DEFAULT NULL,
  `projected_rmi_conversion__` float(10,2) DEFAULT NULL,
  `cf_projected_start_date` date DEFAULT NULL,
  `email_marketing_projected_send_date__upsell_` date DEFAULT NULL,
  `email_marketing_projected_send_date__rmi___cs_` date DEFAULT NULL,
  `quickbase_id` int(11) DEFAULT NULL,
  `relationship_customer_projects_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `quickbase_id` (`quickbase_id`),
  KEY `marketing_project_status` (`marketing_project_status`(255)),
  KEY `relationship_customer_id` (`relationship_customer_id`),
  KEY `project_manager` (`project_manager`),
  KEY `content_status` (`content_status`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`),
  KEY `projected_upsell_conversion__` (`projected_upsell_conversion__`),
  KEY `projected_rmi_conversion__` (`projected_rmi_conversion__`),
  KEY `cf_projected_start_date` (`cf_projected_start_date`),
  KEY `email_marketing_projected_send_date__upsell_` (`email_marketing_projected_send_date__upsell_`),
  KEY `email_marketing_projected_send_date__rmi___cs_` (`email_marketing_projected_send_date__rmi___cs_`),
  KEY `relationship_customer_projects_id` (`relationship_customer_projects_id`),
  KEY `page_name` (`page_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `marketing_projects` WRITE;
/*!40000 ALTER TABLE `marketing_projects` DISABLE KEYS */;

INSERT INTO `marketing_projects` (`id`, `cf_projected_completion_date`, `marketing_project_status`, `content_url`, `relationship_customer_id`, `modified_datetime`, `page_name`, `page_type`, `project_manager`, `assign_to_upsell`, `assign_to_rmi`, `content_launch_date`, `content_status`, `linked_customer_id`, `modified_by`, `projected_upsell_conversion__`, `projected_rmi_conversion__`, `cf_projected_start_date`, `email_marketing_projected_send_date__upsell_`, `email_marketing_projected_send_date__rmi___cs_`, `quickbase_id`, `relationship_customer_projects_id`)
VALUES
	(85,NULL,'Completed','http://www.onlinecolleges.net/alabama/',NULL,'2017-01-12 16:34:41','Alabama','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,835,5),
	(86,NULL,'Completed','http://www.onlinecolleges.net/alaska/',NULL,'2017-01-12 16:34:41','Alaska','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,836,5),
	(87,NULL,'Completed','http://www.onlinecolleges.net/arizona/',NULL,'2017-01-12 16:34:41','Arizona','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,837,5),
	(88,NULL,'Completed','http://www.onlinecolleges.net/arkansas/',NULL,'2017-01-12 16:34:41','Arkansas','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,838,5),
	(89,NULL,'Completed','http://www.onlinecolleges.net/california/',NULL,'2017-01-12 16:34:41','California','State',2,NULL,75,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,839,5),
	(90,NULL,'Completed','http://www.onlinecolleges.net/colorado/',NULL,'2017-01-12 16:34:41','Colorado','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,840,5),
	(91,NULL,'Completed','http://www.onlinecolleges.net/connecticut/',NULL,'2017-01-12 16:34:41','Connecticut','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,841,5),
	(92,NULL,'Completed','http://www.onlinecolleges.net/delaware/',NULL,'2017-01-12 16:34:41','Delaware','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,842,5),
	(93,NULL,'Completed','http://www.onlinecolleges.net/florida/',NULL,'2017-01-12 16:34:41','Florida','State',2,NULL,26,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,843,5),
	(94,NULL,'Completed','http://www.onlinecolleges.net/georgia/',NULL,'2017-01-12 16:34:41','Georgia','State',2,NULL,30,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,844,5),
	(95,NULL,'Completed','http://www.onlinecolleges.net/hawaii/',NULL,'2017-01-12 16:34:41','Hawaii','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,845,5),
	(96,NULL,'Completed','http://www.onlinecolleges.net/idaho/',NULL,'2017-01-12 16:34:41','Idaho','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,846,5),
	(97,NULL,'Completed','http://www.onlinecolleges.net/illinois/',NULL,'2017-01-12 16:34:41','Illinois','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,847,5),
	(98,NULL,'Completed','http://www.onlinecolleges.net/indiana/',NULL,'2017-01-12 16:34:41','Indiana','State',2,NULL,30,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,848,5),
	(99,NULL,'Completed','http://www.onlinecolleges.net/iowa/',NULL,'2017-01-12 16:34:41','Iowa','State',2,NULL,29,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,849,5),
	(100,NULL,'Completed','http://www.onlinecolleges.net/kansas/',NULL,'2017-01-12 16:34:41','Kansas','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,850,5),
	(101,NULL,'Completed','http://www.onlinecolleges.net/kentucky/',NULL,'2017-01-12 16:34:41','Kentucky','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,851,5),
	(102,NULL,'Completed','http://www.onlinecolleges.net/louisiana/',NULL,'2017-01-12 16:34:41','Louisiana','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,852,5),
	(103,NULL,'Completed','http://www.onlinecolleges.net/maine/',NULL,'2017-01-12 16:34:41','Maine','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,853,5),
	(104,NULL,'Completed','http://www.onlinecolleges.net/maryland/',NULL,'2017-01-12 16:34:41','Maryland','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,854,5),
	(105,NULL,'Completed','http://www.onlinecolleges.net/massachusetts/',NULL,'2017-01-12 16:34:41','Massachusetts','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,855,5),
	(106,NULL,'Completed','http://www.onlinecolleges.net/michigan/',NULL,'2017-01-12 16:34:41','Michigan','State',2,NULL,30,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,856,5),
	(107,NULL,'Completed','http://www.onlinecolleges.net/minnesota/',NULL,'2017-01-12 16:34:41','Minnesota','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,857,5),
	(108,NULL,'Completed','http://www.onlinecolleges.net/mississippi/',NULL,'2017-01-12 16:34:41','Mississippi','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,858,5),
	(109,NULL,'Completed','http://www.onlinecolleges.net/missouri/',NULL,'2017-01-12 16:34:41','Missouri','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,859,5),
	(110,NULL,'Completed','http://www.onlinecolleges.net/montana/',NULL,'2017-01-12 16:34:41','Montana','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,860,5),
	(111,NULL,'Completed','http://www.onlinecolleges.net/nebraska/',NULL,'2017-01-12 16:34:41','Nebraska','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,861,5),
	(112,NULL,'Completed','http://www.onlinecolleges.net/nevada/',NULL,'2017-01-12 16:34:41','Nevada','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,862,5),
	(113,NULL,'Completed','http://www.onlinecolleges.net/new-hampshire/',NULL,'2017-01-12 16:34:41','New Hampshire','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,863,5),
	(114,NULL,'Completed','http://www.onlinecolleges.net/new-jersey/',NULL,'2017-01-12 16:34:41','New Jersey','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,864,5),
	(115,NULL,'Completed','http://www.onlinecolleges.net/new-mexico/',NULL,'2017-01-12 16:34:41','New Mexico','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,865,5),
	(116,NULL,'Completed','http://www.onlinecolleges.net/new-york/',NULL,'2017-01-12 16:34:41','New York','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,866,5),
	(117,NULL,'Completed','http://www.onlinecolleges.net/north-carolina/',NULL,'2017-01-12 16:34:41','North Carolina','State',2,NULL,59,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,867,5),
	(118,NULL,'Completed','http://www.onlinecolleges.net/north-dakota/',NULL,'2017-01-12 16:34:41','North Dakota','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,868,5),
	(119,NULL,'Completed','http://www.onlinecolleges.net/ohio/',NULL,'2017-01-12 16:34:41','Ohio','State',2,NULL,70,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,869,5),
	(120,NULL,'Completed','http://www.onlinecolleges.net/oklahoma',NULL,'2017-01-12 16:34:41','Oklahoma','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,870,5),
	(121,NULL,'Completed','http://www.onlinecolleges.net/oregon/',NULL,'2017-01-12 16:34:41','Oregon','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,871,5),
	(122,NULL,'Completed','http://www.onlinecolleges.net/pennsylvania/',NULL,'2017-01-12 16:34:41','Pennsylvania','State',2,NULL,44,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,872,5),
	(123,NULL,'Completed','http://www.onlinecolleges.net/rhode-island/',NULL,'2017-01-12 16:34:41','Rhode Island','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,873,5),
	(124,NULL,'Completed','http://www.onlinecolleges.net/south-carolina/',NULL,'2017-01-12 16:34:41','South Carolina','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,874,5),
	(125,NULL,'Completed','http://www.onlinecolleges.net/south-dakota/',NULL,'2017-01-12 16:34:41','South Dakota','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,875,5),
	(126,NULL,'Completed','http://www.onlinecolleges.net/tennessee/',NULL,'2017-01-12 16:34:41','Tennessee','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,876,5),
	(127,NULL,'Completed','http://www.onlinecolleges.net/texas/',NULL,'2017-01-12 16:34:41','Texas','State',2,NULL,125,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,877,5),
	(128,NULL,'Completed','http://www.onlinecolleges.net/utah/',NULL,'2017-01-12 16:34:41','Utah','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,878,5),
	(129,NULL,'Completed','http://www.onlinecolleges.net/vermont/',NULL,'2017-01-12 16:34:41','Vermont','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,879,5),
	(130,NULL,'Completed','http://www.onlinecolleges.net/virginia/',NULL,'2017-01-12 16:34:41','Virginia','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,880,5),
	(131,NULL,'Completed','http://www.onlinecolleges.net/washington/',NULL,'2017-01-12 16:34:41','Washington State','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,881,5),
	(132,NULL,'Completed','http://www.onlinecolleges.net/west-virginia/',NULL,'2017-01-12 16:34:41','West Virginia','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,882,5),
	(133,NULL,'Completed','http://www.onlinecolleges.net/wisconsin/',NULL,'2017-01-12 16:34:41','Wisconsin','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,883,5),
	(134,NULL,'Completed','http://www.onlinecolleges.net/wyoming/',NULL,'2017-01-12 16:34:41','Wyoming','State',2,NULL,10,NULL,'Complete',3,NULL,40.00,0.75,NULL,NULL,NULL,884,5),
	(135,NULL,'Completed','OnlineSchools.org',NULL,'2017-01-12 16:34:41','OS-Online-Schools','Home Page',2,NULL,20,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,887,7),
	(136,NULL,'Completed','OnlineSchools.org/elementary-school',NULL,'2017-01-12 16:34:41','OS-Elementary-School','Resource',2,NULL,10,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,888,7),
	(137,NULL,'Completed','OnlineSchools.org/middle-school',NULL,'2017-01-12 16:34:41','OS-Middle-School','Resource',2,NULL,15,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,889,7),
	(138,NULL,'Completed','OnlineSchools.org/high-school',NULL,'2017-01-12 16:34:41','OS-High-School','Resource',2,NULL,25,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,890,7),
	(139,NULL,'Completed','OnlineSchools.org/financial-aid/minority/',NULL,'2017-01-12 16:34:41','OS-Financial-Aid-Minority','Resource',2,NULL,15,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,891,7),
	(140,NULL,'Completed','OnlineSchools.org/graduate',NULL,'2017-01-12 16:34:41','OS-Graduate','Resource',2,NULL,0,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,892,7),
	(141,NULL,'Completed','OnlineSchools.org/financial-aid',NULL,'2017-01-12 16:34:41','OS-Financial-Aid','Resource',2,NULL,15,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,893,7),
	(142,NULL,'Completed','OnlineSchools.org/college',NULL,'2017-01-12 16:34:41','OS-College','Resource',2,NULL,0,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,894,7),
	(143,NULL,'Completed','OnlineSchools.org/financial-aid/disabilities',NULL,'2017-01-12 16:34:41','OS-Financial-Aid-Disability','Resource',2,NULL,15,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,895,7),
	(144,NULL,'Completed','OnlineSchools.org/financial-aid/military',NULL,'2017-01-12 16:34:41','OS-Financial-Aid-Military','Resource',2,NULL,15,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,896,7),
	(145,NULL,'Completed','AccreditedOnlineColleges.org',NULL,'2017-01-12 16:34:41','AOC-Accredited-Online-Colleges','Home Page',2,NULL,0,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,897,6),
	(146,NULL,'Completed','AccreditedOnlineColleges.org/resources/accredited-online-colleges-and-disability-education',NULL,'2017-01-12 16:34:41','AOC-Accredited-Online-Colleges-And-Disability-Education','Resource',2,NULL,60,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,898,6),
	(147,NULL,'Completed','AccreditedOnlineColleges.org/resources/veteran-continuing-ed',NULL,'2017-01-12 16:34:41','AOC-Veteran-Continuing-Ed','Resource',2,NULL,0,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,899,6),
	(148,NULL,'Completed','AccreditedOnlineColleges.org/degree-programs',NULL,'2017-01-12 16:34:41','AOC-Degree-Programs','Resource',2,NULL,0,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,900,6),
	(149,NULL,'Completed','AccreditedOnlineColleges.org/online-colleges-that-offer-laptops-for-students',NULL,'2017-01-12 16:34:41','AOC-Online-Colleges-That-Offer-Laptops-For-Students','Resource',2,NULL,0,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,901,6),
	(150,NULL,'Completed','AccreditedOnlineColleges.org/fafsa-guide',NULL,'2017-01-12 16:34:41','AOC-Fafsa-Guide','Resource',2,NULL,0,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,902,6),
	(151,NULL,'Completed','OnlineCourses.com',NULL,'2017-01-12 16:34:41','OC-Online-Courses','Home Page',2,NULL,10,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,913,NULL),
	(152,NULL,'Completed','OnlineCourses.com/information-technology',NULL,'2017-01-12 16:34:41','OC-Information-Technology','Subject',2,NULL,10,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,914,NULL),
	(153,NULL,'Completed','OnlineCourses.com/computerscience',NULL,'2017-01-12 16:34:41','OC-Computerscience','Subject',2,NULL,10,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,915,NULL),
	(154,NULL,'Completed','OnlineCourses.com/accounting',NULL,'2017-01-12 16:34:41','OC-Accounting','Subject',2,NULL,10,'2016-03-29','Complete',3,NULL,40.00,0.50,NULL,NULL,NULL,916,NULL),
	(155,NULL,'Completed','http://www.bestcolleges.com/features/top-online-schools/',NULL,'2017-01-12 16:34:41','BC Top Online Schools','Internal',1,NULL,188,'2016-05-17','Complete',3,NULL,40.00,0.20,'2016-05-17',NULL,NULL,917,8),
	(156,NULL,'In-Progress','http://www.onlinecolleges.net/california/',NULL,'2017-01-12 16:34:41','California Additional','State',1,NULL,31,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-05-30',NULL,'2016-06-09',918,5),
	(157,NULL,'In-Progress','http://www.onlinecolleges.net/florida/',NULL,'2017-01-12 16:34:41','Florida Additional','State',1,NULL,16,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-05-30',NULL,'2016-06-09',919,5),
	(158,NULL,'In-Progress','http://www.onlinecolleges.net',NULL,'2017-01-12 16:34:41','Online College HP','Home Page',1,NULL,113,'2016-06-08','Complete',3,NULL,40.00,0.75,'2016-06-06',NULL,'2016-06-10',920,5),
	(159,NULL,'In-Progress','http://www.onlinecolleges.net/new-york/',NULL,'2017-01-12 16:34:41','New York Additional','State',1,NULL,6,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-06',NULL,'2016-06-10',921,5),
	(160,NULL,'In-Progress','http://www.onlinecolleges.net/ohio/',NULL,'2017-01-12 16:34:41','Ohio Additional','State',1,NULL,3,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-06',NULL,'2016-06-17',922,5),
	(161,NULL,'In-Progress','http://www.onlinecolleges.net/texas/',NULL,'2017-01-12 16:34:42','Texas Additional','State',1,NULL,8,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-06',NULL,'2016-06-17',923,5),
	(162,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-accounting-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Accounting-Programs','Subject Ranking',1,NULL,19,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-06-17',924,8),
	(163,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-rn-to-bsn-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Rn-To-Bsn-Programs','Subject Ranking',1,NULL,22,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-06-17',925,8),
	(164,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-bsn-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Bsn-Programs','Subject Ranking',1,NULL,22,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-06-24',926,8),
	(165,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-master-of-science-in-nursing-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Master-Of-Science-In-Nursing-Programs','Subject Ranking',1,NULL,9,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-06-24',927,8),
	(166,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-associate-medical-assisting-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Associate-Medical-Assisting-Programs','Subject Ranking',1,NULL,14,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-06-24',928,8),
	(167,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-masters-public-health-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Masters-Public-Health-Programs','Subject Ranking',1,NULL,19,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-07-01',929,8),
	(168,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-masters-in-health-informatics-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Masters-In-Health-Informatics-Programs','Subject Ranking',1,NULL,4,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-07-01',930,8),
	(169,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-masters-healthcare-administration-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Masters-Healthcare-Administration-Programs','Subject Ranking',1,NULL,8,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-07-01',931,8),
	(170,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-masters-engineering-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Masters-Engineering-Programs','Subject Ranking',1,NULL,4,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-07-01',932,8),
	(171,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-programs-masters-in-educational-administration/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Programs-Masters-In-Educational-Administration','Subject Ranking',1,NULL,4,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-07-01',933,8),
	(172,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-mba-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Mba-Programs','Subject Ranking',1,NULL,57,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-07-08',934,8),
	(173,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-masters-psychology-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Masters-Psychology-Programs','Subject Ranking',1,NULL,33,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-07-15',935,8),
	(174,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-criminal-justice-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Criminal-Justice-Programs','Subject Ranking',1,NULL,9,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-07-15',936,8),
	(175,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-masters-criminal-justice-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Masters-Criminal-Justice-Programs','Subject Ranking',1,NULL,4,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-07-15',937,8),
	(176,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-medical-billing-coding-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Medical-Billing-Coding-Programs','Subject Ranking',1,NULL,21,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-07-22',938,8),
	(177,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-masters-education-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Masters-Education-Programs','Subject Ranking',1,NULL,29,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-07-22',939,8),
	(178,NULL,'In-Progress','http://www.bestcolleges.com/features/top-masters-in-early-childhood-education-online-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Masters-In-Early-Childhood-Education-Online-Programs','Subject Ranking',1,NULL,1,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-07-29',940,8),
	(179,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-bachelors-early-childhood-education/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Bachelors-Early-Childhood-Education','Subject Ranking',1,NULL,26,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-07-29',941,8),
	(180,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-computer-science-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Computer-Science-Programs','Subject Ranking',1,NULL,9,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-07-29',942,8),
	(181,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-software-engineering-degree-graduate-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Software-Engineering-Degree-Graduate-Programs','Subject Ranking',1,NULL,4,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-07-29',943,8),
	(182,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-masters-educational-leadership-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Masters-Educational-Leadership-Programs','Subject Ranking',1,NULL,4,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-07-29',944,8),
	(183,NULL,'In-Progress','http://www.bestcolleges.com/features/top-christian-colleges/',NULL,'2017-01-12 16:34:42','BC-Top-Christian-Colleges','Subject Ranking',1,NULL,4,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-07-29',945,8),
	(184,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-graphic-design-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Graphic-Design-Programs','Subject Ranking',1,NULL,3,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-13',NULL,'2016-07-29',946,8),
	(185,NULL,'In-Progress','http://www.bestcolleges.com/features/top-mfa-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Mfa-Programs','Subject Ranking',1,NULL,3,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-20',NULL,'2016-08-05',947,8),
	(186,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-substance-abuse-counseling-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Substance-Abuse-Counseling-Programs','Subject Ranking',1,NULL,3,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-06-20',NULL,'2016-08-05',948,8),
	(187,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-business-administration-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Business-Administration-Programs','Subject Ranking',1,NULL,29,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-05',949,8),
	(188,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-bachelors-information-technology-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Bachelors-Information-Technology-Programs','Subject Ranking',1,NULL,4,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-05',950,8),
	(189,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-masters-school-counseling-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Masters-School-Counseling-Programs','Subject Ranking',1,NULL,8,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-05',951,8),
	(190,NULL,'In-Progress','http://www.bestcolleges.com/features/top-masters-in-nutrition-online-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Masters-In-Nutrition-Online-Programs','Subject Ranking',1,NULL,10,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-05',952,8),
	(191,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-hospitality-management-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Hospitality-Management-Programs','Subject Ranking',1,NULL,9,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-12',953,8),
	(192,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-masters-social-work-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Masters-Social-Work-Programs','Subject Ranking',1,NULL,4,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-12',954,8),
	(193,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-paralegal-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Paralegal-Programs','Subject Ranking',1,NULL,28,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-12',955,8),
	(194,NULL,'In-Progress','http://www.bestcolleges.com/features/best-online-masters-counseling-programs/',NULL,'2017-01-12 16:34:42','BC-Best-Online-Masters-Counseling-Programs','Subject Ranking',1,NULL,8,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-12',956,8),
	(195,NULL,'In-Progress','http://www.bestcolleges.com/features/top-online-masters-human-resources-programs/',NULL,'2017-01-12 16:34:42','BC-Top-Online-Masters-Human-Resources-Programs','Subject Ranking',1,NULL,4,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-12',957,8),
	(196,NULL,'In-Progress','http://www.accounting.com/rankings/best-associate-in-accounting-programs/',NULL,'2017-01-12 16:34:42','ACCTG-Best-Associate-In-Accounting-Programs','Subject Ranking',1,NULL,5,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-07-04',NULL,'2016-08-19',958,9),
	(197,NULL,'In-Progress','http://www.accounting.com/rankings/best-online-associate-in-accounting-programs/',NULL,'2017-01-12 16:34:42','ACCTG-Best-Online-Associate-In-Accounting-Programs','Subject Ranking',1,NULL,3,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-19',959,9),
	(198,NULL,'In-Progress','http://www.accounting.com/rankings/best-bachelors-in-accounting-programs/',NULL,'2017-01-12 16:34:42','ACCTG-Best-Bachelors-In-Accounting-Programs','Subject Ranking',1,NULL,3,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-19',960,9),
	(199,NULL,'In-Progress','http://www.accounting.com/rankings/best-online-bachelors-in-accounting-programs/',NULL,'2017-01-12 16:34:42','ACCTG-Best-Online-Bachelors-In-Accounting-Programs','Subject Ranking',1,NULL,3,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-19',961,9),
	(200,NULL,'In-Progress','http://www.accounting.com/rankings/most-affordable-online-bachelors-in-accounting-programs/',NULL,'2017-01-12 16:34:42','ACCTG-Most-Affordable-Online-Bachelors-In-Accounting-Programs','Subject Ranking',1,NULL,3,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-19',962,9),
	(201,NULL,'In-Progress','http://www.accounting.com/rankings/best-masters-in-accounting-programs/',NULL,'2017-01-12 16:34:42','ACCTG-Best-Masters-In-Accounting-Programs','Subject Ranking',1,NULL,3,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-19',963,9),
	(202,NULL,'In-Progress','http://www.accounting.com/rankings/best-online-masters-in-accounting-programs/',NULL,'2017-01-12 16:34:42','ACCTG-Best-Online-Masters-In-Accounting-Programs','Subject Ranking',1,NULL,3,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-19',964,9),
	(203,NULL,'In-Progress','http://www.rntobsn.org/best-online-rn-to-bsn-programs/',NULL,'2017-01-12 16:34:42','RN2BSN-Best-Online-Rn-To-Bsn-Programs','Subject Ranking',1,NULL,20,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-07-04',NULL,'2016-08-19',965,10),
	(204,NULL,'In-Progress','http://www.rntobsn.org/best-hybrid-rn-to-bsn-programs/',NULL,'2017-01-12 16:34:42','RN2BSN-Best-Hybrid-Rn-To-Bsn-Programs','Subject Ranking',1,NULL,15,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-19',966,10),
	(205,NULL,'In-Progress','http://www.rntobsn.org/best-campus-rn-to-bsn-programs/',NULL,'2017-01-12 16:34:42','RN2BSN-Best-Campus-Rn-To-Bsn-Programs','Subject Ranking',1,NULL,15,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-08-26',967,10),
	(206,NULL,'In-Progress','http://www.medicalassistantcertification.org/',NULL,'2017-01-12 16:34:42','MAC-HP','Home Page',1,NULL,15,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-07-04',NULL,'2016-08-26',968,11),
	(207,NULL,'In-Progress','http://www.publichealth.org/degree/masters/',NULL,'2017-01-12 16:34:42','PH-Master-Degree','Subject Ranking',1,NULL,20,'2016-06-08','Complete',3,NULL,40.00,0.25,'2016-07-04',NULL,'2016-08-26',969,12),
	(208,NULL,'In-Progress','http://www.onlinemba.com/',NULL,'2017-01-12 16:34:42','OMBA-HP','Home Page',1,NULL,114,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-09-02',970,13),
	(209,NULL,'In-Progress','http://www.psychology.org/degrees/masters/',NULL,'2017-01-12 16:34:42','PSY-Master-Degree','Subject Ranking',1,NULL,33,'2016-06-08','Complete',3,NULL,40.00,0.25,NULL,NULL,'2016-09-09',971,14),
	(210,NULL,'In-Progress','http://www.criminaljustice.com/',NULL,'2017-01-12 16:34:42','CJ-HP','Home Page',1,NULL,29,'2016-06-08','Complete',3,NULL,40.00,0.50,'2016-07-04',NULL,'2016-09-09',972,15),
	(211,NULL,'In-Progress','http://www.medicalbillingandcoding.org/',NULL,'2017-01-12 16:34:42','MBAC-HP','Home Page',1,NULL,45,'2016-06-08','Complete',3,NULL,40.00,0.50,'2016-07-04',NULL,'2016-09-09',973,16),
	(212,NULL,'In-Progress','http://www.thesimpledollar.com/income-tax-calculator/',NULL,'2017-06-09 21:15:58','TSD 2017 - Income Tax Calculator','TSD/Reviews 2017',0,0,100,'2017-03-08','Completed',2,NULL,1.00,1.00,'2017-03-08','2017-03-08','2017-02-27',NULL,3),
	(213,NULL,'In-Progress','http://www.reviews.com/best-scholarship-search-platforms/',NULL,'2017-06-09 21:15:58','Best Online Scholarship Platform Reviews','TSD/Reviews 2017',0,0,150,'2017-03-08','Completed',2,NULL,1.00,1.00,'2017-03-06','2017-03-06','2017-03-06',NULL,2),
	(215,NULL,'In-Progress','http://www.thesimpledollar.com/pet-cost-calculator/',NULL,'2017-06-09 21:15:58','Pet-Cost-Calculator 2017','TSD/Reviews 2017',0,0,225,'2017-03-13','Completed',2,NULL,1.00,1.00,'2017-03-21','2017-03-21','2017-03-21',NULL,3),
	(216,NULL,'In-Progress','http://www.reviews.com/529-plans/',NULL,'2017-06-09 21:15:58','Best 529','TSD/Reviews 2017',0,0,150,'2017-03-21','',2,NULL,1.00,1.00,'2017-03-21','2017-03-21','2017-03-21',NULL,2),
	(217,NULL,'In-Progress','http://www.thesimpledollar.com/guide-to-securing-your-childs-credit-future/',NULL,'2017-06-09 21:15:58','Securing Your Child Credit Future','TSD/Reviews 2017',0,0,125,'2017-05-01','Completed',2,NULL,1.00,1.00,'2017-05-01','2017-05-01','2017-05-01',NULL,3),
	(218,NULL,'In-Progress','http://www.thesimpledollar.com/guide-to-securing-your-college-students-credit-future/',NULL,'2017-06-09 21:15:58','Securing College Student Credit Future','TSD/Reviews 2017',0,0,125,'2017-05-01','Completed',2,NULL,1.00,1.00,'2017-05-01','2017-05-01','2017-05-01',NULL,3),
	(219,NULL,'In-Progress','http://www.thesimpledollar.com/planning-ahead-for-extended-leave-financially-and-professionally/',NULL,'2017-06-09 21:15:58','Planning Ahead for Extended Leave Financially & Professionally','TSD/Reviews 2017',0,0,125,'2017-05-16','Completed',2,NULL,0.00,1.00,'2017-05-16','2017-05-16','2017-05-16',NULL,3),
	(220,NULL,'In-Progress','http://www.reviews.com/student-internship-platforms/',NULL,'2017-06-09 21:14:06','Student Internship Platform','TSD/Reviews 2017',0,0,200,'2017-04-11','Completed',2,NULL,1.00,1.00,'2017-04-11','2017-04-11','2017-04-11',NULL,2),
	(222,NULL,'In-Progress','',NULL,'2017-06-09 21:15:58','Best General Equivalency Degree Test Prep Reviews','TSD/Reviews 2017',0,0,200,NULL,'Not Started',2,NULL,0.00,1.00,NULL,NULL,NULL,NULL,2),
	(223,NULL,'In-Progress','',NULL,'2017-06-09 21:15:58','Best Online Tutoring Services','TSD/Reviews 2017',0,0,200,NULL,'Not Started',2,NULL,0.00,1.00,NULL,NULL,NULL,NULL,2),
	(224,NULL,'In-Progress','',NULL,'2017-06-09 21:15:58','Best TOEFL Prep Courses','TSD/Reviews 2017',0,0,150,NULL,'Not Started',2,NULL,0.00,1.00,NULL,NULL,NULL,NULL,2),
	(225,NULL,'In-Progress','',NULL,'2017-06-09 21:15:58','Best MOOC Provider Reviews','TSD/Reviews 2017',0,0,150,NULL,'Not Started',2,NULL,0.00,1.00,NULL,NULL,NULL,NULL,2),
	(226,NULL,'In-Progress','http://www.thesimpledollar.com/student-loan-consolidation-guide/',NULL,'2017-06-09 21:15:58','Student Loan Consolidation','TSD/Reviews 2017',0,0,100,'2017-04-11','Complete',2,NULL,0.00,1.00,NULL,NULL,NULL,NULL,3),
	(227,NULL,'Cancelled','www.thesimpledollar.com/affordable-online-colleges/',NULL,'2017-06-09 21:15:58','Affordable Online Colleges','Affordable Review',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(228,NULL,'Cancelled','http://www.reviews.com/home-security-systems/',NULL,'2017-06-09 21:15:58','Best Home Security Systems - Reviews','Reviews High Value',0,0,5,'2016-03-29','Not Started',2,NULL,0.00,0.25,NULL,NULL,NULL,NULL,2),
	(229,NULL,'Cancelled','http://www.reviews.com/homeowners-insurance/',NULL,'2017-06-09 21:15:58','Best Homeowners Insurance - Reviews','Reviews High Value',0,0,100,'2016-07-21','Complete',2,NULL,0.00,0.25,NULL,NULL,NULL,NULL,2),
	(230,NULL,'Cancelled','www.thesimpledollar.com/best-tax-software/',NULL,'2017-06-09 21:15:58','Tax Software','TSD High Value',0,0,20,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(231,NULL,'Cancelled','www.thesimpledollar.com/best-debt-settlement-companies/',NULL,'2017-06-09 21:15:58','Debt Settlement','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(232,NULL,'Cancelled','www.thesimpledollar.com/best-home-warranty/',NULL,'2017-06-09 21:15:58','Home Warranty','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(233,NULL,'Cancelled','www.thesimpledollar.com/best-auto-loans/',NULL,'2017-06-09 21:15:58','Auto Loans','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(234,NULL,'Cancelled','www.thesimpledollar.com/best-bad-credit-auto-loans/',NULL,'2017-06-09 21:15:58','Best Bad Credit Auto Loans','TSD High Value',0,0,20,'2016-01-04','Complete',2,NULL,0.00,0.20,NULL,NULL,NULL,NULL,3),
	(235,NULL,'Cancelled','www.thesimpledollar.com/best-life-insurance-companies/',NULL,'2017-06-09 21:15:58','Life Insurance Companies','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(236,NULL,'Cancelled','www.thesimpledollar.com/cheap-life-insurance/',NULL,'2017-06-09 21:15:58','Life Insurance','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(237,NULL,'Cancelled','www.thesimpledollar.com/best-high-interest-savings-accounts/',NULL,'2017-06-09 21:15:58','High Interest Savings Accounts','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(238,NULL,'Cancelled','www.thesimpledollar.com/best-online-stock-trading-brokers/',NULL,'2017-06-09 21:15:58','Online Stock Brokers','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(239,NULL,'Cancelled','www.thesimpledollar.com/best-home-equity-loan-rates/',NULL,'2017-06-09 21:15:58','Home Equity Loan Rates','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(240,NULL,'Cancelled','www.thesimpledollar.com/best-business-credit-cards/',NULL,'2017-06-09 21:15:58','Business Credit Cards','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(241,NULL,'Cancelled','www.thesimpledollar.com/best-savings-account/',NULL,'2017-06-09 21:15:58','Savings Accounts','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(242,NULL,'Cancelled','www.thesimpledollar.com/best-student-credit-cards/',NULL,'2017-06-09 21:15:58','Student Credit Cards','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(243,NULL,'Cancelled','www.thesimpledollar.com/best-credit-cards-for-bad-credit/',NULL,'2017-06-09 21:15:58','Bad Credit Credit Cards','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(244,NULL,'Cancelled','www.thesimpledollar.com/best-car-insurance-companies/',NULL,'2017-06-09 21:15:58','Car Insurance','TSD High Value',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,3),
	(245,NULL,'Cancelled','www.thesimpledollar.com/best-credit-cards/',NULL,'2017-06-09 21:15:58','Best Credit Cards','TSD High Value',0,0,20,'2016-01-04','Complete',2,NULL,0.00,0.20,NULL,NULL,NULL,NULL,3),
	(246,NULL,'Cancelled','www.thesimpledollar.com/affordable-online-colleges/',NULL,'2017-06-09 21:15:58','V2 Affordable Online Colleges','TSD High Value',0,0,20,'2016-01-04','Complete',2,NULL,0.00,0.20,NULL,NULL,NULL,NULL,3),
	(247,NULL,'Cancelled','www.thesimpledollar.com/best-high-interest-savings-accounts/',NULL,'2017-06-09 21:15:58','Best High Interest Savings Accounts','TSD High Value',0,0,20,'2016-01-04','Complete',2,NULL,0.00,0.25,NULL,NULL,NULL,NULL,3),
	(248,NULL,'Cancelled','www.thesimpledollar.com/best-online-stock-trading-brokers/',NULL,'2017-06-09 21:15:58','Best Online Stock Trading Brokers','TSD High Value',0,0,20,'2016-01-04','Complete',2,NULL,0.00,0.20,NULL,NULL,NULL,NULL,3),
	(249,NULL,'Cancelled','www.thesimpledollar.com/best-savings-account/',NULL,'2017-06-09 21:15:58','Best Savings Account','TSD High Value',0,0,20,'2016-01-04','Complete',2,NULL,0.00,0.25,NULL,NULL,NULL,NULL,3),
	(250,NULL,'Cancelled','www.thesimpledollar.com/free-checking-account/',NULL,'2017-06-09 21:15:58','Free Checking Accounts','TSD High Value',0,0,20,'2016-01-04','Complete',2,NULL,0.00,0.20,NULL,NULL,NULL,NULL,3),
	(251,NULL,'Cancelled','www.thesimpledollar.com/best-home-insurance/',NULL,'2017-06-09 21:15:58','V2 Home Insurance','TSD High Value',0,0,20,'2016-03-29','In-Progress',2,NULL,0.00,0.20,NULL,NULL,NULL,NULL,3),
	(252,NULL,'Cancelled','http://www.thesimpledollar.com/best-home-insurance/',NULL,'2017-06-09 21:15:58','Best Home Insurance','TSD High Value',0,0,5,'2016-03-29','Not Started',2,NULL,0.00,0.25,NULL,NULL,NULL,NULL,3),
	(253,NULL,'Cancelled','http://www.thesimpledollar.com/best-travel-credit-card/',NULL,'2017-06-09 21:15:58','Best Travel Credit Card','TSD High Value',0,0,5,'2016-03-29','Not Started',2,NULL,0.00,0.25,NULL,NULL,NULL,NULL,3),
	(254,NULL,'Cancelled','',NULL,'2017-06-09 21:15:59','Credit Card Processing Guide for Small Businesses','TSD Topical Authority - CC',0,0,50,'2016-07-14','Complete',2,NULL,0.00,0.50,NULL,NULL,NULL,NULL,3),
	(255,NULL,'Cancelled','http://www.thesimpledollar.com/student-loan-consolidation-guide/',NULL,'2017-06-09 21:15:59','Guide to Student Loan Consolidation','TSD Topical Authority - Loans',0,0,10,'2016-03-29','Not Started',2,NULL,0.00,0.50,NULL,NULL,NULL,NULL,3),
	(256,NULL,'Cancelled','http://www.thesimpledollar.com/home-financing-guide/',NULL,'2017-06-09 21:15:59','Home Financing Guide','TSD Topical Authority - Loans',0,0,10,'2016-03-29','Not Started',2,NULL,0.00,0.50,NULL,NULL,NULL,NULL,3),
	(257,NULL,'Cancelled','',NULL,'2017-06-09 21:15:59','Credit Card Repayment Contest','TSD Volume',0,0,500,NULL,'Canceled',2,NULL,0.00,1.00,NULL,NULL,NULL,NULL,3),
	(258,NULL,'Cancelled','http://www.thesimpledollar.com/debt-payoff-calculator/',NULL,'2017-06-09 21:15:59','Debt Payoff Calculator','TSD Volume',0,0,30,'2016-03-29','Not Started',2,NULL,0.00,1.00,NULL,NULL,NULL,NULL,3),
	(259,NULL,'Cancelled','http://www.thesimpledollar.com/disability-benefits-guide/',NULL,'2017-06-09 21:15:59','Disability Benefit Guide','TSD Volume',0,0,94,'2016-03-29','Not Started',2,NULL,0.00,1.00,NULL,NULL,NULL,NULL,3),
	(260,NULL,'Cancelled','http://www.thesimpledollar.com/student-budgeting-calculator/',NULL,'2017-06-09 21:15:59','Student Budgeting Calculator','TSD Volume',0,0,200,'2016-07-13','Complete',2,NULL,0.00,1.00,NULL,NULL,NULL,NULL,3),
	(261,NULL,'Cancelled','',NULL,'2017-06-09 21:15:59','Scholarships Database','TSD Volume',0,0,500,'2016-10-03','Complete',2,NULL,0.00,1.00,NULL,NULL,NULL,NULL,3),
	(262,NULL,'Cancelled','www.reviews.com/online-tax-software/',NULL,'2017-06-09 21:15:59','Online Tax Software','Vertical Review',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,2),
	(263,NULL,'Cancelled','www.reviews.com/best-multivitamin/',NULL,'2017-06-09 21:15:59','Multivitamins','Vertical Review',0,0,15,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,2),
	(264,NULL,'Cancelled','www.reviews.com/best-eye-cream/',NULL,'2017-06-09 21:15:59','Eye Cream','Vertical Review',0,0,0,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,2),
	(265,NULL,'Cancelled','www.reviews.com/home-security-systems/',NULL,'2017-06-09 21:15:59','Home Security Systems','Vertical Review',0,0,20,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,2),
	(266,NULL,'Cancelled','www.reviews.com/best-wireless-router/',NULL,'2017-06-09 21:15:59','Wireless Routers','Vertical Review',0,0,15,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,2),
	(267,NULL,'Cancelled','www.reviews.com/best-electric-toothbrush/',NULL,'2017-06-09 21:15:59','Electric Toothbrushes','Vertical Review',0,0,15,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,2),
	(268,NULL,'Cancelled','http://freshome.com/2014/10/13/10-things-you-should-know-about-becoming-an-interior-designer/',NULL,'2017-06-09 21:15:59','How To Become an Interior Designer','Vertical Review',0,0,0,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,4),
	(269,NULL,'Cancelled','www.reviews.com/auto-insurance/',NULL,'2017-06-09 21:15:59','V2 Auto Insurance','Vertical Review',0,0,20,'2016-01-04','Complete',2,NULL,0.00,0.20,NULL,NULL,NULL,NULL,2),
	(270,NULL,'Cancelled','www.reviews.com/medical-alert-systems/',NULL,'2017-06-09 21:15:59','Medical Alert Systems','Vertical Review',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,2),
	(271,NULL,'Cancelled','www.reviews.com/treadmills/',NULL,'2017-06-09 21:15:59','Treadmills','Vertical Review',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,2),
	(272,NULL,'Cancelled','www.reviews.com/homeowners-insurance/',NULL,'2017-06-09 21:15:59','Home Owner Insurance','Vertical Review',0,0,10,'2016-01-04','Complete',2,NULL,0.00,0.75,NULL,NULL,NULL,NULL,2),
	(273,NULL,'Cancelled','www.reviews.com/web-hosting/',NULL,'2017-06-09 21:15:59','V2 Web Hosting','Vertical Review',0,0,20,'2016-01-04','Complete',2,NULL,0.00,0.20,NULL,NULL,NULL,NULL,2),
	(274,NULL,'Cancelled','www.reviews.com/home-security-systems/',NULL,'2017-06-09 21:15:59','V2 Home Security Systems','Vertical Review',0,0,20,'2016-01-04','Complete',2,NULL,0.00,0.20,NULL,NULL,NULL,NULL,2),
	(275,NULL,'Cancelled','www.reviews.com/life-insurance/',NULL,'2017-06-09 21:15:59','V2 Life Insurance','Vertical Review',0,0,20,'2016-03-29','Complete',2,NULL,0.00,0.20,NULL,NULL,NULL,NULL,2);

/*!40000 ALTER TABLE `marketing_projects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table module_fields_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `module_fields_group`;

CREATE TABLE `module_fields_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) NOT NULL DEFAULT '',
  `group_display_order` tinyint(4) NOT NULL,
  `type` varchar(100) NOT NULL,
  `module_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `group_display_order` (`group_display_order`,`module_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `module_fields_group` WRITE;
/*!40000 ALTER TABLE `module_fields_group` DISABLE KEYS */;

INSERT INTO `module_fields_group` (`id`, `group_name`, `group_display_order`, `type`, `module_name`)
VALUES
	(1,'',1,'default','');

/*!40000 ALTER TABLE `module_fields_group` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table module_settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `module_settings`;

CREATE TABLE `module_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_field_display_name` varchar(250) DEFAULT NULL,
  `module_field_name` varchar(100) DEFAULT NULL,
  `module` varchar(100) DEFAULT NULL,
  `module_field_datatype` enum('varchar','enum','text','integer','currency','decimal','link','user','date','datetime','relationship','number','percentage','formulafield','relationship-aggregator') DEFAULT 'text',
  `display_position` int(11) DEFAULT '100',
  `value` text,
  `link_text` varchar(200) DEFAULT NULL,
  `varchar_limit` int(5) DEFAULT NULL,
  `enable_filter` enum('Y','N') DEFAULT 'N',
  `enable_filter_with_option` enum('Y','N') DEFAULT 'N',
  `required_field` enum('Y','N') DEFAULT 'N',
  `show_in_grid` enum('Y','N') DEFAULT 'Y',
  `unique_field` enum('Y','N') DEFAULT 'N',
  `relationship_module` varchar(100) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  `disabled` enum('Y','N') DEFAULT 'N',
  `relationship_module_unique_field` varchar(250) NOT NULL,
  `formulafield` text,
  `field_group_id` int(11) NOT NULL,
  `aggregator_function` enum('sum','count','avg') DEFAULT NULL,
  `one_2_many_relationship` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique-fieldname-in-table` (`module_field_name`,`module`),
  KEY `module` (`module`),
  KEY `display_position` (`display_position`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `module_settings` WRITE;
/*!40000 ALTER TABLE `module_settings` DISABLE KEYS */;

INSERT INTO `module_settings` (`id`, `module_field_display_name`, `module_field_name`, `module`, `module_field_datatype`, `display_position`, `value`, `link_text`, `varchar_limit`, `enable_filter`, `enable_filter_with_option`, `required_field`, `show_in_grid`, `unique_field`, `relationship_module`, `modified_by`, `modified_datetime`, `disabled`, `relationship_module_unique_field`, `formulafield`, `field_group_id`, `aggregator_function`, `one_2_many_relationship`)
VALUES
	(34,'Marketing Project Status','marketing_project_status','marketing_projects','enum',4,'Not Started|In-Progress|On-Hold|Cancelled|Completed','',NULL,'Y','N','Y','Y','N','',NULL,'2017-03-21 21:13:14','N','','',1,NULL,NULL),
	(35,'Content URL','content_url','marketing_projects','link',7,'value1|value2|value3','URL',NULL,'N','N','N','Y','N','customer',NULL,'2017-06-09 21:14:45','N','','',1,NULL,NULL),
	(37,'College Name','customer_name','customer','varchar',10,NULL,'',164,'Y','N','N','Y','N','',NULL,'2017-08-20 13:45:32','N','','',1,NULL,NULL),
	(65,'Page Name','page_name','marketing_projects','varchar',1,NULL,'',200,'N','N','Y','Y','Y',NULL,NULL,'2017-03-21 21:12:02','N','','',1,NULL,NULL),
	(66,'Page Type','page_type','marketing_projects','varchar',2,NULL,'',64,'N','N','N','Y','N',NULL,NULL,'2017-03-21 21:12:15','N','','',1,NULL,NULL),
	(68,'Project Manager','project_manager','marketing_projects','user',4,NULL,'',NULL,'Y','N','N','Y','N',NULL,NULL,'2017-03-21 21:20:45','N','','',1,NULL,NULL),
	(71,'Assign to UPSELL','assign_to_upsell','marketing_projects','number',100,NULL,'',NULL,'Y','N','N','Y','N',NULL,NULL,'2017-01-02 08:37:19','N','',NULL,0,NULL,NULL),
	(72,'Assign to RMI','assign_to_rmi','marketing_projects','number',100,NULL,'',NULL,'Y','N','N','Y','N',NULL,NULL,'2017-03-21 21:11:10','N','','',1,NULL,NULL),
	(76,'Content Launch Date','content_launch_date','marketing_projects','date',6,NULL,'',NULL,'Y','N','Y','Y','N',NULL,NULL,'2017-03-21 21:20:02','N','','',1,NULL,NULL),
	(77,'Content Status','content_status','marketing_projects','enum',5,'In-progress|Not Started|On Hold|Completed|Closed','',NULL,'Y','N','N','Y','N',NULL,NULL,'2017-03-21 21:20:07','N','','',1,NULL,NULL),
	(83,'Projected UPSELL Conversion %','projected_upsell_conversion__','marketing_projects','percentage',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-03-21 21:11:29','N','','',1,NULL,NULL),
	(84,'Projected RMI Conversion %','projected_rmi_conversion__','marketing_projects','percentage',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-03-21 21:11:45','N','','',1,NULL,NULL),
	(87,'CF Projected Start Date','cf_projected_start_date','marketing_projects','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 09:25:57','N','',NULL,0,NULL,NULL),
	(88,'Email Marketing Projected Send Date (UPSELL)','email_marketing_projected_send_date__upsell_','marketing_projects','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 09:30:27','N','',NULL,0,NULL,NULL),
	(89,'Email Marketing Projected Send Date (RMI & CS)','email_marketing_projected_send_date__rmi___cs_','marketing_projects','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 09:31:23','N','',NULL,0,NULL,NULL),
	(259,'Customer Name','customer_name','customer_projects','relationship',100,NULL,'',NULL,'N','N','N','Y','N','customer',NULL,'2017-01-12 12:56:12','N','customer_name','',1,NULL,NULL),
	(260,'Website','website','customer_projects','varchar',100,NULL,'',200,'Y','N','Y','Y','N',NULL,NULL,'2017-01-12 12:57:09','N','','',1,NULL,NULL),
	(261,'Main Contact','main_contact','customer_projects','varchar',100,NULL,'',100,'N','N','N','Y','N',NULL,NULL,'2017-01-12 12:57:48','N','','',1,NULL,NULL),
	(262,'Title','title','customer_projects','varchar',100,NULL,'',20,'N','N','N','Y','N',NULL,NULL,'2017-01-12 12:58:50','N','','',1,NULL,NULL),
	(263,'Address','address','customer_projects','text',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-12 12:59:29','N','','',1,NULL,NULL),
	(264,'Email Address','email_address','customer_projects','varchar',100,NULL,'',100,'N','N','N','Y','N',NULL,NULL,'2017-01-12 12:59:58','N','','',1,NULL,NULL),
	(265,'Phone','phone','customer_projects','varchar',100,NULL,'',64,'N','N','N','Y','N',NULL,NULL,'2017-01-12 13:00:42','N','','',1,NULL,NULL),
	(266,'Website','website','marketing_projects','relationship',3,NULL,'',NULL,'Y','Y','N','Y','N','customer_projects',NULL,'2017-03-21 21:12:25','N','website','',1,NULL,NULL),
	(283,'Total Projects','website','customer','relationship-aggregator',100,NULL,'',NULL,'N','N','N','Y','N','customer_projects',NULL,'2017-01-15 05:07:54','N','','',1,'count',NULL),
	(284,'Total Marketing Projects','page_name','customer_projects','relationship-aggregator',100,NULL,'',NULL,'N','N','N','Y','N','marketing_projects',NULL,'2017-01-15 05:10:12','N','','',1,'count',NULL),
	(305,'Address','address','customer','text',100,NULL,'',NULL,'N','N','Y','N','N',NULL,NULL,'2017-08-20 13:54:27','N','','',1,NULL,NULL),
	(306,'Affiliated From','affiliated_from','customer','varchar',100,NULL,'',400,'N','N','N','N','N',NULL,NULL,'2017-08-20 13:55:43','N','','',1,NULL,NULL),
	(307,'Affiliate No.','affiliate_no_','customer','varchar',100,NULL,'',100,'N','N','N','Y','N',NULL,NULL,'2017-08-20 13:56:42','N','','',1,NULL,NULL),
	(308,'Name','name','degrees','varchar',100,NULL,NULL,300,'N','N','N','Y','N',NULL,NULL,'2017-09-20 13:56:42','N','',NULL,1,NULL,NULL),
	(309,'Manager','manager','customer','varchar',110,NULL,'',200,'N','N','N','N','N',NULL,NULL,'2017-12-29 06:25:03','N','','',1,NULL,NULL),
	(310,'Manager Mobile No','manager_mobile_no','customer','varchar',110,NULL,'',20,'N','N','N','N','N',NULL,NULL,'2017-12-29 06:26:15','N','','',1,NULL,NULL),
	(311,'Name','subject_name','subjects','varchar',100,NULL,'',100,'N','N','N','Y','N',NULL,NULL,'2017-12-29 07:44:27','N','','',1,NULL,NULL),
	(312,'Degree Name','name','degree_subjects','relationship',100,NULL,'',NULL,'N','N','N','Y','N','degrees',NULL,'2017-12-29 16:24:41','N','name','',1,NULL,NULL),
	(317,'Subjects List','subject_name','degree_subjects','relationship',100,NULL,'',NULL,'N','N','N','N','N','subjects',NULL,'2018-01-03 04:54:30','N','subject_name','',1,NULL,'Y');

/*!40000 ALTER TABLE `module_settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table relationship_degree_subjects_subject_name
# ------------------------------------------------------------

DROP TABLE IF EXISTS `relationship_degree_subjects_subject_name`;

CREATE TABLE `relationship_degree_subjects_subject_name` (
  `degree_subjects_id` int(11) DEFAULT NULL,
  `relationship_subjects_id` int(11) DEFAULT NULL,
  KEY `degree_subjects_id` (`degree_subjects_id`),
  KEY `relationship_subjects_id` (`relationship_subjects_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `relationship_degree_subjects_subject_name` WRITE;
/*!40000 ALTER TABLE `relationship_degree_subjects_subject_name` DISABLE KEYS */;

INSERT INTO `relationship_degree_subjects_subject_name` (`degree_subjects_id`, `relationship_subjects_id`)
VALUES
	(3,4),
	(3,7),
	(2,1),
	(2,4);

/*!40000 ALTER TABLE `relationship_degree_subjects_subject_name` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table report
# ------------------------------------------------------------

DROP TABLE IF EXISTS `report`;

CREATE TABLE `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `report` WRITE;
/*!40000 ALTER TABLE `report` DISABLE KEYS */;

INSERT INTO `report` (`id`, `name`)
VALUES
	(1,'Report 1'),
	(2,'Report 2'),
	(3,'Report 3'),
	(4,'Report 4');

/*!40000 ALTER TABLE `report` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `role`;

CREATE TABLE `role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;

INSERT INTO `role` (`id`, `name`, `description`, `status`, `create_datetime`, `update_datetime`)
VALUES
	(1,'Administrator','Default description',1,'2017-01-11 14:15:12','2017-01-11 14:15:12'),
	(2,'Team Member','Default description',1,'2017-01-11 14:15:12','2017-01-11 14:15:12'),
	(3,'Sales Agent','Default description',1,'2017-01-11 14:15:12','2017-01-11 14:15:12'),
	(4,'TSD','Default description',1,'2017-01-11 14:15:12','2017-01-11 14:15:12'),
	(5,'none','Default description',1,'2017-01-11 14:15:17','2017-01-11 14:15:17'),
	(6,'Client','Default description',1,'2017-01-11 14:15:17','2017-01-11 14:15:17');

/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table role_global_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `role_global_permission`;

CREATE TABLE `role_global_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `manage_user_app_permission` tinyint(1) NOT NULL,
  `edit_app_structure_permission` tinyint(1) NOT NULL,
  `report_permission` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `role_global_permission` WRITE;
/*!40000 ALTER TABLE `role_global_permission` DISABLE KEYS */;

INSERT INTO `role_global_permission` (`id`, `role_id`, `manage_user_app_permission`, `edit_app_structure_permission`, `report_permission`)
VALUES
	(1,1,1,1,1),
	(2,2,0,0,0),
	(3,3,0,0,0),
	(4,4,0,0,0),
	(5,5,0,0,0),
	(6,6,0,0,0);

/*!40000 ALTER TABLE `role_global_permission` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table role_module_field_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `role_module_field_permission`;

CREATE TABLE `role_module_field_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `module_permission_id` int(10) unsigned NOT NULL,
  `field_name_id` varchar(100) NOT NULL,
  `permission` tinyint(4) NOT NULL COMMENT '1=> view, 2=> edit',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table role_module_permission
# ------------------------------------------------------------

DROP TABLE IF EXISTS `role_module_permission`;

CREATE TABLE `role_module_permission` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `module` varchar(50) NOT NULL,
  `view_permission` tinyint(3) unsigned NOT NULL,
  `modify_permission` tinyint(3) unsigned NOT NULL,
  `add_permission` tinyint(1) NOT NULL,
  `delete_permission` tinyint(1) NOT NULL,
  `field_permission` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `role_module_permission` WRITE;
/*!40000 ALTER TABLE `role_module_permission` DISABLE KEYS */;

INSERT INTO `role_module_permission` (`id`, `role_id`, `module`, `view_permission`, `modify_permission`, `add_permission`, `delete_permission`, `field_permission`)
VALUES
	(1,1,'customer',1,1,1,1,0),
	(2,1,'customer_projects',1,1,1,1,0),
	(3,1,'marketing_projects',1,1,1,1,0),
	(4,1,'initiative',1,1,1,1,0),
	(5,1,'campaign',1,1,1,1,0),
	(6,1,'campaign_contacts',1,1,1,1,0),
	(7,1,'psuedo_email_accounts',1,1,1,1,0),
	(8,1,'assign_psuedo',1,1,1,1,0),
	(9,1,'links',1,1,1,1,0),
	(10,1,'link_rates',1,1,1,1,0),
	(11,1,'dnc_lists',1,1,1,1,0),
	(12,2,'customer',1,0,0,0,1),
	(13,2,'customer_projects',1,1,1,0,1),
	(14,2,'marketing_projects',1,1,1,0,1),
	(15,2,'initiative',1,1,1,0,1),
	(16,2,'campaign',1,1,1,0,1),
	(17,2,'campaign_contacts',1,1,1,0,1),
	(18,2,'psuedo_email_accounts',1,1,1,0,1),
	(19,2,'assign_psuedo',1,1,1,0,1),
	(20,2,'links',1,0,0,0,1),
	(21,2,'link_rates',1,0,0,0,1),
	(22,2,'dnc_lists',1,1,1,0,1),
	(23,1,'genric',1,1,1,1,0),
	(24,1,'degree',1,1,1,1,0),
	(25,1,'degrees',1,1,1,1,0),
	(26,1,'subjects',1,1,1,1,0),
	(27,1,'degree_subjects',1,1,1,1,0);

/*!40000 ALTER TABLE `role_module_permission` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table subjects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `subjects`;

CREATE TABLE `subjects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `modified_datetime` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `subject_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`subject_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `subjects` WRITE;
/*!40000 ALTER TABLE `subjects` DISABLE KEYS */;

INSERT INTO `subjects` (`id`, `modified_datetime`, `modified_by`, `linked_customer_id`, `subject_name`)
VALUES
	(1,'2017-12-29 14:38:54',NULL,2,'Hindi'),
	(2,'2017-12-29 14:39:05',NULL,2,'English'),
	(3,'2017-12-29 14:39:16',NULL,2,'Hindi 1'),
	(4,'2017-12-29 14:39:23',NULL,2,'History'),
	(5,'2017-12-29 14:39:40',NULL,2,'Account'),
	(6,'2017-12-29 14:39:49',NULL,2,'Economics'),
	(7,'2017-12-29 14:40:05',NULL,2,'Maths');

/*!40000 ALTER TABLE `subjects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `quickbase_id` varchar(100) DEFAULT NULL,
  `verification_id` varchar(100) DEFAULT NULL,
  `password_reset_id` varchar(100) DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL COMMENT '1=>''registered'', 2=>''unregistered'', 3=>''unverified'', 4=>''deactivated'',5=>''denied'',6=>password_reset ',
  `before_disable_status` tinyint(4) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `current_customer` int(11) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `email`, `password`, `name`, `quickbase_id`, `verification_id`, `password_reset_id`, `status`, `before_disable_status`, `role_id`, `current_customer`, `last_login`, `create_datetime`, `update_datetime`)
VALUES
	(1,'xyz@junk.com','123456','Super Admin','58705085.b9qm',NULL,NULL,1,NULL,1,68,'2017-08-20 12:59:03','2017-01-11 14:15:12','2017-01-11 14:15:12'),
	(96,'shashank.dwivedi@intelligent.com',NULL,'shashank.dwivedi@intelligent.com','59857593.bnst',NULL,NULL,2,NULL,1,NULL,NULL,'2017-01-11 14:15:24','2017-01-11 14:15:24'),
	(105,'shashank@intelligent.com','123456','shank',NULL,'59997a9c61150',NULL,1,NULL,1,286,'2018-01-25 07:15:01','2017-08-20 13:03:40','2017-08-20 13:03:40');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user_allowed_customers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_allowed_customers`;

CREATE TABLE `user_allowed_customers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `is_active` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `user_allowed_customers` WRITE;
/*!40000 ALTER TABLE `user_allowed_customers` DISABLE KEYS */;

INSERT INTO `user_allowed_customers` (`id`, `user_id`, `customer_id`, `is_active`)
VALUES
	(68,1,2,1),
	(156,1,3,1),
	(244,96,3,1),
	(248,96,2,1),
	(286,105,2,1),
	(287,105,3,1);

/*!40000 ALTER TABLE `user_allowed_customers` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
