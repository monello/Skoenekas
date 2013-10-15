<?php
defined('_JEXEC') or die('Restricted Access');

JHtml::_('behavior.tooltip');

switch ($this->type) {
	case "church_name":
		$header = "Maintain the Church Name List";
		break;
	case "pastor_reverend":
		$header = "Maintain the Pastor Name List";
		break;
	case "your_city":
		$header = "Maintain the Citiess List";
		break;
}

?>
<link rel="stylesheet" href="<?php echo JURI::base(true); ?>/components/com_dnagifts/css/themes/base/jquery.ui.all.css" type="text/css">
<link rel="stylesheet" href="<?php echo JURI::base(true); ?>/components/com_dnagifts/css/dnagifts.maintenance.modal.css" type="text/css">

<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/jquery.noconflict.js" type="text/javascript"></script>
<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/jquery.metadata.js" type="text/javascript"></script>
<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/ui/jquery.ui.core.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/ui/jquery.ui.widget.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/ui/jquery.ui.position.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/ui/jquery.ui.autocomplete.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/ui/jquery.ui.menu.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/Namespace.min.js" type="text/javascript"></script>
<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/dnagifts.base.js" type="text/javascript"></script>
<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/dnagifts.init.js" type="text/javascript"></script>
<script src="<?php echo JURI::base(true); ?>/components/com_dnagifts/js/dnagifts.maintenance.js" type="text/javascript"></script>
<script type="text/javascript">
	var juri = '<?php echo JURI::root(true); ?>/administrator';
	var autoSuggestData = <?php echo json_encode($this->autoSuggestData); ?>;
</script>

<h2><?php echo $header; ?></h2>
<div id="mntReady">
<table id="mntTable" cellspacing="0" cellpadding="3">

<?php
	$counter = 1;
	foreach ( $this->data as $row ):
?>
    <tr id="tr_<?php echo $counter; ?>">
		<td><?php echo $row->value; ?></td>
		<td>
			<input type="text" class="autocomplete" id="mapped_<?php echo $counter; ?>" size="40"/>
		</td>
		<td>
			<input type="button" class="saveBtn" value="Save" 
				data="{value: '<?php echo $row->value; ?>', counter: <?php echo $counter; ?>, fieldtype: '<?php echo $this->type; ?>'}"/>
			<input type="button" class="deleteBtn" value="Delete" 
				data="{value: '<?php echo $row->value; ?>', counter: <?php echo $counter; ?>, fieldtype: '<?php echo $this->type; ?>'}"/>
		</td>
	</tr>
<?php 
	$counter++;
	endforeach; 
?>
</table>
</div>
