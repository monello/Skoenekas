<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_dnagifts&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm" id="test-form">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
			<legend><?php echo JText::_( 'COM_DNAGIFTS_TEST_LEGEND_DETAILS' ); ?></legend>
			<ul class="adminformlist">
	<?php foreach($this->form->getFieldset() as $field): ?>
				<li><?php echo $field->label;
					if (preg_match('/mce_editable/i', $field->input)) {
						echo JText::_('COM_DNAGIFTS_CLEARFLOAT');
					}
					echo $field->input;?>
				</li>
	<?php endforeach; ?>
			</ul>
		</fieldset>
	</div>
	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start', 'weblink-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
		<?php echo $this->loadTemplate('config'); ?>
		<?php echo $this->loadTemplate('buttons'); ?>
		<?php echo $this->loadTemplate('questions'); ?>
		<?php echo JHtml::_('sliders.end'); ?>
	</div>
	<div>
		<input type="hidden" name="task" value="test.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>