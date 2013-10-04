<?php
defined('_JEXEC') or die('Restricted Access');

JHtml::_('behavior.tooltip');

?>
ALTERNATIVE TEMPLATE<br/>
<?php
if ($this->type == "church") {
	echo "TYPE: CHURCH";
} else if ($this->type == "pastor") {
	echo "TYPE: PASTOR";
} else if ($this->type == "city") {
	echo "TYPE: CITY";
} else {
	echo "TYPE: UNKNOWN";
}
?>
<h2>Page still under construction</h2>