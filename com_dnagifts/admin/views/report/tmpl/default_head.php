<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="1%">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>
	<th width="5%">
		<?php echo JHtml::_('grid.sort',  'JSTATUS', 'published', $this->listDirn, $this->listOrder); ?>
	</th>
	
	<th width="10%" style="text-align:left">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_ANSWER_HEADING_BUTTONNAME', 'button_name', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="10%" style="text-align:left">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_ANSWER_HEADING_BUTTONTEXT', 'button_text', $this->listDirn, $this->listOrder); ?>
	</th>
	<th style="text-align:left">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_ANSWER_HEADING_DESCRIPTION', 'description', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="5%" class="nowrap">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_ANSWER_HEADING_SCORE', 'score', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="10%" style="text-align:left">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_ANSWER_HEADING_CSSCLASS', 'css_class', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="5%">
		<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_LANGUAGE', 'language', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="10%">
		<?php echo JHtml::_('grid.sort', 'JDATE', 'created', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="10%">
		<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'ordering', $this->listDirn, $this->listOrder); ?>
		<?php if ($this->saveOrder) :?>
			<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'answers.saveorder'); ?>
		<?php endif; ?>
	</th>
	<th width="1%" class="nowrap">
		<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id', $this->listDirn, $this->listOrder); ?>
	</th>
</tr>