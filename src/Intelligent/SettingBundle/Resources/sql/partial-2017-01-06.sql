
ALTER TABLE `module_settings` CHANGE `value` `value` TEXT  CHARACTER SET utf8  COLLATE utf8_general_ci  NULL;

ALTER TABLE `module_settings` CHANGE `module_field_datatype` `module_field_datatype` ENUM('varchar','enum','text','integer','currency','decimal','link','user','date','datetime','relationship','number','percentage','formulafield')  CHARACTER SET utf8  COLLATE utf8_general_ci  NULL  DEFAULT 'text';

ALTER TABLE `module_settings` ADD `formulafield` TEXT  NULL  AFTER `relationship_module_unique_field`;

CREATE TABLE `customer_projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `modified_datetime` datetime DEFAULT NULL,
  `modified_by` int(11) DEFAULT NULL,
  `linked_customer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `modified_datetime` (`modified_datetime`),
  KEY `modified_by` (`modified_by`),
  KEY `linked_customer_id` (`linked_customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;