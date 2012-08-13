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
      <th width="40%"><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_TABLE_COL_DESCRIPTION'); ?></th>
      <th width="30%"><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_TABLE_COL_REASON'); ?></th>
      <th width="10%"><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_TABLE_COL_QUESTION'); ?></th>
      <th width="10%"><?php echo JText::_('COM_DNAGIFTS_TESTINTRO_TABLE_COL_DURATION'); ?></th>
      <th width="10%">&nbsp;</th>
    </tr>
  </thead>  
  <tbody>
    <?php foreach($model->getAllActiveTests() as $i => $test): ?>
    <tr valign="top">
      <td><?php echo $test->test_description; ?></td>
      <td><?php echo $test->test_reason; ?></td>
      <td>XXX</td>
      <td>777min</td>
      <td>Button</td>
    </tr>
    <?php endforeach; ?>
</tbody></table>