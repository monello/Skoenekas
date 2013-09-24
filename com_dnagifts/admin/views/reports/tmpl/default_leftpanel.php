<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<div id="dnaRptTestHistory">
	<h4>Test History</h4>
	<a class="dnaRetportBtn" href="<?php JURI::root(true) ?>/administrator/index.php?option=com_dnagifts&view=testhistory" id="rptSurveyHistory"><img src="<?php JURI::root(true) ?>/media/com_dnagifts/images/archive-icon-64x64.png"/></a>
	<div style="display: inline-block">
		View a list of all the tests registered on the database.
		<ul>	
			<li>Monitor how many tests were successfully completed and how many tests were started, but never completed.</li>
			<li>See the start and end time for each test</li> 
			<li>See the time each answer was saved and the duration between each question</li> 
			<li>See the overall duration of the test.</li> 
			<li>You will also be able to view the final report of each test that was completed, download the report or re-send it to the visitor.</li>
		</ul>
	</div>
</div>
