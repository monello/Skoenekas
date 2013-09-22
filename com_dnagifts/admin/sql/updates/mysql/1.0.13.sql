DROP VIEW IF EXISTS `#__dnagifts_count_testanswers`;
CREATE VIEW `#__dnagifts_count_testanswers` AS
SELECT a.lnk_user_test_id, b.test_id, COUNT(a.id) howmany
FROM `#__dnagifts_lnk_user_test_answers` a
INNER JOIN `#__dnagifts_lnk_user_tests` b ON a.lnk_user_test_id = b.id
GROUP BY a.lnk_user_test_id;

DROP VIEW IF EXISTS `#__dnagifts_calculate_testprogress`;
CREATE VIEW `#__dnagifts_calculate_testprogress` AS 
SELECT a.lnk_user_test_id, a.test_id, a.howmany answercount,  b.howmany questioncount, a.howmany / b.howmany * 100 as progress
FROM `#__dnagifts_count_testanswers` a
INNER JOIN `#__dnagifts_count_testquestions` b ON a.test_id = b.test_id
ORDER BY a.lnk_user_test_id;


ALTER TABLE  `#__dnagifts_lnk_user_tests` 
	ADD  `progress_updated` DATETIME NULL COMMENT  'Tracks when this progress was confirmed by cron job',
	ADD  `resolved` BOOLEAN NOT NULL DEFAULT FALSE COMMENT  'All records of which the progress is not 100 must be investigated',
	ADD  `resolution` VARCHAR( 255 ) NULL COMMENT  'Resolution description';

/* Update Resolved Records */
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 15;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 20;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 28;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 32;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 39;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Nadia Goldberg - Members intro evening at church' WHERE id = 80;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 86;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 89;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 90;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 91;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 93;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 95;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 96;
UPDATE `#__dnagifts_lnk_user_tests` SET resolved = TRUE, resolution = 'Test Record' WHERE id = 104;
