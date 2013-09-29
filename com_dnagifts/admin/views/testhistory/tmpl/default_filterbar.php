<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search">Filter by User Name: </label>
			<input type="text" class="hasTip" name="filter_search" id="filter_search" 
				value="<?php echo $this->escape($this->state->get('filter.search')); ?>" 
				title="<?php echo JText::_('COM_DNAGIFTS_SEARCH_IN_TESTNAME'); ?>" />
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
			
			<select title="<?php echo JText::_('COM_DNAGIFTS_FILTER_BY_BROWSER'); ?>" id="filter_browser" name="filter_browser" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', DnaGiftsHelper::getUserBrowserOptions(), 'value', 'text', $this->state->get('filter.browser'));?>
			</select>
			
			<select title="<?php echo JText::_('COM_DNAGIFTS_FILTER_BY_PLATFORM'); ?>" id="filter_platform" name="filter_platform" class="inputbox" onchange="this.form.submit()">
				<?php echo JHtml::_('select.options', DnaGiftsHelper::getUserPlatformOptions(), 'value', 'text', $this->state->get('filter.platform'));?>
			</select>

		</div>
	</fieldset>
	<?php echo JText::_('COM_DNAGIFTS_CLEARFLOAT');