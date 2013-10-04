<?php
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.application.component.view');
 
class DnaGiftsViewMaintenance extends JView
{	
    function display($tpl = null) 
	{
		$this->addToolBar();
		parent::display($tpl);
		$this->setDocument();
	}
	
	protected function addToolBar() 
	{	
		JToolBarHelper::title(JText::_('COM_DNAGIFTS_MAINTENANCE_HEADING'), 'dnamaintenance48x48');
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/dnagifts.maintenance.css');
	}
}