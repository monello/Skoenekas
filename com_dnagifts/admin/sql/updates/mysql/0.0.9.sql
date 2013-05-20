ALTER TABLE `#__dnagifts_lnk_user_tests` ADD `progress` INT( 11 ) NOT NULL DEFAULT '0' COMMENT 'Indicates the users progress for this test in the current session' AFTER `test_id`;
