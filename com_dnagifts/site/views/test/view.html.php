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
	protected $survey_data;
	
	public function display($tpl=null) 
	{
		$test_id = JRequest::getVar( 'id', 0 );
		
		$model 				= $this->getModel();
		$buttons			= $model->getTestButtons( $test_id );
		$config 			= $model->getTestConfig( $test_id );
		$user_test_id = DnaGiftsHelper::getUserTestID( $test_id );
		$data 				= $model->getTestData( $test_id, $user_test_id );
		$progress 		= DnagiftsHelper::getUserProgress( $user_test_id, $test_id );
		
		$buttonwidth  = floor(100 / count($buttons));
		
		$this->assignRef( 'testid', $test_id );
		$this->assignRef( 'user_test_id', $user_test_id );
		$this->assignRef( 'buttons', $buttons );
    $this->assignRef( 'surveydata', $data );
		$this->assignRef( 'testconfig', $config );
		$this->assignRef( 'buttonwidth', $buttonwidth );
		$this->assignRef( 'progress', $progress );
		
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
		 * 		this page. If it is needed on multiple pages add it to <root>/dnagifts.php
		**/
		// Stylesheets
		$document->addStyleSheet(JURI::root(true).'/components/com_dnagifts/css/dnagifts.test.css');
		
		// Javascripts
		$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/ui/jquery.effects.core.min.js');
		$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.widget.min.js');
		$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.progressbar.min.js');
		$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/jquery.countdown.min.js');
		//$document->addScript(JURI::root(true).'/components/com_dnagifts/js/temp.surveydata.js');
		$document->addScript(JURI::root(true).'/components/com_dnagifts/js/dnagifts.test.countdown.js');
		$document->addScript(JURI::root(true).'/components/com_dnagifts/js/dnagifts.test.js');
	}
}
