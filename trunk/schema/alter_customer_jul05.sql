# Server version: 4.0.13
# PHP Version: 4.3.3
# 
# USE esekey9_eseData;
USE eseData;

ALTER TABLE `customer` ADD `company_id`  mediumint(5) ZEROFILL NOT NULL FIRST;
ALTER TABLE `customer` DROP PRIMARY KEY, ADD PRIMARY KEY ( `company_id` , `customer_id` );  

UPDATE customer a, booking b SET a.company_id = b.company_id WHERE b.customer_id = a.customer_id and b.customer_id > '00000';