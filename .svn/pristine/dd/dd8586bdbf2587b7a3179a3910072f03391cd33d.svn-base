# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `element`

DROP TABLE IF EXISTS `element`;
CREATE TABLE `element` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `element_id` mediumint(9) NOT NULL auto_increment,
  `resource_id` mediumint(9) NOT NULL,
  `image_name` varchar(50) NOT NULL default '',
  `image_type` varchar(50) NOT NULL default '',
  `text` text,
  `link` varchar(50) NOT NULL default '',
  `active_flag` char(1) NOT NULL default 'Y',
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `element_id`)
);

