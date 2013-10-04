<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
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
          ['Incomplete >=80%', <?php echo $this->healthData->total_incomplete ?>],
		  ['Incomplete <80%', <?php echo $this->healthData->total_incomplete_less ?>],
          ['Extra Answers', <?php echo $this->healthData->total_extraanswers ?>],
		  ['No Report', <?php echo $this->healthData->total_noreport ?>]
        ]);

        var options = {
		  legend: 'none',
		  slices: { 4: {offset: 0.2}},
		  is3D: true,
		  backgroundColor: 'transparent',
		  chartArea: { width: 200, height: 200, top: 65 },
		  colors:['#0c7112', '#0000CC',  '#FFFF00', '#ff9900', '#dc3912'],
		  pieStartAngle: -45
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
</script>

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
