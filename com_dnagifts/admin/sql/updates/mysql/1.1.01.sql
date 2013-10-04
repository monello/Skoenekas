ALTER TABLE `#__dnagifts_pretest_info` ADD `church_mapped` VARCHAR( 50 ) NOT NULL COMMENT 'Cleaned Church Value',
ADD `church_done` TINYINT( 1 ) NOT NULL COMMENT 'Church mapping updated',
ADD `city_mapped` VARCHAR( 50 ) NOT NULL COMMENT 'Cleaned City Value',
ADD `city_done` TINYINT( 1 ) NOT NULL COMMENT 'City mapping updated',
ADD `pastor_mapped` VARCHAR( 50 ) NOT NULL COMMENT 'Cleaned Pastor/Reverend Value',
ADD `pastor_done` TINYINT( 1 ) NOT NULL COMMENT 'Pastor/Reverend mapping updated';

UPDATE `#__dnagifts_pretest_info` SET `church_mapped` = `church_name`, `city_mapped` = `your_city`, `pastor_mapped` = `pastor_reverend`;
