<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$document = JFactory::getDocument();

if (!$this->isLoggedIn[0]) {
  echo JText::_('COM_DNAGIFTS_CLEARFLOAT');
  echo JText::_('COM_DNAGIFTS_NOTLOGGEDIN');
  echo $this->isLoggedIn[1];
  return;
} else {
  $this->document->addStyleDeclaration('.btl-panel{display:none}');
  echo $this->isLoggedIn[1];
  $this->document->addScriptDeclaration("jQuery(document).ready(function () { jQuery('.btl-panel').attr('style', 'text-align: right').show();});");
}



