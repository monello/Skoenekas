ALTER TABLE `#__dnagifts_healthchecks` 
ADD `total_incomplete_less` INT( 11 ) NOT NULL AFTER `new_incomplete` ,
ADD `new_incomplete_less` INT( 11 ) NOT NULL AFTER `total_incomplete_less`;
