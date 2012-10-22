<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
$user	= JFactory::getUser();
$this->listOrder	= $this->escape($this->state->get('list.ordering'));
$this->listDirn	= $this->escape($this->state->get('list.direction'));
$this->saveOrder	= $this->listOrder == 'ordering';

?>
<script type="text/javascript">
	var juri = '<?php echo JURI::root(true); ?>/administrator';
</script>
<form action="<?php echo JRoute::_('index.php?option=com_dnagifts&view=gifts'); ?>" method="post" name="adminForm" id="adminForm">
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