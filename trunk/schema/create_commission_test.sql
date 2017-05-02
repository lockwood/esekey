# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `commission_test`

DROP TABLE IF EXISTS `commission_test`;
CREATE TABLE `commission_test` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `quarter` char(6) NOT NULL,
  `booking_reference` mediumint(9) NOT NULL,
  `created_date` date NOT NULL,
  `booking_user` varchar(20) NOT NULL,
  `initial_amount` decimal(9,2) NOT NULL,
  `commission_amount` decimal(9,2) NOT NULL,
  `commission_status` varchar(22) NOT NULL default '',
  `commission_comment` text default '',
  `commission_comment_history` text default '',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `quarter`, `booking_reference`)
);

