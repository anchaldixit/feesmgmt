# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.38)
# Database: aizan_local
# Generation Time: 2017-01-05 07:54:59 +0000
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
  `modified_datetime` datetime DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table campaign
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaign`;

CREATE TABLE `campaign` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `linked_customer_id` int(11) DEFAULT NULL,
  `modified_datetime` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table campaign_contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaign_contacts`;

CREATE TABLE `campaign_contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(400) DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(255)),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table campaign1
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaign1`;

CREATE TABLE `campaign1` (
  `Campaign_Record_ID_` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Campaign_Name` text,
  `Initiative_Record_ID_` text,
  `Initiative_Website` text,
  `Initiative_Page_Name` text,
  `Initiative_Campaign_Type` text,
  `Initiative_Record_ID_CF_Required_Completion_Date` text,
  `Campaign_Link_Neighborhood` text,
  `Instruction_Set_URL_` text,
  `Raw_File_URL_` text,
  `Estimated_ULD_s_Queued_` text,
  `Actual_ULD_s_Post_Filters_` text,
  `CF_Start_Date` text,
  `CF_Status` text,
  `Assigned_CF_TL` text,
  `CF_Completion_Date` text,
  `Cleaned_For_Email_Marketing_of_Contacts_for_EM_` text,
  `CF_Attrition` text,
  `Campaign_Contact_List_URL_` text,
  `Contact_Finding_History_Notes_Issues` text,
  `Email_Marketing_Status` text,
  `Email_Marketing_Required_Send_Date` text,
  `Email_Marketing_Projected_Send_Date` text,
  `Email_Marketing_Actual_Send_Out_Date` text,
  `Promoted_URL` text,
  `Correspondence_Template` text,
  `Panic_Template` text,
  `12_Week_Check` text,
  `Overlapping_Contacts` text,
  `Email_DNC` text,
  `_Total_Email_Sent` text,
  `Projected_Links_From_Email_Sent` text,
  `Final_Campaign_Contact_List_Panic_Gdoc` text,
  `Email_Marketing_History_Notes_Issues` text,
  `_of_Assignments` text,
  `Add_Pusedo_Assignment` text,
  `Total_Bucketed` text,
  `Total_Bucketing_Auto_Responses` text,
  `Total_Bucketing_Positive_Responses` text,
  `Total_Bucketing_Negative_Responses` text,
  `Total_Bucketing_Hard_Bounces` text,
  `Total_Bucketing_Wrong_Contact` text,
  `Total_Response_Rate_` text,
  `Total_Auto_Responses_` text,
  `Total_Positive_Responses_` text,
  `Total_Negative_Responses_` text,
  `Total_Link_Promises` text,
  `Total_Open_Threads` text,
  `Total_Closed` text,
  `_of_Links_Built` text,
  `Actual_Conversion_` text,
  `Projected_Conversion_To_Date_` text,
  `Links` text,
  `Total_Closed_Do_Not_Contact` text,
  `Total_Closed_Not_Interested` text,
  `Total_Closed_Not_Relevant` text,
  `Total_Closed_No_Response` text,
  `Total_Closed_Wrong_Contact` text,
  `Age_of_Campaign_Day_` text,
  `Age_of_Campaign_Week_` text,
  `Projected_Links_Built_To_Date` text,
  `Performance_Links_Builts_Vs_Projected_to_Date` text,
  `Performance_Status` text,
  `Campaign_Performance_History_Notes_Issues` text,
  `Contacts` text,
  `Add_Contact` text,
  `Actual_Contacts_Harvested_Ref_Only_` text,
  `Initial_Email_Sent_Date_For_Verification_Only_` text,
  `QA_Start_Date` text,
  `QA_Completion_Date` text,
  `Add_Agent_Assignment` text,
  `Add_Link` text,
  `Assign_Agent` text,
  `Date_Created` text,
  `Date_Modified` text,
  `Email_Marketing_Send_Date_RMI_CS_` text,
  `Email_Marketing_Send_Date_UPSELL_` text,
  `Initiative_Related_Marketing_project` text,
  `Marketing_Project_Projected_CS_Conversion_` text,
  `Marketing_Project_Projected_RMI_Conversion_` text,
  `Marketing_Project_Projected_UPSELL_Conversion_` text,
  `Last_Modified_By` text,
  `Record_Owner` text,
  `RMI_Conversion_Total_By_Week` text,
  `UPSELL_Conversion_Total_By_Week` text,
  `Age_of_Campaign_Week_Percent_Complete_RMI` text,
  `Age_of_Campaign_Week_Percent_Complete_UPSELL` text,
  `_of_DNC` text,
  `_of_GOV_Links` text,
  `_of_EDU_Links` text,
  `Total_T2_Sent` text,
  `Initiative_Record_ID_Marketing_Project_Page_Type` text,
  `_of_ULD` text,
  PRIMARY KEY (`Campaign_Record_ID_`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table customer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(400) DEFAULT NULL,
  `modified_datetime` datetime NOT NULL,
  `website` varchar(100) DEFAULT NULL,
  `main_contact` varchar(100) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `address` text,
  `city` varchar(64) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `website` (`website`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;

INSERT INTO `customer` (`id`, `customer_name`, `modified_datetime`, `website`, `main_contact`, `title`, `address`, `city`, `modified_by`)
VALUES
	(1,'Expertise','2016-12-30 05:17:27','expertise.com','Greg Schwartz','GM','39 Street','Seattle',NULL),
	(2,'Tom','2016-12-30 05:19:01','accreditedonlinecolleges.org','CNM','Manager','45 street, carson','LA',NULL),
	(4,'no customer name','2017-01-02 19:58:56','www.junky','no content','no title','no address','no city',NULL),
	(5,'Edudemic','2017-01-04 06:50:10','edudemic.com','Shank','Manager','New Delhi','delhi',NULL);

/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dnc_lists
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dnc_lists`;

CREATE TABLE `dnc_lists` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `modified_datetime` datetime DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table initiative
# ------------------------------------------------------------

DROP TABLE IF EXISTS `initiative`;

CREATE TABLE `initiative` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `linked_customer_id` int(11) DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  `relationship_marketing_projects_id` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `relationship_marketing_projects_id` (`relationship_marketing_projects_id`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `initiative` WRITE;
/*!40000 ALTER TABLE `initiative` DISABLE KEYS */;

INSERT INTO `initiative` (`id`, `linked_customer_id`, `modified_datetime`, `relationship_marketing_projects_id`, `modified_by`)
VALUES
	(1,1,'2017-01-04 18:32:53',1,NULL);

/*!40000 ALTER TABLE `initiative` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table link_rates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `link_rates`;

CREATE TABLE `link_rates` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `modified_datetime` datetime DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table links
# ------------------------------------------------------------

DROP TABLE IF EXISTS `links`;

CREATE TABLE `links` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `modified_datetime` datetime DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



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
  `page_name` varchar(64) DEFAULT NULL,
  `page_type` varchar(64) DEFAULT NULL,
  `project_manager` int(11) DEFAULT NULL,
  `priority` varchar(200) DEFAULT NULL,
  `assign_to_upsell` int(11) DEFAULT NULL,
  `assign_to_rmi` int(11) DEFAULT NULL,
  `assign_to_cs` int(11) DEFAULT NULL,
  `__of_emails_available_for_re_harvest` float(12,4) DEFAULT NULL,
  `__of_emails_available_for_resend` float(12,4) DEFAULT NULL,
  `content_launch_date` date DEFAULT NULL,
  `content_status` varchar(200) DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_name` (`page_name`),
  KEY `marketing_project_status` (`marketing_project_status`(255)),
  KEY `relationship_customer_id` (`relationship_customer_id`),
  KEY `project_manager` (`project_manager`),
  KEY `priority` (`priority`),
  KEY `content_status` (`content_status`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `marketing_projects` WRITE;
/*!40000 ALTER TABLE `marketing_projects` DISABLE KEYS */;

INSERT INTO `marketing_projects` (`id`, `cf_projected_completion_date`, `marketing_project_status`, `content_url`, `relationship_customer_id`, `modified_datetime`, `page_name`, `page_type`, `project_manager`, `priority`, `assign_to_upsell`, `assign_to_rmi`, `assign_to_cs`, `__of_emails_available_for_re_harvest`, `__of_emails_available_for_resend`, `content_launch_date`, `content_status`, `linked_customer_id`, `modified_by`)
VALUES
	(1,NULL,'In-Progress','http://www.demolink.com/demo',1,'2016-12-30 06:12:30','SMB Resources for Veterans','Small Business',1,'High',100,150,0,12.3300,12.4440,'2016-12-09','In-progress',1,NULL),
	(2,NULL,'In-Progress','http://googledoclink.com',2,'2016-12-30 06:08:23','Disability Remodeling Resources','Home and Garden',7,'High',0,150,5,30.0000,0.0000,'2017-01-31','Not Started',2,NULL),
	(3,NULL,'Not Started','http://www.new.com',1,'2017-01-02 17:45:43','Career & SMB Resources for Students','Small Business',1,'Medium',0,150,0,12.0030,0.0000,'2017-02-24','Not Started',1,NULL),
	(4,NULL,'Not Started','http://12.122.22.22/',1,'2017-01-04 18:27:38','aaa','a',2,'High',1,1,1,123.0000,123.0000,'2016-12-30','In-progress',1,NULL),
	(5,NULL,'In-Progress','http://www.new.com',2,'2017-01-02 19:57:58','some page','junk',7,'Medium',2,2,23,23.0000,0.0000,'2017-01-10','Not Started',2,NULL);

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
  `module_field_datatype` enum('varchar','enum','text','integer','currency','decimal','link','user','date','datetime','relationship','number','percentage') DEFAULT 'text',
  `display_position` int(11) DEFAULT '100',
  `value` varchar(600) DEFAULT NULL,
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique-fieldname-in-table` (`module_field_name`,`module`),
  KEY `module` (`module`),
  KEY `display_position` (`display_position`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `module_settings` WRITE;
/*!40000 ALTER TABLE `module_settings` DISABLE KEYS */;

INSERT INTO `module_settings` (`id`, `module_field_display_name`, `module_field_name`, `module`, `module_field_datatype`, `display_position`, `value`, `link_text`, `varchar_limit`, `enable_filter`, `enable_filter_with_option`, `required_field`, `show_in_grid`, `unique_field`, `relationship_module`, `modified_by`, `modified_datetime`, `disabled`, `relationship_module_unique_field`)
VALUES
	(28,'name','name','campaign_contacts','varchar',100,'value1|value2|value3','',NULL,'N','N','N','Y','N','',NULL,'0000-00-00 00:00:00','N',''),
	(34,'Marketing Project Status','marketing_project_status','marketing_projects','enum',100,'Not Started|In-Progress|On-Hold|Cancelled|Completed','',NULL,'Y','N','Y','Y','N','',NULL,'2016-12-30 05:09:50','N',''),
	(35,'Guidelines','content_url','marketing_projects','link',100,'value1|value2|value3','google doc',NULL,'N','N','Y','Y','N','customer',NULL,'2016-12-30 05:23:10','N',''),
	(37,'Customer Name','customer_name','customer','varchar',100,NULL,'',164,'Y','N','N','Y','N','',NULL,'2016-12-30 05:20:24','N',''),
	(52,'Email Id','email_id','psuedo_email_accounts','varchar',100,NULL,'',64,'Y','N','N','Y','Y','',NULL,'2016-12-21 05:48:19','N',''),
	(54,'Customer Name','customer_name','marketing_projects','relationship',100,NULL,'',NULL,'Y','N','Y','Y','N','customer',NULL,'2016-12-30 11:48:55','N','customer_name'),
	(60,'Website','website','customer','varchar',6,NULL,'',100,'Y','Y','N','Y','Y',NULL,NULL,'2017-01-04 15:06:50','N',''),
	(61,'Main Contact','main_contact','customer','varchar',10,NULL,'',100,'N','N','N','Y','N',NULL,NULL,'2016-12-30 04:59:03','N',''),
	(62,'Title','title','customer','varchar',15,NULL,'',20,'N','N','N','N','N',NULL,NULL,'2016-12-30 05:00:17','N',''),
	(63,'Address','address','customer','text',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2016-12-30 05:01:28','N',''),
	(64,'City','city','customer','varchar',100,NULL,'',64,'N','N','N','N','N',NULL,NULL,'2016-12-30 05:02:56','N',''),
	(65,'Page Name','page_name','marketing_projects','varchar',10,NULL,'',64,'N','N','Y','Y','Y',NULL,NULL,'2017-01-04 19:39:19','N',''),
	(66,'Page Type','page_type','marketing_projects','varchar',100,NULL,'',64,'N','N','N','Y','N',NULL,NULL,'2016-12-30 05:12:24','N',''),
	(68,'Project Manager','project_manager','marketing_projects','user',100,NULL,'',NULL,'Y','N','N','Y','N',NULL,NULL,'2016-12-30 05:14:07','N',''),
	(69,'Priority','priority','marketing_projects','enum',100,'Medium|High|Low','',NULL,'Y','N','Y','Y','N',NULL,NULL,'2016-12-30 05:15:07','N',''),
	(70,'Website','website','marketing_projects','relationship',12,NULL,'',NULL,'Y','N','N','Y','N','customer',NULL,'2016-12-30 08:39:48','N','customer_name'),
	(71,'Assign to UPSELL','assign_to_upsell','marketing_projects','number',100,NULL,'',NULL,'Y','N','N','Y','N',NULL,NULL,'2017-01-02 08:37:19','N',''),
	(72,'Assign to RMI','assign_to_rmi','marketing_projects','number',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2016-12-30 05:50:22','N',''),
	(73,'Assign to CS','assign_to_cs','marketing_projects','number',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2016-12-30 05:52:52','N',''),
	(74,'# of Emails Available For Re-Harvest','__of_emails_available_for_re_harvest','marketing_projects','decimal',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2016-12-30 05:58:39','N',''),
	(75,'# of Emails Available For Resend','__of_emails_available_for_resend','marketing_projects','decimal',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2016-12-30 05:59:37','N',''),
	(76,'Content Launch Date','content_launch_date','marketing_projects','date',16,NULL,'',NULL,'Y','N','Y','Y','N',NULL,NULL,'2017-01-02 13:26:48','N',''),
	(77,'Content Status','content_status','marketing_projects','enum',100,'In-progress|Not Started|On Hold|Completed|Closed','',NULL,'Y','N','N','Y','N',NULL,NULL,'2016-12-30 06:02:40','N',''),
	(80,'Website','website','initiative','relationship',100,NULL,'',NULL,'N','N','Y','Y','N','marketing_projects',NULL,'2017-01-04 18:50:42','N','website'),
	(81,'Project Manager','project_manager','initiative','relationship',100,NULL,'',NULL,'N','N','N','Y','N','marketing_projects',NULL,'2017-01-04 04:52:56','N','website'),
	(82,'Page Name','page_name','initiative','relationship',100,NULL,'',NULL,'Y','Y','N','Y','N','marketing_projects',NULL,'2017-01-04 19:38:34','N','page_name');

/*!40000 ALTER TABLE `module_settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table psuedo_email_accounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `psuedo_email_accounts`;

CREATE TABLE `psuedo_email_accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email_id` varchar(64) DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_id` (`email_id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
