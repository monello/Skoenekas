ALTER TABLE `#__dnagifts_test` ADD `default_duration` INT( 5 ) NOT NULL DEFAULT '0' COMMENT 'The default "show duration" for all questions in this test' AFTER `use_timing`;
ALTER TABLE `#__dnagifts_test` ADD `test_duration` INT( 5 ) NULL COMMENT 'The estimated duration a user will take to complete the test' AFTER `default_duration`;
ALTER TABLE `#__dnagifts_test` ADD `show_progressbar` TINYINT( 1 ) NOT NULL DEFAULT '1' COMMENT 'Config setting to detemine if the test progress bar should be shown to the user' AFTER `test_duration`;
