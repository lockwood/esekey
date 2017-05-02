-- phpMyAdmin SQL Dump
-- version 2.7.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Apr 21, 2007 at 03:54 PM
-- Server version: 5.0.18
-- PHP Version: 5.1.2
-- 
-- Database: `esedata`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `customer_company`
-- 

DROP TABLE IF EXISTS `customer_company`;
CREATE TABLE `customer_company` (
  `company_id` mediumint(5) unsigned zerofill NOT NULL,
  `customer_company_id` mediumint(5) unsigned zerofill NOT NULL auto_increment,
  `customer_company_name` varchar(64) NOT NULL,
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL,
  `last_modified_on` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`company_id`,`customer_company_id`),
  UNIQUE KEY `customer_company_name` (`customer_company_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
