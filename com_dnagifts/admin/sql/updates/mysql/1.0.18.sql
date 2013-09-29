-- This table is not used and is replaced by `#__dnagifts_testresults` which is more complete
DROP TABLE IF EXISTS `#__dnagifts_lnk_user_gifts`;

ALTER TABLE `#__dnagifts_lnk_user_tests` 
ADD `question_count` INT NOT NULL COMMENT 'The number of questions this test had at the time of starting the test' 
AFTER `test_id`;

DROP VIEW IF EXISTS `#__dnagifts_calculate_testprogress`;
CREATE VIEW `#__dnagifts_calculate_testprogress` AS 
SELECT a.lnk_user_test_id, a.test_id, a.howmany answercount,  
	b.question_count questioncount, 
	a.howmany / b.question_count * 100 as progress
FROM `#__dnagifts_count_testanswers` a
INNER JOIN `#__dnagifts_lnk_user_tests` b ON a.lnk_user_test_id = b.id
ORDER BY a.lnk_user_test_id;


UPDATE `#__dnagifts_lnk_user_tests` a
SET a.`question_count` = (
	SELECT b.`howmany` 
	FROM `#__dnagifts_count_testquestions` b
	WHERE b.`test_id` = a.`test_id`
);
