<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<div style="float: left">
	<h4>Survey System Health Check</h4>
	<table class="dnaHealthChecks">
		<tr>
			<td>Total Tests:</td>
			<td><?php echo $this->healthData->total_tests ?></td>
			<td style="background-color: #fff">&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td>Completed Tests:</td>
			<td><?php echo $this->healthData->total_good ?></td>
			<td style="background-color: #0c7112">&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td>Incomplete Tests:</td>
			<td><?php echo $this->healthData->total_incomplete ?></td>
			<td style="background-color: #3366cc">&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td>Tests with too many answers:</td>
			<td><?php echo $this->healthData->total_extraanswers ?></td>
			<td style="background-color: #ff9900">&nbsp;&nbsp;</td>
		</tr>
		<tr>
			<td>No Report Sent</td>
			<td><?php echo $this->healthData->total_noreport ?></td>
			<td style="background-color: #dc3912">&nbsp;&nbsp;</td>
		</tr>
	</table>
</div>
<div id="donutchart" style="position:relative; top:-50px; float: left; width: 350px; height: 280px;"></div>
