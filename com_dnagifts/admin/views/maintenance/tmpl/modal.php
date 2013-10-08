<?php
defined('_JEXEC') or die('Restricted Access');

JHtml::_('behavior.tooltip');
JLoader::register('MaintenanceHelper', JPATH_COMPONENT.'/helpers/maintenance.php');

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
$data = MaintenanceHelper::getMappedValues($this->type);
?>
<style>
table#mntTable tr:nth-child(even) {background: #ccc}
table#mntTable tr:nth-child(odd) {background: #fff}
</style>
<h2><?php echo $header; ?></h2>
<div id="mntReady">
<table id="mntTable" cellspacing="0" cellpadding="3">

<?php
	$counter = 1;
	foreach ( $data as $row ):
?>
    <tr>
		<td><?php echo $row->value; ?></td>
		<td><input type="text" id="mapped_<?php echo $counter; ?>" size="40"/></td>
		<td><input type="button" value="Save"/> <input type="button" value="Delete"/></td>
	</tr>
<?php 
	$counter++;
	endforeach; 
?>
</table>
</div>
