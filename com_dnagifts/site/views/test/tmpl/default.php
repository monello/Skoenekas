<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');

if ($this->is_active) {
	$playmessage = 'COM_DNAGIFTS_TEST_CONTINUEMESSAGE';
	$playbutton = 'pause';
} else {
	$playmessage = 'COM_DNAGIFTS_TEST_STARTMESSAGE';
	$playbutton = 'play';
}
?>

<script type="text/javascript">
	var juri = '<?php echo JURI::root(true); ?>';
	var surveyconfig = <?php echo $this->testconfig; ?>;
	var reporting_url = '<?php echo JURI::base(); ?>index.php?option=com_dnagifts&view=report&id=';
</script>

<div id="notificationcontainer">
  <div id="notificationtab" style="display: none"></div>
</div>

<div id="dnaTestSpace" data="{userlanguage: '<?php echo DnagiftsHelper::getCurrentLanguageCode(); ?>'}">
	
	<!-- The top bar contains all the test controls -->
	<div id="dnaTopBar">
		<div id="dnaCountdown" style="display:none"></div>
		<div id="dnaMessages" style="display:none"></div>
		<div id="dnaInteractions" style="display:none">
			<span id="pauseTestContainer">
				<a id="dnaPauseButton" href="javascript:void(0)">PAUSE</a>
				<a id="dnaPlayButton" class="playbutton" href="javascript:void(0)" style="display:none">PLAY</a>
				<span class="dnaPauseDivider">&nbsp;/&nbsp;</span>
			</span>
			<a id="dnaPassButton" href="javascript:void(0)">PASS</a>
		</div>
		<div id="dnaProgress" style="display:none"></div>
		<div class="clr">&nbsp;</div>
	</div>
  
  
	<div id="dnaTestBody">
		<div id="dnaLoadingDiv" style="display: none">
			<img src="<?php echo JURI::root(true); ?>/media/com_dnagifts/images/loading.gif" width="100px" height="100px" style="margin: 25px 45%"/>
		</div>
	
		<div id="dnaPauseDiv">
			<a href="#" title="<?php echo JText::_($playmessage.'_TITLE'); ?>::<?php echo JText::_($playmessage); ?>"
				class="hasTip <?php echo $playbutton; ?>button" data="{test_id: <?php echo $this->test_id; ?>}"></a>
		</div>
		<div id="dnaQuestionText" style="display: none"></div>
	</div>
	
	
	<div id="startmessage"><?php echo JText::_($playmessage); ?></div>
	
	<div id="dnaButtonsBar" style="display:none">
		<table width="100%" height="100%">
			<tbody>
				<tr id="trButtons">
				<?php foreach($this->buttons as $i => $button): ?>
					<td width="<?php echo $this->buttonwidth; ?>%" align="center">
						<div class="dnaAnswerButton"><a title='The "<?php echo $button->button_text; ?>::<?php echo $button->button_hint; ?>" button'
							class="<?php echo $button->css_class; ?> btnAnswer hasTip" href="#" data="{answer: <?php echo $button->score; ?>}"><?php echo $button->button_text; ?></a></div>
					</td>
				<?php endforeach; ?>
				</tr>
			</tbody>
		</table>
	</div>
	
	<div class="clr">&nbsp;</div>
	
	<div id="dnaProgressBar" style="display:none">
		<div id="progresspercent"></div>
		<div id="progressbar"></div>
	</div>
	
	<div id="backButton" class="hasTip" title="<?php echo JText::_('COM_DNAGIFTS_TEST_SELECTPAGE'); ?>">
		<a href="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']) ?>"><?php echo JText::_('COM_DNAGIFTS_TEST_BACKBUTTON'); ?></a>
	</div>
	
</div>
