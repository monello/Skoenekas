ALTER TABLE `#__dnagifts_lnk_user_tests` 
ADD COLUMN `user_browser` VARCHAR(20) NULL COMMENT 'Indidates the users browser at time of doing this test' AFTER `started_datetime`,
ADD COLUMN `user_platform` VARCHAR(20) NULL COMMENT 'Details about the browser the user is using' AFTER `user_browser`;

ALTER TABLE `#__dnagifts_lnk_user_tests` 
DROP `browser_info`;