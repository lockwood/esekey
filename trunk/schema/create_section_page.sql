# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `section_page`

DROP TABLE IF EXISTS `section_page`;
CREATE TABLE `section_page` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `section_id` mediumint(9) NOT NULL,
  `menu_sequence` smallint(2) NOT NULL,
  `page_id` mediumint(9) NOT NULL,
  `active_flag` char(1) NOT NULL default 'Y',
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `section_id`, `menu_sequence`)
);

