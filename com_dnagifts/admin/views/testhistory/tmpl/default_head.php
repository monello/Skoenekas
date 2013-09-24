<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="15%" style="text-align:left">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_TESTSHIST_HEADING_USERNAME', 'user_id', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="15%" style="text-align:left">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_TESTSHIST_HEADING_TESTNAME', 'test_id', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="7%">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_TESTSHIST_HEADING_PROGRESS', 'progress', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="15%">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_TESTSHIST_HEADING_DATE', 'started_datetime', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="5%">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_TESTSHIST_HEADING_STATUS', 'status', $this->listDirn, $this->listOrder); ?>
	</th>
	<th style="text-align:left">
		<?php echo JHtml::_('grid.sort', 'COM_DNAGIFTS_TESTSHIST_HEADING_REPORT', 'report_name', $this->listDirn, $this->listOrder); ?>
	</th>
	<th width="1%" class="nowrap">
		<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'id', $this->listDirn, $this->listOrder); ?>
	</th>
</tr>