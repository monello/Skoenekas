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
		//$this->setDocument();
	}
	
	protected function setDocument() 
	{
		//$document = JFactory::getDocument();
		//$document->addStyleSheet('/administrator/components/com_dnagifts/css/themes/base/jquery.ui.all.css');
		//$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/jquery-1.7.2.min.js');
	}
}