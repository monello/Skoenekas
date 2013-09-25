<?php

function logResults($mysqli, $user_test_id) {
	$query = "SELECT b.gift_id, sum( a.answer_score ) AS total_score
		FROM `jml_dnagifts_lnk_user_test_answers` AS a
		LEFT JOIN `jml_dnagifts_question` AS b ON b.id = a.question_id
		WHERE lnk_user_test_id = ".$user_test_id." 
		GROUP BY b.gift_id 
		ORDER BY total_score DESC";
	echo $query."<br />";
	$result = $mysqli->query($query);
	
	$position = 1;
	while($row = $result->fetch_assoc()) {
		$query = "INSERT INTO jml_dnagifts_testresults 
			VALUES (NULL, ".$user_test_id.", ".$position.", ".$row['total_score'].", ".$row['gift_id'].")";
		echo $query."<br />";
		$mysqli->query($query);
		$position++;
	}
	$result->free();
	return $dnaResults;
}

// Create connection
$mysqli = new mysqli("localhost", "dnagifts_cron", "kCRcKqPsTvrQ", "dnagifts_jmln");

$msqlerr = '';
// Check connection
if ($mysqli->connect_errno) {
  $msqlerr ="Failed to connect to MySQL: " . $mysqli->connect_error;
} else {
	$query = "SELECT id FROM `jml_dnagifts_lnk_user_tests` 
		WHERE progress = 100
		AND id NOT IN (SELECT DISTINCT user_test_id FROM `jml_dnagifts_testresults`)";
	$result = $mysqli->query($query);
	echo $query."<br />";
	while($row = $result->fetch_assoc()) {
		logResults($mysqli, $row['id']);
	}
	$result->free();
}

$mysqli->close();

?>