<?php
defined('_JEXEC') or die;

class MaintenanceHelper
{
	public static function getMappedValues($type)
	{
		$db = JFactory::getDbo();
		$options = array(
			'church_name' => 'church_done',
			'your_city' => 'city_done',
			'pastor_reverend' => 'pastor_done'
		);
		$sql = "SELECT DISTINCT $type as value
			FROM #__dnagifts_pretest_info 
			WHERE $type IS NOT NULL 
			AND ".$options[$type]." = 0
			ORDER BY $type ASC";
		$db->setQuery( $sql );
		return $db->loadObjectList();
	}
}
