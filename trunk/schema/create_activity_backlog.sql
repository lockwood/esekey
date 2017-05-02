# Server version: 4.0.13
# PHP Version: 4.3.3
# 
# USE esekey9_eseData;
USE eseData;

# Create Table structure for table `activity_backlog`

DROP TABLE IF EXISTS `activity_backlog`;
CREATE TABLE `activity_backlog` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `activity_id` mediumint(9) NOT NULL auto_increment,
  `page_id` mediumint(9) NOT NULL,
  `time_accessed` timestamp,
  `accessor_address` varchar(20) NOT NULL default '',
  `browser_type` varchar(255) NOT NULL default '',
  `referred_from` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`company_id`, `activity_id`)
);

