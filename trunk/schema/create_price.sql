# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `price`

DROP TABLE IF EXISTS `price`;
CREATE TABLE `price` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `price_code` char(1) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `monthly_rate` smallint(9),
  `weekly_rate` smallint(9),
  `daily_rate` decimal(9,2),
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `price_code`, `start_date`)
);

