# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `email`

DROP TABLE IF EXISTS `email`;
CREATE TABLE `email` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `booking_reference` mediumint(9) NOT NULL,
  `email_sequence` mediumint(9) NOT NULL auto_increment,
  `email_type` varchar(50) NOT NULL default '',
  `email_subject` varchar(50) NOT NULL default '',
  `email_top` text,
  `email_top_text` text,
  `email_body` text,
  `email_tail_text` text,
  `email_tail` text,
  `email_to` varchar(50), 
  `email_headers` varchar(200), 
  `sent_flag` char(1),
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `booking_reference`, `email_sequence`)
);

