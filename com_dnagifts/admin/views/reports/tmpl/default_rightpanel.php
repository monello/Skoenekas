<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<h4>Survey System Health Check</h4>
<table class="dnaHealthChecks">
	<tr>
		<td>Total Tests:</td>
		<td><?php echo $this->healthData->total_tests ?></td>
	</tr>
	<tr>
		<td>Completed Tests:</td>
		<td><?php echo $this->healthData->total_good ?></td>
	</tr>
	<tr>
		<td>Incomplete Tests:</td>
		<td><?php echo $this->healthData->total_incomplete ?></td>
	</tr>
	<tr>
		<td>Tests with too many answers:</td>
		<td><?php echo $this->healthData->total_extraanswers ?></td>
	</tr>
	<tr>
		<td>No Report Sent</td>
		<td><?php echo $this->healthData->total_noreport ?></td>
	</tr>
</table>
<div id="donutchart" style="width: 400px; height: 400px;"></div>
