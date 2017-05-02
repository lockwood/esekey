# Server version: 4.0.13
# PHP Version: 4.3.3
# 
# USE esekey9_eseData;
USE eseData;

# Create Table structure for table `customer`

DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `customer_id` int(11) NOT NULL auto_increment,
  `title` char(4) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(25) NOT NULL,
  `post_address` varchar(100) NOT NULL,
  `post_code` char(8) NOT NULL,
  `telephone` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `customer_company_id` mediumint(5) ZEROFILL NOT NULL,
  `active_flag` char(1) NOT NULL default 'Y',
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `customer_id`),
);

