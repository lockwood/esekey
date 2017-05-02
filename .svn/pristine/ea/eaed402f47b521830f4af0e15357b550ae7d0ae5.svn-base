# Server version: 4.0.13
# PHP Version: 4.3.3
# 

 USE esekey9_eseData;
# USE eseData;

DELETE FROM `company` where company_id = 4;

INSERT INTO `company` VALUES (4, 'Sheephouse Manor', 'sheephousemanor', '+44(0)1628 776902', '+44(0)1628 625138', 'dave@esekey.com', 'Y', 'Y', 'Y', now(), 'root', null);

DELETE FROM `user` where company_id = 4;

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

INSERT INTO `user` VALUES (0, 'Caroline', MD5('aerobics'), 'info@sheephousemanor.co.uk', 4, 'Caroline Street', 'NoSite', 'Y', now(), 'root', null);

DELETE FROM `section` where company_id = 4;

INSERT INTO `section` VALUES (4, 1, 'Home', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (4, 2, 'Gallery', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (4, 3, 'Availability', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (4, 4, 'Booking', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (4, 5, 'Secure Booking', 'Y', now(), 'root', null);

DELETE FROM `page` where company_id = 4;

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

INSERT INTO `page` VALUES (4, 1, '16th Century Guest House and Cottages', 'Home', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (4, 2, 'Bed and Breakfast', 'B &amp; B', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (4, 3, 'Self Catering', 'Self Catering', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (4, 4, 'The Chalets', 'The Chalets', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (4, 5, 'How to find us', 'Find Us', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (4, 6, 'Local Places of Interest', 'Local', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (4, 7, 'Availability', 'Availability', 7, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (4, 8, 'Tariff', 'Tariff', 3, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (4, 9, 'Sheephouse Manor - Secure Booking', 'Secure Booking', 8, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (4, 10, 'Booking', 'Booking', 9, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (4, 11, 'Picture Gallery', 'Gallery', 10, 'Y', now(), 'root', null);

DELETE FROM `section_page` where company_id = 4;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `section_id` mediumint(9) NOT NULL,
#  `menu_sequence` smallint(2) NOT NULL,
#  `page_id` mediumint(9) NOT NULL,
#  `active_flag` char(1) NOT NULL default 'Y',
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `section_id`, `menu_sequence`)

INSERT INTO `section_page` VALUES (4, 1, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (4, 1, 2, 2, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (4, 1, 3, 3, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (4, 1, 4, 4, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (4, 1, 5, 5, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (4, 1, 6, 6, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (4, 1, 7, 7, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (4, 1, 8, 8, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (4, 1, 9, 10, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (4, 1, 10, 11, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (4, 5, 1, 9, 'Y', now(), 'root', null);

DELETE FROM `element` where company_id = 4;

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

INSERT INTO `element` VALUES (4, 1, 0, '', 'Welcome to Sheephouse Manor', '', '
            <ul>
              <li>Set in 2 acres of tranquil countryside overlooking trout fishery and fields<br><br>
              </li>
              <li>High Quality Bed &amp; Breakfast accommodation and four comfortable self catering cottages<br><br>
              </li>
              <li>Easy access from M4, M40 and M25.<br><br>
              </li>
              <li>Maidenhead town centre is 5 minutes by car.<br><br>
              </li>
              <li>Central London is 30 minutes by train<br><br>
              </li>
              <li>Just a few minutes from a host of cosy pubs and restaurants in Cookham and Bray serving delicious food<br>
              </li>
              <li>Children and pets welcome<br><br>
              </li>
            </ul>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 2, 0, '', '', '', 'Sheephouse Manor was originally a farmhouse, built some 500 years ago,
 and retains all the olde worlde charm with original oak beams, timber floors and miniature antique pine doors.<br/>
<br/>Our accommodation is ideal for both professional working people and families.<br/>
<br/>We offer short lets from 1 week to 6 months for contractors or relocations.<br/>
<br/>For family vacations we have a childrens&#039; play area, large gardens, plus a paddock.<br/>
<br/>There is secure off street parking within the grounds. Pets are welcome by arrangement.<br/>
<br/>We aim to provide the conveniences of a hotel but with the comforts of a home.', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 3, 0, '015Sheephouse_Manor_Home_Page.jpg', 'Welcome to Sheephouse Manor', '', '            <div align="center"> 
              <p><font size="2"><b>Beautiful sixteenth century farmhouse<br/>
                English Tourism Council<br/>
                3 star accommodation<br/>
                Established 1989</b></font></p>
            </div>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 4, 0, '', 'Bed and Breakfast', '', '
            <ul>
              <li>Easy access from M4, M40 and M25<br><br>
              </li>
              <li>Maidenhead town centre is 5 minutes by car<br><br>
              </li>
              <li>Just a few minutes from a host of cosy pubs and restaurants in Cookham and Bray serving delicious food<br>
              </li>
              <li>Children welcome<br><br>
              </li>
              <li>Cot and high chair available<br><br>
              </li>
              <li>All rooms en-suite with TV, minibars, tea and coffee<br><br>
              </li>
              <li>Access to phone, fax and internet<br><br>
              </li>
              <li>On site laundry facilities<br><br>
              </li>
              <li>Quiet, relaxing atmosphere<br><br>
              </li>
            </ul>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 5, 0, '', '', '', 'Traditional full English breakfast is served daily in the quaint dining room.<br/>
<br/>For the health conscious, we provide fresh fruit, yoghourts and cheeses.<br/>
<br/>For early departures, a self service buffet is available.<br/>
<br/>Guest bedrooms elegantly and uniquely furnished to compliment the charm of our sixteenth century home.<br/>
<br/>One double and two single bedrooms available in the Manor House.<br/>
<br/>Each bedroom named after local village: Bray, Cookham and Eton.<br/>
', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 6, 0, '007Cookham_Room_B&B.jpg', 'Cookham Room', '', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 7, 0, '011Dining_Room_Main_House_B&B.jpg', 'Dining Room', '', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 8, 0, '', 'Self Catering', '', '
            <ul>
              <li>Pets welcome by arrangement<br><br>
              </li>
              <li>Each chalet has a fully equipped kitchen, ensuite bathroom and TV with video or DVD<br><br>
              </li>
              <li>Cot and high chair available<br><br>
              </li>
              <li>Included in the package are bed linen and towels, heating, electricity, weekly linen change and cleaning.<br><br>
              </li>
              <li>Available from 1 week to 6 month stays<br><br>
              </li>
              <li>Several large supermarkets are just 5 minutes drive away:- Sainsbury, Waitrose and Tesco<br><br>
              </li>
              <li>All cottages inspected annually by the English Tourism Council<br><br>
              </li>
              <li>Cosy pubs and restaurants nearby<br><br>
              </li>
            </ul>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 9, 0, '', '', '', 'Each of our four chalets, set within the delightful grounds of 
Sheephouse Manor, has been tastefully converted from stables and a milking parlour. The cottages, which overlook 
farmland and lakes, sleep between 1 - 5 people and can be booked by singles, couples or family groups. Booked together 
they can accommodate groups of up to 15 people. All cottages are available from 1 week to 6 month stays. 
We are ideal for business relocations, short stay contractors up to 6 months, 
and family holidays.<br/><br/>The chalets range in size from studio through to 2 bedroom, and each has its own fully 
equipped kitchen, ensuite bathroom, dining area, TV with video or DVD, and 24 hour access to laundry facilities. 
Patio furniture and BBQ are available, as is access to large gardens and play area. Some cottages have a sofa bed 
for extra versatility.', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 10, 0, '019Chalet_3_patio_&_garden_Chalets.jpg', 'Chalet 3 patio and garden', '', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 11, 0, '008Chalet_3_Lounge_Chalets.jpg', 'Chalet 3 lounge', '', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 12, 0, '', 'How to find us', '', '
            <ul>
              <li>Set in 2 acres of tranquil countryside overlooking trout fishery and fields<br><br>
              </li>
              <li>High Quality Bed &amp; Breakfast accommodation and four comfortable self catering cottages<br><br>
              </li>
              <li>Easy access from M4, M40 and M25.<br><br>
              </li>
              <li>Maidenhead town centre is 5 minutes by car.<br><br>
              </li>
              <li>Central London is 30 minutes by train<br><br>
              </li>
              <li>Just a few minutes from a host of cosy pubs and restaurants serving delicious food<br>
              </li>
            </ul>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 13, 0, '', '', '', '<p><b>From London/North/South/West (M25 &amp; M4) </b></p>
<p>M4, exit J7. Take A4 towards Maidenhead. Over Maidenhead Bridge and turn right 
  at mini roundabout. Follow A4094 past Boulters Lock, and turn left into Sheephouse 
  Road after 0.5 mile. Sheephouse Manor is about 0.5 mile down on the right. 
</p>
<p><b>From M40 </b></p>
<p>M40, exit J4. Take A404 and exit at Bourne End. Follow A4155 and A4094 towards 
  Maidenhead. Over Cookham Bridge, following A4094 for 3/4 mile, turn right into 
  Sheephouse Road. Sheephouse Manor is about 0.5 mile down on the right.<br>
</p>
<p align="center">
<a href="http://uk.multimap.com/p/browse.cgi?pc=SL68HJ&title=SHEEPHOUSE+MANOR+GUEST+HOUSE" target="multimap">
<font color=black><b>CLICK HERE FOR FULL MAP</b></font></a> <br/>
</p>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 14, 0, 'map2.jpg', 'How to find us', '', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 15, 0, '', 'Local places of interest', '', '
            <ul>
              <li>Easy access to M4, M40 and M25.<br><br>
              </li>
              <li>Maidenhead town centre is 5 minutes by car.<br><br>
              </li>
              <li>Windsor, Slough and Henley are around 15 minutes by car.<br><br>
              </li>
              <li>Heathrow Airport is 20 minutes by car.<br><br>
              </li>
              <li>Central London is 30 minutes by train<br><br>
              </li>
            </ul>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 16, 0, '', '', '', '
We are an ideal base from which to visit Legoland and Windsor Castle, or explore the beautiful Thames Path on foot or 
by bicycle. The beautiful towns of Ascot, Henley and Marlow, with their famous sporting events, are close by. <br/><br/> 
Other local places of interest are Cliveden House, once home of the Astors and now owned by The National Trust, Boulters 
Lock, and the ancient woods at Burnham Beeches.<br/><br/>
After a busy day as a tourist or at work, Sheephouse Manor is a tranquil resting place to recharge and relax.<br/><br/>
Mountain bikes are available to hire, and boat trips on the River Thames are bookable locally.<br/><br/>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 17, 0, '003Legoland_Windsor_Local.jpg', 'A great day out for all the family', '', '<div align="center">Why not try a day&#039;s fly fishing at the <br/><a href="http://www.sheephousetroutfishery.co.uk" target="trout">
<font color=blue>Sheephouse Trout Fishery</font></a><br/>next door?</div>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 18, 0, '', '', '', '<p style="text-align: center"><b>Conditions of Booking</b><br><br>Accommodation at Wisteria, Gardener&#039;s Bothy & The Smithy</p><ol><li>Reservations must be guaranteed with a 30% non-refundable deposit, this will be taken from your credit card after you have provided your details to us securely online.</li><li>Payment in full is required if the booking is made less than 4 weeks before the start date.</li><li>In the event of cancellation or reduction in the booking, cancellation charges will be calculated at 80% of the value of the booking.</li><li>The 70% balance will be refunded provided that 28 days&#039; clear notice by mail, email or fax is given of cancellation of reservations.</li><li>When making your reservation, by completion of this secure online form you authorise that we may take the balance (70%) of the booking from your credit card 4 weeks prior to arrival or take the cancellation fee as above. Please let us know if your prefer to pay the balance by cash or cheque, otherwise the balance will be processed by credit card.</li><li>Please note that the booking is not confirmed until your deposit payment is successfully processed.</li></ol>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 19, 0, '', 'The Chalets', '', '
            <ul>
              <li>Sleep between 1-5 people<br><br>
              </li>
              <li>Patio furniture and BBQ<br><br>
              </li>
              <li>Chalets set within 2 acre grounds of Sheephouse Manor<br><br>
              </li>
              <li>Secure off street parking<br><br>
              </li>
              <li>Ideal for family holidays<br><br>
              </li>
              <li>Longer stays up to 6 months possible<br><br>
              </li>
              <li>Overlooking lakes and farmland<br><br>
              </li>
            </ul><p style="text-align: center"><img border="0" alt="Inspected annually by ETC" src="tourismbadge.jpg"></p>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 20, 0, '', '', '', '<h2>Chalet 1 -  sleeps 1-3</h2>
Studio accommodation with double bed, sofa bed, shower room and kitchenette.<br/><br/><h2>Chalet 2 - sleeps 2-5</h2>
Double Bedroom, lounge with sofa bed, 2 bathrooms, 2nd bedroom with bunk beds, kitchen.<br/><br/><h2>Chalet 3 - sleeps 1-2</h2>
Double bedroom, lounge, kitchen, bathroom.<br/><br/><h2>Chalet 4 - sleeps 2-3</h2>
Large studio with double bed, sofa bed, bathroom and kitchen.', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 21, 0, '005Chalet_4_kitchen_Chalets.jpg', 'Chalet 4 kitchen', '', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (4, 22, 0, '014Chalet_Blocks_Chalets.jpg', 'Chalet blocks', '', '', '', 'Y', now(), 'root', null);

DELETE FROM `page_element` where company_id = 4;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `page_id` mediumint(9) NOT NULL,
#  `sequence` mediumint(9) NOT NULL,
#  `element_id` mediumint(9) NOT NULL,
#  `active_flag` char(1) NOT NULL default 'Y',
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `page_id`, `sequence`)

INSERT INTO `page_element` VALUES (4, 1, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 1, 2, 2, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 1, 3, 3, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 2, 1, 4, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 2, 2, 5, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 2, 3, 6, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 2, 4, 7, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 3, 1, 8, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 3, 2, 9, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 3, 3, 10, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 3, 4, 11, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 4, 1, 19, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 4, 2, 20, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 4, 3, 21, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 4, 4, 22, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 5, 1, 12, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 5, 2, 13, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 5, 3, 14, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 6, 1, 15, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 6, 2, 16, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (4, 6, 3, 17, 'Y', now(), 'root', null);

DELETE FROM `property` where company_id = 4;

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

INSERT INTO `property` VALUES (4, 1, 'Chalet One', 'A', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (4, 2, 'Chalet Two', 'B', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (4, 3, 'Chalet Three', 'C', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (4, 4, 'Chalet Four', 'C', 'S', 'Y', now(), 'root', null);

DELETE FROM `price` where company_id = 4;

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

INSERT INTO `price` VALUES (4, 'A', '2005-01-01', '2007-01-01', '', '', '45.00', now(), 'root', null);
INSERT INTO `price` VALUES (4, 'B', '2005-01-01', '2007-01-01', '', '', '100.00', now(), 'root', null);
INSERT INTO `price` VALUES (4, 'C', '2005-01-01', '2007-01-01', '', '', '60.00', now(), 'root', null);

