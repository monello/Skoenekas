<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');

if ($this->progress['inprogress']) {
  $playmessage = 'COM_DNAGIFTS_TEST_CONTINUEMESSAGE';
  $playbutton = 'pause';
} else {
  $playmessage = 'COM_DNAGIFTS_TEST_STARTMESSAGE';
  $playbutton = 'play';
}
?>

<script type="text/javascript">
var surveyconfig = <?php echo $this->testconfig; ?>;
var surveydata = <?php echo $this->surveydata; ?>;
var user_test_id = <?php echo $this->user_test_id; ?>;
</script>

<div id="dnaTestSpace" data="{userlanguage: '<?php echo DnagiftsHelper::getCurrentLanguageCode(); ?>'}">
  <div id="dnaTopBar">
    <div id="dnaCountdown" style="display:none"></div>
    <div id="dnaMessages" style="display:none"></div>
    <div id="dnaInteractions" style="display:none">
      <a id="dnaPauseButton" href="javascript:void(0)">PAUSE</a>
      <a id="dnaPlayButton" class="playbutton" href="javascript:void(0)" style="display:none">PLAY</a>
      <span class="dnaPauseDivider">&nbsp; | &nbsp;</span>
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
        <a href="&nbsp;<?php echo JText::_($playmessage); ?>" title="<?php echo JText::_($playmessage.'_TITLE'); ?>"
            class="hasTip playbutton" data="{test_id: <?php echo $this->testid; ?>}"><img src="<?php echo JURI::root(true); ?>/media/com_dnagifts/images/<?php echo $playbutton; ?>.png" width="100px" height="100px" style="display:block; margin: 25px -40%"/></a>
      
    </div>
    <div id="dnaQuestionText" style="display: none"></div>
  </div>
  <div id="startmessage"><em><?php echo JText::_($playmessage); ?></em></div>
  <div id="dnaButtonsBar" style="display:none">
    <table width="100%" height="100%">
      <tbody>
        <tr id="trButtons">
          <?php foreach($this->buttons as $i => $button): ?>
          <td width="<?php echo $this->buttonwidth; ?>%" align="center"><div class="dnaAnswerButton"><a title='The "<?php echo $button->button_text; ?>" button'
              class="<?php echo $button->css_class; ?> btnAnswer hasTip" href="&nbsp;<?php echo $button->button_hint; ?>" data="{answer: <?php echo $button->score; ?>}"><?php echo $button->button_text; ?></a></div></td>
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
  <div id="postTestHome" style="display:none">
    <a href="<?php echo JURI::base() ?>"><?php echo jText::_('COM_DNAGIFTS_TEST_HOMEPAGE'); ?></a>
  </div>
  <div id="backButton" class="hasTip" title="<?php echo jText::_('COM_DNAGIFTS_TEST_SELECTPAGE'); ?>">
    <a href="<?php echo htmlspecialchars($_SERVER['HTTP_REFERER']) ?>"><?php echo jText::_('COM_DNAGIFTS_TEST_BACKBUTTON'); ?></a>
  </div>
</div>
