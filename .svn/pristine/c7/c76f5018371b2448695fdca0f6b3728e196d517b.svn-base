# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `company_test`

DROP TABLE IF EXISTS `company_test`;
CREATE TABLE `company_test` (
  `company_id` mediumint(5) ZEROFILL NOT NULL auto_increment,
  `company_name` varchar(50) NOT NULL default '',
  `company_code` varchar(20) NOT NULL default '' UNIQUE,
  `company_telephone` varchar(50) NOT NULL default '',
  `company_fax` varchar(50) NOT NULL default '',
  `company_email` varchar(50) NOT NULL default '',
  `active_flag` char(1) NOT NULL default 'Y',
  `availability_flag` char(1) NOT NULL default 'N',
  `booking_flag` char(1) NOT NULL default 'N',
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`)
);

