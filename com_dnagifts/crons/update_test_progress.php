<?php

// Create connection
$mysqli = new mysqli("localhost", "dnagifts_cron", "kCRcKqPsTvrQ", "dnagifts_jmln");

$msqlerr = '';
// Check connection
if ($mysqli->connect_errno) {
  $msqlerr ="Failed to connect to MySQL: " . $mysqli->connect_error;
} else {
	$report_data = array();

	$mysqli->query("UPDATE jml_dnagifts_lnk_user_tests a
		INNER JOIN jml_dnagifts_calculate_testprogress b ON a.id = b.lnk_user_test_id
		SET a.progress_updated = Now(),
		   a.progress = CONVERT(ROUND(b.progress), UNSIGNED) 
		WHERE a.progress_updated IS NULL
		AND TIME_TO_SEC(TIMEDIFF(NOW(), a.started_datetime))/3600 > 2");
	
	$query = "SELECT * FROM `ccblm_dnagifts_healthchecks` 
			ORDER BY `generated_datetime` DESC LIMIT 1";
	$result = $mysqli->query($query);
	if ($result->num_rows) {
		$last_data = $result->fetch_assoc();
		$result->free();
	}
	
	// Count all the test records
	$query = "SELECT COUNT(id) howmany 
			FROM jml_dnagifts_lnk_user_tests";
	$result = $mysqli->query($query);
	$data = $result->fetch_assoc();
	$report_data['total_tests'] = $data['howmany'];
	$result->free();
	
	// Count all NEW the test records
	if ($last_data) {
		$query = "SELECT COUNT(id) howmany 
				FROM jml_dnagifts_lnk_user_tests 
				WHERE `started_datetime` >= '".$last_data['generated_datetime']."'";
		$result = $mysqli->query($query);
		$data = $result->fetch_assoc();
		$report_data['new_tests'] = $data['howmany'];
		$result->free();
	} else {
		$report_data['new_tests'] = 0;
	}
	
	// count all the good tests
	$query = "SELECT COUNT(id) howmany 
			FROM jml_dnagifts_lnk_user_tests 
			WHERE progress = 100";
	$result = $mysqli->query($query);
	$data = $result->fetch_assoc();
	$report_data['good_tests'] = $data['howmany'];
	$result->free();
	
	// count all the NEW good tests
	if ($last_data) {
		$query = "SELECT COUNT(id) howmany 
				FROM jml_dnagifts_lnk_user_tests 
				WHERE progress = 100 
				AND `started_datetime` >= '".$last_data['generated_datetime']."'";
		$result = $mysqli->query($query);
		$data = $result->fetch_assoc();
		$report_data['new_good_tests'] = $data['howmany'];
		$result->free();
	} else {
		$report_data['new_good_tests'] = 0;
	}
	
	// count all the noreport tests
	$query = "SELECT COUNT(id) howmany 
		FROM jml_dnagifts_lnk_user_tests 
		WHERE progress = 100 
		AND report_name is NULL 
		AND resolved = FALSE";
	$result = $mysqli->query($query);
	$data = $result->fetch_assoc();
	$report_data['noreport_tests'] = $data['howmany'];
	$result->free();
	
	// count all NEW the noreport tests
	if ($last_data) {
		$query = "SELECT COUNT(id) howmany 
				FROM jml_dnagifts_lnk_user_tests 
				WHERE progress = 100 
				AND report_name is NULL 
				AND resolved = FALSE 
				AND `started_datetime` >= '".$last_data['generated_datetime']."'";
		$result = $mysqli->query($query);
		$data = $result->fetch_assoc();
		$report_data['new_noreport_tests'] = $data['howmany'];
		$result->free();
	} else {
		$report_data['new_noreport_tests'] = 0;
	}
	// Extract the data for the no-report tests
	if ($report_data['noreport_tests'] > 0) {
		$query = "SELECT * FROM jml_dnagifts_lnk_user_tests 
			WHERE progress = 100 
			AND report_name is NULL 
			AND resolved = FALSE";
		$result = $mysqli->query($query);
		$noreport_records = "";
		while($row = $result->fetch_assoc()) {
			$noreport_records .= implode(',',$row);
			$noreport_records .= "\n";
		}
		$result->free();
	}
	
	// count all the incomplete tests
	$query = "SELECT COUNT(id) howmany 
		FROM jml_dnagifts_lnk_user_tests 
		WHERE progress < 100";
	$result = $mysqli->query($query);
	$data = $result->fetch_assoc();
	$report_data['incomplete_tests'] = $data['howmany'];
	$result->free();
	
	// count all the NEW incomplete tests
	if ($last_data) {
		$query = "SELECT COUNT(id) howmany 
			FROM jml_dnagifts_lnk_user_tests 
			WHERE progress < 100 
			AND `started_datetime` >= '".$last_data['generated_datetime']."'";
		$result = $mysqli->query($query);
		$data = $result->fetch_assoc();
		$report_data['new_incomplete_tests'] = $data['howmany'];
		$result->free();
	} else {
		$report_data['new_incomplete_tests'] = 0;
	}
	
	// Extract the data for the incomplete tests
	if ($report_data['incomplete_tests'] > 0) {
		$query = "SELECT * FROM jml_dnagifts_lnk_user_tests 
			WHERE progress < 100  
			AND resolved = FALSE";
		$result = $mysqli->query($query);
		$incomplete_records = "";
		while($row = $result->fetch_assoc()) {
			$incomplete_records .= implode(',',$row);
			$incomplete_records .= "\n";
		}
		$result->free();
	}
	
	// count all the extra-answer tests
	$query = "SELECT COUNT(id) howmany 
		FROM jml_dnagifts_lnk_user_tests 
		WHERE progress > 100";
	$result = $mysqli->query($query);
	$data = $result->fetch_assoc();
	$report_data['extraanswers_tests'] = $data['howmany'];
	$result->free();
	
	// count all the NEW extra-answer tests
	if ($last_data) {
		$query = "SELECT COUNT(id) howmany 
			FROM jml_dnagifts_lnk_user_tests 
			WHERE progress > 100 
			AND `started_datetime` >= '".$last_data['generated_datetime']."'";
		$result = $mysqli->query($query);
		$data = $result->fetch_assoc();
		$report_data['new_extraanswers_tests'] = $data['howmany'];
		$result->free();
	} else {
		$report_data['new_extraanswers_tests'] = 0;
	}
	
	// Extract the data for the extra-answer tests
	if ($report_data['extraanswers_tests'] > 0) {
		$query = "SELECT * FROM jml_dnagifts_lnk_user_tests 
			WHERE progress > 100 
			AND resolved = FALSE";
		$result = $mysqli->query($query);
		$overcomplete_records = "";
		while($row = $result->fetch_assoc()) {
			$overcomplete_records .= implode(',',$row);
			$overcomplete_records .= "\n";
		}
		$result->free();
	}
	
	//-----------
	
	// Insert new record into the #__dnagifts_healthchecks table
	$data = "NULL, Now(), ";
	$data .= $report_data['total_tests'].", ";
	$data .= $report_data['new_tests'].", ";
	$data .= $report_data['good_tests'].", ";
	$data .= $report_data['new_good_tests'].", ";
	$data .= $report_data['noreport_tests'].", ";
	$data .= $report_data['new_noreport_tests'].", ";
	$data .= $report_data['incomplete_tests'].", ";
	$data .= $report_data['new_incomplete_tests'].", ";
	$data .= $report_data['extraanswers_tests'].", ";
	$data .= $report_data['new_extraanswers_tests'].", ";
	$data .= "NULL";
	
	$mysqli->query("INSERT INTO jml_dnagifts_healthchecks VALUES (".$data.")");
	$mysqli->close();
}


$to = "louw.morne@gmail.com";
$subject = "CRON - Update Test Progress";
$message = "Result: ";
if ($msqlerr) {
	$message .= "ERROR | ". $msqlerr;
} else {
	$fields = "ID,SESSION_ID,USER_ID,TEST_ID,PROGRESS,STARTED_DATETIME,REPORT_NAME,DATE_SENT,PROGRESS_UPDATED,RESOLVED,RESOLUTION\n";
	
	$message .= "SUCCESS\n\nTotal number of test records: ".$report_data['total_tests'].
		"\nNumber of people that completed the test: ".$report_data['good_tests'].
		"\nNumber of people that completed the test, but did not get a report: ".$report_data['noreport_tests'].
		"\nNumber of people that started a test, but did not complete it: ".$report_data['incomplete_tests'].
		"\nNumber of people that started a test, but have more answers than questions (POSSIBLE ERRORS): ".$report_data['extraanswers_tests'];
		
	if($report_data['incomplete_tests'] > 0) {
		$message .= "\n\nINCOMPLETE RECORDS:\n".$fields.$incomplete_records;
	}
	
	if($report_data['extraanswers_tests'] > 0) {
		$message .= "\n\nTESTS WITH TOO MANY ANSWERS:\n".$fields.$overcomplete_records;
	}
	
	if($report_data['noreport_tests'] > 0) {
		$message .= "\n\nCOMPLETED BUT NO REPORTS:\n".$fields.$noreport_records;
	}
}
$from = "reports@dnagifts.co.za";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";
?>