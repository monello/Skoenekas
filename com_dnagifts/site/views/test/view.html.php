<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

JLoader::register('DnagiftsHelper', JPATH_COMPONENT.'/helpers/dnagifts.php');

class DnaGiftsViewTest extends JView
{
	public function display($tpl=null) 
	{
		$test_id = JRequest::getVar( 'id', 0 );
		
		// Check if this is an active test for the current user session
		$user_test_id		= DnagiftsHelper::getUserTestID($test_id);
		$is_active 			= $user_test_id ? true : false;
		$model 				= $this->getModel();
		$buttons			= $model->getTestButtons( $test_id );
		$buttonwidth		= $this->calcButtonWidth( $buttons );
		$testconfig 		= $model->getTestConfig( $test_id );
		$hasPretestInfo 	= DnagiftsHelper::hasPretestInfo();
		$autoSuggestData	= $model->getAutoSuggestData();
		
		$this->assignRef( 'testconfig', $testconfig );
		$this->assignRef( 'test_id', $test_id );
		$this->assignRef( 'is_active', $is_active );
		$this->assignRef( 'buttons', $buttons );
		$this->assignRef( 'buttonwidth', $buttonwidth );
		$this->assignRef( 'hasPretestInfo', $hasPretestInfo );
		$this->assignRef( 'autoSuggestData', $autoSuggestData );
		
		parent::display();
		$this->setDocument();
	}
	
	protected function calcButtonWidth($buttons)
	{
		$buttonwidth	= 120;
		if (count($buttons)) {
			$buttonwidth  = floor(100 / count($buttons));
		}
		return $buttonwidth;
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		
		/**
		 * NOTE: Only add stylesheets and scripts here that are applicable ONLY to
		 * 		this page. If it is needed on multiple pages add it to <base>/dnagifts.php
		**/
		// Stylesheets
		$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/dnagifts.test.css');
		
		// Javascripts
		// - JQuery - UI
		// -- Core
		$document->addScript(JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.core.min.js');
		$document->addScript(JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.widget.min.js');
		$document->addScript(JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.position.min.js');
		
		// -- Interactions
		
		// -- Widgets
		$document->addScript(JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.progressbar.min.js');
		$document->addScript(JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.autocomplete.min.js');
		$document->addScript(JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.menu.min.js');
		
		// - Other
		$document->addScript(JURI::base(true).'/administrator/components/com_dnagifts/js/jquery.countdown.min.js');
		
		// - DNA Gifts
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.test.countdown.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.test.js');
	}
}