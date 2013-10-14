DROP VIEW IF EXISTS `#__dnagifts_list_all_answers`;
CREATE VIEW `#__dnagifts_list_all_answers` AS 
SELECT a . * , b.test_id
FROM #__dnagifts_lnk_user_test_answers a
LEFT JOIN #__dnagifts_lnk_user_tests b ON b.id = a.lnk_user_test_id;

DROP VIEW IF EXISTS `#__dnagifts_list_all_testbuttons`;
CREATE VIEW `#__dnagifts_list_all_testbuttons` AS 
SELECT a . * , b.button_text, b.score
FROM `#__dnagifts_lnk_test_buttonset` a
LEFT JOIN #__dnagifts_option_button b ON b.id = a.button_id
ORDER BY `a`.`id` ASC 
