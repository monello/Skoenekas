<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

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
		  legend: {position: 'bottom'},
		  height: 300,
		  slices: { 3: {offset: 0.2}},
		  is3D: true
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
	width: 60%;
}
#dnaReportingRightPanel{
	float: right;
	width: 39%;
}

.dnaReportingPanelInner { margin: 10px; }

table.dnaHealthChecks { border: 1px solid #D5D5D5; }
table.dnaHealthChecks tr td { padding: 5px; }
table.dnaHealthChecks tr td:first-of-type { font-weight: bold; }
table.dnaHealthChecks tr td:last-of-type { text-align: right; }
table.dnaHealthChecks tr:nth-child(odd) { background-color:#eee; }
table.dnaHealthChecks tr:nth-child(even) { background-color:#fff; }
</style>

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
