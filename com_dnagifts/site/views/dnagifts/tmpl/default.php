<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.tooltip');

$this->isLoggedIn = DnaGiftsHelper::authenticate();
$this->hasPretestInfo = DnagiftsHelper::hasPretestInfo();

echo '<div id="dnaTestSpace">';
echo '<span class="testlanguage">'.JText::_('COM_DNAGIFTS_TESTLANGUAGE').'</span>';
echo DnaGiftsHelper::loadLanguageSwitch();

// Login & Register buttons
echo $this->loadTemplate('auth');
if (!$this->isLoggedIn[0]) { return; }

echo JText::_('COM_DNAGIFTS_CLEARFLOAT');

// Pretest Form
echo $this->loadTemplate('pretest');
if (!$this->hasPretestInfo) { return; }

// Test Intro
echo $this->loadTemplate('testintro');
echo '</div>';
?>




