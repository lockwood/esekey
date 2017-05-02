# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `location`

DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `location_id` mediumint(9) NOT NULL auto_increment,
  `company_id` mediumint(5) ZEROFILL,
  `name` varchar(50) NOT NULL default '',
  `site_url` varchar(50) NOT NULL default '',
  `description` text NOT NULL default '',
  `postcode` char(8),
  `latitude` decimal(6,4),
  `longitude` decimal(6,4),
  `active_flag` char(1) NOT NULL default 'Y',
  `expiry_date` date NOT NULL default '9999-00-00',
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`location_id`)
);

