# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.38)
# Database: aizan_local
# Generation Time: 2016-12-22 16:58:58 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table assign_psuedo
# ------------------------------------------------------------

DROP TABLE IF EXISTS `assign_psuedo`;

CREATE TABLE `assign_psuedo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table campaign
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaign`;

CREATE TABLE `campaign` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field1` varchar(400) DEFAULT NULL,
  `campaign_name_w` varchar(400) DEFAULT NULL,
  `campaign_n` text,
  `campaign_n1` text,
  `campaign_n2` float(10,2) DEFAULT NULL,
  `camvd11` datetime DEFAULT NULL,
  `field_22` date DEFAULT NULL,
  `field_1` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field1` (`field1`(255)),
  KEY `campaign_name_w` (`campaign_name_w`(255)),
  KEY `campaign_n2` (`campaign_n2`),
  KEY `camvd11` (`camvd11`),
  KEY `field_22` (`field_22`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table campaign_contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaign_contacts`;

CREATE TABLE `campaign_contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table customer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field13` varchar(400) DEFAULT NULL,
  `customer_name` varchar(400) DEFAULT NULL,
  `customer_manager` text,
  `customer_address` text,
  `field3` varchar(64) DEFAULT NULL,
  `enumfield1` varchar(200) DEFAULT NULL,
  `unique_field_name` varchar(64) DEFAULT NULL,
  `unique_field2` varchar(64) DEFAULT NULL,
  `relationship_marketing_projects_id` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_field2` (`unique_field2`),
  KEY `enumfield1` (`enumfield1`),
  KEY `unique_field_name` (`unique_field_name`),
  KEY `relationship_marketing_projects_id` (`relationship_marketing_projects_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;

INSERT INTO `customer` (`id`, `field13`, `customer_name`, `customer_manager`, `customer_address`, `field3`, `enumfield1`, `unique_field_name`, `unique_field2`, `relationship_marketing_projects_id`, `name`)
VALUES
	(1,'hi','expertise.com','1','delhi','hello','new','unique1','unique2',1,NULL);

/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table DNC
# ------------------------------------------------------------

DROP TABLE IF EXISTS `DNC`;

CREATE TABLE `DNC` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table link_rates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_rates`;

CREATE TABLE `link_rates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table links
# ------------------------------------------------------------

DROP TABLE IF EXISTS `links`;

CREATE TABLE `links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table marketing_projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `marketing_projects`;

CREATE TABLE `marketing_projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_manager` int(11) DEFAULT NULL,
  `__of_emails_available_for_re_harvest` varchar(400) DEFAULT NULL,
  `__of_emails_available_for_resend` float(12,4) DEFAULT NULL,
  `cf_projected_completion_date` date DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `marketing_project_status` varchar(400) DEFAULT NULL,
  `content_url` varchar(400) DEFAULT NULL,
  `relationship_customer_id` int(11) DEFAULT NULL,
  `name` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_manager` (`project_manager`),
  KEY `date_created` (`date_created`),
  KEY `marketing_project_status` (`marketing_project_status`(255)),
  KEY `relationship_customer_id` (`relationship_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `marketing_projects` WRITE;
/*!40000 ALTER TABLE `marketing_projects` DISABLE KEYS */;

INSERT INTO `marketing_projects` (`id`, `project_manager`, `__of_emails_available_for_re_harvest`, `__of_emails_available_for_resend`, `cf_projected_completion_date`, `date_created`, `marketing_project_status`, `content_url`, `relationship_customer_id`, `name`)
VALUES
	(1,111,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `marketing_projects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table module_settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `module_settings`;

CREATE TABLE `module_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_field_display_name` varchar(250) DEFAULT NULL,
  `module_field_name` varchar(100) DEFAULT NULL,
  `module` varchar(100) DEFAULT NULL,
  `module_field_datatype` enum('varchar','enum','text','integer','currency','decimal','link','user','date','datetime','relationship') DEFAULT 'text',
  `display_position` int(11) DEFAULT '100',
  `value` varchar(400) DEFAULT NULL,
  `link_text` varchar(200) DEFAULT NULL,
  `varchar_limit` int(5) DEFAULT NULL,
  `enable_filter` enum('Y','N') DEFAULT 'N',
  `required_field` enum('Y','N') DEFAULT 'N',
  `show_in_grid` enum('Y','N') DEFAULT 'Y',
  `unique_field` enum('Y','N') DEFAULT 'N',
  `relationship_module` varchar(100) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  `disabled` enum('Y','N') DEFAULT 'N',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique-fieldname-in-table` (`module_field_name`,`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `module_settings` WRITE;
/*!40000 ALTER TABLE `module_settings` DISABLE KEYS */;

INSERT INTO `module_settings` (`id`, `module_field_display_name`, `module_field_name`, `module`, `module_field_datatype`, `display_position`, `value`, `link_text`, `varchar_limit`, `enable_filter`, `required_field`, `show_in_grid`, `unique_field`, `relationship_module`, `modified_by`, `modified_datetime`, `disabled`)
VALUES
	(2,'Campaign End Date','campaign_end_date','campaign','datetime',2,NULL,'',NULL,'N','N','Y','N',NULL,NULL,'2016-12-21 14:07:38','N'),
	(18,'campaign name w','campaign_name_w','campaign','varchar',1,NULL,'',NULL,'Y','Y','Y','N','',NULL,'2016-12-21 14:08:30','N'),
	(26,'field13','field13','customer','enum',100,'value121|value21|value3','',NULL,'N','N','Y','N','',NULL,'2016-12-01 08:00:01','N'),
	(27,'field2','field2','psuedo_email_accounts','varchar',100,'value1|value2|value3','',NULL,'Y','N','Y','N','',NULL,'0000-00-00 00:00:00','N'),
	(28,'name','name','campaign_contacts','varchar',100,'value1|value2|value3','',NULL,'N','N','Y','N','',NULL,'0000-00-00 00:00:00','N'),
	(29,'Project Manager','project_manager','marketing_projects','user',100,'value1|value2|value3','',NULL,'Y','N','Y','N','',NULL,'2016-12-04 17:13:04','N'),
	(30,'# of Emails Available For Re-Harvest','__of_emails_available_for_re_harvest','marketing_projects','varchar',100,'value1|value2|value3','',NULL,'N','Y','Y','N','',NULL,'2016-12-04 05:24:04','N'),
	(31,'# of Emails Available For Resend','__of_emails_available_for_resend','marketing_projects','decimal',100,'value1|value2|value3','',NULL,'N','N','Y','N','',NULL,'2016-12-01 05:28:01','N'),
	(32,'CF Projected Completion Date','cf_projected_completion_date','marketing_projects','date',100,'value1|value2|value3','',NULL,'N','N','Y','N','',NULL,'0000-00-00 00:00:00','N'),
	(33,'Date Created','date_created','marketing_projects','datetime',100,'value1|value2|value3','',NULL,'Y','N','N','N','',NULL,'2016-12-29 05:31:29','N'),
	(34,'Marketing Project Status','marketing_project_status','marketing_projects','enum',100,'Not Started|In-Progress|On-Hold|Cancelled','',NULL,'Y','Y','Y','N','',NULL,'0000-00-00 00:00:00','N'),
	(35,'Content URL','content_url','marketing_projects','link',100,'value1|value2|value3','google doc',NULL,'N','Y','Y','N','customer',NULL,'0000-00-00 00:00:00','N'),
	(36,'field 1','field_1','campaign','varchar',100,'value1|value2|value3','',NULL,'N','Y','Y','N','',NULL,'2016-12-20 11:32:41','N'),
	(37,'Customer Name','customer_name','customer','varchar',100,NULL,'',164,'N','N','Y','N','',NULL,'2016-12-20 12:37:36','N'),
	(40,'Customer Manager','customer_manager','customer','text',100,NULL,'',NULL,'N','Y','Y','N','',NULL,'2016-12-20 12:42:24','N'),
	(41,'Customer Address','customer_address','customer','text',100,NULL,'',NULL,'N','N','Y','N','',NULL,'2016-12-20 12:51:24','N'),
	(42,'field3','field3','customer','varchar',100,NULL,'',64,'N','N','Y','N','',NULL,'2016-12-20 13:02:13','N'),
	(49,'enumfield1','enumfield1','customer','enum',100,'value1|value2|value3b','',NULL,'Y','Y','Y','N','',NULL,'2016-12-20 16:24:05','N'),
	(50,'unique field name','unique_field_name','customer','varchar',10,NULL,'',64,'Y','Y','N','Y','',NULL,'2016-12-21 14:00:39','N'),
	(51,'unique field2','unique_field2','customer','varchar',100,NULL,'',64,'N','Y','Y','Y','',NULL,'2016-12-20 17:44:43','N'),
	(52,'Email Id','email_id','psuedo_email_accounts','varchar',100,NULL,'',64,'Y','N','Y','Y','',NULL,'2016-12-21 05:48:19','N'),
	(54,'Customer Name','customer_name','marketing_projects','relationship',100,NULL,'',NULL,'N','Y','N','N','customer',NULL,'2016-12-21 15:55:09','N'),
	(56,'Customer Manager','customer_manager','marketing_projects','relationship',100,NULL,'',NULL,'N','N','Y','N','customer',NULL,'2016-12-21 17:41:32','N'),
	(57,'Project Manager','project_manager','customer','relationship',100,NULL,'',NULL,'N','N','Y','N','marketing_projects',NULL,'2016-12-22 11:28:19','N'),
	(58,'name','name','customer','varchar',100,NULL,'',64,'N','N','Y','N',NULL,NULL,'2016-12-22 11:32:50','N'),
	(59,'name','name','marketing_projects','varchar',100,NULL,'',64,'N','N','Y','N',NULL,NULL,'2016-12-22 11:33:09','N');

/*!40000 ALTER TABLE `module_settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table psuedo_email_accounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `psuedo_email_accounts`;

CREATE TABLE `psuedo_email_accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `field2` varchar(400) DEFAULT NULL,
  `email_id` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_id` (`email_id`),
  KEY `field2` (`field2`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
