<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$buttonwidth = 16;
?>

<script type="text/javascript">
<?php echo $this->survey_data; ?>
</script>

<div id="dnaTestSpace" data="{userlanguage: '<?php echo DnagiftsHelper::getCurrentLanguageCode(); ?>'}">
  <div id="dnaTopBar">
    <div id="dnaCountdown" style="display:none"></div>
    <div id="startmessage"><em><?php echo JText::_('COM_DNAGIFTS_TEST_STARTMESSAGE'); ?></em></div>
    <div id="dnaInteractions" style="display:none">
      <a id="dnaPauseButton" href="javascript:void(0)">PAUSE</a>
      <a id="dnaPlayButton" class="playbutton" href="javascript:void(0)" style="display:none">PLAY</a>
      <span class="dnaPauseDivider">&nbsp; | &nbsp;</span>
      <a id="dnaPassButton" href="javascript:void(0)">PASS</a>
      <span class="dnaPauseDivider">&nbsp; | &nbsp;</span>
      <a id="dnaStopButton" href="javascript:void(0)">STOP</a>
    </div>
    <div id="dnaProgress" style="display:none"></div>
    <div class="clr">&nbsp;</div>
  </div>
  <div id="dnaTestBody">
    <div id="dnaLoadingDiv" style="display: none">
        <img src="/media/com_dnagifts/images/loading.gif" width="100px" height="100px" style="margin: 25px 45%"/>
    </div>
    <div id="dnaPauseDiv">
        <a href="javascript:void(0)" class="playbutton"><img src="/media/com_dnagifts/images/play.png" width="100px" height="100px" style="margin: 25px 45%"/></a>
    </div>
    <div id="dnaQuestionText" style="display: none">
        Question Text will go here
    </div>
  </div>
  <div id="dnaButtonsBar" style="display:none">
    <table width="100%" height="100%">
      <tbody>
        <tr>
          
      <td width="<?php echo $buttonwidth; ?>%"><div class="dnaAnswerButton"><a class="btnNever btnAnswer" href="#" data="{answer: -1}">Never</a></div></td>
      <td width="<?php echo $buttonwidth; ?>%"><div class="dnaAnswerButton"><a class="btnSeldom btnAnswer" href="#" data="{answer: 1}">Seldom</a></div></td>
      <td width="<?php echo $buttonwidth; ?>%"><div class="dnaAnswerButton"><a class="btnUsually btnAnswer" href="#" data="{answer: 3}">Usually</a></div></td>
      <td width="<?php echo $buttonwidth; ?>%"><div class="dnaAnswerButton"><a class="btnMosty btnAnswer" href="#" data="{answer: 4}">Mostly</a></div></td>
      <td width="<?php echo $buttonwidth; ?>%"><div class="dnaAnswerButton"><a class="btnAlways btnAnswer" href="#" data="{answer: 5}">Always</a></div></td>
      
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
    <a href="<?php echo JURI::root(true) ?>"><?php echo jText::_('COM_DNAGIFTS_TEST_HOMEPAGE'); ?></>
  </div>
</div>
