<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

$this->isLoggedIn = DnaGiftsHelper::authenticate();
?>
<script type="text/javascript">
	var juri = '<?php echo JURI::root(true); ?>';
</script>
<?php
echo '<div id="dnaTestSpace">';
echo JText::_('COM_DNAGIFTS_TESTINTRO_HEAD');

echo '<span class="testlanguage">'.JText::_('COM_DNAGIFTS_TESTLANGUAGE').'</span>';
echo DnaGiftsHelper::loadLanguageSwitch();

// Login & Register buttons
echo $this->loadTemplate('auth');
if (!$this->isLoggedIn[0]) { return; }

/*
// Pretest Form
echo $this->loadTemplate('pretest');
if (!$this->hasPretestInfo) { return; }
*/

// Test Intro
echo $this->loadTemplate('testintro');
echo '</div>';
