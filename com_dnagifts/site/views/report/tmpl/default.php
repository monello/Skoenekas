<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.tooltip');

$this->isLoggedIn = DnaGiftsHelper::authenticate();

?>
<script type="text/javascript">
	var juri = '<?php echo JURI::root(true); ?>';
</script>
<div id="notificationcontainer">
  <div id="notificationtab">
	<img id="notificationspinner" src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/spinner16x16.gif">
	<span id="notificationtext"><?php echo JText::_('COM_DNAGIFTS_REPORT_PREPEMAIL'); ?></span>
  </div>
</div>

<script type="text/javascript">
	var dnaChartCount = 5;
	var dnaMaxScore = <?php echo $this->dnaMaxScore; ?>;
	var userTestID = <?php echo $this->userTestID; ?>;
	var dnaResults = <?php echo json_encode($this->dnaResults); ?>;
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
			<?php echo JText::_('COM_DNAGIFTS_REPORT_INTRO'); ?>
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
						<?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART_HEAD'); ?>
					</td>
				</tr>
				<tr>
					<td>
						<img src="<?php echo $this->dnaChartSrc; ?>">
						<img src="<?php echo JURI::base(true) ?>/media/com_dnagifts/images/primary-secondary-<?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART_PRIMSECIMG'); ?>-2.png" />
					</td>
				</tr>
			</table>
			
		</td>
		<td>&nbsp;</td>
		<td>
			<?php echo JText::_('COM_DNAGIFTS_REPORT_DNACHART_TEXT'); ?>
		</td>
	</tr>
	
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
	
	<tr>
		<td colspan="3"><p class="rptText16"><?php echo JText::_('COM_DNAGIFTS_REPORT_DNACOMP_HEAD'); ?></p></td>
	</tr>
	<tr>
		<td>
			<div id="piechart_div" style="width: 400px; height: 300px;"></div>
		</td>
		<td>&nbsp;</td>
		<td>
			<?php echo JText::_('COM_DNAGIFTS_REPORT_DNACOMP_TEXT'); ?>
		</td>
	</tr>
	
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
	
	<tr>
		<td colspan="3"><p class="rptText16"><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_HEAD'); ?></p></td>
	</tr>
	<tr>
		<td>
			<div id="linechart_div" style="width: 400px; height: 300px;"></div>
		</td>
		<td>&nbsp;</td>
		<td>
			<?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT'); ?>
		</td>
	</tr>
	
	
	<tr><td colspan="3"><hr class="sectionSeparator"/></td></tr>
	
	<tr>
		<td colspan="3">
			<p class="rptText16"><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_DETAIL'); ?></p>
		</td>
	</tr>
	<?php $position = 0; ?>
	<tr>
		<td colspan="3">
			<p class="rptText14"><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_PRIMARY'); ?><?php echo ReportsHelper::getGiftLabel($this->dnaResults, $position); ?></p>
		</td>
	</tr>
	<tr>
		<td>
			<p></p><?php echo JText::_('COM_DNAGIFTS_REPORT_PRIMARY_GIFT'); ?></p>
			<div style="float:left; width: 140px; height: 200px;"><img src="<?php echo ReportsHelper::getCharacterImg($this->dnaResults, $position); ?>" /></div>
			<div style="float:left; width: 130px; height: 150px;margin-left: 50px">
				<div id="gauge1chart_div" class="gaugecontainer"></div>
			</div>
		</td>
		<td>&nbsp;</td>
		<td>
			<img src="<?php echo ReportsHelper::getHeaderImg($this->dnaResults, $position); ?>" />
			<?php echo ReportsHelper::getGiftDescription($this->dnaResults, $position); ?>
		</td>
	</tr>
	
	<tr><td colspan="3">&nbsp;</td></tr>
	
	<?php $position += 1; ?>
	<tr>
		<td><p class="rptText14"><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY'); ?></p></td>
	</tr>
	<tr>
		<td>
			<div style="float:left; width: 140px; height: 200px;"><img src="<?php echo ReportsHelper::getCharacterImg($this->dnaResults, $position); ?>" /></div>
			<div style="float:left; width: 130px; height: 150px;margin-left: 50px">
				<div id="gauge2chart_div" class="gaugecontainer"></div>
			</div>
		</td>
		<td>&nbsp;</td>
		<td>
			<img src="<?php echo ReportsHelper::getHeaderImg($this->dnaResults, $position); ?>" />
			<?php echo ReportsHelper::getGiftDescription($this->dnaResults, $position); ?>
		</td>
	</tr>
	
	<tr><td colspan="3">&nbsp;</td></tr>
	
	<?php $position += 1; ?>
	<tr>
		<td>
			<div style="float:left; width: 140px; height: 200px;"><img src="<?php echo ReportsHelper::getCharacterImg($this->dnaResults, $position); ?>" /></div>
			<div style="float:left; width: 130px; height: 150px;margin-left: 50px">
				<div id="gauge3chart_div" class="gaugecontainer"></div>
			</div>
		</td>
		<td>&nbsp;</td>
		<td>
			<img src="<?php echo ReportsHelper::getHeaderImg($this->dnaResults, $position); ?>" />
			<?php echo ReportsHelper::getGiftDescription($this->dnaResults, $position); ?>
		</td>
	</tr>
	
	<!-- RXTRA GUAGES -->
	<tr><td colspan="3">&nbsp;</td></tr>
	<tr>
		<td><p class="rptText14"><?php echo JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_SERVICE'); ?></p></td>
	</tr>
	<?php $position += 1; ?>
	<tr>
		<td colspan="3">
			
			<table id="tblServiceGifts" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td width="150px">
						<div style="float:left; width: 130px; height: 150px;margin-left: 10px">
							<div id="gauge4chart_div" class="gaugecontainer"></div>
						</div>
					</td>
					<td>
						<?php echo ReportsHelper::getGiftDescription($this->dnaResults, $position); ?>
					</td>
					<td width="150px">
						<div style="float:left; width: 130px; height: 150px;margin-left: 10px">
							<div id="gauge5chart_div" class="gaugecontainer"></div>
						</div>
					</td>
					<td>
						<?php echo ReportsHelper::getGiftDescription($this->dnaResults, $position+1); ?>
					</td>
				</tr>
				<tr>
					<td>
						<div style="float:left; width: 130px; height: 150px;margin-left: 10px">
							<div id="gauge6chart_div" class="gaugecontainer"></div>
						</div>
					</td>
					<td>
						<?php echo ReportsHelper::getGiftDescription($this->dnaResults, $position+2); ?>
					</td>
					<td>
						<div style="float:left; width: 130px; height: 150px;margin-left: 10px">
							<div id="gauge7chart_div" class="gaugecontainer"></div>
						</div>
					</td>
					<td>
						<?php echo ReportsHelper::getGiftDescription($this->dnaResults, $position+3); ?>
					</td>
				</tr>
			</table>
			
		</td>
	</tr>
</table>

<!--
<div id="dnaReportSpace">
	<a href="http://localhost/" class="hasTip" title="This is a tip Title::This is the tip body text">back</a>
</div>
-->


