<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');

$this->listOrder	= $this->escape($this->state->get('list.ordering'));
$this->listDirn		= $this->escape($this->state->get('list.direction'));
$this->saveOrder	= $this->listOrder == 'ordering';

?>
<script type="text/javascript">
	var juri = '<?php echo JURI::root(true); ?>/administrator';
</script>
<style>
select#filter_progress { text-align:right; }
div.statusicon {
	display: inline-block;
	height: 24px;
	width: 24px;
	background-image: url(<?php echo JURI::root(true) ?>/media/com_dnagifts/images/status-icons.png);
}
.goodicon { background-position: 175px 0px }
.incompleteicon { background-position: 137px 0px }
.noreporticon { background-position: 62px 0px }
.extraanswersicon { background-position: 100px 0px }

.progresstext { font-weight: bold; font-size: 110% }
.goodstatus	{ color: rgb(3,122,11) }
.incompletestatus { color: rgb(104,104,104)  }
.noreportstatus { color: rgb(176,0,0) }
.extraanswersstatus { color: rgb(255,137,17) }

a.viewreport {
	display: block; 
	height: 24px;
	width: 24px;
	background-image: url(<?php echo JURI::root(true) ?>/media/com_dnagifts/images/view-report24x24.png);
}
</style>
<form action="<?php echo JRoute::_('index.php?option=com_dnagifts&view=testhistory'); ?>" method="post" name="adminForm" id="adminForm">
	<?php echo $this->loadTemplate('filterbar');?>
	<table class="adminlist">
		<thead><?php echo $this->loadTemplate('head');?></thead>
		<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
		<tbody><?php echo $this->loadTemplate('body');?></tbody>
	</table>
	<div>
		<input type="hidden" name="filter_order" value="<?php echo $this->listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $this->listDirn; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>