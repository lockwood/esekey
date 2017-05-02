# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

ALTER TABLE `payment` CHANGE `deposit_field1` `deposit_field1` VARCHAR(30) DEFAULT NULL;
ALTER TABLE `payment` CHANGE `deposit_field2` `deposit_field2` VARCHAR(30) DEFAULT NULL;
ALTER TABLE `payment` CHANGE `deposit_method` `payment_method` CHAR(1) NOT NULL;
ALTER TABLE `payment` CHANGE `balance_method` `tariff` CHAR(1) NOT NULL;
ALTER TABLE `payment` CHANGE `balance_field1` `tariff_field1` VARCHAR(30) DEFAULT NULL;
ALTER TABLE `payment` CHANGE `balance_field2` `tariff_field2` VARCHAR(30) DEFAULT NULL;
