# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `charge_rate`

DROP TABLE IF EXISTS `charge_rate`;
CREATE TABLE `charge_rate` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `charge_code` smallint(9) NOT NULL,
  `charge_from` date NOT NULL,
  `charge_amount` decimal(9,2),
  `charge_parameter` mediumint(5),
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `charge_code`, `charge_from`)
);

