UPDATE #__dnagifts_pretest_info SET church_mapped = church_name WHERE church_done = 0;
UPDATE #__dnagifts_pretest_info SET city_mapped = your_city WHERE city_done = 0;
UPDATE #__dnagifts_pretest_info SET pastor_mapped = pastor_reverend WHERE pastor_done = 0;

DROP VIEW IF EXISTS #__dnagifts_churchlist;
CREATE VIEW #__dnagifts_churchlist AS
SELECT distinct church_mapped AS church_name FROM #__dnagifts_pretest_info WHERE church_mapped IS NOT NULL AND char_length(church_mapped) > 0;

DROP VIEW IF EXISTS #__dnagifts_pastorlist;
CREATE VIEW #__dnagifts_pastorlist AS
SELECT distinct pastor_mapped AS pastor_reverend FROM #__dnagifts_pretest_info WHERE pastor_mapped IS NOT NULL AND char_length(pastor_mapped) > 0;

DROP VIEW IF EXISTS #__dnagifts_citylist;
CREATE VIEW #__dnagifts_citylist AS
SELECT distinct city_mapped AS your_city FROM #__dnagifts_pretest_info WHERE city_mapped IS NOT NULL AND char_length(city_mapped) > 0;