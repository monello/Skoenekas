<?php
defined('_JEXEC') or die;

class UtilsHelper
{	
	public function getUserObject($uid) {
		if ($uid) {
			return JFactory::getUser($uid);
		} else {
			return JFactory::getUser();
		}
	}
	
	/*
	* This function takes a user-test-id and returns the user_id and test_id
	*/
	public function reverseUserTestId($user_test_id)
	{
		$db	= JFactory::getDBO();
		
		$query = "
			SELECT user_id, test_id
			FROM ".$db->nameQuote('#__dnagifts_lnk_user_tests')."
			WHERE ".$db->nameQuote('id')." = ".$db->quote($user_test_id);

		$db->setQuery($query);
		$db->query();

		if ($db->getNumRows()) {
			$rows = $db->loadObjectList();
			$data = $rows[0];
			return array(True, $data->user_id, $data->test_id);
		} else {
			return array(False);
		}
	}
}