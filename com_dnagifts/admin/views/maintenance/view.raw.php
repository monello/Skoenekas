<?php
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.application.component.view');
 
class DnaGiftsViewMaintenance extends JView
{	
    function display($tpl = null) 
	{
		$type 	= JRequest::getVar('type');
		$done 	= JRequest::getVar('done', 0);
		$this->assignRef( 'type', $type );
		$this->assignRef( 'done', $done );
		parent::display($tpl);
	}
}