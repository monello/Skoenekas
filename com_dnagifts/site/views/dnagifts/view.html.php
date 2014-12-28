<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
JLoader::register('DnaGiftsHelper', JPATH_COMPONENT.'/helpers/dnagifts.php');

/**
 * HTML View class for the DnaGifts Component
 */
class DnaGiftsViewDnaGifts extends JView
{
	public function display($tpl = null) 
	{
		$result = $this->loadTemplate($tpl);
		if ($result instanceof Exception)
		{
			return $result;
		}

		echo $result;
		
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