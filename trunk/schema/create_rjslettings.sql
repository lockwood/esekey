# Server version: 4.0.13
# PHP Version: 4.3.3
# 

# USE esekey9_eseData;
 USE eseData;

DELETE FROM `company` where company_id = 7;

INSERT INTO `company` VALUES (7, 'RJS Lettings', 'rjslettings', '+44(0)1628 411273', '+44(0)1628 411274', 'dave@esekey.com', 'Y', 'Y', 'N', now(), 'root', null);

DELETE FROM `user` where company_id = 7;

#  `user_id` int(11) NOT NULL auto_increment,
#  `user_name` varchar(40) UNIQUE,
#  `password` varchar(50),
#  `email` varchar(50), 
#  `company_id` mediumint(5) ZEROFILL,
#  `given_name` varchar(50) default '',
#  `permissions` varchar(50) default '',
#  `active_flag` char(1) default 'Y',
#  `created_date` date,
#  `last_modified_by` varchar(40),
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`user_id`)

INSERT INTO `user` VALUES (0, 'rjstreet', MD5('password'), 'rolandstreet@maidenheadwine.co.uk', 7, 'Roland Street', 'NoSite', 'Y', now(), 'root', null);

DELETE FROM `section` where company_id = 7;

INSERT INTO `section` VALUES (7, 1, 'Home', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (7, 2, 'Gallery', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (7, 3, 'Availability', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (7, 4, 'Booking', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (7, 5, 'Secure Booking', 'Y', now(), 'root', null);

DELETE FROM `page` where company_id = 7;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `page_id` mediumint(9) NOT NULL auto_increment,
#  `page_title` varchar(50) NOT NULL default '',
#  `page_name` varchar(50) NOT NULL default '',
#  `content_source` smallint(2),
#  `active_flag` char(1) NOT NULL default 'Y',
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `page_id`)

INSERT INTO `page` VALUES (7, 1, 'Self Catering Accommodation', 'Home', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (7, 2, 'How to find us', 'Find Us', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (7, 3, 'Local Attractions', 'Local Attractions', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (7, 4, 'Availability', 'Availability', 7, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (7, 5, 'Tariff', 'Tariff', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (7, 6, 'RJS Lettings - Secure Booking', 'Secure Booking', 8, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (7, 7, 'Booking', 'Booking', 9, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (7, 8, 'Picture Gallery', 'Gallery', 10, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (7, 9, 'About 26 New Road', 'About 26 New Road', 1, 'Y', now(), 'root', null);

DELETE FROM `section_page` where company_id = 7;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `section_id` mediumint(9) NOT NULL,
#  `menu_sequence` smallint(2) NOT NULL,
#  `page_id` mediumint(9) NOT NULL,
#  `active_flag` char(1) NOT NULL default 'Y',
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `section_id`, `menu_sequence`)

INSERT INTO `section_page` VALUES (7, 1, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (7, 1, 2, 2, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (7, 1, 3, 3, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (7, 1, 4, 4, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (7, 1, 5, 5, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (7, 5, 1, 6, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (7, 1, 6, 7, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (7, 1, 7, 8, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (7, 1, 8, 9, 'Y', now(), 'root', null);

DELETE FROM `element` where company_id = 7;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `element_id` mediumint(9) NOT NULL auto_increment,
#  `resource_id` mediumint(9) NOT NULL,
#  `image_name` varchar(50) NOT NULL default '',
#  `image_alt` varchar(50) NOT NULL default '',
#  `element_type` varchar(50) NOT NULL default '',
#  `text` text,
#  `link` varchar(50) NOT NULL default '',
#  `active_flag` char(1) NOT NULL default 'Y',
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `element_id`)

INSERT INTO `element` VALUES (7, 1, 0, '', '26 New Road', '', '
            <ul>
              <li>Set close to the village centre of Holyport, the property is also conveniently located for local shops and a couple of cosy pubs/restaurants on the village green.<br><br>
              </li>
              <li>Maidenhead and Windsor town centres are both within 10 minutes drive.<br><br>
              </li>
              <li>Easy access from M4 and M40.<br><br>
              </li>
              <li>Central London can be accessed within 30 minutes by train.<br><br>
              </li>
              <li>Children and pets are welcome, by arrangement.<br><br>
              </li>
              <li>There is off-street parking for 2 cars.<br><br>
              </li>
              <li>Short-term lets are available starting at 2 nights duration.<br><br>
              </li>
              <li>The accommodation is suitable for either professionals or families.<br><br>
              </li>
              <li>We aim to provide the conveniences of a hotel, but with the comforts of a home.<br><br>
              </li>
            </ul>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (7, 2, 0, '', 'Prices', '', '
            <table width=100%>
              <tr><td><b>Rental Duration</b></td><td><b>Daily Charge (based on occupancy of 2)</b></td></tr>
              <tr><td align=center>2-5 nights</td><td align=center>GBP 99.00</td></tr>
              <tr><td align=center>6-13 nights</td><td align=center>GBP 75.00</td></tr>
              <tr><td align=center>14-27 nights</td><td align=center>GBP 65.00</td></tr>
              <tr><td align=center>1-3 months</td><td align=center>GBP 55.00</td></tr>
            </table>
            <p>Extra persons are charged at GBP 5.00 per person per night (max. 2 extra).</p>
            <p>Cleaning of the house is carried out weekly for lettings in excess of 1 week, and linen changed, within the prices quoted above.</p>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (7, 3, 0, '', 'Terms and Conditions of Booking', '', '
            <p>A 25% non-refundable deposit is required at the time of booking for the property. This will not normally be refunded under any circumstances, and you are recommended to take out your own cancellation insurance policy.</p>
            <p>The 75% balance will be required immediately prior to commencement of stay or alternatively on arrival. The amounts paid are understood to cover the guaranteed duration of stay. Again insurance should be taken to cover monies paid.</p>
            <p>Rates include heating, lighting, linen and towels, plus weekly cleaning and service.</p>
            <p>Check-in is by arrangement, but will normally be after 4:00 p.m.</p>
            <p>Check-out is by 10:00 a.m. on the date of departure.</p>
            <p>Breakages and damage, if significant, will be charged for at cost.</p>
            <p>Online bookings can only be made at least <b>three</b> days in advance, otherwise by telephone or the e-mail address shown above.</p>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (7, 4, 0, '', 'How to find us', '', '
<p>From A4 Maidenhead take the A308 towards Windsor, past the town centre, straight on at the first roundabout, straight on (staying on the A308) at the A308(M) roundabout, under the motorway bridge, turn right at the next roundabout into Holyport Road.
Turn left into Stroud Farm Road, first left into Stompits Road, right into New Road. Number 26 is located on the right hand side.</p>
<p align=center><a href="http://uk.multimap.com/p/browse.cgi?pc=SL62LQ&title=26+New+Road+Holyport" target="multimap">
<font color=black><b>CLICK HERE FOR FULL MAP</b></font></a></p>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (7, 5, 0, '', 'Local Attractions', '', '
            <p>We are conveniently located for the following attractions. For any other information, kindly e-mail or telephone us.</p>
            <ul>
              <li>Windsor and Windsor Castle, Theatre Royal Windsor
              </li>
              <li>Dorney Lake and Dorney Court (Stately home)
              </li>
              <li>Eton College
              </li>
              <li>Legoland Windsor
              </li>
              <li>Thorpe Park
              </li>
              <li>Bekonscot Model Village
              </li>
              <li>Windsor Great Park and Savill Garden
              </li>
              <li>Windsor Racecourse
              </li>
              <li>Ascot Racecourse
              </li>
              <li>French Brothers Thames Boat Trips (Windsor)
              </li>
              <li>Bray Boats (Maidenhead)
              </li>
              <li>Cliveden House and Hotel (National Trust Grounds)
              </li>
              <li>Odds Farm Park (rare breeds animal park)
              </li>
              <li>London Zoo
              </li>
              <li>Magnet Leisure Centre, Maidenhead
              </li>
            </ul>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (7, 6, 1, '', '26 New Road', '', '
            <ul>
              <li>Set close to the village centre of Holyport, the property is also conveniently located for local shops and a couple of cosy pubs/restaurants on the village green.<br><br>
              </li>
              <li>Maidenhead and Windsor town centres are both within 10 minutes drive.<br><br>
              </li>
              <li>Easy access from M4 and M40.<br><br>
              </li>
              <li>Central London can be accessed within 30 minutes by train.<br><br>
              </li>
              <li>Children and pets are welcome, by arrangement.<br><br>
              </li>
              <li>There is off-street parking for 2 cars.<br><br>
              </li>
              <li>Short-term lets are available starting at 2 nights duration.<br><br>
              </li>
              <li>The accommodation is suitable for either professionals or families.<br><br>
              </li>
              <li>We aim to provide the conveniences of a hotel, but with the comforts of a home.<br><br>
              </li>
            </ul>', '', 'Y', now(), 'root', null);

DELETE FROM `page_element` where company_id = 7;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `page_id` mediumint(9) NOT NULL,
#  `sequence` mediumint(9) NOT NULL,
#  `element_id` mediumint(9) NOT NULL,
#  `active_flag` char(1) NOT NULL default 'Y',
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `page_id`, `sequence`)

INSERT INTO `page_element` VALUES (7, 1, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (7, 2, 1, 4, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (7, 3, 1, 5, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (7, 5, 1, 2, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (7, 7, 1, 3, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (7, 9, 1, 6, 'Y', now(), 'root', null);

DELETE FROM `property` where company_id = 7;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `property_id` mediumint(9) NOT NULL auto_increment,
#  `name` varchar(50) NOT NULL default '',
#  `price_code` char(1),
#  `booking_pattern` char(1),
#  `active_flag` char(1) NOT NULL default 'Y',
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `property_id`)

INSERT INTO `property` VALUES (7, 1, '26 New Road', 'A', 'S', 'Y', now(), 'root', null);

DELETE FROM `price` where company_id = 7;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `price_code` char(1) NOT NULL,
#  `start_date` date NOT NULL,
#  `end_date` date NOT NULL,
#  `monthly_rate` smallint(9),
#  `weekly_rate` smallint(9),
#  `daily_rate` decimal(9,2),
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `price_code`, `start_date`)

INSERT INTO `price` VALUES (7, 'A', '2005-01-01', '2007-01-01', '', '', '45.00', now(), 'root', null);

