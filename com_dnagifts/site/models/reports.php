<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.model');

/**
 * DnaGifts Model
 */
class DnaGiftsModelReports extends JModel
{
	public function getUserReports() {
		$user = JFactory::getUser();
		
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
		$query->select('a.*, b.test_name');
		$query->from($db->quoteName('#__dnagifts_lnk_user_tests'). ' AS a');
		$query->join('LEFT', $db->quoteName('#__dnagifts_test').' AS b ON a.test_id = b.id');
		$query->where('a.user_id = '.$user->get('id'));
		$query->where('a.progress >= 100');
		$db->setQuery($query);
		$data = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return $data;
	}

}
