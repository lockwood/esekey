# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `property`

DROP TABLE IF EXISTS `property`;
CREATE TABLE `property` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `property_id` mediumint(9) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `price_code` char(1),
  `booking_pattern` char(1),
  `active_flag` char(1) NOT NULL default 'Y',
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `property_id`)
);

