# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.38)
# Database: aizan_local
# Generation Time: 2016-12-22 16:52:14 +0000
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
	(1,'Admin','This is the admin role.',1,'2016-12-17 02:29:35','2016-12-17 02:29:35');

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `role_global_permission` WRITE;
/*!40000 ALTER TABLE `role_global_permission` DISABLE KEYS */;

INSERT INTO `role_global_permission` (`id`, `role_id`, `manage_user_app_permission`, `edit_app_structure_permission`)
VALUES
	(1,1,1,1);

/*!40000 ALTER TABLE `role_global_permission` ENABLE KEYS */;
UNLOCK TABLES;


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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `role_module_permission` WRITE;
/*!40000 ALTER TABLE `role_module_permission` DISABLE KEYS */;

INSERT INTO `role_module_permission` (`id`, `role_id`, `module`, `view_permission`, `modify_permission`, `add_permission`, `delete_permission`)
VALUES
	(1,1,'Customer',1,1,1,1),
	(2,1,'MarketingMailers',1,1,1,1);

/*!40000 ALTER TABLE `role_module_permission` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `verification_id` varchar(100) DEFAULT NULL,
  `password_reset_id` varchar(100) DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL COMMENT '1=>''registered'', 2=>''unregistered'', 3=>''unverified'', 4=>''deactivated'',5=>''denied'',6=>password_reset ',
  `role_id` int(11) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `email`, `password`, `first_name`, `last_name`, `verification_id`, `password_reset_id`, `status`, `role_id`, `last_login`, `create_datetime`, `update_datetime`)
VALUES
	(0,'shashank.dwivedi@intelligent.com','shashank','shank','dwivedi',NULL,NULL,0,NULL,NULL,'0000-00-00 00:00:00','0000-00-00 00:00:00');

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
