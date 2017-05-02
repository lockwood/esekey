# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `payment`

DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `booking_reference` mediumint(9) NOT NULL,
  `payment_method` char(1) NOT NULL,
  `deposit_amount` decimal(9,2) NOT NULL,
  `deposit_field1` varchar(30),
  `deposit_field2` varchar(30),
  `tariff` char(1) NOT NULL,
  `balance_amount` decimal(9,2) NOT NULL,
  `tariff_field1` varchar(30),
  `tariff_field2` varchar(30),
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `booking_reference`)
);

