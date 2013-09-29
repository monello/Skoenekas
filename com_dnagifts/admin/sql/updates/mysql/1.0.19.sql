ALTER TABLE `#__dnagifts_lnk_user_tests` 
ADD `is_timing_on` TINYINT(1) NOT NULL COMMENT 'Indidates if the question timing was on for this test when it was done' 
AFTER `test_id`;

ALTER TABLE `#__dnagifts_lnk_user_tests` 
ADD `browser_info` CHAR(255) NOT NULL COMMENT 'Details about the browser the user is using' 
AFTER `started_datetime`;