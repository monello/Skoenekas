<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
JLoader::register('ReportsHelper', JPATH_COMPONENT.'/helpers/reports.php');
 
/**
 * HTML View class for the DnaGifts Component
 */
class DnaGiftsViewReport extends JView
{
	public function display($tpl = null) 
	{
		$user = JFactory::getUser();
		if (!$user->get("id")) {
			$app = JFactory::getApplication()->redirect('/');
			return false;
		}
		
		$model		= $this->getModel();
		$app		= JFactory::getApplication();
	    $params    	= $app->getParams();
    	$dispatcher	= JDispatcher::getInstance();
		
		$test_id 	= JRequest::getVar('id');
		if (!$test_id) 
		{
			JError::raiseError(500, implode('<br />', array("Invalid Request :: Missing test_id")));
			return false;
		}
		
		$test_user_id = ReportsHelper::getTestUserId($test_id);
		if (!$test_user_id) 
		{
			JError::raiseError(500, implode('<br />', array("Invalid Request :: Test ID does not match user")));
			return false;
		}
		
		$this->assignRef( 'dnaMaxScore', ReportsHelper::getDnaMaxScore($test_user_id) );
		$this->assignRef( 'user', JFactory::getUser() );
		$this->assignRef( 'userTestID', $test_user_id );
		$this->assignRef( 'dnaResults', $model->getResultsObject($test_user_id));
		$this->assignRef( 'dnaChartSrc', ReportsHelper::generateDNAChart($this->dnaResults, $test_user_id) );
		
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
		
		echo $html;

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
		$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/dnagifts.report.css');
		
		// Javascripts
		$document->addScript('https://www.google.com/jsapi');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.report.js');
	}
}
