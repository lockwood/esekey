# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `descriptor`

DROP TABLE IF EXISTS `descriptor`;
CREATE TABLE `descriptor` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `field_name` char(30) NOT NULL,
  `field_label` char(30) NOT NULL,
  `description` varchar(50) NOT NULL,
  `help_text` text,
  `justify` char(1),
  `type` char(1),
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `field_name`)
);

