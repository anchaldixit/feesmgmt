# ************************************************************
# Sequel Pro SQL dump
# Version 4135
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.38)
# Database: aizan_local
# Generation Time: 2017-01-06 17:38:21 +0000
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
  `relationship_campaign_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_by` (`modified_by`),
  KEY `relationship_campaign_id` (`relationship_campaign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table campaign
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaign`;

CREATE TABLE `campaign` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `linked_customer_id` int(11) DEFAULT NULL,
  `modified_datetime` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `relationship_initiative_id` int(11) DEFAULT NULL,
  `campaign_link_neighborhood` text,
  `campaign_name` varchar(150) DEFAULT NULL,
  `instruction_set__url_` varchar(400) DEFAULT NULL,
  `raw_file__url_` varchar(400) DEFAULT NULL,
  `estimated_uld_s__queued_` int(11) DEFAULT NULL,
  `actual_uld_s__post_filters_` int(11) DEFAULT NULL,
  `cf_status` varchar(200) DEFAULT NULL,
  `assigned_cf_tl` int(11) DEFAULT NULL,
  `cf_start_date` date DEFAULT NULL,
  `qa_completion_date` date DEFAULT NULL,
  `cf_completion_date` date DEFAULT NULL,
  `cleaned_for_email_marketing` int(11) DEFAULT NULL,
  `campaign_contact_list` varchar(400) DEFAULT NULL,
  `contact_finding__history_notes_issues` text,
  `email_marketing_status` varchar(200) DEFAULT NULL,
  `email_marketing_projected_send_date` date DEFAULT NULL,
  `promoted_url` varchar(400) DEFAULT NULL,
  `correspondence_template` varchar(400) DEFAULT NULL,
  `panic_template` varchar(400) DEFAULT NULL,
  `12_week_check` int(11) DEFAULT NULL,
  `overlapping_contacts` int(11) DEFAULT NULL,
  `email_dnc` int(11) DEFAULT NULL,
  `email_marketing_actual_send_out_date` date DEFAULT NULL,
  `final_campaign_contact_list_panic_gdoc` varchar(400) DEFAULT NULL,
  `email_marketing__history_notes_issues` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `campaign_name` (`campaign_name`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`),
  KEY `relationship_initiative_id` (`relationship_initiative_id`),
  KEY `instruction_set__url_` (`instruction_set__url_`(255)),
  KEY `raw_file__url_` (`raw_file__url_`(255)),
  KEY `estimated_uld_s__queued_` (`estimated_uld_s__queued_`),
  KEY `actual_uld_s__post_filters_` (`actual_uld_s__post_filters_`),
  KEY `cf_status` (`cf_status`),
  KEY `assigned_cf_tl` (`assigned_cf_tl`),
  KEY `cf_start_date` (`cf_start_date`),
  KEY `qa_completion_date` (`qa_completion_date`),
  KEY `cf_completion_date` (`cf_completion_date`),
  KEY `cleaned_for_email_marketing` (`cleaned_for_email_marketing`),
  KEY `campaign_contact_list` (`campaign_contact_list`(255)),
  KEY `email_marketing_status` (`email_marketing_status`),
  KEY `email_marketing_projected_send_date` (`email_marketing_projected_send_date`),
  KEY `promoted_url` (`promoted_url`(255)),
  KEY `correspondence_template` (`correspondence_template`(255)),
  KEY `panic_template` (`panic_template`(255)),
  KEY `12_week_check` (`12_week_check`),
  KEY `overlapping_contacts` (`overlapping_contacts`),
  KEY `email_dnc` (`email_dnc`),
  KEY `email_marketing_actual_send_out_date` (`email_marketing_actual_send_out_date`),
  KEY `final_campaign_contact_list_panic_gdoc` (`final_campaign_contact_list_panic_gdoc`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `campaign` WRITE;
/*!40000 ALTER TABLE `campaign` DISABLE KEYS */;

INSERT INTO `campaign` (`id`, `linked_customer_id`, `modified_datetime`, `modified_by`, `relationship_initiative_id`, `campaign_link_neighborhood`, `campaign_name`, `instruction_set__url_`, `raw_file__url_`, `estimated_uld_s__queued_`, `actual_uld_s__post_filters_`, `cf_status`, `assigned_cf_tl`, `cf_start_date`, `qa_completion_date`, `cf_completion_date`, `cleaned_for_email_marketing`, `campaign_contact_list`, `contact_finding__history_notes_issues`, `email_marketing_status`, `email_marketing_projected_send_date`, `promoted_url`, `correspondence_template`, `panic_template`, `12_week_check`, `overlapping_contacts`, `email_dnc`, `email_marketing_actual_send_out_date`, `final_campaign_contact_list_panic_gdoc`, `email_marketing__history_notes_issues`)
VALUES
	(1,1,2017,NULL,1,'Link Neighborhood','Campaign Name:','http://url','http://url',2,2,'1. Not Started',1,'2017-01-06','2017-01-06','2017-01-06',2,'http://url','s','1. Email Marketing Scheduled','2017-01-06','http://ss','http://url','http://url',23,2,2,'2017-01-06','http://url','2');

/*!40000 ALTER TABLE `campaign` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table campaign_contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaign_contacts`;

CREATE TABLE `campaign_contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(400) DEFAULT NULL,
  `modified_datetime` datetime DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `relationship_campaign_id` int(11) DEFAULT NULL,
  `campaign_name__ref_` varchar(200) DEFAULT NULL,
  `suggested_landing_page_domain` varchar(400) DEFAULT NULL,
  `suggested_landing_page` varchar(400) DEFAULT NULL,
  `harvested_landing_page` varchar(400) DEFAULT NULL,
  `harvested_landing_page_type` varchar(200) DEFAULT NULL,
  `geo_location` varchar(200) DEFAULT NULL,
  `state_territory` varchar(80) DEFAULT NULL,
  `city` varchar(120) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `degree_level` varchar(200) DEFAULT NULL,
  `page_type` varchar(64) DEFAULT NULL,
  `business_service_` varchar(30) DEFAULT NULL,
  `first_name` varchar(150) DEFAULT NULL,
  `last_name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `email_url` varchar(400) DEFAULT NULL,
  `cf_agent` varchar(100) DEFAULT NULL,
  `harvested_date` date DEFAULT NULL,
  `notes` text,
  `q_a_agent` varchar(100) DEFAULT NULL,
  `q_a_notes` text,
  `initial_email_sent_date` date DEFAULT NULL,
  `bucketing___response_type` varchar(200) DEFAULT NULL,
  `better_url_found` varchar(400) DEFAULT NULL,
  `new_contact_email_1` varchar(200) DEFAULT NULL,
  `new_contact_email_2` varchar(200) DEFAULT NULL,
  `new_contact_email_3` varchar(200) DEFAULT NULL,
  `dnc_request__email_` varchar(150) DEFAULT NULL,
  `last_email_sent_to_contact` varchar(200) DEFAULT NULL,
  `link_promise` varchar(200) DEFAULT NULL,
  `assigned_pseudo` varchar(100) DEFAULT NULL,
  `closed_date` date DEFAULT NULL,
  `upsell_response` varchar(200) DEFAULT NULL,
  `correspondence_notes` text,
  PRIMARY KEY (`id`),
  KEY `name` (`name`(255)),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_by` (`modified_by`),
  KEY `relationship_campaign_id` (`relationship_campaign_id`),
  KEY `campaign_name__ref_` (`campaign_name__ref_`),
  KEY `suggested_landing_page_domain` (`suggested_landing_page_domain`(255)),
  KEY `suggested_landing_page` (`suggested_landing_page`(255)),
  KEY `harvested_landing_page` (`harvested_landing_page`(255)),
  KEY `harvested_landing_page_type` (`harvested_landing_page_type`),
  KEY `geo_location` (`geo_location`),
  KEY `state_territory` (`state_territory`),
  KEY `city` (`city`),
  KEY `subject` (`subject`),
  KEY `degree_level` (`degree_level`),
  KEY `page_type` (`page_type`),
  KEY `business_service_` (`business_service_`),
  KEY `first_name` (`first_name`),
  KEY `last_name` (`last_name`),
  KEY `email` (`email`),
  KEY `email_url` (`email_url`(255)),
  KEY `cf_agent` (`cf_agent`),
  KEY `harvested_date` (`harvested_date`),
  KEY `q_a_agent` (`q_a_agent`),
  KEY `initial_email_sent_date` (`initial_email_sent_date`),
  KEY `bucketing___response_type` (`bucketing___response_type`),
  KEY `better_url_found` (`better_url_found`(255)),
  KEY `new_contact_email_1` (`new_contact_email_1`),
  KEY `new_contact_email_2` (`new_contact_email_2`),
  KEY `new_contact_email_3` (`new_contact_email_3`),
  KEY `dnc_request__email_` (`dnc_request__email_`),
  KEY `last_email_sent_to_contact` (`last_email_sent_to_contact`),
  KEY `link_promise` (`link_promise`),
  KEY `assigned_pseudo` (`assigned_pseudo`),
  KEY `closed_date` (`closed_date`),
  KEY `upsell_response` (`upsell_response`)
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
  `modified_by` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `website` (`website`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;

INSERT INTO `customer` (`id`, `customer_name`, `modified_datetime`, `website`, `modified_by`)
VALUES
	(1,'Expertise','2016-12-30 05:17:27','expertise.com',NULL),
	(2,'Tom','2016-12-30 05:19:01','accreditedonlinecolleges.org',NULL),
	(4,'no customer name','2017-01-02 19:58:56','www.junky',NULL),
	(5,'Edudemic','2017-01-04 06:50:10','edudemic.com',NULL);

/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table customer_projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer_projects`;

CREATE TABLE `customer_projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `modified_datetime` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  `relationship_customer_id` int(11) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `main_contact` varchar(64) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL,
  `address` text,
  `city` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `website` (`website`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `relationship_customer_id` (`relationship_customer_id`),
  KEY `main_contact` (`main_contact`),
  KEY `title` (`title`),
  KEY `city` (`city`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `customer_projects` WRITE;
/*!40000 ALTER TABLE `customer_projects` DISABLE KEYS */;

INSERT INTO `customer_projects` (`id`, `modified_datetime`, `modified_by`, `linked_customer_id`, `relationship_customer_id`, `website`, `main_contact`, `title`, `address`, `city`)
VALUES
	(1,'2017-01-06 14:14:51',NULL,1,1,'expertise.com','m','hr','a','c'),
	(2,'2017-01-06 14:15:24',NULL,1,1,'intelligent.com','','','',''),
	(3,'2017-01-06 14:16:23',NULL,2,2,'accreditedonlinecolleges.org','','','','');

/*!40000 ALTER TABLE `customer_projects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table DNC
# ------------------------------------------------------------

DROP TABLE IF EXISTS `DNC`;

CREATE TABLE `DNC` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



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
  `initiative_type` varchar(200) DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `priority` varchar(200) DEFAULT NULL,
  `initiative_details` text,
  PRIMARY KEY (`id`),
  KEY `relationship_marketing_projects_id` (`relationship_marketing_projects_id`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`),
  KEY `initiative_type` (`initiative_type`),
  KEY `assigned_to` (`assigned_to`),
  KEY `priority` (`priority`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `initiative` WRITE;
/*!40000 ALTER TABLE `initiative` DISABLE KEYS */;

INSERT INTO `initiative` (`id`, `linked_customer_id`, `modified_datetime`, `relationship_marketing_projects_id`, `modified_by`, `initiative_type`, `assigned_to`, `priority`, `initiative_details`)
VALUES
	(1,1,'2017-01-04 18:32:53',1,NULL,NULL,NULL,NULL,NULL);

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
  `projected_upsell_conversion__` float(10,2) DEFAULT NULL,
  `projected_rmi_conversion__` float(10,2) DEFAULT NULL,
  `projected_cs_conversion__` float(10,2) DEFAULT NULL,
  `cf_projected_start_date` date DEFAULT NULL,
  `email_marketing_projected_send_date__upsell_` date DEFAULT NULL,
  `email_marketing_projected_send_date__rmi___cs_` date DEFAULT NULL,
  `relationship_customer_projects_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `page_name` (`page_name`),
  KEY `marketing_project_status` (`marketing_project_status`(255)),
  KEY `project_manager` (`project_manager`),
  KEY `priority` (`priority`),
  KEY `content_status` (`content_status`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`),
  KEY `projected_upsell_conversion__` (`projected_upsell_conversion__`),
  KEY `projected_rmi_conversion__` (`projected_rmi_conversion__`),
  KEY `projected_cs_conversion__` (`projected_cs_conversion__`),
  KEY `cf_projected_start_date` (`cf_projected_start_date`),
  KEY `email_marketing_projected_send_date__upsell_` (`email_marketing_projected_send_date__upsell_`),
  KEY `email_marketing_projected_send_date__rmi___cs_` (`email_marketing_projected_send_date__rmi___cs_`),
  KEY `relationship_customer_projects_id` (`relationship_customer_projects_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `marketing_projects` WRITE;
/*!40000 ALTER TABLE `marketing_projects` DISABLE KEYS */;

INSERT INTO `marketing_projects` (`id`, `cf_projected_completion_date`, `marketing_project_status`, `content_url`, `modified_datetime`, `page_name`, `page_type`, `project_manager`, `priority`, `assign_to_upsell`, `assign_to_rmi`, `assign_to_cs`, `__of_emails_available_for_re_harvest`, `__of_emails_available_for_resend`, `content_launch_date`, `content_status`, `linked_customer_id`, `modified_by`, `projected_upsell_conversion__`, `projected_rmi_conversion__`, `projected_cs_conversion__`, `cf_projected_start_date`, `email_marketing_projected_send_date__upsell_`, `email_marketing_projected_send_date__rmi___cs_`, `relationship_customer_projects_id`)
VALUES
	(1,NULL,'In-Progress','http://www.demolink.com/demo','2017-01-06 14:38:03','SMB Resources for Veterans','Small Business',1,'High',100,150,0,12.3300,12.4440,'2016-12-09','In-progress',1,NULL,23.00,0.00,0.00,'2017-01-06','2017-01-06','2017-01-06',1),
	(2,NULL,'In-Progress','http://googledoclink.com','2016-12-30 06:08:23','Disability Remodeling Resources','Home and Garden',7,'High',0,150,5,30.0000,0.0000,'2017-01-31','Not Started',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(3,NULL,'Not Started','http://www.new.com','2017-01-06 14:37:44','Career & SMB Resources for Students','Small Business',1,'Medium',0,150,0,12.0030,0.0000,'2017-02-24','Not Started',1,NULL,2.00,0.00,0.00,'2017-01-06','2017-01-06','2017-01-06',1),
	(4,NULL,'Not Started','http://12.122.22.22/','2017-01-06 14:38:20','aaa','a',2,'High',1,1,1,123.0000,123.0000,'2016-12-30','In-progress',1,NULL,10.00,0.00,0.00,'2017-01-06','2017-01-06','2017-01-06',2),
	(5,NULL,'In-Progress','http://www.new.com','2017-01-02 19:57:58','some page','junk',7,'Medium',2,2,23,23.0000,0.0000,'2017-01-10','Not Started',2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

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
  `module_field_datatype` enum('varchar','enum','text','integer','currency','decimal','link','user','date','datetime','relationship','number','percentage','formulafield') DEFAULT 'text',
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique-fieldname-in-table` (`module_field_name`,`module`),
  KEY `module` (`module`),
  KEY `display_position` (`display_position`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `module_settings` WRITE;
/*!40000 ALTER TABLE `module_settings` DISABLE KEYS */;

INSERT INTO `module_settings` (`id`, `module_field_display_name`, `module_field_name`, `module`, `module_field_datatype`, `display_position`, `value`, `link_text`, `varchar_limit`, `enable_filter`, `enable_filter_with_option`, `required_field`, `show_in_grid`, `unique_field`, `relationship_module`, `modified_by`, `modified_datetime`, `disabled`, `relationship_module_unique_field`, `formulafield`)
VALUES
	(28,'name','name','campaign_contacts','varchar',100,'value1|value2|value3','',NULL,'N','N','N','Y','N','',NULL,'0000-00-00 00:00:00','N','',NULL),
	(34,'Marketing Project Status','marketing_project_status','marketing_projects','enum',100,'Not Started|In-Progress|On-Hold|Cancelled|Completed','',NULL,'Y','N','Y','Y','N','',NULL,'2016-12-30 05:09:50','N','',NULL),
	(35,'Content URL','content_url','marketing_projects','link',100,'value1|value2|value3','URL',NULL,'N','N','Y','Y','N','customer',NULL,'2017-01-05 09:22:36','N','',NULL),
	(37,'Customer Name','customer_name','customer','varchar',1,NULL,'',164,'Y','N','N','Y','N','',NULL,'2017-01-06 13:56:27','N','',''),
	(52,'Email Id','email_id','psuedo_email_accounts','varchar',100,NULL,'',64,'Y','N','N','Y','Y','',NULL,'2016-12-21 05:48:19','N','',NULL),
	(60,'Website','website','customer','varchar',6,NULL,'',100,'Y','Y','N','Y','Y',NULL,NULL,'2017-01-04 15:06:50','N','',NULL),
	(65,'Page Name','page_name','marketing_projects','varchar',10,NULL,'',64,'N','N','Y','Y','Y',NULL,NULL,'2017-01-04 19:39:19','N','',NULL),
	(66,'Page Type','page_type','marketing_projects','varchar',100,NULL,'',64,'N','N','N','Y','N',NULL,NULL,'2016-12-30 05:12:24','N','',NULL),
	(68,'Project Manager','project_manager','marketing_projects','user',100,NULL,'',NULL,'Y','N','N','Y','N',NULL,NULL,'2016-12-30 05:14:07','N','',NULL),
	(69,'Priority','priority','marketing_projects','enum',100,'Medium|High|Low','',NULL,'Y','N','Y','Y','N',NULL,NULL,'2016-12-30 05:15:07','N','',NULL),
	(71,'Assign to UPSELL','assign_to_upsell','marketing_projects','number',100,NULL,'',NULL,'Y','N','N','Y','N',NULL,NULL,'2017-01-02 08:37:19','N','',NULL),
	(72,'Assign to RMI','assign_to_rmi','marketing_projects','number',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2016-12-30 05:50:22','N','',NULL),
	(73,'Assign to CS','assign_to_cs','marketing_projects','number',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2016-12-30 05:52:52','N','',NULL),
	(74,'# of Emails Available For Re-Harvest','__of_emails_available_for_re_harvest','marketing_projects','decimal',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2016-12-30 05:58:39','N','',NULL),
	(75,'# of Emails Available For Resend','__of_emails_available_for_resend','marketing_projects','decimal',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2016-12-30 05:59:37','N','',NULL),
	(76,'Content Launch Date','content_launch_date','marketing_projects','date',16,NULL,'',NULL,'Y','N','Y','Y','N',NULL,NULL,'2017-01-02 13:26:48','N','',NULL),
	(77,'Content Status','content_status','marketing_projects','enum',100,'In-progress|Not Started|On Hold|Completed|Closed','',NULL,'Y','N','N','Y','N',NULL,NULL,'2016-12-30 06:02:40','N','',NULL),
	(80,'Website','website','initiative','relationship',100,NULL,'',NULL,'N','N','Y','Y','N','marketing_projects',NULL,'2017-01-04 18:50:42','N','website',NULL),
	(81,'Project Manager','project_manager','initiative','relationship',100,NULL,'',NULL,'N','N','N','Y','N','marketing_projects',NULL,'2017-01-04 04:52:56','N','website',NULL),
	(82,'Page Name','page_name','initiative','relationship',100,NULL,'',NULL,'Y','Y','N','Y','N','marketing_projects',NULL,'2017-01-04 19:38:34','N','page_name',NULL),
	(83,'Projected UPSELL Conversion %','projected_upsell_conversion__','marketing_projects','percentage',100,NULL,'',NULL,'N','N','Y','Y','N',NULL,NULL,'2017-01-05 09:11:26','N','',NULL),
	(84,'Projected RMI Conversion %','projected_rmi_conversion__','marketing_projects','percentage',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 09:13:23','N','',NULL),
	(85,'Projected CS Conversion %','projected_cs_conversion__','marketing_projects','percentage',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 09:14:19','N','',NULL),
	(87,'CF Projected Start Date','cf_projected_start_date','marketing_projects','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 09:25:57','N','',NULL),
	(88,'Email Marketing Projected Send Date (UPSELL)','email_marketing_projected_send_date__upsell_','marketing_projects','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 09:30:27','N','',NULL),
	(89,'Email Marketing Projected Send Date (RMI & CS)','email_marketing_projected_send_date__rmi___cs_','marketing_projects','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 09:31:23','N','',NULL),
	(90,'Initiative Type','initiative_type','initiative','enum',100,'UPSELL|RMI|CS','',NULL,'Y','N','N','Y','N',NULL,NULL,'2017-01-05 09:38:50','N','',NULL),
	(91,'Assigned to','assigned_to','initiative','user',100,NULL,'',NULL,'Y','N','N','Y','N',NULL,NULL,'2017-01-05 09:39:56','N','',NULL),
	(92,'Priority','priority','initiative','enum',100,'High|Medium|Low','',NULL,'Y','N','N','Y','N',NULL,NULL,'2017-01-05 09:40:55','N','',NULL),
	(95,'Initiative Details: History/Notes/Issues','initiative_details','initiative','text',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-05 09:54:14','N','',NULL),
	(96,'Initiative - Page Name','page_name','campaign','relationship',100,NULL,'',NULL,'N','N','N','Y','N','initiative',NULL,'2017-01-05 10:23:39','N','page_name',NULL),
	(97,'Campaign Link Neighborhood','campaign_link_neighborhood','campaign','text',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-05 10:26:45','N','',NULL),
	(98,'Campaign Name','campaign_name','campaign','varchar',100,NULL,'',150,'N','N','N','Y','Y',NULL,NULL,'2017-01-05 10:28:27','N','',NULL),
	(99,'Instruction Set (URL)','instruction_set__url_','campaign','link',100,NULL,'URL',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 10:29:48','N','',NULL),
	(100,'Raw File (URL)','raw_file__url_','campaign','link',100,NULL,'File',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 10:30:29','N','',NULL),
	(101,'Estimated ULD\'s (Queued)','estimated_uld_s__queued_','campaign','number',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-05 10:32:49','N','',NULL),
	(102,'Actual ULD\'s (Post Filters)','actual_uld_s__post_filters_','campaign','number',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-05 10:33:42','N','',NULL),
	(103,'CF Status','cf_status','campaign','enum',100,'1. Not Started|2. Need IS 3. Ready For Setup|3a. Leads Ready For Checking|4. Ready For Harvesting/CF Team|5. CF In-Progress|6. Ready For TL Check|7. TL Check In Progress|8. Ready For QA|9. QA In Progress|10. Ready Cleaning|11. CF Complete/Ready for Email Marketing|12. STOP|13. CF Complete - Rejected/Bad List/No Contact Found|14. CF Complete - List/Campaign Re-allocated to Other campaign.','',NULL,'Y','N','N','Y','N',NULL,NULL,'2017-01-05 10:37:53','N','',NULL),
	(104,'Assigned CF TL','assigned_cf_tl','campaign','user',100,NULL,'',NULL,'N','N','Y','Y','N',NULL,NULL,'2017-01-05 10:39:40','N','',NULL),
	(105,'CF Start Date','cf_start_date','campaign','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 10:48:02','N','',NULL),
	(106,'QA Completion Date','qa_completion_date','campaign','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 11:24:28','N','',NULL),
	(107,'CF Completion Date','cf_completion_date','campaign','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 11:25:27','N','',NULL),
	(108,'Cleaned For Email Marketing (# of Contacts for EM)','cleaned_for_email_marketing','campaign','number',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 12:26:22','N','',NULL),
	(109,'Campaign Contact List (URL)','campaign_contact_list','campaign','link',100,NULL,'contacts',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 12:44:25','N','',NULL),
	(110,'Contact Finding: History/Notes/Issues','contact_finding__history_notes_issues','campaign','text',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-05 12:45:03','N','',NULL),
	(111,'Email Marketing Status','email_marketing_status','campaign','enum',100,'1. Email Marketing Scheduled|2. Template Created|3. Agent Assigned|4. Panic Uploaded|5. Campaign Launched|6. Template QA\'ed|7. Email Marketing In Progress|8. On Hold','',NULL,'Y','N','N','Y','N',NULL,NULL,'2017-01-05 12:47:48','N','',NULL),
	(112,'Email Marketing Projected Send Date','email_marketing_projected_send_date','campaign','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 12:57:12','N','',NULL),
	(113,'Promoted URL','promoted_url','campaign','link',100,NULL,'URL',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 12:57:57','N','',NULL),
	(114,'Correspondence Template','correspondence_template','campaign','link',100,NULL,'tpl',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 12:58:48','N','',NULL),
	(115,'Panic Template','panic_template','campaign','link',100,NULL,'tpl',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 12:59:31','N','',NULL),
	(116,'12 Week Check','12_week_check','campaign','number',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-05 13:00:14','N','',NULL),
	(117,'Overlapping Contacts','overlapping_contacts','campaign','number',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:01:09','N','',NULL),
	(118,'Email DNC','email_dnc','campaign','number',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:01:46','N','',NULL),
	(119,'Email Marketing Actual Send Out Date','email_marketing_actual_send_out_date','campaign','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:02:26','N','',NULL),
	(120,'Final Campaign Contact List/Panic Gdoc','final_campaign_contact_list_panic_gdoc','campaign','link',100,NULL,'gdoc',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:04:22','N','',NULL),
	(121,'Email Marketing: History/Notes/Issues','email_marketing__history_notes_issues','campaign','text',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-05 13:05:26','N','',NULL),
	(122,'Campaign Name','campaign_name','campaign_contacts','relationship',100,NULL,'',NULL,'Y','N','N','Y','N','campaign',NULL,'2017-01-05 13:15:40','N','campaign_name',NULL),
	(123,'Campaign Name (Ref)','campaign_name__ref_','campaign_contacts','varchar',100,NULL,'',200,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:17:15','N','',NULL),
	(124,'Promoted URL','promoted_url','campaign_contacts','relationship',100,NULL,'',NULL,'N','N','N','Y','N','campaign',NULL,'2017-01-05 13:18:33','N','campaign_name',NULL),
	(125,'Suggested Landing Page Domain','suggested_landing_page_domain','campaign_contacts','link',100,NULL,'domain',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:20:02','N','',NULL),
	(126,'Suggested Landing Page','suggested_landing_page','campaign_contacts','link',100,NULL,'page url',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:21:03','N','',NULL),
	(127,'Harvested Landing Page','harvested_landing_page','campaign_contacts','link',100,NULL,'page url',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:22:38','N','',NULL),
	(128,'Harvested Landing Page Type','harvested_landing_page_type','campaign_contacts','enum',100,'Good|Bad','',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:23:36','N','',NULL),
	(129,'GEO Location','geo_location','campaign_contacts','varchar',100,NULL,'',200,'N','N','N','N','N',NULL,NULL,'2017-01-05 13:24:53','N','',NULL),
	(130,'State/Territory','state_territory','campaign_contacts','varchar',100,NULL,'',80,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:25:22','N','',NULL),
	(131,'City','city','campaign_contacts','varchar',100,NULL,'',120,'N','N','N','N','N',NULL,NULL,'2017-01-05 13:26:24','N','',NULL),
	(132,'Subject','subject','campaign_contacts','varchar',100,NULL,'',100,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:26:53','N','',NULL),
	(133,'Degree Level','degree_level','campaign_contacts','varchar',100,NULL,'',200,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:27:24','N','',NULL),
	(134,'Page Type','page_type','campaign_contacts','varchar',100,NULL,'',64,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:28:13','N','',NULL),
	(135,'Business/Service?','business_service_','campaign_contacts','varchar',100,NULL,'',30,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:28:37','N','',NULL),
	(136,'First Name','first_name','campaign_contacts','varchar',100,NULL,'',150,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:29:04','N','',NULL),
	(137,'Last Name','last_name','campaign_contacts','varchar',100,NULL,'',150,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:29:40','N','',NULL),
	(138,'Email','email','campaign_contacts','varchar',100,NULL,'',150,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:30:04','N','',NULL),
	(139,'Email URL','email_url','campaign_contacts','link',100,NULL,'url',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:31:11','N','',NULL),
	(140,'CF Agent','cf_agent','campaign_contacts','varchar',100,NULL,'',100,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:31:45','N','',NULL),
	(141,'Harvested Date','harvested_date','campaign_contacts','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:32:21','N','',NULL),
	(142,'Notes','notes','campaign_contacts','text',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-05 13:32:42','N','',NULL),
	(143,'Q/A Agent','q_a_agent','campaign_contacts','varchar',100,NULL,'',100,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:33:08','N','',NULL),
	(144,'Q/A Notes','q_a_notes','campaign_contacts','text',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-05 13:34:58','N','',NULL),
	(145,'Initial Email Sent Date','initial_email_sent_date','campaign_contacts','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:36:04','N','',NULL),
	(146,'Bucketing - Response Type','bucketing___response_type','campaign_contacts','enum',100,'Auto|Hard Bounce|Negative|Non-Negative|Wrong Contact','',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:37:46','N','',NULL),
	(147,'Better URL Found','better_url_found','campaign_contacts','link',100,NULL,'url',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:40:07','N','',NULL),
	(148,'New Contact Email 1','new_contact_email_1','campaign_contacts','varchar',100,NULL,'',200,'N','N','N','N','N',NULL,NULL,'2017-01-05 13:41:05','N','',NULL),
	(149,'New Contact Email 2','new_contact_email_2','campaign_contacts','varchar',100,NULL,'',200,'N','N','N','N','N',NULL,NULL,'2017-01-05 13:41:42','N','',NULL),
	(150,'New Contact Email 3','new_contact_email_3','campaign_contacts','varchar',100,NULL,'',200,'N','N','N','N','N',NULL,NULL,'2017-01-05 13:42:04','N','',NULL),
	(151,'DNC Request (Email)','dnc_request__email_','campaign_contacts','varchar',100,NULL,'',150,'N','N','N','N','N',NULL,NULL,'2017-01-05 13:42:51','N','',NULL),
	(152,'Last Email Sent to Contact','last_email_sent_to_contact','campaign_contacts','enum',100,'T2|Q1|Q2|Q3|Craft|NCT2|WCFU|Link Promise|WC|Tweaked Template|LinkUp Thanks|OOFU|LDF1|LDF2|LDF4|LDF3|NI Template|LPF1|LDF5|T1|LPF2|CFU|R3|R4|R1|R5|R2|6/1/2015|6/2/2015|Negative|LDF|Hard Bounce|OOOR|Link Up Thanks|LDF 2|assets.pinterest.com|tweak template|Tweak Tempalte|Crafted|Linkpromise|LPF4|T`|Tweak T2|Tweaked Tempalte|LPF3|Linkup|NI Template - Last Email Sent to Contact|Lin promise|kaphillips@gmail.com|Initial|Tweaked Templates|Craf|Tweaked Tempalate|Escalate|R|Phone request|','',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:53:14','N','',NULL),
	(153,'Link Promise','link_promise','campaign_contacts','enum',100,'Yes|No','',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-05 13:55:12','N','',NULL),
	(154,'Assigned Pseudo','assigned_pseudo','campaign_contacts','varchar',100,NULL,'',100,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:56:09','N','',NULL),
	(155,'Closed Date','closed_date','campaign_contacts','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:56:53','N','',NULL),
	(156,'Upsell Response','upsell_response','campaign_contacts','enum',100,'Negative|Non-Negative','',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 13:57:51','N','',NULL),
	(157,'Correspondence Notes','correspondence_notes','campaign_contacts','text',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-05 13:58:22','N','',NULL),
	(158,'Pseudo First Name','pseudo_first_name','psuedo_email_accounts','varchar',100,NULL,'',64,'N','N','N','Y','N',NULL,NULL,'2017-01-05 14:05:27','N','',NULL),
	(159,'Pseudo Last Name','pseudo_last_name','psuedo_email_accounts','varchar',100,NULL,'',64,'N','N','N','Y','N',NULL,NULL,'2017-01-05 14:06:04','N','',NULL),
	(160,'Pseudo Email Address','pseudo_email_address','psuedo_email_accounts','varchar',100,NULL,'',150,'N','N','N','Y','N',NULL,NULL,'2017-01-05 14:06:34','N','',NULL),
	(161,'Pseudo Email account Password','pseudo_email_account_password','psuedo_email_accounts','varchar',100,NULL,'',100,'N','N','N','Y','N',NULL,NULL,'2017-01-05 14:07:25','N','',NULL),
	(162,'Date Pseudo Created','date_pseudo_created','psuedo_email_accounts','date',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-05 14:08:11','N','',NULL),
	(163,'Creation Proxy URL','creation_proxy_url','psuedo_email_accounts','varchar',100,NULL,'',300,'N','N','N','Y','N',NULL,NULL,'2017-01-05 14:09:07','N','',NULL),
	(164,'Creation Proxy IP','creation_proxy_ip','psuedo_email_accounts','varchar',100,NULL,'',64,'N','N','N','Y','N',NULL,NULL,'2017-01-05 14:09:41','N','',NULL),
	(165,'Campaign Name','campaign_name','assign_psuedo','relationship',100,NULL,'',NULL,'Y','N','N','Y','N','campaign',NULL,'2017-01-05 14:13:42','N','campaign_name',NULL),
	(166,'Formlative field','formlative_field','marketing_projects','formulafield',100,NULL,'',NULL,'N','N','N','Y','N',NULL,NULL,'2017-01-06 12:21:37','N','','CONCAT(marketing_projects.assign_to_upsell * 100,\'%\' )'),
	(167,'Customer Name','customer_name','customer_projects','relationship',100,NULL,'',NULL,'N','N','N','Y','N','customer',NULL,'2017-01-06 14:01:51','N','customer_name','module.fieldname * 100'),
	(168,'Website','website','customer_projects','varchar',100,NULL,'',100,'Y','Y','N','Y','Y',NULL,NULL,'2017-01-06 14:05:38','N','','module.fieldname * 100'),
	(169,'Main Contact','main_contact','customer_projects','varchar',100,NULL,'',64,'N','N','N','Y','N',NULL,NULL,'2017-01-06 14:06:34','N','','module.fieldname * 100'),
	(170,'Title','title','customer_projects','varchar',100,NULL,'',10,'N','N','N','Y','N',NULL,NULL,'2017-01-06 14:07:38','N','','module.fieldname * 100'),
	(171,'Address','address','customer_projects','text',100,NULL,'',NULL,'N','N','N','N','N',NULL,NULL,'2017-01-06 14:08:21','N','','module.fieldname * 100'),
	(172,'City','city','customer_projects','varchar',100,NULL,'',64,'N','N','N','N','N',NULL,NULL,'2017-01-06 14:09:00','N','','module.fieldname * 100'),
	(173,'Website','website','marketing_projects','relationship',12,NULL,'',NULL,'Y','N','N','Y','N','customer_projects',NULL,'2017-01-06 14:39:06','N','website','module.fieldname * 100'),
	(174,'Initiative - Website','website','campaign','relationship',3,NULL,'',NULL,'N','N','N','Y','N','initiative',NULL,'2017-01-06 14:50:43','N','page_name','module.fieldname * 100');

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
  `pseudo_first_name` varchar(64) DEFAULT NULL,
  `pseudo_last_name` varchar(64) DEFAULT NULL,
  `pseudo_email_address` varchar(150) DEFAULT NULL,
  `pseudo_email_account_password` varchar(100) DEFAULT NULL,
  `date_pseudo_created` date DEFAULT NULL,
  `creation_proxy_url` varchar(300) DEFAULT NULL,
  `creation_proxy_ip` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_id` (`email_id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `linked_customer_id` (`linked_customer_id`),
  KEY `modified_by` (`modified_by`),
  KEY `pseudo_first_name` (`pseudo_first_name`),
  KEY `pseudo_last_name` (`pseudo_last_name`),
  KEY `pseudo_email_address` (`pseudo_email_address`),
  KEY `pseudo_email_account_password` (`pseudo_email_account_password`),
  KEY `date_pseudo_created` (`date_pseudo_created`),
  KEY `creation_proxy_url` (`creation_proxy_url`(255)),
  KEY `creation_proxy_ip` (`creation_proxy_ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
