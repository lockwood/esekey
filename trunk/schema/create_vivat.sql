# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

DELETE FROM `company` where company_id = 5;

INSERT INTO `company` VALUES (5, 'The Vivat Trust', 'vivat', '07860 832741', '07860 832741', 'dave@esekey.com', 'Y', 'Y', 'Y', now(), 'root', null);

DELETE FROM `user` where company_id = 5;

INSERT INTO `user` VALUES (0, 'Test5', MD5('password'), 'test5@esekey.com', 5, 'Vivat Test', '', 'Y', now(), 'root', null);

DELETE FROM `section` where company_id = 5;

INSERT INTO `section` VALUES (5, 0, 'Vivat&nbsp;Home', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (5, 1, 'Vivat&nbsp;Information', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (5, 2, 'Vivat&nbsp;News', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (5, 3, 'The&nbsp;Properties', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (5, 4, 'Reservations', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (5, 5, 'Secure&nbsp;Booking', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (5, 6, 'Contact&nbsp;Us', 'Y', now(), 'root', null);

DELETE FROM `page` where company_id = 5;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `page_id` mediumint(9) NOT NULL auto_increment,
# `page_title` varchar(50) NOT NULL default '',
#  `page_name` varchar(50) NOT NULL default '',
#  `content_source` smallint(2),
#  `active_flag` char(1) NOT NULL default 'Y',
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `page_id`)

INSERT INTO `page` VALUES (5, 1, 'The Vivat Trust', 'Holidays in Historic Buildings', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 2, 'About the Vivat Trust', 'Introduction', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 3, 'About the Vivat Trust', 'About the properties', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 4, 'About the Vivat Trust', 'The Trustees', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 5, 'About the Vivat Trust', 'Our Suppliers', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 6, 'About the Vivat Trust', 'How to make a donation', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 7, 'About the Vivat Trust', 'Other sites of interest', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 8, 'Vivat News', '18th-century London building to be restored', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 9, 'Vivat News', 'Open Days', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 10, 'Vivat News', 'New Projects', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 11, 'Vivat News', 'Fundraising Gifts', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 12, 'Vivat News', 'Events', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 13, 'Vivat Properties', 'Location Map', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 14, 'The Chantry', 'Description', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 15, 'The Chantry', 'Historical Background', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 16, 'The Chantry', 'Local Attractions', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 17, 'The Chantry', 'Facilities', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 18, 'The Chantry', 'Floor Plan', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 19, 'The Chantry', 'Location', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 20, 'The Chantry', 'Availability', 7, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 21, 'Church Brow Cottage', 'Description', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 22, 'Church Brow Cottage', 'Historical Background', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 23, 'Church Brow Cottage', 'Local Attractions', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 24, 'Church Brow Cottage', 'Facilities', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 25, 'Church Brow Cottage', 'Floor Plan', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 26, 'Church Brow Cottage', 'Location', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 27, 'Church Brow Cottage', 'Availability', 7, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 28, 'Reservation Information', 'Making a Reservation', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 29, 'Reservation Information', 'Terms and Conditions', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 30, 'Reservation Information', 'Secure Online Booking', 9, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 31, 'Secure Booking', 'Secure Booking', 8, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 32, 'Contact Us', 'Vivat Trust Holidays', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 33, 'Contact Us', 'Request a Brochure', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 34, 'Contact Us', 'Privacy Policy', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (5, 35, 'Reservation Information', 'Lastminute Discounts', 1, 'Y', now(), 'root', null);

DELETE FROM `section_page` where company_id = 5;

INSERT INTO `section_page` VALUES (5, 0, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 1, 1, 2, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 1, 2, 3, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 1, 3, 4, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 1, 4, 5, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 1, 5, 6, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 1, 6, 7, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 2, 1, 8, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 2, 2, 9, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 2, 3, 10, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 2, 4, 11, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 2, 5, 12, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 1, 13, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 2, 14, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 3, 15, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 4, 16, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 5, 17, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 6, 18, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 7, 19, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 8, 20, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 9, 21, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 10, 22, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 11, 23, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 12, 24, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 13, 25, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 14, 26, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 3, 15, 27, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 4, 1, 28, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 4, 2, 29, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 4, 3, 35, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 4, 4, 30, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 5, 1, 31, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 6, 1, 32, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 6, 2, 33, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (5, 6, 3, 34, 'Y', now(), 'root', null);

DELETE FROM `element` where company_id = 5;

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

INSERT INTO `element` VALUES (5, 1, 0, 'infopica.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 2, 0, 'infopicb.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 3, 0, 'infopicc.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 4, 0, '', '', 'headpic', 'Introduction', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 5, 0, '', '', '', 'The Vivat Trust is a charity dedicated 
                        to rescuing neglected and dilapidated listed historic 
                        buildings of architectural, industrial and historical 
                        interest. Established in 1981, Vivat was the first trust 
                        to be allowed to acquire leasehold properties by The 
                        Charity Commissioners. As a result, Vivat is able to 
                        repair and improve small and medium sized buildings 
                        which have been passed over by larger organisations, 
                        whose owners cannot or do not wish to grant a 
                        freehold.<BR><BR>As Vivat has no endowment, repair and 
                        renovation funds are raised on a project by project 
                        basis. Funding bodies include <A 
                        href="http://www.ahfund.org.uk/"><U>The Architectural 
                        Heritage Fund</U><A>, English Heritage, <A 
                        href="http://www.hlf.org.uk/"><U>The Heritage Lottery 
                        Fund</U></A> and Historic Scotland as well as 
                        grant-making trusts and public companies. Once the 
                        buildings have been repaired and improved they must be 
                        self-financing which is why all of Vivat’s properties 
                        are currently let out as distinctive and luxurious 
                        holiday accommodation.<BR><BR>Letting out the buildings 
                        as holiday accommodation guarantees income for their 
                        maintenance and also allows them to be more sensitively 
                        repaired, as the structural changes need not be as 
                        radical as for residential homes. <BR><BR>Each project 
                        is thought out in an imaginative and flexible manner, 
                        with the help of Vivat’s voluntary Council of Management 
                        whose varied skills and breadth of experience provide 
                        The Trust with a solid foundation of professional 
                        knowledge and expertise.<BR><BR>By staying at a Vivat 
                        property you not only guarantee that The Trust’s 
                        historic buildings will be preserved for posterity but 
                        your support of Vivat’s work will help to fulfil it’s 
                        aim of heightening people’s awareness of Britain’s built 
                        heritage.', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 6, 0, '', '', '', 'All of Vivat’s properties are listed buildings of architectural, historical or industrial interest which are identified at risk and in many cases cannot be made available on the open market.  The Trustees seek out buildings that are threatened, solve the legal issues and problems that caused their demise and make them available for public enjoyment.  Buildings include humble cottages in fragile locations, vernacular buildings of local historical interest and follies which were built for whimsical and amusing reasons.<br><br><br>Holiday accommodation is the hallmark of Vivat and has proved to be most successful as it maintains the integrity of the building with less intervention than a permanent occupier would require, and generates the highest level of return.  <br><br>However, Vivat is not wedded to this solution;  it also considers both permanent residential accommodation and commercial use for derelict buildings.  The Trust also conducts feasibility studies and manages property on behalf of others.<br><br><br>The huge cost of repairing historic buildings results in Vivat’s properties being of a small or medium size and as Vivat has no endowment funds are raised on a project by project basis.  Experience has also taught that a building which appears to be immediately available will take on average between three and five years to complete.  <br><br><br>If you know of an historic building which has been neglected and you think Vivat could help, please email Vivat at <a href="mailto:enquiries@vivat.org.uk"><u>enquiries@vivat.co.uk</u></a> ', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 7, 0, 'newspica.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 8, 0, 'newspicb.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 9, 0, 'newspicc.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 10, 0, '', '', 'headpic', '18th-century London building to be restored', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 11, 0, '', '', '', 'With the help of donations from The Garfield Weston and Welton Foundations and a low-interest loan from the Architectural Heritage Fund, Vivat has acquired a 4-storey 18th-century shop and premises at 19 Crown Passage from James Lock & Co Ltd. The ground floor will be fitted out as a retail outlet from which to sell the Trust’s holidays in historic buildings. The upper floors will provide the Trust with premises from which to operate.<br><br>
By acquiring 19 Crown Passage, The Vivat Trust has saved this intriguing building, used variously in the past as a ships’ chandler’s, a licensed victualler’s and an ironmongers, from the developer’s hand. Despite retaining many of its original historical features the building is not listed,: its 18th-century interior, featuring original panelling, fireplaces and a dog-legged staircase, remains largely untouched.  The crucial lack of listed status meant that, had the building passed to an unsympathetic owner, these fascinating features might have been lost forever.  The Vivat Trust, in contrast, will apply best conservation practice to repair the building, bringing it back into beneficial use.<br><br>
It is the intention of The Trust to approach the Department of Culture, Media and Sport to gain listed status for the building. Applications will then be made to a number of grant giving trusts to cover the cost of restoration. These works will prevent the continuing deterioration of the building, already in a poor state of repair. <br><br>
Public access to the building will be permanently available once works are completed.  During office hours visitors will be able to explore the building in its entirety, at no cost, with the aid of a free leaflet detailing its history and restoration.  The Vivat Trust also intends to open the building as part of the London Open House weekend, each September.', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 12, 0, 'p0pica.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 13, 0, 'p0picb.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 14, 0, 'p0picc.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 15, 0, '', '', 'headpic', 'Location Map', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 16, 0, '', '', '', '<DIV align="center"><IMG height=400 
                        alt="Select a property from the map" 
                        src="ukmapred.gif" 
                        width=297 useMap=#gb border=0> <MAP id=gb 
                          name=gb><AREA shape=CIRCLE alt="The Chantry" 
                          coords=155,334,5 
                          href="p14.php"><AREA 
                          shape=CIRCLE alt="Church Brow Cottage" 
                          coords=150,201,5 
                          href="p21.php"><AREA 
                          shape=CIRCLE alt="The Cloister House" coords=152,150,5 
                          href="#"><AREA 
                          shape=CIRCLE alt="Comberemere Abbey Cottages" 
                          coords=153,251,5 
                          href="#"><AREA 
                          shape=CIRCLE alt="North Lees Hall" coords=176,244,5 
                          href="#"><AREA 
                          shape=CIRCLE alt="The Summer House" coords=160,271,5 
                          href="#"><AREA 
                          shape=CIRCLE alt="The Temple" coords=147,282,5 
                          href="#"><AREA 
                          shape=CIRCLE alt="The Tower of Halibar" 
                          coords=118,157,5 
                          href="#"><AREA 
                          shape=CIRCLE alt="Mill Hill Cottage" coords=214,243,5 
                          href="#"><AREA 
                          shape=CIRCLE alt="Barns Tower" coords=135,149,6 
                          href="#"><AREA 
                          shape=CIRCLE alt="Nettlestead Place Gatehouse" 
                          coords=240,319,5 
                          href="#"></MAP></DIV>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 17, 1, 'p1pica.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 18, 1, 'p1picb.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 19, 1, 'p1picc.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 20, 1, '', '', 'headpic', '<span class="headscript">Bridport, Dorset,<br>2 miles from the coast at West Bay<br>Sleeps up to 5<br>£560 to £725 per week, from £310 for a short break</span>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 21, 1, '', '', '', '<i>"We’ve had a wonderful few days, enjoying Dorset’s beaches in lovely sunshine and relaxing in this fantastic house."</i><br><br>Situated in Bridport, The Chantry dates from circa 1300 and is the oldest secular building in this charming Dorset town.  It is believed to have originally served as a primitive lighthouse and toll collection point but became a chantry, or priest’s house in 1362, when a new chapel in the local church was built.<br><br>Features that remain from this era are a piscina in the arched alcove of the romantic main bedroom and a rare pigeon loft on the top floor, which would have supplemented the priest’s income but now gives a delightful honeycomb effect.  Following Edward VI’s dissolution of the chantries, the building was converted to residential use.<br><br>The simple attractive lime washed walls of the interior are complemented by furniture of the Arts & Crafts movement of the early part of the 20th-century.<br><br>The Chantry is ideally placed for family holidays, exploring the Dorset coast and rolling countryside immortalised by the works of Thomas Hardy.<br><br><b>There is one week available at this property due to a cancellation between 16th-23rd October 2004</b><br>Contact the Vivat office for more information on 0845 090 0194.', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 22, 1, '', '', 'headpic', 'Historical Background', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 23, 1, '', '', '', 'The Chantry was built circa 1300 as a two-storey square tower and its traditional name ‘Dungeness’ meaning prison or a headland suggests that the building originally had a semi-defensive function.  Its situation overlooking the now extinct River Brit has prompted suggestions that The Chantry might have been a toll collection point and semi-circular projecting stones on the south wall indicate that it may also have served as a primitive lighthouse.<br><br>The original license for a chantry was granted in 1362, but until the new chapel was constructed the priest sang masses from the altar in his home.  At this time a pigeon loft was added to the top floor which would have been used to supplement the priest’s income and the porch was rebuilt to include an altar on the first floor.  The building continued to be used as a priest’s house until the Dissolution of the Chantries by Edward VI.<br><br>During the 17th-century changes were made to adapt the building to domestic use.  Fragments of geometric and floral patterned wallpaintings still remain from this era.  Further modernisation was carried out circa 1870, including the construction of a new staircase.  Twenty-five years later the famous Glaswegian architect, Charles Rennie Macintosh executed two sketches of The Chantry.<br><br>The last tenant vacated the building in 1972 and in 1986 The West Dorset District Council leased The Chantry to The Vivat Trust for 99 years.  The Trust converted the first and second floors into holiday accommodation and although The Bridport Museum retained the ground floor, it recently reverted to The Trust.', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 24, 1, '', '', 'headpic', 'Local Attractions', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 25, 1, '', '', '', 'Parnham House, famous for its furniture making is a short drive.  The West Dorset Heritage Coast with its coastal paths, The Swannery at Abbotsbury and The Chesil Beach are a short drive.  Within easy reach of Lyme Regis, Weymouth, Durdle Door and Lulworth Cove.  Further field for the more ambitious traveller Corfe Castle (NT) and Wareham.<br><br>Bridport Tourist Information Office:<br>32 South Street<br>Bridport<br>Dorset<br>DT6 3NQ<br><br>01308 424 901 ', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 26, 1, '', '', 'headpic', 'Facilities', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 27, 1, '', '', '', 'Off street parking. Linen and towels are provided. <br><br>One family pet allowed at no charge.<br><br>Highchair and cot provided – please supply linen for the cot. <P> </p><br><br><p class="basictextfac">Night Storage Heaters,&nbsp;Fridge + Fridge/Freezer,&nbsp; Electric Cooker,&nbsp; Washing Machine,&nbsp; DryerID,&nbsp; Dishwasher,&nbsp; Microwave,&nbsp; Payphone,&nbsp; Radio,&nbsp; TV,&nbsp; Video,&nbsp; Garden,&nbsp; Garden Furniture,&nbsp; Parking,&nbsp; Pet,&nbsp; BarbQ,&nbsp; HighChair,&nbsp; Cot,&nbsp; Open Fire.</p>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 28, 1, '', '', 'headpic', 'Floor Plan', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 29, 1, '', '', '', 'The entrance porch leads into the ground floor sitting and dining room with its magnificent sixteenth century fireplace and its wood burning stove. French windows lead out into the private garden. Next door is the well-equipped kitchen  designed for the Chantry by Newcastle Furniture Company, built into the large historic chimney piece.  Up the staircase is a large landing and a shower room. The spacious double bedroom is also on this floor, with its gothic arch, garderobe and wood burning stove. The second floor houses a twin bedroom, a single bedroom and a bathroom. These rooms feature a rare pigeon loft or columbarium.<br>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 30, 1, 'p1floor1.jpg', '', 'flow', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 31, 1, 'p1floor2.jpg', '', 'flow', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 32, 1, 'p1floor3.jpg', '', 'flow', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 33, 1, '', '', 'headpic', 'Location', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 34, 1, '', '', '', 'Situated in the town of Bridport, Dorset, The Chantry is ideally placed to explore the Dorset coast and rolling countryside immortalised by Thomas Hardy and provides a calming atmosphere in which to relax.  Located 2 miles from the coast at West Bay <i>(the setting for the new</i> Harbour Lights <i>series).<br><br>20 minutes drive from the historic town of Dorchester on the A35.</i>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 35, 1, '', '', 'headpic', 'Availability', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 36, 2, 'p2pica.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 37, 2, 'p2picb.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 38, 2, 'p2picc.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 39, 2, '', '', 'headpic', '<span class="headscript">Kirkby Lonsdale, Cumbria,<br>45 minutes from Lancaster on A683<br>Sleeps up to 2<br>£505 to £670 per week, from £275 for a short break</span>', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 40, 2, '', '', '', '<i>"This is proper England. Beautiful, unspoilt and wonderful.  We will return."</i><br><br>Church Brow Cottage was designed as a summer retreat for Abbots Brow House circa 1830. Perched on a steep bank of the River Lune the cottage commands a spectacular view across the valley, which Ruskin described as "one of the loveliest scenes in England, therefore the world" in 1875.  <br><br>Built in the Romantic Gothic style, this late Georgian garden pavilion with its pretty arched windows fulfils the notions of the rural idyll made popular in the mid-eighteenth century by the utopian novels of Jean Jacques Rousseau.  Church Brow Cottage has timeless qualities and makes an enchanting holiday destination.<br><br>   A beautiful garden - perfect for al fresco dining - with a formal upper terrace and more natural lower terraces, leads down to the river.  Wile away your days relaxing at Church Brow or if you prefer the cottage is the ideal place from which to explore the Lake District and Yorkshire Dales.', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 41, 0, 'rsrvpica.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 42, 0, 'rsrvpicb.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 43, 0, 'rsrvpicc.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 44, 0, '', '', 'headpic', 'Making a Reservation', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 45, 0, '', '', '', '1.	After considering the availability lists, you can either call us on 0845 090 0194 (outside the UK call : 00 44 207 336 8825), with your credit card to confirm the booking immediately, or you can fill in the <a href="../booking/booking.cfm?chunkID=form&ArtNoID=non">online reservation form</a>.<br><br>2.	Upon receiving your email notification Vivat will process your reservation and the booking will be held in your name for exactly one week.<br><br>3.	An email will be sent to you confirming your reservation with a booking reference number and will state the cost of your holiday, including any discounts. <br> <br>4.	The booking will not be confirmed until a deposit (see deposit payments information) or full payment has been received by Vivat.  If the booking is made within 10 weeks of your holiday start date payment is required in full.<br><br>5.	Please call Vivat on 0845 090 0194 (outside the UK call : 00 44 207 336 8825), with your credit card details upon receipt of your reservation confirmation to confirm your booking.<br><br>OPENING HOURS<br><br>	The office is open from 9am-5.00pm, Monday to Friday except on Bank Holidays. <br><br> Online reservations made after 5.30pm will not be confirmed until the following working day.  <br><br>Reservations are held for on week after the reservation confirmation email is sent.<br><br>In the unlikely situation of two people sending a reservation request after business hours for the same property and dates, the matter shall be dealt with on a first come first served basis according to the time the emails were received by Vivat.<br><br>CONFIRMATION OF BOOKING<br><br>Upon receipt of you deposit payment we will send you a confirmation of booking, stating the date when the balance payment will be due – 8 weeks prior to the start date of your holiday.<br><br>PLEASE NOTE:-	We reserve the right to levy a surcharge if payment of the balance is not reserved by the date shown on the Confirmation of Booking.<br><br>DEPOSIT PAYMENTS<br><br>All holiday bookings made more than 8 weeks before intended date of departure must be accompanied with the appropriate deposit.<br><br><i>TOTAL PRICE OF HOLIDAY AND DEPOSIT DUE </i><br><br>Less than £200	£60.00<br><br>£201-300	£90.00<br><br>£301-400	£120.00<br><br>£401-500	£150.00<br><br>£501-750	£200.00<br><br>£751-1000	£300.00<br><br>£1001 AND ABOVE	£400.00<br><br>ALTERATIONS TO BOOKINGS<br><br>We regret that we are unable to accept alterations to confirmed bookings, except in special circumstances where an additional administration charge of £20.00 (inc. VAT) will be made.  Alterations to bookings will not be implemented until we have received written confirmation together with payment of the administration charge.<br><br>CANCELLATION<br><br>We do hope that you do not have to cancel.  But if for any reason this is necessary you must write to us immediately to confirm cancellation.  In the event of cancellation your <b>DEPOSIT IS NON-REFUNDABLE</b> and the following cancellation charges will apply:-<br><br><i>PERIOD BEFORE HOLIDAY START DATE WHEN WRITEN NOTIFICATION IS RECEIVED BY VIVAT AND CANCELLATION CHARGE</i><br><br>UP TO 57 DAYS BEFORE START DATE	YOUR DEPOSIT<br><br>56-15 DAYS BEFORE START DATE 50% OF TOTAL RENTAL<br>	<br>14 – 8 DAYS BEFORE START DATE 75% OF TOTAL RENTAL<br><br>LESS THAN 8 DAYS 100% OF TOTAL RENTAL<br><br>We do not operate a Cancellation Insurance Scheme as experience leads us to believe that many people already have their own year-round cover.  However, if you do wish to take out insurance against cancellation please contact us for a proposal form.  This should be completed and sent together with the appropriate premium direct to the Insurance company.<br><br>FINAL INSTRUCTIONS AND ROAD DIRECTIONS<br><br>Upon receipt of your final payment, we will send you our Holiday Information Pack containing all the details you should need to enjoy your Vivat Trust holiday.  The pack includes:-<br><br>-	The address and directions to the properties.<br><br>-	Details of how to contact the Keyholder at least a week before your holiday is due to start.<br><br>-	A leaflet detailing the history of the property (not including Combermere Abbey Cottages).<br><br>ARRIVAL AND DEPARTURE TIMES<br><br>Your cottage will be available for you from 3pm on the start date of your holiday.  PLEASE AVOID ARRIVING EARLY.  You are required to vacate the property no later than 10am on the day of your departure to avoid causing a delay to the start of someone else’s holiday.<br><br>CLEANING<br><br>All our cottages are cleaned between guests but, because of limited time available between holidays you are requested to leave the property and its contents in a clean and tidy condition.  Please make a note of a note of any breakages or deficiencies and report them to the Keyholder upon departure so that the items may be replaced.  Our housekeepers are always anxious to please but they do need your co-operation to ensure that the property is up to standard for the people following you.', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 46, 0, '', '', 'headpic', 'Terms and Conditions', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 47, 0, '', '', 'headpic', 'Secure Online Booking', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 48, 0, 'ctctpica.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 49, 0, 'ctctpicb.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 50, 0, 'ctctpicc.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 51, 0, '', '', 'headpic', 'Vivat Trust Holidays', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 52, 0, '', '', 'headpic', 'About the properties', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 53, 0, '', '', 'headpic', 'The Trustees', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 54, 0, '', '', 'headpic', 'Our Suppliers', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 55, 0, '', '', 'headpic', 'How to make a donation', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 56, 0, '', '', 'headpic', 'Other sites of interest', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 57, 0, '', '', '', '<b>70 Cowcross Street<br>London<br>EC1M 6EJ<br><br>Telephone: 0845 090 0194<br>(outside the UK call: 00 44 207 336 8825)<br>Fax: 0845 090 0174<br>Email: <a href="mailto:enquiries@vivat.org.uk" onmouseover="window.status=&#39;Contact Vivat&#39;; return true" onmouseout="window.status=&#39;&#39;; return true"><u>enquiries@vivat.org.uk</u></a></b><br><br>Please contact us for further details or if you are having a problem with the site.', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 58, 0, '', '', 'headpic', 'Last Minute Discounts', '', 'Y', now(), 'root', null);

INSERT INTO `element` VALUES (5, 59, 0, '', '', '', '<a href="#"><u><b>Mill Hill Cottage</u></a></b> Has 5 nights available in February, <b>7th-12th</b> Vivat is offering the break for just <b>£400</b> <br><br> Phone the Vivat office today to enjoy the open fires and relaxing atmosphere of this interesting building <br><br><a href="#"><u><b>Barns Tower</u></a></b> has a lastminute mid week break<b> 22nd-25th February</B> Book soon to enjoy the log fires and wonderful border countryside this winter!<br> The three nights are being offered for just<b> £270</b> <br><br> <a href="#"><u><b> Nettlestead Place Gatehouse</u></a></b> set in the heart of rural Kent is free for the weekend of <b>4th-7th February</b><br>This last minute break is going for just <b>£310!!</b><br><br> <a href="p14.php"><u><b>The Chantry</u></a></b><br> This popular property in the delightful market town of Bridport, Dorset has four nights available mid week<b> 7th-11th February</b> Snap up this deal for just<b> £335.00</b> <br> The property sleeps up to five people on three floors.
<br><br<small><br><br>Last Minute Discounts are only valid for the properties/dates shown.  Other offers or discounts are not applicable.', '', 'Y', now(), 'root', null);

DELETE FROM `page_element` where company_id = 5;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `page_id` mediumint(9) NOT NULL,
#  `sequence` mediumint(9) NOT NULL,
#  `element_id` mediumint(9) NOT NULL,
#  `active_flag` char(1) NOT NULL default 'Y',
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `page_id`, `sequence`)

INSERT INTO `page_element` VALUES (5, 2, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 2, 2, 2, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 2, 3, 3, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 2, 4, 4, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 2, 5, 5, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 3, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 3, 2, 2, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 3, 3, 3, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 3, 4, 52, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 3, 5, 6, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 4, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 4, 2, 2, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 4, 3, 3, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 4, 4, 53, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 5, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 5, 2, 2, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 5, 3, 3, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 5, 4, 54, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 6, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 6, 2, 2, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 6, 3, 3, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 6, 4, 55, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 7, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 7, 2, 2, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 7, 3, 3, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 7, 4, 56, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 8, 1, 7, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 8, 2, 8, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 8, 3, 9, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 8, 4, 10, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 8, 5, 11, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 9, 1, 7, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 9, 2, 8, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 9, 3, 9, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 10, 1, 7, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 10, 2, 8, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 10, 3, 9, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 11, 1, 7, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 11, 2, 8, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 11, 3, 9, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 12, 1, 7, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 12, 2, 8, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 12, 3, 9, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 13, 1, 12, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 13, 2, 13, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 13, 3, 14, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 13, 4, 15, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 13, 5, 16, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 14, 1, 17, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 14, 2, 18, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 14, 3, 19, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 14, 4, 20, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 14, 5, 21, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 15, 1, 17, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 15, 2, 18, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 15, 3, 19, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 15, 4, 22, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 15, 5, 23, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 16, 1, 17, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 16, 2, 18, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 16, 3, 19, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 16, 4, 24, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 16, 5, 25, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 17, 1, 17, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 17, 2, 18, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 17, 3, 19, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 17, 4, 26, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 17, 5, 27, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 18, 1, 17, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 18, 2, 18, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 18, 3, 19, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 18, 4, 28, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 18, 5, 29, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 18, 6, 30, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 18, 7, 31, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 18, 8, 32, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 19, 1, 17, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 19, 2, 18, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 19, 3, 19, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 19, 4, 33, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 19, 5, 34, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 20, 1, 17, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 20, 2, 18, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 20, 3, 19, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 20, 4, 35, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 21, 1, 36, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 21, 2, 37, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 21, 3, 38, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 21, 4, 39, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 21, 5, 40, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 28, 1, 41, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 28, 2, 42, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 28, 3, 43, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 28, 4, 44, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 28, 5, 45, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 29, 1, 41, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 29, 2, 42, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 29, 3, 43, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 29, 4, 46, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 30, 1, 41, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 30, 2, 42, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 30, 3, 43, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 30, 4, 47, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 32, 1, 48, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 32, 2, 49, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 32, 3, 50, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 32, 4, 51, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 32, 5, 57, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 33, 1, 48, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 33, 2, 49, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 33, 3, 50, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 33, 4, 51, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 34, 1, 48, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 34, 2, 49, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 34, 3, 50, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 34, 4, 51, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 35, 1, 41, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 35, 2, 42, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 35, 3, 43, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 35, 4, 58, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (5, 35, 5, 59, 'Y', now(), 'root', null);

DELETE FROM `property` where company_id = 5;

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

INSERT INTO `property` VALUES (5, 0, 'The Chantry', 'A', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (5, 0, 'Church Brow Cottage', 'A', 'S', 'Y', now(), 'root', null);

