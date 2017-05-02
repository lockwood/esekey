# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `view_descriptor`

DROP TABLE IF EXISTS `view_descriptor`;
CREATE TABLE `view_descriptor` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `view_name` char(30) NOT NULL,
  `field_name` char(30) NOT NULL,
  `field_sequence` smallint(2) NOT NULL,
  `unique_key` char(1),
  `list` char(1),
  `user_edit` char(1),
  `foreign_key` char(20),
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `view_name`, `field_name`)
);

