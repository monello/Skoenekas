DROP VIEW IF EXISTS #__dnagifts_churchlist;
CREATE VIEW #__dnagifts_churchlist AS
SELECT distinct church_name FROM #__dnagifts_pretest_info;

DROP VIEW IF EXISTS #__dnagifts_pastorlist;
CREATE VIEW #__dnagifts_pastorlist AS
SELECT distinct pastor_reverend  FROM #__dnagifts_pretest_info;

DROP VIEW IF EXISTS #__dnagifts_citylist;
CREATE VIEW #__dnagifts_citylist AS
SELECT distinct your_city FROM #__dnagifts_pretest_info;