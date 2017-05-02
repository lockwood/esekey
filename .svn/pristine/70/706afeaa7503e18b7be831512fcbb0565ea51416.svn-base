# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `section`

DROP TABLE IF EXISTS `section`;
CREATE TABLE `section` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `section_id` mediumint(9) NOT NULL,
  `description` varchar(50) NOT NULL default '',
  `active_flag` char(1) NOT NULL default 'Y',
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `section_id`)
);

