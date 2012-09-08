<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the DnaGifts Component
 */
class DnaGiftsViewReport extends JView
{
	public function display($tpl = null) 
	{	
		$app		= JFactory::getApplication();
	    $params    	= $app->getParams();
    	$dispatcher	= JDispatcher::getInstance();
		
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$html = $this->loadTemplate($tpl);
		if ($html instanceof Exception)
		{
			return $html;
		}

		//echo $html;
		
		
		DnagiftsHelper::generatepdf('Morne Louw', 'DNA Gifts - Report',
				'Test Results', 'DNA Gifts, Free Test',
				'results001', $html, 'I');
		
		
		// Set the document
		$this->setDocument();
	}
	
	protected function setDocument() 
	{
//		$document = JFactory::getDocument();
	}
}