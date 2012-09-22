<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');

$this->isLoggedIn = DnaGiftsHelper::authenticate();

?>

<div id="notificationcontainer">
  <div id="notificationtab">
	<img src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/spinner16x16.gif">
	<span id="notificationtext"><?php echo JText::_('COM_DNAGIFTS_REPORT_PREPEMAIL'); ?></span>
  </div>
</div>

<script type="text/javascript">
	var dnaChartCount = 2;
	var dnaMaxScore = 60;
	var dnaResults = <?php echo json_encode($this->dnaResults)?>;
</script>

<table id="tblReportSection" width="670" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3">
			<span class="rptText16">Hi <?php echo $this->user->name; ?></span>
		</td>
	</tr>
	
	<tr>
		<td width="400">
			<p class="rptText16">Here are your DNA test results.</p>
			<p>Each statement in this test was linked to a DNA Gift.<br/>
			Each answer button awarded a different score depending how much you agreed with the statement.</p>
			<p>The Primary Gifting is therfore determined by finding the set of statements that you agreed with the most (has the highest score).</p>
		</td>
		<td width="20">&nbsp;</td>
		<td width="250">
			
			<table id="tblScores" width="250" cellspacing="3">
				<thead>
					<th>Gift</th>
					<th>Score</th>
					<th>Your Gift</th>
				</thead>
				<tbody>
					<?php foreach($this->dnaResults as $data): ?>
						<tr class="tr<?php echo $data['label']; ?>">						
							<td><?php echo $data['abbr']; ?></td>
							<td class="tdScore"><?php echo $data['score']; ?></td>
							<td class="tdYourGift"><?php echo $data['label']; ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
			
		</td>
	</tr>
	
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
	
	<tr>
		<td colspan="3">
			<p class="rptText16">This is your DNA Gifts Line Profile.</p>
		</td>
	</tr>
	<tr>
		<td>
			<table id="tblDNAChart">
				<tr>
					<td align="center">
						<strong>DNA CHART</strong>
					</td>
				</tr>
				<tr>
					<td>
						<?php
							$charttype = 'lxy';
							$chartsize = '400x300';
							$chartdata = 't:7,15,23,30,38,46,53|'.$this->chartdata;
							$chartscale = '0,60';
							$linestyle = '1';
							$visibleaxes = 'x,x,y'; // (x,y,t,b) (x-axis, y-axis, top, bottom)
							$axeslabels = '0:| |'.$this->axeslabelsAbbr.
								'| |1:| |'.$this->axeslabelsScores.
								'| |2:|0|10|20|30|40|50|60';
							$chartgrid = '100.0,25.0';
							$chartfill = 'bg,ls,0,FFFFFF,0.09,'.$this->chartfillArr[0].
								',0.10,'.$this->chartfillArr[1].
								',0.095,'.$this->chartfillArr[2].
								',0.095,'.$this->chartfillArr[3].
								',0.10,'.$this->chartfillArr[4].
								',0.10,'.$this->chartfillArr[5].
								',0.09,'.$this->chartfillArr[6].
								',0.09,FFFFFF,0.2';
							$markers = 'd,'.$this->markersArr[0].
								',0,0,10|d,'.$this->markersArr[1].
								',0,1,10|d,'.$this->markersArr[2].
								',0,2,10|d,'.$this->markersArr[3].
								',0,3,10|d,'.$this->markersArr[4].
								',0,4,10|d,'.$this->markersArr[5].
								',0,5,10|d,'.$this->markersArr[6].
								',0,6,10'; // marker type, color, series index, which points, size
							$primarybubble = 'y;s=bubble_text_small;d=bb,Primary+Gift,FF8,000;ds=0;dp='.$this->primaryDatapoint;
							$secondarybubble = 'y;s=bubble_text_small;d=bb,Secondary+Gift,FF8,000;ds=0;dp='.$this->secondaryDatapoint;
							
						?>
						<img src="https://chart.googleapis.com/chart?cht=<?php echo $charttype;
							?>&chs=<?php echo $chartsize;
							?>&chd=<?php echo $chartdata;
							?>&chds=<?php echo $chartscale;
							?>&chco=<?php echo $this->seriescolors;
							?>&chls=<?php echo $linestyle;
							?>&chxt=<?php echo $visibleaxes;
							?>&chxl=<?php echo $axeslabels;
							?>&chg=<?php echo $chartgrid;
							?>&chf=<?php echo $chartfill;
							?>&chm=<?php echo $markers;
							?>&chdl=<?php echo $this->legends;
							?>&chem=<?php echo $primarybubble; ?>|<?php echo $secondarybubble; ?>">
					</td>
				</tr>
			</table>
			
		</td>
		<td>&nbsp;</td>
		<td>
			<p>Your Line Profile is a direct reflection of your test results.</p>
			<p>The higher you scored in a specific gift, the higher the score will plot on this chart.</p>
			<p>From this graph you can clearly see what your strongest natural gifts are.</p>
			<p>We indicated your strongest gift as your Primary Gift and your second most strongest gift as Secondary Gift.</p>
			<p>This merely means that these naturally stand out for you and not that you are weak an all the other Gifts.</p>
		</td>
	</tr>
	
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
	
	<tr>
		<td colspan="3"><p class="rptText16">Your DNA composition looks like this.</p></td>
	</tr>
	<tr>
		<td>
			<div id="piechart_div" style="width: 400px; height: 300px;"></div>
		</td>
		<td>&nbsp;</td>
		<td>
			<p>The composition pie chart puts into perspective how much each Gift make up of your overall DNA.</p>
			<p>This is expressed as a percentage, based on the scores you earned for each answer as you progressed through the test.</p>
		</td>
	</tr>
	
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
	
	<tr>
		<td colspan="3"><p class="rptText16">This is the order of your motivational flow.</p></td>
	</tr>
	<tr>
		<td>
			<div id="linechart_div" style="width: 400px; height: 300px;"></div>
		</td>
		<td>&nbsp;</td>
		<td>
			<p>Here goes some explanation of what the user should read and get from this graph.</p>
			<p>Here goes some explanation of what the user should read and get from this graph.</p>
		</td>
	</tr>
	
	
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
	
	<tr>
		<td colspan="3">
			<p class="rptText16">Lets take a look at your motivational flow in more detail:</p>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<p class="rptText14">Your Primary Gift is Exhorter</p>
		</td>
	</tr>
	<tr>
		<td>
			<p>Your Primary Primary flow comes from this gift.</p>
			<div style="float:left; width: 140px; height: 200px;"><img src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/exhorter.png" /></div>
			<div style="float:left; width: 130px; height: 150px;margin-left: 50px">
				<div id="gauge1chart_div" class="gaugecontainer"></div>
			</div>
		</td>
		<td>&nbsp;</td>
		<td>
			<img src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/exhorter-header.png" />
			<p>Your birthright is locked up inside this gift, your <strong>DYNAMIC NATURAL ABILITY/AUTHORITY/ATTRIBUTES</strong> comes from this gift that God placed inside you.</p>
			<p>The agreement meter shows how much you agreed with all the Exhorter statements in the test.</p>
		</td>
	</tr>
	
	<tr><td colspan="3">&nbsp;</td></tr>
	
	<tr>
		<td><p class="rptText14">Your Secondary Gifts are...</p></td>
	</tr>
	<tr>
		<td>
			<div style="float:left; width: 140px; height: 200px;"><img src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/ruler.png" /></div>
			<div style="float:left; width: 130px; height: 150px;margin-left: 50px">
				<div id="gauge2chart_div" class="gaugecontainer"></div>
			</div>
		</td>
		<td>&nbsp;</td>
		<td>
			<img src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/ruler-header.png" />
			<p>Your birthright is locked up inside this gift, your <strong>DYNAMIC NATURAL ABILITY/AUTHORITY/ATTRIBUTES</strong> comes from this gift that God placed inside you.</p>
			<p>The agreement meter shows how much you agreed with all the Exhorter statements in the test.</p>
		</td>
	</tr>
	
	<tr><td colspan="3">&nbsp;</td></tr>
	
	<tr>
		<td>
			<div style="float:left; width: 140px; height: 200px;"><img src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/giver.png" /></div>
			<div style="float:left; width: 130px; height: 150px;margin-left: 50px">
				<div id="gauge3chart_div" class="gaugecontainer"></div>
			</div>
		</td>
		<td>&nbsp;</td>
		<td>
			<img src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/giver-header.png" />
			<p>Your birthright is locked up inside this gift, your <strong>DYNAMIC NATURAL ABILITY/AUTHORITY/ATTRIBUTES</strong> comes from this gift that God placed inside you.</p>
			<p>The agreement meter shows how much you agreed with all the Exhorter statements in the test.</p>
		</td>
	</tr>
</table>

<!--
<div id="dnaReportSpace">
	<a href="http://localhost/" class="hasTip" title="This is a tip Title::This is the tip body text">back</a>
</div>
-->


