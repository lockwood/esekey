# Server version: 4.0.13
# PHP Version: 4.3.3
# 
# USE esekey9_eseData;
USE eseData;

# Create Table structure for table `enquiry`

DROP TABLE IF EXISTS `enquiry`;
CREATE TABLE `enquiry` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `enquiry_reference` mediumint(9) NOT NULL auto_increment,
  `property_id` mediumint(9),
  `area` varchar(50),
  `beds` smallint(2),
  `sleeps` smallint(2),
  `parking` char(1),
  `start_date` date,
  `nights` smallint(2),
  `sort` char(20) NOT NULL default 'Name',
  `contact_id` mediumint(9) ZEROFILL NOT NULL,
  `created_date` date NOT NULL default '0000-00-00',
  `expiry` datetime NOT NULL,
  `enquiry_notes` text,
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `enquiry_reference`)
);

