-- phpMyAdmin SQL Dump
-- version 2.7.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Apr 21, 2007 at 04:37 PM
-- Server version: 5.0.18
-- PHP Version: 5.1.2
-- 
-- Database: `esedata`
-- 

-- 
-- Dumping data for table `descriptor`
-- 

INSERT INTO `descriptor` VALUES (00000, 'active_flag', 'Active', 'Status of this record', 'Sorry - No help available', 'C', 'C', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'activity_id', 'Activity Id', 'Unique Activity Id', 'Sorry - No help available', 'L', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'activity_log', 'Activity Log', 'Activity Log Table', 'Sorry - No help available', 'L', '0', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'arrival_date', 'Arrival', 'Arrival Date', 'Sorry - No help available', 'L', 'D', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'availability_flag', 'Show Availability', 'Switch Availability on or off', 'Sorry - No help available', 'C', 'C', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'balance_amount', 'Balance', 'Balance Amount', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'booking', 'Booking', 'Booking Table', 'Sorry - No help available', 'L', '0', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'booking_flag', 'Take Bookings', 'Switch online bookings on or off', 'Sorry - No help available', 'C', 'C', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'booking_notes', 'Notes', 'Comments and Notes', 'Sorry - No help available', 'L', 'A', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'booking_pattern', 'Booking Pattern', 'Booking Pattern for this Property', 'Sorry - No help available', 'R', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'booking_reference', 'Ref', 'Unique Booking Reference', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'booking_status', 'Status', 'Status of this booking', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'booking_user', 'User', 'Booking User', 'Sorry - No help available', 'C', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'charge_amount', 'Amount', 'Charge Amount', 'Sorry - No help available', 'L', 'T', '2006-02-12', 'root', '2006-02-12 21:35:08');
INSERT INTO `descriptor` VALUES (00000, 'charge_code', 'Charge Code', 'Charge Code', 'Sorry - No help available', 'R', 'I', '2006-02-12', 'root', '2006-02-12 21:35:08');
INSERT INTO `descriptor` VALUES (00000, 'charge_description', 'Description', 'Charge Description', 'Sorry - No help available', 'L', 'T', '2006-02-12', 'root', '2006-02-12 21:35:08');
INSERT INTO `descriptor` VALUES (00000, 'charge_from', 'From', 'Charge From', 'Sorry - No help available', 'L', 'D', '2006-02-12', 'root', '2006-02-12 21:35:08');
INSERT INTO `descriptor` VALUES (00000, 'charge_name', 'Charge Name', 'Charge Name', 'Sorry - No help available', 'L', 'T', '2006-02-12', 'root', '2006-02-12 21:35:08');
INSERT INTO `descriptor` VALUES (00000, 'charge_parameter', 'Parameter', 'Charge Parameter', 'Sorry - No help available', 'R', 'I', '2006-02-12', 'root', '2006-02-12 22:18:28');
INSERT INTO `descriptor` VALUES (00000, 'charge_type', 'Type', 'Charge Type', 'Sorry - No help available', 'R', 'I', '2006-02-12', 'root', '2006-02-12 21:35:08');
INSERT INTO `descriptor` VALUES (00000, 'commission_amount', 'Commission', 'Commission Amount', 'Sorry - No help available', 'R', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'commission_comment', 'Comments', 'Commission Comments', 'Sorry - No help available', 'L', 'A', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'commission_comment_history', 'History', 'Comment History', 'Sorry - No help available', 'L', 'A', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'commission_status', 'Status', 'Commission Status', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'company', 'Company', 'Company Table', 'Sorry - No help available', 'L', '0', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'company_email', 'Email', 'Contact Email Address', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'company_fax', 'Fax', 'Contact Fax Number', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'company_id', 'Company Id', 'Unique Identifier for Company', 'Sorry - No help available', 'L', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'company_name', 'Name', 'Company Name', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'company_telephone', 'Telephone', 'Contact Telephone Number', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'contact_id', 'Contact', 'Contact Id', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2007-03-11 16:01:02');
INSERT INTO `descriptor` VALUES (00000, 'content_source', 'Content', 'Special Content included in this page', 'Sorry - No help available', 'L', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'created_date', 'Date Created', 'Date this record was created', 'Sorry - No help available', 'L', 'D', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'cumulative', 'Cumulative', 'Multiple rates apply cumulatively', 'Sorry - No help available', 'L', 'C', '2005-07-20', 'root', '2006-07-10 20:09:25');
INSERT INTO `descriptor` VALUES (00000, 'customer_company_id', 'Customer Company', 'Customer Company Id', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2007-03-11 16:22:38');
INSERT INTO `descriptor` VALUES (00000, 'customer_id', 'Customer', 'Customer Id', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'daily_rate', 'Daily Rate', 'Rate per Day', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2006-07-10 20:11:30');
INSERT INTO `descriptor` VALUES (00000, 'departure_date', 'Departure', 'Departure Date', 'Sorry - No help available', 'L', 'D', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'deposit_amount', 'Deposit', 'Deposit Amount', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'deposit_field1', 'Card Number', 'Card Number', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'deposit_field2', 'Validations', 'Validations', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'description', 'Description', 'Description', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'diary', 'Diary', 'Diary Table', 'Sorry - No help available', 'L', '0', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'display_status', 'Display Status', 'Bookable Status', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'element_id', 'Element Id', 'Unique Identifier for Element', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'element_type', 'Element Type', 'Type of element', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'email', 'Email', 'Email Address for User', 'Sorry - No help available', 'L', 'E', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'email_body', 'Body', 'Email Body', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'email_headers', 'Headers', 'Email Headers', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'email_sequence', 'Email Id', 'Email Identifier', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'email_subject', 'Subject', 'Email Subject', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'email_tail', 'Tail', 'Email Tail', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'email_tail_text', 'Tail Text', 'Email Tail Text', 'Sorry - No help available', 'L', 'A', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'email_to', 'To', 'Email To', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'email_top', 'Top', 'Email Top', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'email_top_text', 'Top Text', 'Email Top Text', 'Sorry - No help available', 'L', 'A', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'email_type', 'Type', 'Email Type', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'end_date', 'End', 'End Date', 'Sorry - No help available', 'L', 'D', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'entry_status', 'Status', 'Booking Status', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'expiry', 'Expires', 'Booking Expiry', 'Sorry - No help available', 'L', '4', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'first_name', 'First Name', 'First Name', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'gallery_title', 'Exhibit', 'Gallery Exhibit', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'given_name', 'Name', 'Name of User', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'guest_id', 'Guest', 'Guest Id', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2007-03-11 16:00:33');
INSERT INTO `descriptor` VALUES (00000, 'image_alt', 'Alt', 'Alternate text for image', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'image_name', 'Image', 'Image attached to this element', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'initial_amount', 'Initial Booking Value', 'Initial Amount', 'Sorry - No help available', 'R', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'last_modified_by', 'Mod. User', 'User who last updated this record', 'Sorry - No help available', 'L', 'U', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'last_modified_on', 'Mod. On', 'Date last modified', 'Sorry - No help available', 'L', 'D', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'last_name', 'Last Name', 'Last Name', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'link', 'Link', 'Hypertext Link for text in this element', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'max_nights', 'Max Nights', 'Maximum number of nights at this rate', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2006-07-10 20:13:40');
INSERT INTO `descriptor` VALUES (00000, 'menu_sequence', 'Menu Sequence', 'Sort order for menu', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'number_adults', 'Adults', 'Number of Adults', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'number_children', 'Children', 'Number of Children', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'number_infants', 'Infants', 'Number of Infants', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'number_nights', 'Nights', 'Number of Nights', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'page', 'Page', 'Page Table', 'Sorry - No help available', 'L', '0', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'page_element', 'Element', 'Element Table', 'Sorry - No help available', 'L', '0', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'page_id', 'Page Id', 'Unique Identifier for Page', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'page_name', 'Name', 'Page Name', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'page_title', 'Title', 'Page Title', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'password', 'Password', 'Password for User', 'Sorry - No help available', 'L', 'P', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'payment', 'Payment', 'Payment Table', 'Sorry - No help available', 'L', '0', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'payment_method', 'Card Type', 'Card Type', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'post_address', 'Address', 'Postal Address', 'Sorry - No help available', 'L', 'A', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'post_code', 'Post Code', 'Post Code', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'price', 'Price', 'Price Table', 'Sorry - No help available', 'L', '0', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'price_code', 'Price Code', 'Price indicator code for this property', 'Sorry - No help available', 'R', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'property', 'Property', 'Property Table', 'Sorry - No help available', 'L', '0', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'property_id', 'Property Id', 'Unique Identifier for Property', 'Sorry - No help available', 'C', 'I', '2005-07-20', 'root', '2007-02-22 00:01:08');
INSERT INTO `descriptor` VALUES (00000, 'property_name', 'Property', 'Name of Property', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2006-07-10 16:31:55');
INSERT INTO `descriptor` VALUES (00000, 'property_number', 'Property No.', 'Number of Property', 'Sorry - No help available', 'C', 'T', '2005-07-20', 'root', '2007-02-22 00:01:48');
INSERT INTO `descriptor` VALUES (00000, 'quarter', 'Quarter', 'Quarterly Period', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'resource_id', 'Property Id', 'Unique Id of Property', 'Sorry - No help available', 'L', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'resource_type', 'Type', 'Type of resource', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'section', 'Section', 'Section Table', 'Sorry - No help available', 'L', '0', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'section_id', 'Section Id', 'Unique Identifier for Section', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'sent_flag', 'Sent', 'Sent Flag', 'Sorry - No help available', 'C', 'C', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'sequence', 'Sequence', 'Sort order', 'Sorry - No help available', 'R', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'start_date', 'Start', 'Start Date', 'Sorry - No help available', 'L', 'D', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'tariff', 'Tariff', 'Payment Tariff', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'tariff_field1', 'Discount', 'Discount', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'tariff_field2', 'Neg. Price', 'Negotiated Price', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'telephone', 'Telephone', 'Telephone Number', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'text', 'Text', 'Editorial Content for this page', 'Sorry - No help available', 'L', 'A', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'time_accessed', 'Accessed', 'Time Accessed', 'Sorry - No help available', 'L', 'D', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'title', 'Title', 'Title', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'total_amount', 'Price', 'Total Price', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'user', 'User', 'User Table', 'Sorry - No help available', 'L', '0', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'user_id', 'User Id', 'Unique Identifier for User', 'Sorry - No help available', 'L', 'I', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'user_name', 'User Name', 'Unique Login Name for User', 'Sorry - No help available', 'L', 'T', '2005-07-20', 'root', '2005-07-20 20:35:07');
INSERT INTO `descriptor` VALUES (00000, 'weekly_rate', 'Weekly Rate', 'Rate per Week', 'Sorry - No help available', 'L', 'I', '2005-07-20', 'root', '2006-07-10 20:10:22');
