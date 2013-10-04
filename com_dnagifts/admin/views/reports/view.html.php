<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
require_once JPATH_COMPONENT.'/helpers/dnagifts.php';

class DnaGiftsViewReports extends JView
{	
    protected $healthData;

	function display($tpl = null) 
	{
		$this->healthData = DnagiftsHelper::getHealhCheckData();
		$this->addToolBar();
		parent::display($tpl);
		$this->setDocument();
	}

	protected function addToolBar() 
	{	
		JToolBarHelper::title(JText::_('COM_DNAGIFTS_REPORTING_HEADING'), 'dnareports48x48');
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/dnagifts.reports.css');
	}
}