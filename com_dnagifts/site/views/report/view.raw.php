<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
JLoader::register('UtilsHelper', JPATH_COMPONENT.'/helpers/utils.php');
JLoader::register('ReportsHelper', JPATH_COMPONENT.'/helpers/reports.php');

/**
 * HTML View class for the DnaGifts Component
 */
class DnaGiftsViewReport extends JView
{
	public function display($tpl = null) 
	{
		$test_user_id 	= JRequest::getVar('id');
		if (!$test_user_id) {
			JError::raiseError(500, implode('<br />', array("Invalid Request :: Not a valid user-test-id")));
			return false;
		}
		
		$data = UtilsHelper::reverseUserTestId($test_user_id);
		if (!$data[0]) {
			JError::raiseError(500, implode('<br />', array("Invalid Request :: Not a valid user-test-id")));
			return false;
		}
		
		$user_id = $data[1];
		$test_id = $data[2];
		
		$user = UtilsHelper::getUserObject($user_id);
		if (!$user->get("id")) {
			JError::raiseError(500, implode('<br />', array("Invalid Request :: Not a valid user id")));
			return false;
		}
		
		$model		= $this->getModel();
		$app		= JFactory::getApplication();
	    $params    	= $app->getParams();
    	$dispatcher	= JDispatcher::getInstance();
		
		if (!$test_id) 
		{
			JError::raiseError(500, implode('<br />', array("Invalid Request :: Missing test_id")));
			return false;
		}
		$israw = 1;
		$this->assignRef( 'dnaMaxScore', ReportsHelper::getDnaMaxScore($test_user_id) );
		$this->assignRef( 'user', $user );
		$this->assignRef( 'israw', $israw );
		$this->assignRef( 'testid', $test_id);
		$this->assignRef( 'userTestID', $test_user_id );
		$this->assignRef( 'dnaResults', $model->getResultsObject($test_user_id));
		$this->assignRef( 'dnaChartSrc', ReportsHelper::generateDNAChart($this->dnaResults, $test_user_id));
		
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
		
		$sas = $this->getScriptsAndAtyles();
		$html = $sas.$html;
		
		echo $html;
  }
	
	protected function getScriptsAndAtyles()
	{
		$styles = '<link rel="stylesheet" href="'.JURI::base(true).'/components/com_dnagifts/css/dnagifts.report.css" type="text/css">';
		$scripts = '<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery-1.9.1.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery.noconflict.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery.metadata.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/Namespace.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/dnagifts.base.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/dnagifts.init.js" type="text/javascript"></script>
			<script src="https://www.google.com/jsapi" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/components/com_dnagifts/js/dnagifts.report.js" type="text/javascript"></script>';
		return $styles.$scripts;
	}
}
