<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.controllerform');

class DnaGiftsControllerMaintenance extends JControllerForm
{
	public function saveMappedValue() {
		$oldvalue = JRequest::getVar('oldvalue');
		$newvalue = JRequest::getVar('newvalue');
		$type = JRequest::getVar('fieldtype');
		$counter = JRequest::getVar('counter');
		
		switch($type) {
			case 'church_name':
				$approvefield = 'church_approved';
				break;
			case 'pastor_reverence':
				$approvefield = 'pastor_approved';
				break;
			case 'your_city':
				$approvefield = 'city_approved';
				break;
		}
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_presetinfo');
		$query->set($type.' = "'.$newvalue.'"');
		$query->set($approvefield.' = 1');
		$query->where($type.' = "'.$oldvalue.'"');
		$db->setQuery($query);
		$db->query();
		
		//echo json_encode(array("success" => false, "message" => "There was an error\nWe were unable to complete your request\nWe applogise for teh inconvenience"));
		echo json_encode(array("success" => true, "counter" => $counter));
	}
	
	public function deleteBadValue() {
		$oldvalue = JRequest::getVar('oldvalue');
		$type = JRequest::getVar('fieldtype');
		$counter = JRequest::getVar('counter');
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_presetinfo');
		$query->set($type.' = NULL');
		$query->where($type.' = "'.$oldvalue.'"');
		$db->setQuery($query);
		echo $query;
		$db->query();
		
		//echo json_encode(array("success" => false, "message" => "There was an error\nWe were unable to complete your request\nWe applogise for teh inconvenience"));
		echo json_encode(array("success" => true, "counter" => $counter));
	}
}