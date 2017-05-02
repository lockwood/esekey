# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `user`

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL auto_increment,
  `user_name` varchar(40) UNIQUE,
  `password` varchar(50),
  `email` varchar(50), 
  `company_id` mediumint(5) ZEROFILL,
  `given_name` varchar(50) default '',
  `permissions` varchar(50) default '',
  `active_flag` char(1) default 'Y',
  `created_date` date,
  `last_modified_by` varchar(40),
  `last_modified_on` timestamp,
  PRIMARY KEY  (`user_id`)
);
