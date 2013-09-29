SELECT a.user_test_id, a.score, a.gift_id, b.name, b.color_hex
FROM ccblm_dnagifts_testresults a
LEFT JOIN ccblm_dnagifts_lst_gift b ON b.id = a.gift_id
WHERE a.position = 1


-- ------------------------------------------
DROP PROCEDURE IF EXISTS simpleproc;

delimiter //

CREATE PROCEDURE simpleproc (IN find_id INT, OUT gift_id1 INT)
BEGIN
	SELECT gift_id INTO gift_id1 
	FROM ccblm_dnagifts_testresults
	WHERE user_test_id = find_id
	AND position = 1;
END//

delimiter ;

CALL simpleproc(1, @gift_id1);

SELECT @gift_id1 AS gift_id1;

-- ------------------------------------------
DROP PROCEDURE IF EXISTS simpleproc2;

delimiter //

CREATE PROCEDURE simpleproc2 (IN find_id INT, OUT gift_id1 INT, OUT gift_id2 INT)
BEGIN
	SELECT gift_id INTO gift_id1 
	FROM ccblm_dnagifts_testresults
	WHERE user_test_id = find_id
	AND position = 1;
	
	SELECT gift_id INTO gift_id2 
	FROM ccblm_dnagifts_testresults
	WHERE user_test_id = find_id
	AND position = 2;
END//

delimiter ;

CALL simpleproc2(1, @gift_id1, @gift_id2);

SELECT @gift_id1 AS gift_id1, @gift_id2 AS gift_id2;
