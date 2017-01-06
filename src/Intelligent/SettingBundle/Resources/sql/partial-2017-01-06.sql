
ALTER TABLE `module_settings` CHANGE `value` `value` TEXT  CHARACTER SET utf8  COLLATE utf8_general_ci  NULL;

ALTER TABLE `module_settings` CHANGE `module_field_datatype` `module_field_datatype` ENUM('varchar','enum','text','integer','currency','decimal','link','user','date','datetime','relationship','number','percentage','formulafield')  CHARACTER SET utf8  COLLATE utf8_general_ci  NULL  DEFAULT 'text';

ALTER TABLE `module_settings` ADD `formulafield` TEXT  NULL  AFTER `relationship_module_unique_field`;
