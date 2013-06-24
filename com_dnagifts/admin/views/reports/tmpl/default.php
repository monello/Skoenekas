<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

// load tooltip behavior
JHtml::_('behavior.tooltip');

?>
<script type="text/javascript">
	var juri = '<?php echo JURI::root(true); ?>/administrator';
</script>

<div id="reportswrapper">
	<a href="javascript:void(0)" class="reportblock">Country</a>
	<a href="javascript:void(0)" class="reportblock">Town</a>
	<a href="javascript:void(0)" class="reportblock">Church</a>
	<a href="javascript:void(0)" class="reportblock">Gender</a>
	<a href="javascript:void(0)" class="reportblock">Saved</a>
	<a href="<?php echo JRoute::_('index.php?option=com_dnagifts&view=report&type=results', false) ?>" class="reportblock">Results</a>
</div>