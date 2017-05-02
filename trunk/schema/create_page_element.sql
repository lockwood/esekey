# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `page_element`

DROP TABLE IF EXISTS `page_element`;
CREATE TABLE `page_element` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `page_id` mediumint(9) NOT NULL,
  `sequence` mediumint(9) NOT NULL,
  `element_id` mediumint(9) NOT NULL,
  `active_flag` char(1) NOT NULL default 'Y',
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `page_id`, `sequence`)
);

