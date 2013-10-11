<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');
JLoader::register('UtilsHelper', JPATH_COMPONENT_SITE.'/helpers/utils.php');
 
class DnaGiftsViewTestdetail extends JView
{
	function display($tpl = null) 
	{
		$user_test_id = JRequest::getVar( 'id' );
		
		list($success, $user_id, $test_id) = UtilsHelper::reverseUserTestId($user_test_id);
		$user = UtilsHelper::getUserObject($user_id);
		
		$model = $this->getModel();
		$testdata = $model->getTestQuestions($test_id);
		$testsummary = $model->getTestSummary($user_test_id);
		$answerdata = $model->getUserAnswers($user_test_id);
		$buttonscores = $model->getButtonScores($test_id);
		$scoregroups = $model->getTestScoreGroups($user_test_id);
		
		$stats = array(
			'questionCount' => count($testdata), 
			'answerCount' => count($answerdata),
			'missedQuestions' => count($testdata) - count($answerdata),
			'percentComplete' => round(count($answerdata) / count($testdata) * 100, 2)
		);
		$this->assignRef( 'testdata', $testdata );
		$this->assignRef( 'user', $user );
		$this->assignRef( 'testsummary', $testsummary );
		$this->assignRef( 'answerdata', $answerdata );
		$this->assignRef( 'stats', $stats );
		$this->assignRef( 'buttonscores', $buttonscores );
		$this->assignRef( 'scoregroups', $scoregroups );
		
		$this->addToolBar();
		parent::display($tpl);
		$this->setDocument();
	}
	
	protected function addToolBar() 
	{	
		JToolBarHelper::title(JText::_('COM_DNAGIFTS_TESTDETAIL_HEADING'), 'dnareports48x48');
		JToolBarHelper::back();
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		
		// Stylesheets
		$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/dnagifts.testdetail.css');
		
		// Javascripts
		// - JQuery
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/jquery-1.9.1.min.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/jquery-migrate-1.2.1.min.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/jquery.noconflict.js');
		
		// - JQuery - UI
		// -- core
		// -- Interactions
		// -- Widgets

		// - Other
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/Namespace.min.js');

		// - DNA Gifts
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.base.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.init.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.testdetail.js');
		
	}
}