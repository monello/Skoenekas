<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
$model = $this->getModel('dnagifts');
?>
<?php echo JText::_('COM_DNAGIFTS_TESTINTRO_HEAD'); ?>

<table width="100%" id="introtable"><tbody><tr>
    <td valign="top"><img src="<?php echo JText::_('COM_DNAGIFTS_TESTINTRO_ANIMATION_PATH'); ?>" class="introanimation"/></td>
    <td><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_BLURB'); ?></td>
</tr></tbody></table>

<?php echo JText::_('COM_DNAGIFTS_TESTINTRO_PICKTEST'); ?>

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
    <?php foreach($model->getAllActiveTests() as $i => $test): ?>
    <tr valign="top">
      <td><?php echo $test->test_description; ?></td>
      <td><?php echo $test->test_reason; ?></td>
      <td align="center"><?php echo $test->howmany; ?></td>
      <td align="center">
      <?php if ((int) $test->test_duration > 0):
          echo $test->test_duration . " min";
        else:
          echo "&nbsp;";
      endif; ?>
      </td>
      <td align="center"><a href="<?php echo JRoute::_('index.php?option=com_dnagifts&view=test&id='.$test->test_id, false) ?>" class="doTestButton"><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_STARTTEST_BUTTON'); ?></a></td>
    </tr>
    <?php endforeach; ?>
</tbody></table>
