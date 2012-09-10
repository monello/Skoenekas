<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the DnaGifts Component
 */
class DnaGiftsViewReports extends JView
{
	/**
	 * display method of DNAGIFT view
	 * @return void
	 */
	public function display($tpl=null) 
	{
		
		
		// Display the template
		parent::display();
		
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
		
		/**
		 * NOTE: Only add stylesheets and scripts here that are applicable ONLY to
		 * 		this page. If it is needed on multiple pages add it to <base>/dnagifts.php
		**/
		// Stylesheets
		//$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/dnagifts.test.css');
		
		// Javascripts
		//$document->addScript(JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.effects.core.min.js');
		//$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.test.js');
	}
}