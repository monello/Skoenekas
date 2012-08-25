<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the DnaGifts Component
 */
class DnaGiftsViewDnaGifts extends JView
{
	public function display($tpl = null) 
	{
		require_once JPATH_COMPONENT.'/helpers/dnagifts.php';
		
		$app				= JFactory::getApplication();
    $params    	= $app->getParams();
    $dispatcher	= JDispatcher::getInstance();
		
		// Get some data from the models
		$state			= $this->get('State');
		$this->form	= $this->get('Form');
		$this->item = $this->get('Item');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		// Display the template
		parent::display($tpl);
		
		// Set the document
		$this->setDocument();
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		
		/**
		 * NOTE: Only add stylesheets and scripts here that are applicable ONLY to
		 * 		this page. If it is needed on multiple pages add it to <base>/dnagifts.php
		**/
		// Stylesheets
		$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/dnagifts.css');
		// Javascripts
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.js');
	}
}