<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import joomla controller library
jimport('joomla.application.component.controller');

$document = JFactory::getDocument();
/**
* NOTE: Only add stylesheets and scripts here that are applicable multiple pages
* 		If the stylesheet or script is applicable to only page, add it to the
* 		view.html.php -> setDocument() function of the view
**/
// Stylesheets
$document->addStyleSheet(JURI::root(true).'/administrator/components/com_dnagifts/css/themes/base/jquery.ui.all.css');

// Javascripts
// - JQuery
$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/jquery-1.7.2.min.js');
$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/jquery.noconflict.js');
$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/jquery.metadata.js');

// - JQuery - UI
// -- core
// -- Interactions
// -- Widgets

// - Other
$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/Namespace.min.js');

// - DNA Gifts
$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/dnagifts.base.js');
$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/dnagifts.init.js');

 
// Get an instance of the controller prefixed by DnaGifts
$controller = JController::getInstance('DnaGifts');
 
// Perform the Request task
$controller->execute(JRequest::getCmd('task'));
 
// Redirect if set by the controller
$controller->redirect();