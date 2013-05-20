DROP VIEW IF EXISTS #__dnagifts_testquestions_and_answers;
CREATE VIEW #__dnagifts_testquestions_and_answers AS
SELECT a.*, c.answer_score, c.lnk_user_test_id
FROM `#__dnagifts_list_testquestions` AS a 
LEFT JOIN `#__dnagifts_lnk_user_tests` AS b ON b.test_id = a.test_id
LEFT JOIN `#__dnagifts_lnk_user_test_answers` AS c ON b.id = c.lnk_user_test_id AND a.question_id = c.question_id
ORDER BY a.ordering ASC;