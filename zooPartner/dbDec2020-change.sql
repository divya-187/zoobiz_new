ALTER TABLE `users_master` ADD `user_social_media_name` VARCHAR(100) NOT NULL AFTER `is_developer_account`;


CREATE TABLE `business_sub_ctagory_relation_master` (
  `business_sub_ctagory_relation_id` int(11) NOT NULL,
  `business_sub_category_id` int(11) NOT NULL,
  `related_sub_category_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
 
ALTER TABLE `business_sub_ctagory_relation_master`
  ADD PRIMARY KEY (`business_sub_ctagory_relation_id`);
 
ALTER TABLE `business_sub_ctagory_relation_master`
  MODIFY `business_sub_ctagory_relation_id` int(11) NOT NULL AUTO_INCREMENT;



  -------------------------
  /*4dec2020*/

  CREATE TABLE `language_master` (
  `language_id` int(11) NOT NULL,
  `language_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_name_1` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language_file` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `continue_btn_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active_status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
 
INSERT INTO `language_master` (`language_id`, `language_name`, `language_name_1`, `language_file`, `continue_btn_name`, `active_status`) VALUES
(1, 'English', 'English', 'english.png', 'CONTINUE', 0),
(2, 'Hindi ', 'हिन्दी', 'hindi.png', 'आगे बढ़े', 0),
(3, 'Gujarati ', 'ગુજરાતી', 'gujrati.png', 'આગળ જાઓ ', 0),
(4, 'Hinglish', 'Hinglish', 'hinglishNew.png', 'Aage Badhe', 0);
 
ALTER TABLE `language_master`
  ADD PRIMARY KEY (`language_id`);
 
ALTER TABLE `language_master`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


CREATE TABLE `language_key_master` (
  `language_key_id` int(11) NOT NULL,
  `key_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key_status` int(11) NOT NULL,
  `key_type` int(11) NOT NULL COMMENT '1 for array',
  `no_of_key` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `language_key_master`
  ADD PRIMARY KEY (`language_key_id`);

  ALTER TABLE `language_key_master`
  MODIFY `language_key_id` int(11) NOT NULL AUTO_INCREMENT;


  CREATE TABLE `language_key_value_master` (
  `key_value_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `language_key_id` int(11) NOT NULL,
  `value_name` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


  ALTER TABLE `language_key_value_master`
  ADD PRIMARY KEY (`key_value_id`);


  ALTER TABLE `language_key_value_master`
  MODIFY `key_value_id` int(11) NOT NULL AUTO_INCREMENT;


  INSERT INTO `master_menu` (`menu_id`, `parent_menu_id`, `menu_name`, `menu_link`, `menu_icon`, `sub_menu`, `status`, `page_status`, `order_no`, `created_by`, `updated_by`, `created_date`, `updated_date`) VALUES (NULL, '53', 'Manage Language', 'manageLanguage', '', '0', '0', '0', '11', 'Asif Sir', 'Asif Sir', '', '');
  INSERT INTO `master_menu` (`menu_id`, `parent_menu_id`, `menu_name`, `menu_link`, `menu_icon`, `sub_menu`, `status`, `page_status`, `order_no`, `created_by`, `updated_by`, `created_date`, `updated_date`) VALUES (NULL, '53', 'Manage Language Value', 'manageLanguageValue', '', '0', '0', '0', '13', 'Asif Sir', 'Asif Sir', '', '');
  INSERT INTO `master_menu` (`menu_id`, `parent_menu_id`, `menu_name`, `menu_link`, `menu_icon`, `sub_menu`, `status`, `page_status`, `order_no`, `created_by`, `updated_by`, `created_date`, `updated_date`) VALUES (NULL, '53', 'Manage Language Keys', 'manageLanguagKeys', '', '0', '0', '0', '12', 'Asif Sir', 'Asif Sir', '', '')
