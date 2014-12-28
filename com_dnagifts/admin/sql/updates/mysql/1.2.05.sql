DROP VIEW IF EXISTS `#__dnagifts_max_question_time`;

CREATE VIEW `#__dnagifts_max_question_time` AS
SELECT `lnk_user_test_id`, MAX(`answer_datetime`) AS `max_date`
FROM `#__dnagifts_list_all_answers`
GROUP BY `lnk_user_test_id`;

UPDATE `#__dnagifts_lnk_user_tests` a
JOIN `#__dnagifts_max_question_time` b ON b.`lnk_user_test_id` = a.`id`
SET a.`ended_datetime` = b.`max_date`,
	a.`duration` = TIMESTAMPDIFF(SECOND, a.`started_datetime`, b.`max_date`)
WHERE a.`ended_datetime` IS NULL;

DROP VIEW IF EXISTS `#__dnagifts_max_question_time`;
