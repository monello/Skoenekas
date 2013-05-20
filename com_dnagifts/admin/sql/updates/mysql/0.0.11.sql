DROP VIEW IF EXISTS #__dnagifts_testquestions_and_answers;
CREATE VIEW #__dnagifts_testquestions_and_answers AS
SELECT a.*, b.answer_score, b.lnk_user_test_id 
FROM `#__dnagifts_list_testquestions` AS a 
LEFT JOIN `#__dnagifts_lnk_user_test_answers` AS b ON b.question_id = a.question_id
ORDER BY a.ordering ASC;
