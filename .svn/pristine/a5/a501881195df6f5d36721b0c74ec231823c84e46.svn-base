# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `diary`

DROP TABLE IF EXISTS `diary`;
CREATE TABLE `diary` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `resource_id` mediumint(9) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `resource_type` mediumint(9) NOT NULL,
  `entry_status` char(1) NOT NULL default 'Y',
  `booking_reference` mediumint(9) NOT NULL auto_increment,
  `created_date` date NOT NULL default '0000-00-00',
  `expiry` datetime NOT NULL,
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`booking_reference`)
);

