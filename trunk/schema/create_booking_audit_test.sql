# Server version: 4.0.13
# PHP Version: 4.3.3
# 
# USE esekey9_eseData;
USE eseData;

# Create Table structure for table `booking_audit_test`

DROP TABLE IF EXISTS `booking_audit_test`;
CREATE TABLE `booking_audit_test` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `booking_reference` mediumint(9) NOT NULL,
  `booking_sequence` smallint(2) NOT NULL auto_increment,
  `arrival_date` date NOT NULL,
  `departure_date` date NOT NULL,
  `number_adults` smallint(2),
  `number_children` smallint(2),
  `number_infants` smallint(2),
  `customer_id` mediumint(9) ZEROFILL NOT NULL,
  `display_status` char(1) NOT NULL default 'D',
  `booking_status` varchar(22) NOT NULL default '',
  `deposit_amount` decimal(9,2) NOT NULL,
  `balance_amount` decimal(9,2) NOT NULL,
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `booking_reference`, `booking_sequence`)
);

