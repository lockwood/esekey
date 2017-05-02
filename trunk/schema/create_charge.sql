# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

# Create Table structure for table `charge`

DROP TABLE IF EXISTS `charge`;
CREATE TABLE `charge` (
  `company_id` mediumint(5) ZEROFILL NOT NULL,
  `charge_code` smallint(9) NOT NULL,
  `charge_name` char(32) NOT NULL,
  `charge_description` text NOT NULL,
  `charge_type` smallint(9),
  `created_date` date NOT NULL default '0000-00-00',
  `last_modified_by` varchar(20) NOT NULL default '',
  `last_modified_on` timestamp,
  PRIMARY KEY  (`company_id`, `charge_code`)
);

