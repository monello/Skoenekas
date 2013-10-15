ALTER TABLE `#__dnagifts_pretest_info`
	DROP `church_mapped`,
	DROP `church_done`,
	DROP `city_mapped`,
	DROP `city_done`,
	DROP `pastor_mapped`,
	DROP `pastor_done`;

ALTER TABLE `#__dnagifts_pretest_info`
	ADD `church_approved` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT 'Allow this value in the auto suggest widgets' AFTER `created` ,
	ADD `pastor_approved` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT 'Allow this value in the auto suggest widgets' AFTER `church_approved` ,
	ADD `city_approved` TINYINT( 1 ) NOT NULL DEFAULT '0' COMMENT 'Allow this value in the auto suggest widgets' AFTER `pastor_approved`;
	
DROP VIEW IF EXISTS #__dnagifts_churchlist;
CREATE VIEW #__dnagifts_churchlist AS
SELECT distinct church_name, church_approved 
FROM #__dnagifts_pretest_info 
WHERE church_name IS NOT NULL;

DROP VIEW IF EXISTS #__dnagifts_pastorlist;
CREATE VIEW #__dnagifts_pastorlist AS
SELECT distinct pastor_reverend, pastor_approved
FROM #__dnagifts_pretest_info 
WHERE pastor_reverend IS NOT NULL;

DROP VIEW IF EXISTS #__dnagifts_citylist;
CREATE VIEW #__dnagifts_citylist AS
SELECT distinct your_city, city_approved 
FROM #__dnagifts_pretest_info 
WHERE your_city IS NOT NULL;
