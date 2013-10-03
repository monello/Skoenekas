<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');
JHTML::_('behavior.modal');

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
.incompleteicon { background-position: 1px 0px }
.incompletelessicon { background-position: 236px 0px }
.noreporticon { background-position: 62px 0px }
.extraanswersicon { background-position: 100px 0px }

.progresstext { font-weight: bold; font-size: 110% }
.goodstatus	{ color: #0c7112 }
.incompletestatus { color: #0000CC }
.incompletelessstatus { color: #FFFF00 }
.noreportstatus { color: rgb(176,0,0) }
.extraanswersstatus { color: rgb(255,137,17) }

a.viewreport,
a.pdfreport,
a.reviewreport,
a.emailreport {
	display: inline-block; 
	height: 24px;
	width: 24px;
	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";
	filter: alpha(opacity=40);
	-moz-opacity:0.4;
	-khtml-opacity: 0.4;
	opacity: 0.4;
}
a.viewreport:hover,
a.pdfreport:hover,
a.reviewreport:hover,
a.emailreport:hover {
	-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=100);
	-moz-opacity:1;
	-khtml-opacity: 1;
	opacity: 1;
}
a.viewreport { background-image: url(<?php echo JURI::root(true) ?>/media/com_dnagifts/images/view-report24x24.png);}
a.pdfreport { background-image: url(<?php echo JURI::root(true) ?>/media/com_dnagifts/images/1347795839_pdf.png);}
a.reviewreport { background-image: url(<?php echo JURI::root(true) ?>/media/com_dnagifts/images/reports-22x22.png);}
a.emailreport { background-image: url(<?php echo JURI::root(true) ?>/media/com_dnagifts/images/emailIcon24x24.png);}

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