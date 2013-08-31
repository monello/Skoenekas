UPDATE jml_dnagifts_lnk_user_test_answers
SET keep = 0;

DROP VIEW IF EXISTS tmp_dedupe1;

CREATE VIEW tmp_dedupe1 AS
SELECT MIN(id) minid, lnk_user_test_id, question_id, COUNT(id) as howmany
FROM jml_dnagifts_lnk_user_test_answers
GROUP BY lnk_user_test_id, question_id
HAVING howmany = 1;

DROP VIEW IF EXISTS tmp_dedupe;

CREATE VIEW tmp_dedupe AS
SELECT MIN(id) minid, lnk_user_test_id, question_id, COUNT(id) as howmany
FROM jml_dnagifts_lnk_user_test_answers
GROUP BY lnk_user_test_id, question_id
HAVING howmany > 1;

UPDATE jml_dnagifts_lnk_user_test_answers
SET keep = 1 
WHERE id in (SELECT minid FROM tmp_dedupe1);

UPDATE jml_dnagifts_lnk_user_test_answers
SET keep = 1 
WHERE id not in (SELECT minid FROM tmp_dedupe);