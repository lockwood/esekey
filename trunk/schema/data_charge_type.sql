# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

#
# Test data for table `charge_type`
#
#  `charge_type` smallint(9) NOT NULL,
#  `charge_type_name` char(32) NOT NULL,
#  `charge_type_description` text NOT NULL,
#  `charge_type_applies` char(32) NOT NULL,
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
 
INSERT INTO `charge_type` VALUES (1, 'Daily', 'Daily Charge', 'Per Booking', now(), 'root', null);
INSERT INTO `charge_type` VALUES (2, 'Weekly', 'Weekly Charge', 'Per Booking', now(), 'root', null);
INSERT INTO `charge_type` VALUES (3, 'Single', 'Single Charge', 'Per Booking', now(), 'root', null);
INSERT INTO `charge_type` VALUES (4, 'Discount', 'Percentage Discount', 'Per Booking', now(), 'root', null);
INSERT INTO `charge_type` VALUES (5, 'Deposit', 'Percentage Deposit', 'Per Booking', now(), 'root', null);
INSERT INTO `charge_type` VALUES (6, 'Daily', 'Daily Charge', 'Per Person', now(), 'root', null);
INSERT INTO `charge_type` VALUES (7, 'Weekly', 'Weekly Charge', 'Per Person', now(), 'root', null);
INSERT INTO `charge_type` VALUES (8, 'Single', 'Single Charge', 'Per Person', now(), 'root', null);
INSERT INTO `charge_type` VALUES (9, 'Discount', 'Percentage Discount', 'Per Person', now(), 'root', null);
INSERT INTO `charge_type` VALUES (10, 'Surcharge', 'Percentage Surcharge', 'Per Person', now(), 'root', null);
INSERT INTO `charge_type` VALUES (11, 'Daily', 'Daily Charge', 'Per Property', now(), 'root', null);
INSERT INTO `charge_type` VALUES (12, 'Weekly', 'Weekly Charge', 'Per Property', now(), 'root', null);
INSERT INTO `charge_type` VALUES (13, 'Single', 'Single Charge', 'Per Property', now(), 'root', null);
INSERT INTO `charge_type` VALUES (14, 'Discount', 'Percentage Discount', 'Per Property', now(), 'root', null);
INSERT INTO `charge_type` VALUES (15, 'Surcharge', 'Percentage Surcharge', 'Per Property', now(), 'root', null);
INSERT INTO `charge_type` VALUES (16, 'Daily', 'Optional Extra', 'Per Booking', now(), 'root', null);

