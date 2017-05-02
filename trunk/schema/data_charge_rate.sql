# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

#
# Test data for table `charge_rate`
#
#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `charge_code` char(1) NOT NULL,
#  `charge_from` date NOT NULL,
#  `charge_amount` decimal(9,2),
#  `charge_parameter` mediumint(5),
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
 
INSERT INTO `charge_rate` VALUES (00007, 1, now(), '94.00', 2, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 2, now(), '80.00', 5, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 3, now(), '70.00', 9, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 4, now(), '60.00', 14, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 5, now(), '53.00', 21, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 6, now(), '45.00', 28, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 7, now(), '40.00', 90, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 8, now(), '5.00', 1, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 9, now(), '00.00', 0, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 9, '2006-12-01', '10.00', 0, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 9, '2007-02-01', '00.00', 0, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 10, now(), '25.00', 28, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 11, now(), '2.50', 0, now(), 'root', null);
INSERT INTO `charge_rate` VALUES (00007, 12, now(), '5.00', 0, now(), 'root', null);
