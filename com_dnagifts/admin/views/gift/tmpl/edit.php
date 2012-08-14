<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_dnagifts&layout=edit&id='.(int) $this->item->id); ?>"
      method="post" name="adminForm" id="gift-form">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'COM_DNAGIFTS_GIFT_LEGEND_DETAILS' ); ?></legend>
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
	<div>
		<input type="hidden" name="task" value="gift.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>