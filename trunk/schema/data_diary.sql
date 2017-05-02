# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

#
# Test data for table `diary`
#

INSERT INTO `diary` VALUES (1, 1, '2004-01-17', '2004-01-23', 1, 'P', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (1, 1, '2003-11-17', '2003-11-19', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (1, 3, '2004-02-02', '2004-02-20', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (1, 2, date_add(now(), interval 7 day), date_add(now(), interval 14 day), 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (1, 1, '2003-12-28', '2003-12-29', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (1, 4, '2003-12-29', '2004-01-04', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (1, 1, '2003-09-29', '2003-09-30', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (1, 2, '2003-12-13', '2003-12-20', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (1, 2, '2004-04-24', '2004-05-09', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (2, 1, '2004-01-17', '2004-01-23', 1, 'P', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (2, 1, '2003-11-17', '2003-11-19', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (2, 3, '2004-02-02', '2004-02-20', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (2, 2, date_add(now(), interval 7 day), date_add(now(), interval 14 day), 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (2, 1, '2003-12-28', '2003-12-29', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (2, 4, '2003-12-29', '2004-01-04', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (2, 1, '2003-09-29', '2003-09-30', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (2, 2, '2003-12-13', '2003-12-20', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);
INSERT INTO `diary` VALUES (2, 2, '2004-04-24', '2004-05-09', 1, 'C', 0, now(), '2005-01-01 00:00:00', 'root', null);

