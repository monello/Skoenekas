-- to test: search & replace "#_" with "ccblm"
DROP VIEW IF EXISTS `#__dnagifts_list_testquestions`;
CREATE VIEW `#__dnagifts_list_testquestions` AS
  SELECT b.test_id, b.question_id, b.show_duration, b.ordering,
    c.question_text, c.question_hint, c.gift_id
  FROM `#__dnagifts_lnk_test_question` AS b
  LEFT JOIN `#__dnagifts_question` AS c ON b.question_id = c.id
  WHERE b.published = 1
  ORDER BY b.ordering;
