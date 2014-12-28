<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controllerform');

class DnaGiftsControllerMaintenance extends JControllerForm
{
	public function saveMappedValue()
	{
		$oldvalue = JRequest::getVar('oldvalue');
		$newvalue = JRequest::getVar('newvalue');
		$type = JRequest::getVar('fieldtype');
		$counter = JRequest::getVar('counter');
		
		switch($type) {
			case 'church_name':
				$approvefield = 'church_approved';
				break;
			case 'pastor_reverend':
				$approvefield = 'pastor_approved';
				break;
			case 'your_city':
				$approvefield = 'city_approved';
				break;
		}

		$newvalue = preg_replace('/\s+/', ' ',$newvalue); // reduce repeating spaces
		$newvalue = trim($newvalue); // trim leading and trailing spaces
			
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_pretest_info');
		$query->set($type.' = "'.$newvalue.'"');
		$query->set($approvefield.' = 1');
		$query->where($type.' = "'.$oldvalue.'"');
		$db->setQuery($query);
		$db->query();
		
		echo json_encode(array("success" => true, "counter" => $counter));
	}
	
	public function deleteBadValue() 
	{
		$oldvalue = JRequest::getVar('oldvalue');
		$type = JRequest::getVar('fieldtype');
		$counter = JRequest::getVar('counter');
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_pretest_info');
		$query->set($type.' = NULL');
		$query->where($type.' = "'.$oldvalue.'"');
		$db->setQuery($query);
		$db->query();
		
		echo json_encode(array("success" => true, "counter" => $counter));
	}
}