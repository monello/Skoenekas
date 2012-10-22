<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<script type="text/javascript">
	var juri = '<?php echo JURI::root(true); ?>/administrator';
</script>
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
		
	<div id="imagesContainer">
		<div id="imagesContainer-characters">
			<img src="<?php echo JURI::root(true); ?>$/media/com_dnagifts/images/characters/<?php echo $this->item->characters_image; ?>" alt="Please select an image from the 'Character Image' select list on the left"/>
		</div>
		<p>Character Image</p>
		<div id="imagesContainer-text">
			<img src="<?php echo JURI::root(true); ?>/media/com_dnagifts/images/text/<?php echo $this->item->text_image; ?>" alt="Please select an image from the 'Text Image' select list on the left"/>
		</div>
		<p>Text Image</p>
		<?php echo JText::_('COM_DNAGIFTS_CLEARFLOAT'); ?>
	</div>

	</fieldset>
	<div>
		<input type="hidden" name="task" value="gift.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
