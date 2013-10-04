<?php
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.application.component.view');
 
class DnaGiftsViewMaintenance extends JView
{	
    function display($tpl = null) 
	{
		$type 	= JRequest::getVar('type');
		$this->assignRef( 'type', $type );
		parent::display($tpl);
	}
}