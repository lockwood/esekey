# Server version: 4.0.13
# PHP Version: 4.3.3
# 
USE eseData;

DELETE FROM `company` where company_id = 6;

INSERT INTO `company` VALUES (6, 'Mapledurham Estate', 'mapledurham', '07860 832741', '07860 832741', 'dave@esekey.com', 'Y', 'Y', 'Y', now(), 'root', null);

DELETE FROM `user` where company_id = 6;

INSERT INTO `user` VALUES (0, 'Test6', MD5('password'), 'test6@esekey.com', 6, 'Mapledurham T6', '', 'Y', now(), 'root', null);

DELETE FROM `section` where company_id = 6;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `section_id` mediumint(9) NOT NULL,
#  `description` varchar(50) NOT NULL default '',
#  `active_flag` char(1) NOT NULL default 'Y',
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `section_id`)

INSERT INTO `section` VALUES (6, 1, 'Home', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (6, 2, 'The&nbsp;Experience', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (6, 3, 'The&nbsp;Cottages', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (6, 4, 'The&nbsp;History', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (6, 5, 'Secure&nbsp;Booking', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (6, 6, 'Reservations', 'Y', now(), 'root', null);
INSERT INTO `section` VALUES (6, 7, 'Contact&nbsp;Us', 'Y', now(), 'root', null);

DELETE FROM `page` where company_id = 6;

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

INSERT INTO `page` VALUES (6, 0, 'Holiday Cottages, ', 'watermill, historical estate house and village', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'The Experience', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Mapledurham Holiday Cottages', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'History of Mapledurham village and estate', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, 'Secure Booking', 'Secure Booking', 8, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Holiday Cottage Reservations', 9, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Holiday Cottage Availability', 2, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Contact the Mapledurham Estate office', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Yew Tree Cottage', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Yew Tree Cottage - Availability', 7, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Thatch Cottage', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Thatch Cottage - Availability', 7, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Pear Tree Cottage', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Honeysuckle Cottage', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'The Bothy', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Willow Cottage', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Step Cottage', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'Bottom Farm Cottage', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'The Gardens', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'The Almshouses (#1)', 1, 'Y', now(), 'root', null);
INSERT INTO `page` VALUES (6, 0, '', 'The Almshouses (#2)', 1, 'Y', now(), 'root', null);

DELETE FROM `section_page` where company_id = 6;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `section_id` mediumint(9) NOT NULL,
#  `menu_sequence` smallint(2) NOT NULL,
#  `page_id` mediumint(9) NOT NULL,
#  `active_flag` char(1) NOT NULL default 'Y',
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `section_id`, `menu_sequence`)

INSERT INTO `section_page` VALUES (6, 1, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 2, 1, 2, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 3, 1, 3, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 4, 1, 4, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 5, 1, 5, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 6, 1, 6, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 6, 2, 7, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 7, 1, 8, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 3, 2, 9, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 3, 3, 10, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 3, 4, 11, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 3, 5, 12, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 3, 6, 13, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 3, 7, 14, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 3, 8, 15, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 3, 9, 16, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 3, 10, 17, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 3, 11, 18, 'Y', now(), 'root', null);
INSERT INTO `section_page` VALUES (6, 3, 12, 19, 'Y', now(), 'root', null);

DELETE FROM `element` where company_id = 6;

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

#page 1
INSERT INTO `element` VALUES (6, 0, 0, 'house.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, '', '', 'headpic', '<OBJECT codeBase=http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=5,0,0,0 height=75 width=220 classid=clsid:D27CDB6E-AE6D-11cf-96B8-444553540000><PARAM NAME="movie" VALUE="address.swf"><PARAM NAME="menu" VALUE="false"><PARAM NAME="quality" VALUE="best"><PARAM NAME="wmode" VALUE="transparent"><PARAM NAME="bgcolor" VALUE="#003300"><EMBED src="address.swf" menu=false quality=best wmode=transparent bgcolor=#003300  WIDTH=220 HEIGHT=75 TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></EMBED></OBJECT>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, 'thatch.jpg', '', 'headpic', '', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, '', '', '', '<p align="justify"><font face="Tahoma" size="2" color="#800000"><b>Away from the distractions of town, business or busy hotels, Mapledurham is an oasis of peace, natural beauty and history which can be an ideal setting for small conferences, business meetings or corporate events.</b></font></p>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, '', '', '', '<p align="justify"><font face="Tahoma" size="2"> The grounds are ideal for parties, weddings and outdoor activities. Activities within Mapledurham Estate can include clay pigeon shooting, archery, quad biking, and horse riding. There is also a championship length <a href="http://www.cavershamgolf.co.uk"><font color="#000000">golf course</font></a> locally. The location has been used for many film and television productions.</font></p>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, 'map1.jpg', 'The Mapledurham Experience', 'left', '<p align="justify"><font face="Tahoma" size="2">Experience the Mapledurham Estate and the surrounding countryside through our public and private <a href="p2.php"><font color="#000000">events</font></a>.</font>', 'p2.php', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, 'map2.jpg', 'The Cottages', 'left', '<p align="justify"><font face="Tahoma" size="2">There are a number of beautiful <a href="p3.php"><font color="#000000"> cottages</font></a> available for holidaying throughout the year.</font>', 'p3.php', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, 'map3.jpg', 'The History Of Mapledurham', 'left', '<p align="justify"><font face="Tahoma" size="2">The Mapledurham House and Watermill date back to Doomsday England and have a varied <a href="p4.php"><font color="#000000">history</font></a>.</font>', 'p4.php', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, 'map4.jpg', 'Contact The Mapledurham Trust', 'left', '<p align="justify"><font face="Tahoma" size="2"><a href="p7.php"><font color="#000000">Contact</font></a> us if you are interested in any of the cottages, the village or events held on the Estate.</font>', 'p7.php', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, '', '', '', '<p align="justify"><font face="Tahoma" size="2"><b>Click on one of the pictures above for more information on the area.</b></font></p>', '', 'Y', now(), 'root', null);

#page 2
INSERT INTO `element` VALUES (6, 0, 0, '', '', 'headpic', '<p align="center"><b><u><font face="Tahoma" size="3" color="#FFFF66">The Experience</font></u></b></p><p align="justify"><font face="Tahoma" size="2" color="#FFFF66">You can experience the Mapledurham Estate by visiting one of our <a href="#">public events</a> or by organising your own <a href="#">private event</a> in the grounds of the Mapledurham House.</font>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, 'watermil.jpg', '', 'headpic', '<p align="justify"><font face="Tahoma" size="2" color="#FFFF66">Why not visit Mapledurham house and the watermill during your stay, open at weekends from Easter to the end of September.</font></p><p align="center"><font face="Tahoma" size="2" color="#FFFF66"><b><u>Opening Times</u></b></font></p><p align="center"><font face="Tahoma" size="2" color="#FFFF66">Riverside Picnic Park<br>Mapledurham Watermill<br>Mapledurham House</font></p><p align="center"><font face="Tahoma" size="2" color="#FFFF66">2:00pm - 5:30pm</font></p><p align="justify"><font face="Tahoma" size="2" color="#FFFF66">Refreshments are available during these opening hours. For more information, call the Estate office on</p><p align="center"><font face="Tahoma" size="2" color="#FFFF66">+44 (0)118 972 3350</font></p>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, '', '', '', '<p align="justify"><font size="2" face="Tahoma" color="#800000"><b>Mapledurham
              is a village with a special charm of it’s own, set in the valley
              of the River Thames, below the Goring Gap. It’s cottages, church,
              almshouses and Watermill, with the old brick and flint walls,
              backed by the Elizabethan mansion and the still older manor house
              of Mapledurham Gurney, together retain an ancient village pattern
              which is rare today. Many of the holiday cottages have historic
              interest and are listed buildings.</b></font></p>
              <p align="justify"><font size="2" face="Tahoma">The mansion, 
              Watermill and riverside park are open at weekends and Bank 
              Holidays from Easter Saturday until the end of September. The
              Watermill produces flour for sale, with wheat still ground by the
              traditional millstones.</font></p>
              <p align="justify"><font size="2" face="Tahoma">As well as the
              pleasure of the immediate surroundings, the locality offers ready
              access to places of historic interest and importance. Henley,
              Oxford, Windsor, Eton, Hampton Court, Blenheim Palace and
              Winchester are within easy reach.</font></p>
              <p align="justify"><font size="2" face="Tahoma">There is no public
              transport to Mapledurham village itself so a car is essential.
              Reading railway station is about five miles away and provides
              services to most areas. London is only a half hour journey by rail
              and an easy drive via the M4 motorway. Heathrow and Gatwick
              airports have good road and coach links with Reading.</font></p>
              <p align="justify"><font face="Tahoma" size="2">There is a small
              village shop nearby at Woodcote way that stocks basic provisions.
              Caversham and Reading are close by offering excellent facilities.
              If you are arriving from overseas we would be happy to purchase
              some groceries on your behalf.</font></p>
              <p align="justify"><font face="Tahoma" size="2">Temporary
              membership of <a href="http://www.cavershamgolf.co.uk"><font color="#000000">Caversham
              Heath Golf Club</font></a> in Mapledurham is available free of charge to
              clients renting one of our holiday cottages. This must be
              requested in writing at least four weeks in advance of arriving or
              at the time of booking. The course is an 18 hole with excellent
              club facilities.</font></p>
              <p align="justify"><font face="Tahoma" size="2">Coarse fishing
              permits are available from the Estate Office, for the River Thames
              bordering the Estate.</font>
              <p align="justify"><font face="Tahoma" size="2"><b>Click on the
              links for more information on attending a <a href="#"><font color="#000000">public
              event</font></a> or organising a <a href="#"><font color="#000000">private
              event</font></a> at Mapledurham.</b></font>', '', 'Y', now(), 'root', null);

#page 3
INSERT INTO `element` VALUES (6, 0, 0, '', '', 'headpic', '<p align="center"><b><u><font face="Tahoma" size="3" color="#FFFF66">The Cottages</font></u></b></p>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, 'thatch.jpg', '', 'headpic', '#cottages#', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, 'newfarm.jpg', '', 'headpic', '<p align="center"><b><font color="#FF0000" face="Verdana" size="2">Christmas and New Year<br> prices available on request</font></b></p>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, '', '', '', '<p align="justify"><font face="Tahoma" size="2" color="#800000"><b>All the self catering cottages at Mapledurham are farm cottages which have been refurbished, whilst maintaining the individual character of each property. Some cottages are situated within the village of Mapledurham itself, and the others are located on the surrounding farms.</b></font></p>
              <p align="justify"><font face="Tahoma" size="2">The cottages are comfortably furnished to Southern Tourist Board standards. Each has an electric cooker, microwave, refrigerator, colour television, immersion heater and free standing electric fires. Sufficient cutlery, china, cooking and cleaning equipment is supplied. 
              All of the cottages are equipped with duvets and bed linen. 
              Towels can be hired for all 
              cottages if necessary. It is possible for us to provide further 
              clean bedding as required at an additional charge. High chairs, 
              cots and Z-beds can also be hired, subject to availability. Several of our 
              cottages have payphones installed. Please note that the Estate 
              cannot deliver messages except in an emergency.</font></p>
              <p align="justify"><font face="Tahoma" size="2">All heating &amp; electricity 
              is included in the price. In the following cottages, the drinking water is 
              drawn from the Estate’s own supply: The Bothy, Pear Tree Cottage,   
              Honeysuckle Cottage, Step, Willow, No 1 Almshouse, No 2 Almshouse, The Gardens, Bottom Farm Cottage. 
              It is of exceptional quality.</font></p>
              <p align="justify"><font face="Tahoma" size="2">Occupiers are asked to treat the furnishings and equipment with due consideration, and to report any damage or breakages, which are chargeable. We also request that you clean the cottage and leave it as you would wish to find it.</font></p>
              <p align="justify"><font face="Tahoma" size="2"><b>Click on the links in the list on the left to view the specific cottage properties or you can book a holiday in
              one of the cottages through the </b></font><b><a href="p6.php"><font face="Tahoma" size="2" color="#000000">reservations page</font></a><font face="Tahoma" size="2" color="#000000">. See our booking </font><a href="#"><font face="Tahoma" size="2" color="#000000">terms
              &amp; conditions</font></a><font face="Tahoma" size="2" color="#000000">.</font></b></p>
              <p align="justify"><b><font face="Tahoma" size="2">All invoices 
              relating to your stay must be paid in advance, and we are able to 
              accept most major credit cards</font><font face="Tahoma" size="2" color="#000000">.</font></b></p>', '', 'Y', now(), 'root', null);

#page 4
INSERT INTO `element` VALUES (6, 0, 0, '', '', 'headpic', '<p align="center"><b><u><font face="Tahoma" size="3" color="#FFFF66">The History</font></u></b></p>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, 'inside.jpg', '', 'headpic', '<p align="justify"><font face="Tahoma" size="2" color="#FFFF66" bgColor="#003300">Mapledurham has been open to visitors now for over twenty years and during this time some hundreds of thousands of people have enjoyed visiting my home. I am grateful to you all, both for the kind letters of encouragement I have received and for the essential support without which it would be impossible to keep going.</font></p><p align="justify"><font face="Tahoma" size="2" color="#FFFF66" bgColor="#003300">This is a wealth of history at Mapledurham in its conservation area and its listed buildings representing a very fine example of the vernacular. The demands and pressure of modern life and economics do not help the task of looking after such a special place, and so it is hoped to effect a plan for survival in the future. Such a plan needs to combine the requirements of farming and forestry with the opportunity of leisure.</font></p><p align="justify"><font face="Tahoma" size="2" color="#FFFF66" bgColor="#003300">Your visit will help us towards this goal. I hope you have enjoyed it and I should like to thank all those who help me to make it possible.</font></p><p align="right"><font face="Tahoma" size="2" color="#FFFF66" bgColor="#003300">- John Eyston</font>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, 'sheep.jpg', '', 'headpic', '<p align="center"><font face="Tahoma" size="2" color="#FFFF66" bgColor="#003300"><b><u>The wolf in sheep’s clothing</u></b></font></p><p align="justify"><font face="Tahoma" size="2" color="#FFFF66" bgColor="#003300">Several of these unusual 17th and 18th century English carved wooden heads seem to have symbolic significance. This one clearly illustrates Aesop’s fable: &quot;There goes a story of a Wolfe, that Wrapt himself up in a Sheeps-skin, and Worry’d Lambs for a Good while under That Disguise; but the Shepard Met with him at last, and Truss’d him up, Sheeps-skin and all, upon an Eminent Gibbet, for a Spectacle, and an Example&quot; (L’Estrange’s translation, 1694). The bull symbolises strength, the goat avarice, and the boar gluttony.</font></p>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, '', '', '', '<p align="justify"><font face="Tahoma" size="2" color="#800000"><b>Below is a summary of the history of Mapledurham from Doomsday England to today. This information is taken from the Mapledurham guide which may be purchased from the shop.</b></font></p>
<p align="justify"><font face="Tahoma" size="2">Mapledurham "the maple tree enclosure" appears in Doomsday as two manors, Mapledurham Gurney belonging to William de Warenne, while Milo Crispin, Lord of the honour of Wallingford, owned the smaller Mapledurham Chazey.</font></p>
<p align="justify"><font face="Tahoma" size="2">The larger manor takes its name from Gerard de Gournay, to whom it passed as a marriage portion. It passed again by marriage in about 1270 to the Bardolfs, who were here for about 120 years, until the death in 1395 of Sir Robert Bardolf, esquire of the body to Edward III and Richard II and builder of the aisle, which bears his name. The manor passed in 1416 to his widows nephew, William Lynde, whose grandson sold it in 1490 to Richard Blount of Iver; it has belonged to his descendants ever since.</font></p>
<p align="justify"><font face="Tahoma" size="2">The Blounts claim descent from a Norman family, Le Blond, who came over with William the Conqueror. Richard Blounts great-grandfather, Sir Walter who married Sanchia de Ayala, a Spanish noblewoman, was Henry IV’s standard bearer at the Battle of Shrewsbury (1403); Shakespeare portrays his violent death in Henry IV, part 1. His son, Sir Thomas (d.1456), was Treasurer of Normandy in the early years of Henry V’s reign; from his eldest son Sir Walter, 1st Lord Mountjoy (d.1474), sprang the line which ended so illustriously with the Earl of Devonshire (1563-1606). Richard Blount, purchaser of Mapledurham, was the son of Sir Thomas’ second son.</font></p>
<p align="justify"><font face="Tahoma" size="2">His son Sir Richard (d.1564) who married Elizabeth Lister, daughter of the Lord Chief Justice, succeeded him; in 1558 he was appointed Lieutenant of the Tower of London, a post also held by his son Sir Michael (d.1610). Father and son lie beneath a splendid tomb in the Chapel Royal in the Tower.</font></p>
<p align="justify"><font face="Tahoma" size="2">In 1588 Sir Michael raised a loan of £1,500 for the purpose, it is believed, of building the present House, an altogether grander one which better expressed his status as a high official of Elizabeth I. It was completed by his son Sir Richard in 1612; he also increased his estate by buying, in 1582, the smaller Chazey manor from Anthony Brydges. He tried unsuccessfully to claim the extinct barony of Mountjoy on the death of the Earl of Devonshire. The House of Lords rejecting the claim for lack of evidence. Sir Richard died in 1628 and lies in the church in a tomb surmounted by effigies of himself and his first wife, Cecily Baker.&nbsp;</font></p>
<p align="justify"><font face="Tahoma" size="2">His son Sir Charles (c.1598-1655) succeeded him. Like many Royalist gentry he was extravagant; in 1635 he had to sell off his household goods to pay his debts. There can have been little left when in 1643 the Roundheads besieged and sacked the house, a year before Sir Charles death at the siege at Oxford.</font></p>
<p align="justify"><font face="Tahoma" size="2">The estate was sequestered by Parliament. The heir, Michael, was murdered in 1649, aged 19, at Charing Cross by a footman; his younger brother Walter (d.1671) obtained the return of his estates about 1651. Although married twice, he had no heir and left Mapledurham to his cousin Lyster (1654-1710). Lyster married Martha Englefield, from Whitenights, Reading; it was to court their two daughters that, from 1707-1715, Alexander Pope became a frequent visitor. In 1715 their brother Michael (1693-1739) married Mary Agnes Tichbourne, and the sisters went to live in London. Pope quarreled with Theresa in 1716 for reasons unknown, but his friendship with Martha had lasted until his death in 1744, when he left her a substantial part of his property, some of which is still here. Both sisters died unmarried, Theresa in 1759, Martha in 1763.</font></p>
<p align="justify"><font face="Tahoma" size="2">Their brother inherited in 1710 a much impoverished estate. Like other Catholic landowners, the family had been forced to pay the penal Double Land Tax (not abolished until 1821). In the year of his death, he surveyed his finances; during his 29 years of ownership he had overspent his income by £2,500 - it would have been more, he wrote, "but that my dear wife was so prudent not to accept of diamond ear-rings".</font></p>
<p align="justify"><font face="Tahoma" size="2">His son Michael (1719-1792) also faced financial problems; like his father, he spent long periods living away, only returning when he could no longer find a tenant. Family tradition records that about 1740 he was forced to sell the family’s fine collection of armour. The first in the family to marry into the professional classes, he married Mary Eugenia, daughter of the solicitor Michael Strickland, and apparently practised too as a lawyer.</font></p>
<p align="justify"><font face="Tahoma" size="2">His son and successor, also Michael (1743-1821) married twice; firstly, the Irish heiress Eleanora Fitzgerald, a lady of "uncommon virtues;" and then Catherine Petre. He built the chapel, but the present appearance of the House is due to his son, Michael Henry (1789-1874). He employed Thomas Martin to make alterations in 1828 and carried out further work in 1863. He married firstly Eliza Petre (1798-1848) and secondly Lucy Catherine Wheble (1809-1908). There were five sons and nine daughters from the two marriages. The two eldest sons set up as solicitors in Richmond, Yorks. Each in turn inherited the estate, dying within a few months of each other in 1881.</font></p>
<p align="justify"><font face="Tahoma" size="2">The estate passed to their brother, John Darell-Blount (1833-1908), and then to Edward Riddell, the grandson of his youngest sister who added the name of Blount to his own. On his death in 1943 the estate passed back to the family of John Darrell-Blounts eldest married sister, Agnes Mary, wife of Charles John Eyston of East Hendred. Her grandson Thomas was killed in action in 1940 and the estate passed to his son John Joseph Eyston, the present owner. Since 1960 he has restored the House, and once again it is a family home, where he lives with his wife, Lady Anne, daughter of the late Viscount Maitland, and their three children Edward, Katherine and Mary.</font></p>', '', 'Y', now(), 'root', null);

#page 6
INSERT INTO `element` VALUES (6, 0, 0, '', '', 'headpic', '<p align="center"><b><u><font face="Tahoma" size="3" color="#FFFF66">Reservations</font></u></b></p>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, 'newfarm.jpg', '', 'headpic', '<div align="center">
          <center>
          <table border="0" width="90%" cellspacing="0" cellpadding="0">
            <tr>
              <td width="100%">
                <p align="justify"><font face="Tahoma" size="2" color="#FFFF66">All bookings run from Friday to Friday. Cottage keys are available between 3 and 5pm on the day of entry, from the Estate Office in Mapledurham house. Occupants arriving after 5pm must notify the Estate Office beforehand, when other arrangements will be made for the collection of the keys, The property must be vacated by 10am on the day of departure to allow our staff sufficient time to service it.</font></p>
                <p align="justify"><font face="Tahoma" size="2" color="#FFFF66">Dogs are allowed in certain cottages, for a small charge. We regret cats are not allowed.</font></p>
                <p align="justify"><font face="Tahoma" size="2" color="#FFFF66">Most insurance companies can arrange cancellation cover for holidays (see
                section 4c).</font></p>
                <p align="justify"><font face="Tahoma" size="2" color="#FFFF66">Please note we can only accept payments from outside the UK if made in Sterling either by Eurocheque, using cheques of less than £200 or by credit cards.</font></td>
            </tr>
          </table>
          </center>
        </div>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, '', '', '', '<table border="0" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">1.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">Reservations will
                    only be accepted on receipt of a completed and signed
                    booking form together with payment of the deposit required.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">2.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">The deposit paid
                    is accepted as part-payment for the booking. The date by
                    which the balance must be received will be indicated on the
                    confirmation form sent on receipt of the booking. No
                    reminder will be sent.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">3.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">If the balance of
                    the cost is not received by the due date the Mapledurham
                    Trust shall be entitled to cancel the booking without notice
                    to the client, and without incurring any liability to the
                    client in respect of any loss or damage following such
                    cancellation. The deposit paid will not be refundable.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">4.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">Cancellation: Any
                    cancellation made by the client (for whatever reason) shall
                    be made in writing addressed to Mapledurham Trust. On
                    receipt of such a notice of cancellation, Mapledurham Trust
                    shall endeavour to re-let the cottage for the entire period
                    of the original booking.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="center"><font face="Tahoma" size="1">a)</font></p>
                  </td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">If Mapledurham
                    Trust shall be successful in re-letting the cottage for the
                    entire period originally booked, it shall refund all monies
                    paid (whether by way of deposit or otherwise) less a
                    handling charge of £10 plus VAT per week booked.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="center"><font face="Tahoma" size="1">b)</font></p>
                  </td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">If Mapledurham
                    Trust shall only succeed in re-letting the cottage for a
                    proportion of the period originally booked, it shall refund
                    that proportion of monies paid (whether by way of deposit or
                    otherwise) that the period re-let bears to the period
                    originally booked less a handling charge of £10 plus VAT
                    per week booked.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="center"><font face="Tahoma" size="1">c)</font></p>
                  </td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">If Mapledurham
                    Trust shall be unable to re-let the cottage at all then all
                    monies paid by the client (whether by way of deposit or
                    otherwise) shall be forfeit to the Mapledurham Trust. We
                    therefore recommend cancellation insurance.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">5.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">The Mapledurham
                    Trust reserve the right to refuse bookings without
                    explanation. Provisional telephone booking without receipt
                    of a deposit will not be taken. In the event of Mapledurham
                    Trust being unable to reserve any of the accommodation
                    requested we shall endeavour to provide you with an
                    alternative. If this is not satisfactory any deposit paid
                    will be refunded in full.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">6.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">While all
                    bookings are accepted in good faith, in the event of it
                    becoming necessary for the Mapledurham Trust to alter or
                    cancel a booking the liability of Mapledurham Trust shall be
                    limited either to the offer of alternative accommodation of
                    similar value if available, or the return of the all monies
                    paid.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">7.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">For bookings of
                    up to four weeks duration, the full cost is due four weeks
                    prior to commencement.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">8.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">For bookings
                    exceeding four weeks duration, the cost of the initial four
                    weeks is due four weeks prior to commencement, and
                    thereafter the cost of bookings in any one calendar month is
                    due on the first day of the previous month.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">9.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">In no
                    circumstances can the period booked be exceeded. The letting
                    is a holiday letting and pursuant to paragraph 9 of Schedule
                    1 of the Housing Act 1988. It is not and will not become an
                    Assured Tenancy. Possession will be requested at the end of
                    the term.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">10.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">In no
                    circumstances can the total number of persons staying the a
                    property exceed the numbers stated in the relevant
                    literature.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">11.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">The Mapledurham
                    Trust reserve the right to charge a deposit and initially
                    charge any damage or extra cleaning against the deposit.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">12.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">All cottages must
                    be vacated by 10am on the day of departure. All keys must be
                    returned to the Estate Office and any outstanding accounts
                    must be settled prior to departure. Failure to comply will
                    result in extra administration charges being raised.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">13.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">The use of all
                    equipment and amenities is entirely at the clients risk, as
                    the client hereby acknowledges and no responsibility can be
                    accepted for personal injury to or damage to belongings of
                    the client or any other person visiting.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">14.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">The Mapledurham
                    Trust reserve the right of entry for their agents and
                    employees to any property at any reasonable time, for the
                    purpose of inspecting or the carrying out of repairs.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">15.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">The Mapledurham
                    Trust reserve the right to alter terms and conditions as
                    necessary.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">16.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">The Mapledurham
                    Trust reserve the right to pass on any increase in the rate
                    of VAT.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">17.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">Clients are
                    expected to leave the cottage and gardens in the condition
                    they found them.</font></p></td>
                </tr>
                <tr>
                  <td width="6%" valign="top">
                    <p align="left"><font face="Tahoma" size="1">18.</font></td>
                  <td width="94%">
                    <p align="justify"><font face="Tahoma" size="1">Staff
                    of Mapledurham Trust have no authority to alter the
                    conditions printed above.</font></p></td>
                </tr>
              </table>', '', 'Y', now(), 'root', null);

#page 7, Availability
INSERT INTO `element` VALUES (6, 0, 0, '', '', 'headpic', '<p align="center"><b><u><font face="Tahoma" size="3" color="#FFFF66">Availability</font></u></b></p>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, 'yew.jpg', '', 'headpic', '<div align="right">
        </div>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 0, '', '', '', '<p align="justify"><font face="Tahoma" size="2" color="#800000"><b>The
              following information is maintained real-time when bookings are taken.</b></font></p>', '', 'Y', now(), 'root', null);

#page 9, 10 - Yew Tree Cottage
INSERT INTO `element` VALUES (6, 0, 1, '', '', 'headpic', '<p align="center"><b><u><font face="Tahoma" size="3" color="#FFFF66">Yew Tree Cottage</font></u></b></p>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 1, 'yew.jpg', '', 'headpic', '<div align="right">
          <table border="0" width="95%" cellspacing="1" cellpadding="0">
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Sleeps:</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">2</font></td>
            </tr>
            <tr>
              <td width="100%" colspan="2"><font face="Tahoma" size="1">&nbsp;&nbsp;&nbsp;</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">
              Duvets &amp; bed linen</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Thoroughly
                cleaned before letting</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">All
                furnishings in good condition</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Gardens
                maintained in good order</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Reasonable
                space for movement</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Adequate
                table and seating</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">
              Colour TV available</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Adequate
                heating and lighting</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Full
                range of crockery &amp; cutlery</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Cooker
                including oven and grill</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Local
                tourist information</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Easy
                chairs and sofas for all</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Bedside
                units or shelves</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Bedside
                lights</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Heating
                in all rooms</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Fridge
                (with icemaker) and kettle</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Linen
                and towels available</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Iron
                and ironing board</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Dressing
                table &amp; wardrobe in bedrooms</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">All
                sleep in beds or bunks (no settees)</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Supplementary
                lighting in living room</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Garden
                furniture available</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Washing
                machine or laundry service</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">All
                rooms with auto-controlled heaters</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Bath</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Second
                bathroom WC</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Telephone</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Hairdryer</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Food
                processor</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Microwave</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Dishwasher</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Fridge
                freezer</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="100%" colspan="2"><font face="Tahoma" size="1" color="#FFFF66">&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
            </tr>
            <tr>
              <td width="100%" colspan="2"><font face="Tahoma" size="1" color="#FFFF66">English
                Tourist Board Classified: 3 Star</font></td>
            </tr>
          </table>
        </div>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 1, '', '', '', '<p align="justify"><font face="Tahoma" size="2" color="#800000"><b>The
              Yew Tree Cottage is a delightful grade II listed thatched cottage
              that has been recently modernised.</b></font></p>
              <p align="justify"><font face="Tahoma" size="2" color="#000000">Downstairs comprises a small entrance porch, living room, small kitchen 
              (equipped with automatic washing machine, cooker microwave and fridge 
              with freezer compartment), bathroom and toilet. Upstairs there is a twin bedroom. 
              There are electric convector heaters throughout. Bed linen is included 
              in this cottage.</font></p>
              <p align="justify"><font face="Tahoma" size="2" color="#000000">The cottage is set in large gardens with 
              parking spaces for two cars. It is adjacent to the A4074 and is on 
              the bus route to Reading and Caversham.</font></p>
              <p align="justify"><font face="Tahoma" size="2" color="#000000"><b>Pricing
              Information:</b></font></p>

              <div align="right">

          <table border="0" width="90%" cellspacing="0" cellpadding="0">
            <tr>
              <td width="55%"><font face="Tahoma" size="2" color="#000000">From
                19/11/2004:</font></td>
              <td width="45%"><font face="Tahoma" size="2" color="#000000">£315
                per week</font></td>
            </tr>
            <tr>
              <td width="55%"><font face="Tahoma" size="2" color="#000000">From
                25/03/2005:</font></td>
              <td width="45%"><font face="Tahoma" size="2" color="#000000">£325
                per week</font></td>
            </tr>
            <tr>
              <td width="55%"><font face="Tahoma" size="2" color="#000000">From
                29/04/2005:</font></td>
              <td width="45%"><font face="Tahoma" size="2" color="#000000">£330
                per week</font></td>
            </tr>
            <tr>
              <td width="55%"><font face="Tahoma" size="2" color="#000000">From
                27/05/2005:</font></td>
              <td width="45%"><font face="Tahoma" size="2" color="#000000">£345
                per week</font></td>
            </tr>
            <tr>
              <td width="55%"><font face="Tahoma" size="2" color="#000000">From
                24/06/2005:</font></td>
              <td width="45%"><font face="Tahoma" size="2" color="#000000">£365
                per week</font></td>
            </tr>
            <tr>
              <td width="55%"><font face="Tahoma" size="2" color="#000000">From
                02/09/2005:</font></td>
              <td width="45%"><font face="Tahoma" size="2" color="#000000">£345
                per week</font></td>
            </tr>
          </table>


              </div>


              <p align="justify"><font face="Tahoma" size="2"><b>Additional Charges:</b></font></p>
              <ul>
                <li>
                <p align="justify"><font face="Tahoma" size="2">Z- beds can be 
                supplied in some cottages for an extra visitor subject to 
                availability at £15.00 per week.</font></li>
                <li>
                <p align="justify"><font face="Tahoma" size="2">Cots and high 
                chairs are provided subject to availability at £5.00 per week.</font></li>
                <li>
                <p align="justify"><font face="Tahoma" size="2">Towels may be 
                hired at a cost of £3.00 per person.</font></li>
                <li>
                <p align="justify"><font face="Tahoma" size="2">Dogs are allowed 
                in some cottages for a £10.00 per week surcharge.</font></li>
                <li>
                <p align="justify"><font face="Tahoma" size="2">A booking 
                deposit is required of £75.00 per week booked.</font></li>
                <li>
                <p align="justify"><font face="Tahoma" size="2">The above prices 
                are subject to there being no significant increases in council 
                tax, electricity, heating oil or other similar charges.</font></li>
              </ul>
              <p align="justify"><b><a href="p7.php"><font face="Tahoma" size="2" color="#000000">Click here to view availability for this cottage</font></a><font face="Tahoma" size="2" color="#000000"> or you can book a holiday in this cottage through the </font><a href="p6.php"><font face="Tahoma" size="2" color="#000000">reservations page</font></a><font face="Tahoma" size="2" color="#000000">.</font></b></p>', '', 'Y', now(), 'root', null);

#page 11, 12 Thatch Cottage
INSERT INTO `element` VALUES (6, 0, 2, '', '', 'headpic', '<p align="center"><b><u><font face="Tahoma" size="3" color="#FFFF66">Thatch Cottage</font></u></b></p>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 2, 'thatch.jpg', '', 'headpic', '<div align="right">
          <table border="0" width="95%" cellspacing="1" cellpadding="0">
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Sleeps:</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">2</font></td>
            </tr>
            <tr>
              <td width="100%" colspan="2"><font face="Tahoma" size="1">&nbsp;&nbsp;&nbsp;</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">
              Duvets &amp; bed linen</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Thoroughly
                cleaned before letting</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">All
                furnishings in good condition</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Gardens
                maintained in good order</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Reasonable
                space for movement</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Adequate
                table and seating</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Colour
                TV available</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Adequate
                heating and lighting</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Full
                range of crockery &amp; cutlery</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Cooker
                including oven and grill</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Local
                tourist information</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Easy
                chairs and sofas for all</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Bedside
                units or shelves</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Bedside
                lights</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Heating
                in all rooms</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Fridge
                (with icemaker) and kettle</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Linen
                and towels available</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Iron
                and ironing board</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Dressing
                table &amp; wardrobe in bedrooms</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">All
                sleep in beds or bunks (no settees)</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Supplementary
                lighting in living room</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Garden
                furniture available</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Washing
                machine or laundry service</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">All
                rooms with auto-controlled heaters</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Shower</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Second
                bathroom WC</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Telephone</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Hairdryer</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Food
                processor</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Microwave</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">Yes</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Dishwasher</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="87%"><font face="Tahoma" size="1" color="#FFFF66">Fridge
                freezer</font></td>
              <td width="13%"><font face="Tahoma" size="1" color="#FFFF66">No</font></td>
            </tr>
            <tr>
              <td width="100%" colspan="2"><font face="Tahoma" size="1" color="#FFFF66">&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
            </tr>
            <tr>
              <td width="100%" colspan="2"><font face="Tahoma" size="1" color="#FFFF66">English
                Tourist Board Classified: 3 Star</font></td>
            </tr>
          </table>
        </div>', '', 'Y', now(), 'root', null);
INSERT INTO `element` VALUES (6, 0, 2, '', '', '', '<p align="justify"><b><font face="Tahoma" size="2" color="#800000">Thatch
              Cottage is an 18th Century woodmans cottage, listed grade II with an attractive thatched
              roof. The cottage has been completely restored and modernised.</font></b></p>
              <p align="justify"><font face="Tahoma" size="2" color="#000000">The accommodation is compact and all on one floor, and consists of a large living room with dining area, kitchen 
              (equipped with microwave, fridge with freezer compartment), shower room with toilet, and a double bedroom with wash basin. Bed linen and duvets included. There is a large garden and orchard surrounding the cottage with ample parking space. The cottage is convenient for the local bus route.&nbsp;A 
              payphone is also included.</font></p>
              <p align="justify"><font face="Tahoma" size="2" color="#000000"><b>Pricing
              Information:</b></font></p>

              <div align="right">


          <table border="0" width="90%" cellspacing="0" cellpadding="0">
            <tr>
              <td width="55%"><font face="Tahoma" size="2" color="#000000">From 
              19/11/2004:</font></td>
              <td width="45%"><font face="Tahoma" size="2" color="#000000">£290 
              per week</font></td>
            </tr>
            <tr>
              <td width="55%"><font face="Tahoma" size="2" color="#000000">From 
              25/03/2005:</font></td>
              <td width="45%"><font face="Tahoma" size="2" color="#000000">£295 
              per week</font></td>
            </tr>
            <tr>
              <td width="55%"><font face="Tahoma" size="2" color="#000000">From 
              29/04/2005:</font></td>
              <td width="45%"><font face="Tahoma" size="2" color="#000000">£300 
              per week</font></td>
            </tr>
            <tr>
              <td width="55%"><font face="Tahoma" size="2" color="#000000">From 
              27/05/2005:</font></td>
              <td width="45%"><font face="Tahoma" size="2" color="#000000">£315 
              per week</font></td>
            </tr>
            <tr>
              <td width="55%"><font face="Tahoma" size="2" color="#000000">From 
              24/06/2005:</font></td>
              <td width="45%"><font face="Tahoma" size="2" color="#000000">£335 
              per week</font></td>
            </tr>
            <tr>
              <td width="55%"><font face="Tahoma" size="2" color="#000000">From 
              02/09/2005:</font></td>
              <td width="45%"><font face="Tahoma" size="2" color="#000000">£315 
              per week</font></td>
            </tr>
          </table>
          

              </div>


              <p align="justify"><font face="Tahoma" size="2"><b>Additional Charges:</b></font></p>
              <ul>
                <li>
                <p align="justify"><font face="Tahoma" size="2">Z- beds can be 
                supplied in some cottages for an extra visitor subject to 
                availability at £15.00 per week.</font></li>
                <li>
                <p align="justify"><font face="Tahoma" size="2">Cots and high 
                chairs are provided subject to availability at £5.00 per week.</font></li>
                <li>
                <p align="justify"><font face="Tahoma" size="2">Towels may be 
                hired at a cost of £3.00 per person.</font></li>
                <li>
                <p align="justify"><font face="Tahoma" size="2">Dogs are allowed 
                in some cottages for a £10.00 per week surcharge.</font></li>
                <li>
                <p align="justify"><font face="Tahoma" size="2">A booking 
                deposit is required of £75.00 per week booked.</font></li>
                <li>
                <p align="justify"><font face="Tahoma" size="2">The above prices 
                are subject to there being no significant increases in council 
                tax, electricity, heating oil or other similar charges.</font></li>
              </ul>
              <p align="justify"><b><a href="p7.php"><font face="Tahoma" size="2" color="#000000">Click here to view availability for this cottage</font></a><font face="Tahoma" size="2" color="#000000"> or you can book a holiday in this cottage through the </font><a href="p6.php"><font face="Tahoma" size="2" color="#000000">reservations page</font></a><font face="Tahoma" size="2" color="#000000">.</font></b></p>', '', 'Y', now(), 'root', null);

DELETE FROM `page_element` where company_id = 6;

#  `company_id` mediumint(5) ZEROFILL NOT NULL,
#  `page_id` mediumint(9) NOT NULL,
#  `sequence` mediumint(9) NOT NULL,
#  `element_id` mediumint(9) NOT NULL,
#  `active_flag` char(1) NOT NULL default 'Y',
#  `created_date` date NOT NULL default '0000-00-00',
#  `last_modified_by` varchar(20) NOT NULL default '',
#  `last_modified_on` timestamp,
#  PRIMARY KEY  (`company_id`, `page_id`, `sequence`)

INSERT INTO `page_element` VALUES (6, 1, 1, 1, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 1, 2, 2, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 1, 3, 3, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 1, 4, 4, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 1, 5, 5, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 1, 6, 6, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 1, 7, 7, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 1, 8, 8, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 1, 9, 9, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 1, 10, 10, 'Y', now(), 'root', null);

INSERT INTO `page_element` VALUES (6, 2, 1, 11, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 2, 2, 12, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 2, 3, 13, 'Y', now(), 'root', null);

INSERT INTO `page_element` VALUES (6, 3, 1, 14, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 3, 2, 15, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 3, 3, 16, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 3, 4, 17, 'Y', now(), 'root', null);

INSERT INTO `page_element` VALUES (6, 4, 1, 18, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 4, 2, 19, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 4, 3, 20, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 4, 4, 21, 'Y', now(), 'root', null);

INSERT INTO `page_element` VALUES (6, 6, 1, 22, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 6, 2, 23, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 6, 3, 24, 'Y', now(), 'root', null);

INSERT INTO `page_element` VALUES (6, 7, 1, 25, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 7, 2, 26, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 7, 3, 27, 'Y', now(), 'root', null);

INSERT INTO `page_element` VALUES (6, 9, 1, 28, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 9, 2, 29, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 9, 3, 30, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 10, 1, 28, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 10, 2, 29, 'Y', now(), 'root', null);

INSERT INTO `page_element` VALUES (6, 11, 1, 31, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 11, 2, 32, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 11, 3, 33, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 12, 1, 31, 'Y', now(), 'root', null);
INSERT INTO `page_element` VALUES (6, 12, 2, 32, 'Y', now(), 'root', null);

DELETE FROM `property` where company_id = 6;

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

INSERT INTO `property` VALUES (6, 0, 'Yew Tree Cottage', '2', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (6, 0, 'Thatch Cottage', '2', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (6, 0, 'Pear Tree Cottage', '3', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (6, 0, 'Honeysuckle Cottage', '3', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (6, 0, 'The Bothy', '4', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (6, 0, 'Willow Cottage', '5', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (6, 0, 'Step Cottage', '5', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (6, 0, 'Bottom Farm Cottage', '5', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (6, 0, 'The Gardens', '6', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (6, 0, 'The Almshouses (#1)', '6', 'S', 'Y', now(), 'root', null);
INSERT INTO `property` VALUES (6, 0, 'The Almshouses (#2)', '6', 'S', 'Y', now(), 'root', null);

