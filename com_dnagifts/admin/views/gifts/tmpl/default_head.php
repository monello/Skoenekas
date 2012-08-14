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
	<th width="5%" style="text-align:left">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_GIFTS_HEADING_CODE', 'code', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="7%" style="text-align:left">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_GIFTS_HEADING_NAME', 'name', $this->listDirn, $this->listOrder); ?>
	</th>
	<th style="text-align:left">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_GIFTS_HEADING_DESCRRIPTION', 'description', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="5%" class="nowrap">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_GIFTS_HEADING_COLORHEX', 'color_hex', $this->listDirn, $this->listOrder); ?>
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
			<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'gifts.saveorder'); ?>
		<?php endif; ?>
	</th>
	<th width="1%" class="nowrap">
		<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id', $this->listDirn, $this->listOrder); ?>
	</th>
</tr>