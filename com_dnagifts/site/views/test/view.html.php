<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the DnaGifts Component
 */
class DnaGiftsViewTest extends JView
{
	/**
	 * display method of DNAGIFT view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		/**
		* The entite test is handled by ajax from here onward.
		*  So I will not be loading the forms through normal Joomla functions
		**/
		
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
		
		/**
		 * NOTE: Only add stylesheets and scripts here that are applicable ONLY to
		 * 		this page. If it is needed on multiple pages add it to <root>/dnagifts.php
		**/
		// Stylesheets
		$document->addStyleSheet(JURI::root(true).'/components/com_dnagifts/css/dnagifts.test.css');
		
		// Javascripts
		$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/ui/jquery.effects.core.min.js');
		$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.widget.min.js');
		$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.progressbar.min.js');
		$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/jquery.countdown.min.js');
		$document->addScript(JURI::root(true).'/components/com_dnagifts/js/temp.surveydata.js');
		$document->addScript(JURI::root(true).'/components/com_dnagifts/js/dnagifts.test.countdown.js');
		$document->addScript(JURI::root(true).'/components/com_dnagifts/js/dnagifts.test.js');
	}
}