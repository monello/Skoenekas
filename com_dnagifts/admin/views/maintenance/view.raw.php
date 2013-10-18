<?php
defined('_JEXEC') or die('Restricted access');
 
jimport('joomla.application.component.view');
JLoader::register('MaintenanceHelper', JPATH_COMPONENT.'/helpers/maintenance.php');

class DnaGiftsViewMaintenance extends JView
{	
    function display($tpl = null) 
	{
		$type 	= JRequest::getVar('type');
		$done 	= JRequest::getVar('done', 0);
		$data	= MaintenanceHelper::getMappedValues($type);
		$autoSuggestData = MaintenanceHelper::getAutoSuggestData();
		
		switch ($type) {
			case 'church_name':
				$asData = $autoSuggestData['churchList'];
				break;
			case 'pastor_reverend':
				$asData = $autoSuggestData['pastorList'];
				break;
			case 'your_city':
				$asData = $autoSuggestData['cityList'];
				break;
		}
		
		$this->assignRef( 'type', $type );
		$this->assignRef( 'done', $done );
		$this->assignRef( 'data', $data );
		$this->assignRef( 'autoSuggestData', $asData );
		
		parent::display($tpl);
	}
}