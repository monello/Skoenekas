<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Gifts View
 */
class DnaGiftsViewReports extends JView
{
	/**
	 * DnaGifts view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
		
		// Set the document
		$this->setDocument();
	}
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		
		// Stylesheets
		$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/dnagifts.reports.css');	
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('COM_DNAGIFTS_REPORTING_HEADING'), 'dnareports48x48');
	}
}