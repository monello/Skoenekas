DROP VIEW IF EXISTS `#__dnagifts_count_testquestions`;
CREATE VIEW `#__dnagifts_count_testquestions` AS
  SELECT `test_id`, COUNT(*) AS `howmany` 
  FROM `#__dnagifts_lnk_test_question` 
  WHERE `published` = 1
  GROUP BY `test_id`;
