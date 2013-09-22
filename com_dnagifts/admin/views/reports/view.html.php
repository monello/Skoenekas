<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
require_once JPATH_COMPONENT.'/helpers/dnagifts.php';
 
/**
 * Reports View
 */
class DnaGiftsViewReports extends JView
{	
    protected $healthData;
	
	/**
	 * DnaGifts view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		$this->healthData = DnagiftsHelper::getHealhCheckData();
		
		// Set the toolbar
		$this->addToolBar();
		
		// Display the template
		parent::display($tpl);
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{	
		JToolBarHelper::title(JText::_('COM_DNAGIFTS_REPORTING_HEADING'), 'dnareports48x48');
	}
	
}