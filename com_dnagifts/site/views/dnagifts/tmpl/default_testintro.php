<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
$model = $this->getModel('dnagifts');

?>
<?php echo JText::_('COM_DNAGIFTS_TESTINTRO_HEAD'); ?>

<table width="100%" id="introtable"><tbody>
  <tr>
    <td valign="top"><img src="<?php echo JText::_('COM_DNAGIFTS_TESTINTRO_ANIMATION_PATH'); ?>" class="introanimation"/></td>
    <td><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_BLURB'); ?></td>
  </tr>

<?php if ((int) DnagiftsHelper::hasCompletedTests() > 0): ?>
  <tr>
    <td colspan=2><p><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_TESTSDONETEXT'); ?><a href="<?php echo JRoute::_('index.php?option=com_dnagifts&view=reports', false) ?>"><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_YOURRESULTS'); ?></a></p></td>
  </tr>
<?php endif; ?>

</tbody></table>

<?php
if (!$model->countActiveTests()) {
  echo JText::_('COM_DNAGIFTS_TESTINTRO_HEAD_NOTESTS');
  return;
}
echo JText::_('COM_DNAGIFTS_TESTINTRO_PICKTEST');
$activeTests = $model->getAllActiveTests();
?>

<?php if (count($activeTests)): ?>

  <table width="100%" id="picktesttable"><thead>
      <tr>
        <th width="30%"><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_TABLE_COL_DESCRIPTION'); ?></th>
        <th><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_TABLE_COL_REASON'); ?></th>
        <th width="10%" align="center"><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_TABLE_COL_QUESTION'); ?></th>
        <th width="10%" align="center"><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_TABLE_COL_DURATION'); ?></th>
        <th width="10%" align="center">&nbsp;</th>
      </tr>
    </thead>  
    <tbody>
      <?php foreach($activeTests as $i => $test): ?>
      <?php
        $user_test_id = DnagiftsHelper::getUserTestID( $test->test_id );
        $progress = DnagiftsHelper::getUserProgress( $user_test_id, $test->test_id );
      ?>
      <tr valign="top">
        <td><?php echo $test->test_description; ?></td>
        <td><?php echo $test->test_reason; ?></td>
        <td align="center"><?php echo $test->howmany; ?></td>
        <td align="center">
        <?php if ((int) $test->test_duration > 0):
            echo $test->test_duration . " min";
          else:
            echo '<em style="color: LightGrey">' . JText::_('COM_DNAGIFTS_TESTINTRO_NODURATION') . '</em>';
        endif; ?>
        </td>
        <td align="center">
          <?php if ($progress['inprogress']): ?>
            <a href="<?php echo JRoute::_('index.php?option=com_dnagifts&view=test&id='.$test->test_id, false) ?>" class="doTestButton">
            <span title="<?php echo JText::sprintf('COM_DNAGIFTS_TESTINTRO_PROGRESS_PERCENT', $progress['percent']); ?>::<?php echo JText::sprintf('COM_DNAGIFTS_TESTINTRO_PROGRESS_QUESTIONS', $progress['answers'], $progress['howmany']); ?>"
                href="#"
                class="hasTip"><?php echo $progress['percent']; ?>%</span>
            </a>
          <?php else: ?>
            <?php 
            if ((int) $progress['percent'] >= 100): 
            ?>
              <img src="<?php echo JURI::root(true); ?>/media/com_dnagifts/images/tinycheck.png"
                height="16px"
                width="16px"
                alt="<?php echo JText::_('COM_DNAGIFTS_TESTINTRO_DONE_BUTTON'); ?>"
                title="<?php echo JText::_('COM_DNAGIFTS_TESTINTRO_DONE_BUTTON'); ?>"
                class="hasTip"/>
            <?php else: ?>
              <a href="<?php echo JRoute::_('index.php?option=com_dnagifts&view=test&id='.$test->test_id, false) ?>" class="doTestButton">
              <img src="<?php echo JURI::root(true); ?>/media/com_dnagifts/images/play-small.png"
                height="16px"
                width="16px"
                alt="<?php echo JText::_('COM_DNAGIFTS_TESTINTRO_STARTTEST_BUTTON'); ?>"
                title="<?php echo JText::_('COM_DNAGIFTS_TESTINTRO_STARTTEST_BUTTON'); ?>"
                class="hasTip"/>
              </a>
            <?php endif; ?>
          <?php endif; ?>
        </td>
        
      </tr>
      <?php endforeach; ?>
  </tbody></table>
  
<?php else: ?>

  <em><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_STARTTEST_NOTESTS'); ?></em>

<?php endif; ?>
