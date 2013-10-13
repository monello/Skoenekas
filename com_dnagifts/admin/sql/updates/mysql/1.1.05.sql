ALTER TABLE `#__dnagifts_lnk_user_tests` 
ADD `ended_datetime` DATETIME NULL COMMENT 'Date and time the user finished the test' AFTER `started_datetime` ,
ADD `duration` INT NULL COMMENT 'total duration, in seconds, the user took to complete the test' AFTER `ended_datetime` ;

ALTER TABLE `#__dnagifts_lnk_user_test_answers`
ADD `answer_startdatetime` DATETIME NULL COMMENT 'Date and time to question was fetched' AFTER `answer_score` ,
ADD `duration` INT NULL COMMENT 'The time in seconds it took the user to answer this question' AFTER `answer_datetime`,
ADD `is_skipped` TINYINT( 1 ) NULL DEFAULT '1' COMMENT 'Indicates if (and how many times) the user skipped this question' AFTER `duration`;

DROP VIEW IF EXISTS `#__dnagifts_count_testanswers`;
CREATE VIEW `#__dnagifts_count_testanswers` AS
SELECT a.lnk_user_test_id, b.test_id, COUNT(a.id) howmany
FROM `#__dnagifts_lnk_user_test_answers` a
INNER JOIN `#__dnagifts_lnk_user_tests` b ON a.lnk_user_test_id = b.id
WHERE a.is_skipped = 0
GROUP BY a.lnk_user_test_id;
