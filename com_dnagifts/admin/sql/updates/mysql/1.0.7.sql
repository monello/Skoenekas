ALTER TABLE `#__dnagifts_lnk_test_question` ADD INDEX ( `published` ) ;

DROP VIEW IF EXISTS `#__dnagifts_count_testquestions`;
CREATE VIEW `#__dnagifts_count_testquestions` AS
  SELECT `test_id`, COUNT(`test_id`) AS `howmany` 
  FROM `#__dnagifts_lnk_test_question` 
  WHERE `published` = 1
  GROUP BY `test_id`;
  
ALTER TABLE `#__dnagifts_option_button` ADD INDEX ( `published` ) ;

DROP VIEW IF EXISTS #__dnagifts_testquestions_and_answers;
