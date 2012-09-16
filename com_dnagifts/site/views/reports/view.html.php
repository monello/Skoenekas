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
		$model		= $this->getModel();
		$reports 	= $model->getUserReports();
		$this->assignRef( 'reports', $reports );
		
		if (count($this->reports) <= 0){
			$app = JFactory::getApplication();
			$app->redirect('/index.php?option=com_dnagifts');
		}
		
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
		$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/dnagifts.reports.css');
		
		// Javascripts
		//$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.test.js');
	}
}
