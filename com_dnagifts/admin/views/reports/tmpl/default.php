<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
JHTML::_('behavior.modal');
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	var juri = '<?php echo JURI::root(true); ?>/administrator';
	
	google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Type', 'Size'],
          ['Completed', <?php echo $this->healthData->total_good ?>],
          ['Incomplete', <?php echo $this->healthData->total_incomplete ?>],
          ['Extra Answers', <?php echo $this->healthData->total_extraanswers ?>],
		  ['No Report', <?php echo $this->healthData->total_noreport ?>]
        ]);

        var options = {
		  legend: 'none',
		  slices: { 3: {offset: 0.2}},
		  is3D: true,
		  backgroundColor: 'transparent',
		  chartArea: { width: 200, height: 200, top: 65 },
		  colors:['#0c7112', '#3366cc', '#ff9900', '#dc3912'],
		  pieStartAngle: -45
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
</script>

<style>
#dnaReportingLeftPanel,
#dnaReportingRightPanel {
	background-color: #FFFFFF;
    border: 1px solid #D5D5D5;
}

#dnaReportingLeftPanel {
	float: left;
	width: 50%;
}
#dnaReportingRightPanel{
	float: right;
	width: 49%;
	min-width: 605px;
}

.dnaReportingPanelInner { margin: 10px; }

table.dnaHealthChecks { border: 1px solid #D5D5D5; }
table.dnaHealthChecks tr td { padding: 5px; }
table.dnaHealthChecks tr td:first-of-type { font-weight: bold; }
table.dnaHealthChecks tr td:last-of-type { text-align: right; }
table.dnaHealthChecks tr:nth-child(odd) { background-color:#eee; }
table.dnaHealthChecks tr:nth-child(even) { background-color:#fff; }

a.dnaRetportBtn {
	border: 1px solid #D5D5D5;
    border-radius: 5px;
    display: inline-block;
    padding: 5px;
	float: left;
	margin-right: 10px;
	margin-bottom: 10px;
}
a.dnaRetportBtn:hover {
	background-color: #D5D5D5;
}
div#dnaRptTestHistory ul { padding-left: 13px; }
</style>

<a href="http://localhost/index.php?option=com_dnagifts&format=raw&view=report&id=11" class="modal" rel="{size: {x: 1000, y: 600}, handler: 'iframe'}">Re-Generate Report</a>

<div id="dnaReportingWrapper">
	<div id="dnaReportingLeftPanel">
		<div class="dnaReportingPanelInner">
			<?php echo $this->loadTemplate('leftpanel');?>
		</div>
	</div>
	<div id="dnaReportingRightPanel">
		<div class="dnaReportingPanelInner">
			<?php echo $this->loadTemplate('rightpanel');?>
		</div>
	</div>
</div>
