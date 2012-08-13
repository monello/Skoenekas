<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_DNAGIFTS_SEARCH_IN_QUESTIONCODE'); ?>" />
			<button type="submit"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
		<div class="filter-select fltrt">
			<select title="<?php echo JText::_('COM_DNAGIFTS_FILTER_BY_QUESTIONSTATUS'); ?>" name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.state'), true);?>
			</select>
			
			<select title="<?php echo JText::_('COM_DNAGIFTS_FILTER_BY_GIFTID');?>" name="filter_gift_id" class="inputbox" onchange="this.form.submit()">
				<option value="">- Select Gift Code -</option>
				<?php echo JHtml::_('select.options', DnaGiftsHelper::getGiftOptions(), 'value', 'text', $this->state->get('filter.gift_id'));?>
			</select>
			
			<select title="<?php echo JText::_('COM_DNAGIFTS_FILTER_BY_QUESTIONLANGUAGE'); ?>" name="filter_language" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('JOPTION_SELECT_LANGUAGE');?></option>
				<?php echo JHtml::_('select.options', DnaGiftsHelper::getLanguageOptions(), 'value', 'text', $this->state->get('filter.language'));?>
			</select>

		</div>
	</fieldset>
	<?php echo JText::_('COM_DNAGIFTS_CLEARFLOAT');