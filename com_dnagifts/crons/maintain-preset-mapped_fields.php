<?php
/**
 * This cron updates the mapped fields in the presetinfo table.
 * These fields are used to populate the autosuggest widgets with our preferred values.
 * Run this cron once a day
 **/
 
// Create connection
$mysqli = new mysqli("localhost", "dnagifts_cron", "kCRcKqPsTvrQ", "dnagifts_jmln");

$msqlerr = '';
// Check connection
if ($mysqli->connect_errno) {
	$msqlerr ="Failed to connect to MySQL: " . $mysqli->connect_error;
} else {
	$mysqli->query("UPDATE jml_dnagifts_pretest_info SET church_mapped = church_name WHERE church_done = 0 AND church_mapped IS NULL");
	$mysqli->query("UPDATE jml_dnagifts_pretest_info SET city_mapped = your_city WHERE city_done = 0 AND city_mapped IS NULL");
	$mysqli->query("UPDATE jml_dnagifts_pretest_info SET pastor_mapped = pastor_reverend WHERE pastor_done = 0 AND pastor_mapped IS NULL");
}
$mysqli->close();
?>