<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_DNAGIFTS_SEARCH_IN_TESTNAME'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">
			<select title="<?php echo JText::_('COM_DNAGIFTS_FILTER_BY_STATUS'); ?>" name="filter_status" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', DnaGiftsHelper::getTestStatusOptions(), 'value', 'text', $this->state->get('filter.status'));?>
			</select>
			<select title="<?php echo JText::_('COM_DNAGIFTS_FILTER_BY_TESTUSER'); ?>" name="filter_user_id" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', DnaGiftsHelper::getTestUserOptions(), 'value', 'text', $this->state->get('filter.user_id'));?>
			</select>
			
			<select title="<?php echo JText::_('COM_DNAGIFTS_FILTER_BY_TESTID'); ?>" name="filter_test_id" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', DnaGiftsHelper::getTestsDoneOptions(), 'value', 'text', $this->state->get('filter.test_id'));?>
			</select>
			
			<select title="<?php echo JText::_('COM_DNAGIFTS_FILTER_BY_PROGRESS'); ?>" id="filter_progress" name="filter_progress" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', DnaGiftsHelper::getTestProgressOptions(), 'value', 'text', $this->state->get('filter.progress'));?>
			</select>

		</div>
	</fieldset>
	<?php echo JText::_('COM_DNAGIFTS_CLEARFLOAT');