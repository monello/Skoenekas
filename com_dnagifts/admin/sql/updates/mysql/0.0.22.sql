ALTER TABLE `#__dnagifts_lnk_user_tests` ADD `progress` INT( 3 ) NOT NULL DEFAULT '0' COMMENT 'Indicates the users progress for this test in the current session' AFTER `test_id`;
ALTER TABLE `#__dnagifts_lnk_user_tests` ADD `report_name` VARCHAR( 70 ) NULL COMMENT 'Filename of the PDF report';
