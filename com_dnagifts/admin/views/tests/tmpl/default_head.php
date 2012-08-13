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
	<th width="15%" style="text-align:left">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_TESTS_HEADING_TESTNAME', 'test_name', $this->listDirn, $this->listOrder); ?>
	</th>
	<th style="text-align:left">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_TESTS_HEADING_TESTDESCRIPTION', 'test_description', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="5%">
		<?php echo JHtml::_('grid.sort', 'JGLOBAL_HITS', 'hits', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="5%">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_TESTS_HEADING_COMPLETE', 'complete', $this->listDirn, $this->listOrder); ?>
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
			<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'tests.saveorder'); ?>
		<?php endif; ?>
	</th>
	<th width="1%" class="nowrap">
		<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id', $this->listDirn, $this->listOrder); ?>
	</th>
</tr>