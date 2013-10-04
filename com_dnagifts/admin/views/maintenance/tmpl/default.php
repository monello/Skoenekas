<?php
defined('_JEXEC') or die('Restricted Access');

JHtml::_('behavior.tooltip');
JHTML::_('behavior.modal');

$churchtip = "Church Values::Click here to clean up and maintain the list of church names";
$pastortip = "Pastor/Minister Values::Click here to clean up and maintain the list of pastor/minister names";
$citytip = "City Values::Click here to clean up and maintain the list of city names";
?>
<a id="churchBtn" 
	title="<?php echo $churchtip ?>"
	href="<?php JURI::root(true) ?>/administrator/index.php?option=com_dnagifts&format=raw&view=maintenance&layout=alt&type=church"
	class="hasTip maintain modal" 
	rel="{size: {x: 1000, y: 550}, handler: 'iframe'}"><span class="maintainLbl">Church Names</span></a>
	
<a id="pastorBtn" 
	title="<?php echo $pastortip ?>" 
	href="<?php JURI::root(true) ?>/administrator/index.php?option=com_dnagifts&format=raw&view=maintenance&layout=alt&type=pastor"
	class="hasTip maintain modal" 
	rel="{size: {x: 1000, y: 550}, handler: 'iframe'}"><span class="maintainLbl">Pastor/Minister Names</span></a>
	
<a id="cityBtn" 
	title="<?php echo $citytip ?>" 
	href="<?php JURI::root(true) ?>/administrator/index.php?option=com_dnagifts&format=raw&view=maintenance&layout=alt&type=city"
	class="hasTip maintain modal" 
	rel="{size: {x: 1000, y: 550}, handler: 'iframe'}"><span class="maintainLbl">City/Town Names</span></a>
