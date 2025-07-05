-- 1. ALTER geofences table (safe to execute as it's a modification)
ALTER TABLE `geofences` CHANGE `geo_modifieddate` `geo_modifieddate` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

-- 2. Create missing tables with IF NOT EXISTS
CREATE TABLE IF NOT EXISTS `ac_accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `balance` varchar(11) DEFAULT NULL,
  `created_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_date` date DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ac_moneytransfer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transfer_date` date DEFAULT NULL,
  `reference_no` varchar(50) DEFAULT NULL,
  `debit_account_id` int(11) DEFAULT NULL,
  `credit_account_id` int(11) DEFAULT NULL,
  `amount` double(20,4) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_date` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `from_account_id` (`debit_account_id`),
  KEY `to_account_id` (`credit_account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ac_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_date` date DEFAULT NULL,
  `transaction_type` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `cat_id` varchar(100) DEFAULT NULL,
  `note` text CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `reference_number` varchar(100) DEFAULT NULL,
  `v_id` varchar(11) DEFAULT NULL,
  `trip_id` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `created_by` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `created_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `journal_id` (`transaction_type`),
  KEY `account_id` (`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ac_transactions_category` (
  `ie_cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `ie_cat_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ie_cat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `backup_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file_name` varchar(255) NOT NULL,
  `file_size` varchar(50) DEFAULT NULL,
  `backup_date` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `coupons` (
  `cp_id` int(11) NOT NULL AUTO_INCREMENT,
  `cp_code` varchar(50) NOT NULL,
  `cp_discount` decimal(10,2) NOT NULL,
  `cp_start_date` date NOT NULL,
  `cp_end_date` date NOT NULL,
  `cp_usage_limit` varchar(100) NOT NULL,
  `cp_discount_method` varchar(100) NOT NULL,
  `cp_status` varchar(11) DEFAULT '1',
  `cp_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `cp_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`cp_id`),
  UNIQUE KEY `cp_code` (`cp_code`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. Add missing columns with IF NOT EXISTS checks
ALTER TABLE `drivers` ADD COLUMN IF NOT EXISTS `d_email` varchar(100) COLLATE latin1_swedish_ci NULL;

CREATE TABLE IF NOT EXISTS `email_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_id` varchar(11) NOT NULL,
  `module` varchar(100) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `error_description` varchar(255) DEFAULT NULL,
  `to_email` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `email_template` ADD COLUMN IF NOT EXISTS `et_status` int(11) NOT NULL DEFAULT '1';

CREATE TABLE IF NOT EXISTS `frontendwebsite_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `phone` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `facebook_link` varchar(255) DEFAULT NULL,
  `twitter_link` varchar(255) DEFAULT NULL,
  `instagram_link` varchar(255) DEFAULT NULL,
  `linkedin_link` varchar(255) DEFAULT NULL,
  `youtube_link` varchar(255) DEFAULT NULL,
  `text1` text DEFAULT NULL,
  `text2` text DEFAULT NULL,
  `text3` text DEFAULT NULL,
  `scrolling_text` text DEFAULT NULL,
  `our_fleet_heading` varchar(255) DEFAULT NULL,
  `our_fleet_subtext` text DEFAULT NULL,
  `call_to_action_text` varchar(255) DEFAULT NULL,
  `call_to_action_number` varchar(15) DEFAULT NULL,
  `about_us` text DEFAULT NULL,
  `contact_address` text DEFAULT NULL,
  `terms` text DEFAULT NULL,
  `privacy_policy` text DEFAULT NULL,
  `primary_color` varchar(11) DEFAULT NULL,
  `secondary_color` varchar(11) DEFAULT NULL,
  `mainbg_img` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `geofences` ADD COLUMN IF NOT EXISTS `geo_notify_type` varchar(100) COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `geofences` ADD COLUMN IF NOT EXISTS `geo_notify_members` longtext COLLATE utf8mb4_bin NULL;

ALTER TABLE `login` ADD COLUMN IF NOT EXISTS `u_surname` varchar(100) COLLATE latin1_swedish_ci NULL;
ALTER TABLE `login` ADD COLUMN IF NOT EXISTS `u_idno` varchar(100) COLLATE latin1_swedish_ci NULL;
ALTER TABLE `login` ADD COLUMN IF NOT EXISTS `u_mobile` varchar(100) COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `login` ADD COLUMN IF NOT EXISTS `u_lastlogin` varchar(100) COLLATE latin1_swedish_ci NULL;
ALTER TABLE `login` ADD COLUMN IF NOT EXISTS `u_reset_token` varchar(255) COLLATE latin1_swedish_ci NULL;
ALTER TABLE `login` ADD COLUMN IF NOT EXISTS `u_reset_expires_at` datetime NULL;

ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_vehiclevendors` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_vehiclevendors_add` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_vehiclevendors_del` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_mechanic` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_mechanic_add` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_mechanic_del` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_vendor` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_vendor_add` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_vendor_del` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_fuel_vendor` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_ie_cat` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_route` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_route_add` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_route_del` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_dashboard` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_employees` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_coupon` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_stock_add` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_stock` int(11) NOT NULL DEFAULT '0';
ALTER TABLE `login_roles` ADD COLUMN IF NOT EXISTS `lr_accounts` int(11) NOT NULL DEFAULT '0';

ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_booking_prefix` varchar(11) COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_phoneno` varchar(100) COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_email` varchar(100) COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_invoice_template` varchar(11) COLLATE latin1_swedish_ci NULL DEFAULT '1';
ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_mapunit` varchar(11) COLLATE latin1_swedish_ci NOT NULL DEFAULT 'mile';
ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_defaultmapapi` varchar(100) COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_mapstarting_marker` varchar(100) COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_mapending_marker` varchar(100) COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_frontend_enabled` int(11) NOT NULL DEFAULT '1';
ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_timezone` varchar(100) COLLATE latin1_swedish_ci NULL;
ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_admin_pcolor` varchar(100) COLLATE latin1_swedish_ci NULL;
ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_admin_scolor` varchar(100) COLLATE latin1_swedish_ci NULL;
ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `version` varchar(100) COLLATE latin1_swedish_ci NULL;

CREATE TABLE IF NOT EXISTS `settings_tax` (
  `ts_id` int(11) NOT NULL AUTO_INCREMENT,
  `ts_tax_name` varchar(50) NOT NULL,
  `ts_tax_percentage` decimal(5,2) NOT NULL,
  `ts_tax_type` enum('fixed','percentage') DEFAULT 'percentage',
  `ts_status` tinyint(1) DEFAULT 1,
  `ts_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `ts_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ts_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `settings_twilio` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ss_is_active` tinyint(1) NOT NULL DEFAULT 1,
  `ss_account_sid` varchar(64) NOT NULL,
  `ss_auth_token` varchar(64) NOT NULL,
  `ss_number` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `sms_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref_id` varchar(11) NOT NULL,
  `module` varchar(100) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `error_code` int(11) DEFAULT NULL,
  `error_description` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `sms_template` (
  `st_id` int(11) NOT NULL AUTO_INCREMENT,
  `st_name` varchar(255) NOT NULL,
  `st_body` text NOT NULL,
  `st_status` tinyint(1) NOT NULL DEFAULT 1,
  `st_created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`st_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `stockinventory` (
  `s_id` int(11) NOT NULL AUTO_INCREMENT,
  `s_name` varchar(256) NOT NULL,
  `s_desc` varchar(256) DEFAULT NULL,
  `s_stock` int(100) NOT NULL DEFAULT 0,
  `s_status` int(100) NOT NULL DEFAULT 1,
  `s_price` int(11) DEFAULT NULL,
  `s_created_date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`s_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `stockinventory_history` (
  `sh_id` int(11) NOT NULL AUTO_INCREMENT,
  `sh_s_id` varchar(100) NOT NULL,
  `sh_stock` varchar(100) NOT NULL,
  `sh_desc` varchar(256) NOT NULL,
  `sh_date` datetime NOT NULL DEFAULT current_timestamp(),
  `sh_purhcasefrom` varchar(100) DEFAULT NULL,
  `sh_cost` varchar(100) DEFAULT NULL,
  `sh_paymentstatus` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sh_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `traccarsync_log` (
  `tl_id` int(11) NOT NULL AUTO_INCREMENT,
  `tl_time` varchar(100) NOT NULL,
  `tl_total_records` varchar(100) NOT NULL,
  PRIMARY KEY (`tl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `trip_expenses` (
  `te_id` int(11) NOT NULL AUTO_INCREMENT,
  `te_trip_id` int(11) NOT NULL,
  `te_vehicle_id` int(11) NOT NULL,
  `te_driver_id` int(11) NOT NULL,
  `te_expense_date` date NOT NULL,
  `te_expense_for` varchar(100) NOT NULL,
  `te_amount` decimal(10,2) NOT NULL,
  `te_notes` text DEFAULT NULL,
  `te_created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `te_updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `te_showinvoice` int(11) DEFAULT NULL,
  `te_includetocustomer` int(11) DEFAULT NULL,
  PRIMARY KEY (`te_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `trip_status_master` (
  `tsm_id` int(11) NOT NULL AUTO_INCREMENT,
  `tsm_name` varchar(256) NOT NULL,
  `tsm_enabled_for_driver` varchar(11) DEFAULT '0',
  PRIMARY KEY (`tsm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_bookingid` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_tripstartreading` int(11) NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_trip_stops` longtext COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_billingtype` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_rate` varchar(11) COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_qty` varchar(11) COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_withouttax_trip_amount` decimal(10,2) NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_trip_tax` decimal(10,2) NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_trip_final_amount` decimal(10,2) NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_discount_method` varchar(20) COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_discountvalue` varchar(100) COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_discountcode` varchar(50) COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_discountamount` varchar(11) COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_comments` longtext COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_bookingemail` int(11) NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_bookingsms` int(11) NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_type` varchar(100) COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_requested_v_type` varchar(11) COLLATE utf8mb4_unicode_ci NULL;
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_bookingfrom` varchar(100) COLLATE utf8mb4_unicode_ci NULL;

ALTER TABLE `vehicle_group` ADD COLUMN IF NOT EXISTS `gr_image` varchar(255) COLLATE latin1_swedish_ci NULL;
ALTER TABLE `vehicle_group` ADD COLUMN IF NOT EXISTS `gr_visibletobooking` int(11) NOT NULL DEFAULT '1';

ALTER TABLE `vehicle_maintenance` ADD COLUMN IF NOT EXISTS `m_odometer_reading` varchar(100) COLLATE latin1_swedish_ci NOT NULL;
ALTER TABLE `vehicle_maintenance` ADD COLUMN IF NOT EXISTS `m_notify_members` longtext COLLATE latin1_swedish_ci NULL;
ALTER TABLE `vehicle_maintenance` ADD COLUMN IF NOT EXISTS `m_notify_type` varchar(100) COLLATE latin1_swedish_ci NULL;

ALTER TABLE `vehicle_maintenance_parts_used` ADD COLUMN IF NOT EXISTS `pu_s_id` varchar(100) COLLATE utf8mb4_general_ci NULL;

CREATE TABLE IF NOT EXISTS `vehicle_vendors` (
  `vn_id` int(11) NOT NULL AUTO_INCREMENT,
  `vn_mobile` varchar(15) DEFAULT NULL,
  `vn_address` varchar(250) DEFAULT NULL,
  `vn_doj` varchar(100) DEFAULT NULL,
  `vn_is_active` int(11) DEFAULT NULL,
  `vn_file` varchar(256) DEFAULT NULL,
  `vn_created_by` varchar(100) DEFAULT NULL,
  `vn_created_date` datetime NOT NULL,
  `vn_modified_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `vn_name` varchar(100) DEFAULT NULL,
  `vn_contact_person` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`vn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_ins_exp_date` varchar(11) COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_odometer_reading` int(11) NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_minitruckfields` text COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_openbodytruckfields` text COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_closedcontainerfields` text COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_trailerfields` text COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_tankerfields` text COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_tipperfields` text COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_carfields` text COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_vanfields` text COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_minibusfields` text COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_otherfields` text COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_defaultcost` decimal(10,2) NOT NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_default_billing_type` varchar(11) COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_ownership` enum('owned','vendor') COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_vendor_name` varchar(100) COLLATE utf8_general_ci NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_lease_start_date` date NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_lease_end_date` date NULL;
ALTER TABLE `vehicles` ADD COLUMN IF NOT EXISTS `v_lease_payment` decimal(10,2) NULL;

ALTER TABLE `settings` ADD COLUMN IF NOT EXISTS `s_icon` VARCHAR(100) NULL AFTER `s_admin_scolor`;

-- 4. Insert data into frontendwebsite_content if empty
INSERT INTO `frontendwebsite_content` 
(`phone`, `email`, `facebook_link`, `twitter_link`, `instagram_link`, `linkedin_link`, `youtube_link`, 
`text1`, `text2`, `text3`, `scrolling_text`, `our_fleet_heading`, `our_fleet_subtext`, `call_to_action_text`, 
`call_to_action_number`, `about_us`, `contact_address`, `terms`, `privacy_policy`, `primary_color`, `secondary_color`, 
`mainbg_img`, `created_at`, `updated_at`) 
SELECT * FROM (SELECT 
    '3333333333' AS phone, 'test@onetrans.com' AS email, 
    'https://facebook.com/testt' AS facebook_link, 'https://twitter.com/example' AS twitter_link, 'https://instagram.com/example' AS instagram_link, 
    'https://linkedin.com/example' AS linkedin_link, 'https://youtube.com/c/example' AS youtube_link, 
    'Welcome to our website!' AS text1, 'Discover our wide range of services.' AS text2, 'Contact us for the best deals.' AS text3, 
    'SUV, MUV, Hatchback, Sedan, Sports, Minivan, Bus' AS scrolling_text, 
    'Our Fleets' AS our_fleet_heading, 'Call us for further information. Our customer care is here to help you anytime.' AS our_fleet_subtext, 
    'Call us for further information. Our customer care is here to help you.' AS call_to_action_text, '9876543210' AS call_to_action_number, 
    'Test Where quality meets affordability. We understand the importance of a smooth and enjoyable journey without the burden of excessive costs. That is why we have meticulously crafted our offerings to provide you with top-notch vehicles at minimum expense.' AS about_us, 
    '123 Main Street, City, Country, ZIP' AS contact_address, 
    'Our terms and conditions are clearly outlined for transparency.' AS terms, 
    'Our privacy policy explains how we collect, use, and protect your data.' AS privacy_policy, 
    '#D32E33' AS primary_color, '#1E2340' AS secondary_color, '1738693614-slider-img-1.jpg' AS mainbg_img, 
    '2025-01-01 23:30:40' AS created_at, '2025-02-04 23:56:54' AS updated_at
) AS temp
WHERE NOT EXISTS (SELECT 1 FROM `frontendwebsite_content`);

-- 5. Update settings
UPDATE `settings` 
SET 
    `s_booking_prefix` = 'CC', 
    `s_phoneno` = '+91 97987977979', 
    `s_email` = 'connect@transline.com', 
    `s_invoice_template` = '3', 
    `s_mapunit` = 'km', 
    `s_defaultmapapi` = 'openstreetmap', 
    `s_mapstarting_marker` = 'assets/marker/1734726161-marker-green.png', 
    `s_mapending_marker` = 'assets/marker/marker-red.png', 
    `s_frontend_enabled` = 1, 
    `s_timezone` = 'Asia/Kolkata', 
    `s_admin_pcolor` = '#C60007', 
    `s_admin_scolor` = '#1E2340',
    `version` = '7'
WHERE `s_id` = 1;

-- 6. Update login_roles permissions
UPDATE `login_roles` SET 
    `lr_vehiclevendors` = '1', 
    `lr_vehiclevendors_add` = '1', 
    `lr_vehiclevendors_del` = '1', 
    `lr_mechanic` = '1', 
    `lr_mechanic_add` = '1', 
    `lr_mechanic_del` = '1', 
    `lr_vendor` = '1', 
    `lr_vendor_add` = '1', 
    `lr_vendor_del` = '1', 
    `lr_fuel_vendor` = '1', 
    `lr_ie_cat` = '1', 
    `lr_route` = '1', 
    `lr_route_add` = '1', 
    `lr_route_del` = '1', 
    `lr_dashboard` = '1', 
    `lr_employees` = '1', 
    `lr_coupon` = '1', 
    `lr_stock_add` = '1', 
    `lr_stock` = '1', 
    `lr_accounts` = '1' 
WHERE `lr_id` = 1;

-- 7. Update settings icon
UPDATE `settings` SET `s_icon` = '1742751797-icon.png' WHERE `s_id` = 1;

-- 8. Create vehicle_route table if not exists
CREATE TABLE IF NOT EXISTS `vehicle_route` (
  `vr_id` int(11) NOT NULL AUTO_INCREMENT,
  `vr_name` varchar(256) DEFAULT NULL,
  `vr_created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`vr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- 9. Insert sample route if not exists
INSERT INTO `vehicle_route` (`vr_id`, `vr_name`, `vr_created_date`) 
SELECT 2, 'Test', '2024-06-06 15:31:13'
FROM DUAL
WHERE NOT EXISTS (SELECT 1 FROM `vehicle_route` WHERE `vr_id` = 2);

-- 10. Add route column to trips
ALTER TABLE `trips` ADD COLUMN IF NOT EXISTS `t_route` VARCHAR(11) NULL AFTER `t_vechicle`;

-- 11. Create maintenance mechanic/vendor tables
CREATE TABLE IF NOT EXISTS `vehicle_maintenance_mechanic` (
  `mm_id` int(11) NOT NULL AUTO_INCREMENT,
  `mm_name` varchar(100) DEFAULT NULL,
  `mm_email` varchar(100) DEFAULT NULL,
  `mm_phone` varchar(100) DEFAULT NULL,
  `mm_category` varchar(100) DEFAULT NULL,
  `mm_created_date` datetime NOT NULL,
  PRIMARY KEY (`mm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `vehicle_maintenance_vendor` (
  `mv_id` int(11) NOT NULL AUTO_INCREMENT,
  `mv_name` varchar(100) DEFAULT NULL,
  `mv_email` varchar(100) DEFAULT NULL,
  `mv_phone` varchar(100) DEFAULT NULL,
  `mv_created_date` datetime NOT NULL,
  PRIMARY KEY (`mv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 12. Add vendor/mechanic columns to maintenance
ALTER TABLE `vehicle_maintenance` 
ADD COLUMN IF NOT EXISTS `m_vendor_id` INT NULL AFTER `m_v_id`, 
ADD COLUMN IF NOT EXISTS `m_mechanic_id` INT NULL AFTER `m_vendor_id`;

-- 13. Add fuel source/vendor columns
ALTER TABLE `fuel` 
ADD COLUMN IF NOT EXISTS `v_fuelsource` VARCHAR(100) NULL AFTER `v_fuelcomments`, 
ADD COLUMN IF NOT EXISTS `v_fuelvendor` VARCHAR(100) NULL AFTER `v_fuelsource`;

-- 14. Create fuel tables
CREATE TABLE IF NOT EXISTS `fuel_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `totalstock` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `fuel_vendor` (
  `fv_id` int(11) NOT NULL AUTO_INCREMENT,
  `fv_name` varchar(256) DEFAULT NULL,
  `fv_created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`fv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- 15. Add reminder services
ALTER TABLE `reminder` ADD COLUMN IF NOT EXISTS `r_services` VARCHAR(100) NULL AFTER `r_message`;

CREATE TABLE IF NOT EXISTS `reminder_services` (
  `rs_id` int(11) NOT NULL AUTO_INCREMENT,
  `rs_name` varchar(100) NOT NULL,
  `rs_createddate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`rs_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 16. Truncate and rebuild email/sms templates
TRUNCATE TABLE `email_template`;
INSERT INTO `email_template` (`et_id`, `et_name`, `et_subject`, `et_body`, `et_status`, `et_created_date`) VALUES
(1, 'booking', 'Booking Confirmation - India One Trans', '<p>Dear Customer,<p>\r\n\r\n<p>Thank you for choosing VMS<p>\r\n\r\n<p>We look forward to welcoming you to strat trip.<p>\r\n\r\n<b><p>Booking ID : {{bookingid}}<p>\r\n\r\n<p>Vechicle : {{vehicle}}<p>\r\n\r\n<p>Driver : {{driver}}<p>\r\n\r\n<p>Pickup : {{from}} to {{to}}<p>\r\n\r\n<p>Date : {{start_date}} to {{end_date}}<p>\r\n\r\n<p>Total Distance: {{totaldistance}}<p>\r\n\r\n<p>Odometer Reading: {{tripstartreading}}<p>\r\n\r\n<p>Stops: {{trip_stops}}<p>\r\n\r\n<p>Total Payment: {{trip_amount}}<p>\r\n\r\n<p>Status: {{trip_status}}<p></b>\r\n\r\n<p>Our professional and friendly staff are committed to ensuring your travel is both enjoyable and comfortable.<p>\r\n\r\n<p>Should you have any requests prior to your travel, please do not hesitate to contact us and we will endeavor to assist you whenever possible.<p>', 1, '2024-11-19 16:52:17'),
(2, 'tracking', 'Trip Tracking - VMS', '<p>Dear Customer,</p>\r\n\r\n<p>We are excited to keep you updated on your journey! You can now track the live status of your trip using the link below:</p>\r\n\r\n<p><b>URL : {{url}}</b><p>\r\n\r\n<p>Feel free to reach out to us if you need any assistance. Thank you for choosing VMS for your travel needs!<p>\r\n\r\n', 1, '2024-11-18 16:29:36'),
(3, 'status', 'Trip Status - VMS', '<p>Dear Customer,</p>\n\n<p>We wanted to inform you that the status of your trip has been updated. Below are the updated status of your trip,</p>\n\n<p><b>New Status: {{trip_status}}</b><p>\n\n<p>If you have any questions or require assistance regarding this update, please feel free to contact our support team.</p>\n\n<p>Thank you for choosing VMS. We remain committed to ensuring your journey is smooth and enjoyable.</p>', 1, '2024-11-18 16:28:04'),
(4, 'payment', 'Payment Reminder - VMS', '<p>Dear Customer,</p>\n\n<p>This is a friendly reminder regarding your pending payment for the following trip:</p>\n\n<b><p>Booking ID: {{bookingid}}</p>\n\n<p>Trip Date: {{start_date}} to {{end_date}}</p>\n\n<p>Total Amount: {{trip_amount}}</p>\n\n<p>Amount Due: {{amount_due}}</p></b>\n\n<p>We kindly request you to complete the payment as soon as possible to avoid any inconvenience.</p>\n\n<p>If you have already made the payment, please disregard this message. For any queries or assistance, feel free to contact our support team.</p>\n\n<p>Thank you for your prompt attention to this matter.</p>', 1, '2024-11-18 16:44:26'),
(5, 'custom', 'Custom', '', 1, '2024-11-18 16:44:26'),
(6, 'booking cancellation ', 'Booking Cancellation - VMS', '<p>Dear Customer,<p>\r\n\r\n<p>We regret to inform you that your booking for {{vehicle}} scheduled on {{start_date}} has been canceled.<p>\r\n\r\n<p>Booking Details:<p>\r\n\r\n<b><p>Booking ID : {{bookingid}}<p>\r\n\r\n<p>Vechicle : {{vehicle}}<p>\r\n\r\n<p>Date : {{start_date}} to {{end_date}}<p></b>\r\n\r\n<p>If this cancellation was unintended or if you wish to reschedule, please contact our support team.<p></p>\r\n\r\n<p>We apologize for any inconvenience this may have caused and appreciate your understanding.<p></p>\r\n\r\n<p>Thank you for choosing.<p></p>', 1, '2024-11-19 16:44:37'),
(7, 'maintenance', 'Maintenance - Details', '<p>Dear Team/Driver,<p>\r\n\r\n<p>This is to inform you about the recent maintenance activity performed on the vehicle. Below are the details:<p>\r\n\r\n<p>Vehicle Maintenance Details:<p>\r\n<p>Vehicle Name: {{vehicle}}<p>\r\n<p>Vehicle Number: {{vehicle_number}}<p>\r\n<p>Service Date: {{service_date}}<p>\r\n<p>Odometer Reading: {{odometer_reading}}<p>\r\n\r\n<p>Status : {{status}}<p>\r\n\r\n<p><b>Action Required:</b><p>\r\n\r\n<p><b>Driver:</b> Ensure vehicle readiness for upcoming trips. Report any issues promptly.<p>\r\n<p><b>Internal Team: </b>Log this maintenance record in the system and notify relevant stakeholders if further action is needed.<p>\r\n\r\n<p>Thank you for your attention to this update. Please contact us with any questions.<p>', 1, '2024-11-28 16:30:02'),
(8, 'resetpassword', 'Reset Password', '<p>Dear User,</p>\r\n\r\n<p>We received a request to reset the password for your account associated with the email address. If you didn\t request this change, please ignore this email.</p>\r\n\r\n<p>To reset your password, please click the link below:</p>\r\n\r\n<p><a href=\'{{link}}\'>Click Here to Reset Your Password</a></p>\r\n\r\n<p>The link will expire in 15mins, so be sure to reset your password soon.</p>', 1, '2025-03-15 02:53:45');

TRUNCATE TABLE `sms_template`;
INSERT INTO `sms_template` (`st_id`, `st_name`, `st_body`, `st_status`, `st_created_date`) VALUES
(1, 'Booking', 'Dear Customer, your booking for {{from}} to {{to}} on {{start_date}} has been confirmed. Booking ID: {{bookingid}}. We look forward to serving you!\r\n', 1, '2024-11-06 16:03:26'),
(2, 'Cancel', 'Dear Customer, your booking for {{from}} to {{to}} on {{start_date}} has been cancelled. If you have any questions, please contact us. Thank you!', 1, '2024-11-06 16:03:46'),
(3, 'Tracking', 'Track your vehicle {{vehicle}} in real-time! Use the link: {{trackingurl}} Stay updated on your journey!', 1, '2024-11-06 16:03:46'),
(4, 'Status Update', 'The status of your vehicle {{vehicle}} has been updated to {{trip_status}}. For more details contact us.', 1, '2024-11-06 16:03:46'),
(5, 'Payment Reminder', 'This is a friendly reminder that your payment of {{trip_amount}} for vehicle {{vehicle}}. Kindly make the payment to avoid late charges.', 1, '2024-11-06 16:03:46'),
(7, 'Maintenance', 'Reminder: Vehicle {{vehicle}} ({{vehicle_number}}) is currently under maintenance. Please avoid scheduling trips until further notice. Contact us for updates. ', 1, '2024-11-06 16:03:46');

-- 17. Final update of login_roles permissions
UPDATE login_roles SET 
    lr_vech_list=1, lr_vech_list_view=1, lr_vech_list_edit=1, lr_vech_add=1, 
    lr_vech_group=1, lr_vech_group_add=1, lr_vech_group_action=1, 
    lr_drivers_list=1, lr_drivers_list_edit=1, lr_drivers_add=1, 
    lr_trips_list=1, lr_trips_list_edit=1, lr_trips_add=1, 
    lr_cust_list=1, lr_cust_edit=1, lr_cust_add=1, 
    lr_fuel_list=1, lr_fuel_edit=1, lr_fuel_add=1, 
    lr_reminder_list=1, lr_reminder_delete=1, lr_reminder_add=1, 
    lr_ie_list=1, lr_ie_edit=1, lr_ie_add=1, 
    lr_tracking=1, lr_liveloc=1, 
    lr_geofence_add=1, lr_geofence_list=1, lr_geofence_delete=1, lr_geofence_events=1, 
    lr_reports=1, lr_settings=1, 
    lr_vech_del=1, lr_driver_del=1, lr_booking_del=1, lr_cust_del=1, lr_fuel_del=1, 
    lr_reminder_del=1, lr_ie_del=1, 
    lr_maintenace=1, lr_maintenace_add=1, lr_vech_availablity=1, lr_parts=1, 
    lr_vehiclevendors=1, lr_vehiclevendors_add=1, lr_vehiclevendors_del=1, 
    lr_mechanic=1, lr_mechanic_add=1, lr_mechanic_del=1, 
    lr_vendor=1, lr_vendor_add=1, lr_vendor_del=1, 
    lr_fuel_vendor=1, lr_ie_cat=1, 
    lr_route=1, lr_route_add=1, lr_route_del=1, 
    lr_dashboard=1, lr_employees=1, lr_coupon=1, 
    lr_stock_add=1, lr_stock=1, lr_accounts=1 
WHERE lr_id=1;

-- 18. Modify trips table columns
ALTER TABLE trips 
MODIFY t_trip_fromlocation VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
MODIFY t_trip_tolocation VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
