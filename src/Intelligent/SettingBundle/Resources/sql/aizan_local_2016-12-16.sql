# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Database: aizan_local
# Generation Time: 2016-12-16 08:02:14 +0000
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
  PRIMARY KEY (`id`)
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table psuedo_email_accounts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `psuedo_email_accounts`;

CREATE TABLE `psuedo_email_accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table module_settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `module_settings`;

CREATE TABLE `module_settings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `module_field_display_name` varchar(250) DEFAULT NULL,
  `module_field_name` varchar(100) DEFAULT NULL,
  `module` varchar(100) DEFAULT NULL,
  `module_field_datatype` enum('varchar','enum','text','integer','currency','decimal','link','user','date','datetime') DEFAULT 'text',
  `value` varchar(400) DEFAULT NULL,
  `link_text` varchar(200) DEFAULT NULL,
  `enable_filter` enum('Y','N') DEFAULT 'N',
  `required_field` enum('Y','N') DEFAULT 'N',
  `modified_by` int(11) DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  `disabled` enum('Y','N') DEFAULT 'N',
  `relationship_module` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique-fieldname-in-table` (`module_field_name`,`module`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;





/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
