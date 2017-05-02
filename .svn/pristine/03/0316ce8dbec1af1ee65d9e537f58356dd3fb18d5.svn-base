# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `date_booking`

DROP TABLE IF EXISTS `date_booking`;
CREATE TABLE `date_booking` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `resource_id` mediumint(9) NOT NULL,
  `booking_date` date NOT NULL,
  `day_of_week` smallint(1) NOT NULL default 0,
  `booking_reference` mediumint(9) NOT NULL default 0,
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `resource_id`, `booking_date`)
);

