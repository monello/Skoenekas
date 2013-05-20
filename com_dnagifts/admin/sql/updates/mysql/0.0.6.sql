-- to test: search & replace "#_" with "ccblm"
DROP VIEW IF EXISTS `#__dnagifts_list_testquestions`;
CREATE VIEW `#__dnagifts_list_testquestions` AS
  SELECT a.id, a.use_timing, a.default_duration, a.show_progressbar,
    b.question_id, b.show_duration, b.ordering,
    c.question_text, c.question_hint, c.gift_id
  FROM `#__dnagifts_test` AS a
  LEFT JOIN `#__dnagifts_lnk_test_question` AS b ON a.id = b.test_id
  LEFT JOIN `#__dnagifts_question` AS c ON b.question_id = c.id
  WHERE b.published = 1
  ORDER BY b.ordering;

DROP VIEW IF EXISTS `#__dnagifts_list_testbuttons`;
CREATE VIEW `#__dnagifts_list_testbuttons` AS
  SELECT a.test_id, b.button_text, b.button_hint, b.score, b.css_class
  FROM `#__dnagifts_lnk_test_buttonset` AS a
  LEFT JOIN `#__dnagifts_option_button` AS b ON a.button_id = b.id
  WHERE b.published = 1
  ORDER BY a.ordering;
