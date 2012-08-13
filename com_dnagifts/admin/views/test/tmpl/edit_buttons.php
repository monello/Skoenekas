<?php
// No direct access.
defined('_JEXEC') or die;
//require_once JPATH_COMPONENT.'/helpers/dnagifts.php';
echo JHtml::_('sliders.panel', JText::_('COM_DNAGIFTS_TEST_BUTTONS_HEADER'), 'publishing-details');
$record_id = ($this->item->id) ? $this->item->id : -1;
?>
<fieldset class="panelform">
	<div id="select_buttons">
	
	<!-- Edit buttons modal -->
	<div id="edit-test-button" title="Update Button Details">
		<table width="100%">
			<tr>
				<td>Language:</td>
				<td>
					<select title="<?php echo JText::_('COM_DNAGIFTS_TEST_FIELD_LANGUAGE_LABEL');?>" id="language-edit" name="language-edit" class="inputbox">
						<option value="">- Select Language -</option>
						<?php echo JHtml::_('select.options', DnaGiftsHelper::getLanguageOptions(), 'value', 'text');?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Button:</td>
				<td>
					<select title="<?php echo JText::_('COM_DNAGIFTS_TEST_BUTTON_SELECT');?>" id="button_id-edit" name="button_id-edit" class="inputbox" disabled="true">
						<option value="">- Select Button -</option>
					</select>
				</td>
			</tr>
		</table>
	</div>
			
	<?php if ($this->item->id == 0): ?>
		<div id="system-message-container">
			<dl id="system-message">
				<dt class="notice">Notice</dt>
				<dd class="notice message">
					<ul>
						<li><?php echo JText::_('COM_DNAGIFTS_TEST_NOTICE_SAVE_BUTTONS'); ?></li>
					</ul>
				</dd>
			</dl>
		</div>
	<?php else: ?>
			<ul class="sortable">
				<?php foreach(DnaGiftsHelper::getCurrentButtons($record_id) as $i => $button): ?>
					<li id="test-button-<?php echo $button->id; ?>"
							data="{link_id: '<?php echo $button->id; ?>', test_id: '<?php echo $record_id; ?>', button_id: '<?php echo $button->value; ?>', language: '<?php echo $button->language; ?>'}"
							class="ui-state-default">
						<div class="buttonDetailsContainer">
							<a class="ui-icon ui-icon-arrowthick-2-n-s " title="Click and drag Button to new position" href="#" style="float:left">Drag Button</a>
							<div class="testButtonText"><?php echo $button->text; ?></div>
							<div class="testButtonLanguage">(<?php echo $button->language; ?>)</div>
						</div>
						<div class="actionButtonsContainer">
							<a class="ui-icon ui-icon-arrowthickstop-1-s actionBtn toBottomBtn"
									title="To Bottom" href="#" style="float:right">To Bottom</a>
							<a class="ui-icon ui-icon-arrowthick-1-s actionBtn downOneBtn"
									title="Down One" href="#" style="float:right">Down One</a>
							<a class="ui-icon ui-icon-arrowthick-1-n actionBtn upOneBtn"
									title="Up One" href="#" style="float:right">Up One</a>
							<a class="ui-icon ui-icon-arrowthickstop-1-n actionBtn toTopBtn"
									title="To Top" href="#" style="float:right">To Top</a>
							<strong class="actionButtonSpacer">&nbsp;</strong>
							<a class="ui-icon ui-icon-close actionBtn goDeleteBtn"
									title="Delete" href="#" style="float:right">Delete</a>
							<a class="ui-icon ui-icon-pencil actionBtn goEditBtn"
									title="Edit" href="#" style="float:right">Edit</a>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
	<?php endif; ?>
	</div>
	
	<?php if ($this->item->id > 0): ?>
	<div id="add_button">
		<select title="<?php echo JText::_('COM_DNAGIFTS_TEST_FIELD_LANGUAGE_LABEL');?>" id="language" name="language" class="inputbox">
			<option value="">- Select Language -</option>
			<?php echo JHtml::_('select.options', DnaGiftsHelper::getLanguageOptions(), 'value', 'text');?>
		</select>
		
		<select title="<?php echo JText::_('COM_DNAGIFTS_TEST_BUTTON_SELECT');?>" id="button_id" name="button_id" class="inputbox" disabled="true">
			<option value="">- Select Button -</option>
		</select>
		
		<input type="button" id="saveNewButton" data="{test_id: '<?php echo $record_id; ?>'}" value="<?php echo JText::_('COM_DNAGIFTS_SAVEBUTTON_TEXT');?>"/>
	</div>
	<?php endif; ?>
</fieldset>
