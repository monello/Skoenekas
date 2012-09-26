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
	var dnaChartCount = 5;
	var dnaMaxScore = 60;
	var dnaResults = <?php echo json_encode($this->dnaResults)?>;
	var dnaReportCopy = {
		'motivationalflow': "<?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_CHARTHEAD'); ?>"
	};
</script>

<table id="tblReportSection" width="670" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="3">
			<span class="rptText16">Hi <?php echo $this->user->name; ?></span>
		</td>
	</tr>
	
	<tr>
		<td width="400">
			<p class="rptText16"><?php echo JText::_('COM_DNAGIFTS_REPORT_HEREYOURESULTS'); ?></p>
			<p><?php echo JText::_('COM_DNAGIFTS_REPORT_INTRO_P1'); ?></p>
			<p><?php echo JText::_('COM_DNAGIFTS_REPORT_INTRO_P2'); ?></p>
		</td>
		<td width="20">&nbsp;</td>
		<td width="250">
			
			<table id="tblScores" width="250" cellspacing="3">
				<thead>
					<th><?php echo JText::_('COM_DNAGIFTS_REPORT_THGIFT'); ?></th>
					<th><?php echo JText::_('COM_DNAGIFTS_REPORT_THSCORE'); ?></th>
					<th><?php echo JText::_('COM_DNAGIFTS_REPORT_THYOURGIFT'); ?></th>
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
			<p class="rptText16"><?php echo JText::_('COM_DNAGIFTS_REPORT_YOURLINEPROFILE'); ?></p>
		</td>
	</tr>
	<tr>
		<td>
			<table id="tblDNAChart">
				<tr>
					<td align="center">
						<strong><?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART'); ?></strong>
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
							$chartfill = 'c,ls,0,FFFFFF,0.07,'.$this->chartfillArr[0].
								',0.12,'.$this->chartfillArr[1].
								',0.13,'.$this->chartfillArr[2].
								',0.12,'.$this->chartfillArr[3].
								',0.12,'.$this->chartfillArr[4].
								',0.13,'.$this->chartfillArr[5].
								',0.13,'.$this->chartfillArr[6].
								',0.13,FFFFFF,0.2';
							//$chartfill='c,ls,0,FFFFFF,0.07,FF6262,0.1,FFCC99,0.095,FFFF99,0.095,99CC99,0.1,66CCCC,0.1,6666CC,0.09,9966CC,0.09,FFFFFF,0.2';
							$markers = 'd,'.$this->markersArr[0].
								',0,0,10|d,'.$this->markersArr[1].
								',0,1,10|d,'.$this->markersArr[2].
								',0,2,10|d,'.$this->markersArr[3].
								',0,3,10|d,'.$this->markersArr[4].
								',0,4,10|d,'.$this->markersArr[5].
								',0,5,10|d,'.$this->markersArr[6].
								',0,6,10'; // marker type, color, series index, which points, size
							$primarybubble = 'y;s=bubble_text_small_withshadow;d=bb,'.JText::_('COM_DNAGIFTS_REPORT_PRIMARYGIFTBUBBLE').',FF8,000;ds=0;dp='.$this->primaryDatapoint;
							$secondarybubble = 'y;s=bubble_text_small_withshadow;d=bb,'.JText::_('COM_DNAGIFTS_REPORT_SECONDARYGIFTBUBBLE').',FF8,000;ds=0;dp='.$this->secondaryDatapoint;
							
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
						<img src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/primary-secondary-<?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART_PRIMSECIMG'); ?>-2.png" />
					</td>
				</tr>
			</table>
			
		</td>
		<td>&nbsp;</td>
		<td>
			<p><?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART_P1'); ?></p>
			<p><?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART_P2'); ?></p>
			<p><?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART_P3'); ?></p>
			<p><?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART_P4'); ?></p>
			<p><?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART_P5'); ?></p>
		</td>
	</tr>
	
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
	
	<tr>
		<td colspan="3"><p class="rptText16"><?php echo JText::_('COM_DNAGIFTS_REPORT_DNACOMP'); ?></p></td>
	</tr>
	<tr>
		<td>
			<div id="piechart_div" style="width: 400px; height: 300px;"></div>
		</td>
		<td>&nbsp;</td>
		<td>
			<p><?php echo JText::_('COM_DNAGIFTS_REPORT_DNACOMP_P1'); ?></p>
			<p><?php echo JText::_('COM_DNAGIFTS_REPORT_DNACOMP_P2'); ?></p>
		</td>
	</tr>
	
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
	
	<tr>
		<td colspan="3"><p class="rptText16"><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW'); ?></p></td>
	</tr>
	<tr>
		<td>
			<div id="linechart_div" style="width: 400px; height: 300px;"></div>
		</td>
		<td>&nbsp;</td>
		<td>
			<p><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_P1'); ?></p>
			<p><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_P2'); ?></p>
		</td>
	</tr>
	
	
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
	
	<tr>
		<td colspan="3">
			<p class="rptText16"><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_DETAIL'); ?></p>
		</td>
	</tr>
	<tr>
		<td colspan="3">
			<p class="rptText14"><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_PRIMARY'); ?>???????????</p>
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
		<td><p class="rptText14"><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY'); ?></p></td>
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


