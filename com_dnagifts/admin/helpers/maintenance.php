<?php
defined('_JEXEC') or die;

class MaintenanceHelper
{
	public static function getMappedValues($type)
	{
		$db = JFactory::getDbo();
		$options = array(
			'church_name' => 'church_approved',
			'your_city' => 'city_approved',
			'pastor_reverend' => 'pastor_approved'
		);
		$sql = "SELECT DISTINCT $type as value, COUNT(*) as howmany
			FROM #__dnagifts_pretest_info 
			WHERE $type IS NOT NULL 
			AND ".$options[$type]." = 0
			GROUP BY $type
			ORDER BY $type ASC";
		$db->setQuery( $sql );
		return $db->loadObjectList();
	}
	
	public function getAutoSuggestData() {
		$db = JFactory::getDbo();
		
		// Get the Church List
		$query = $db->getQuery(true);
		$query->select('church_name');
		$query->from($db->quoteName('#__dnagifts_churchlist'));
		$query->where('church_approved = 1');
		$query->order('church_name');
		$db->setQuery($query);
		$churchList = $db->loadResultArray();
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		// Get the City List
		$query = $db->getQuery(true);
		$query->select('your_city');
		$query->from($db->quoteName('#__dnagifts_citylist'));
		$query->where('city_approved = 1');
		$query->order('your_city');
		$db->setQuery($query);
		$cityList = $db->loadResultArray();
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		// Get the Pastor List
		$query = $db->getQuery(true);
		$query->select('pastor_reverend');
		$query->from($db->quoteName('#__dnagifts_pastorlist'));
		$query->where('pastor_approved = 1');
		$query->order('pastor_reverend');
		$db->setQuery($query);
		$pastorList = $db->loadResultArray();
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		$autoSuggestData = array(
			'churchList' => $churchList,
			'pastorList' => $pastorList,
			'cityList' => $cityList
		);
		
		return $autoSuggestData;
	}
}
