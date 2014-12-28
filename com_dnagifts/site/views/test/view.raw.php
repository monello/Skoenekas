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
		
		$html = $this->loadTemplate($tpl);
		
		
		if ($html instanceof Exception)
		{
			return $html;
		}
		
		$sas = $this->getScriptsAndStyles();
		$html = $sas.$html;
		
		echo $html;
	}
	
	protected function calcButtonWidth($buttons)
	{
		$buttonwidth	= 120;
		if (count($buttons)) {
			$buttonwidth  = floor(100 / count($buttons));
		}
		return $buttonwidth;
	}
	
	protected function getScriptsAndStyles()
	{
		$styles = '<link type="text/css" href="'.JURI::base(true).'/administrator/components/com_dnagifts/css/themes/base/jquery.ui.all.css" rel="stylesheet">
		<link rel="stylesheet" href="'.JURI::base(true).'/components/com_dnagifts/css/dnagifts.test.css" type="text/css">';
		
		$scripts = '<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery-1.9.1.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery.noconflict.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery.metadata.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/Namespace.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/dnagifts.base.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/dnagifts.init.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.core.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.widget.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.position.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.progressbar.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.autocomplete.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.menu.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery.countdown.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/components/com_dnagifts/js/dnagifts.test.countdown.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/components/com_dnagifts/js/dnagifts.test.js" type="text/javascript"></script>';
		return $styles.$scripts;
	}
}