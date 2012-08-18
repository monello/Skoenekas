<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.model');
 
/**
 * DnaGifts Model
 */
class DnaGiftsModelTest extends JModel
{
	public function getTestQuestions($test_id) {
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
		$query->select('*');
		$query->from($db->quoteName('#__dnagifts_list_testquestions'));
		$query->order($db->getEscaped('ordering ASC'));
		$db->setQuery($query);
		$data = $db->loadObjectList();
		
		$survey_data = array();
		
		foreach($data as $i => $test) {
			$survey_data[] = array(
				'id' => $test->question_id,
				'duration' => $test->show_duration,
		    'question' => $test->question_text,
				'hint' => $test->question_hint,
				'catid' => $test->gift_id
			);
		}
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return json_encode($survey_data);
	}
	
	public function getTestConfig($test_id) {
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
		$query->select('id, use_timing, default_duration, show_progressbar');
		$query->from($db->quoteName('#__dnagifts_test'));
		$query->where('id = '.$test_id);
		$db->setQuery($query, 0, 1); // <- applies a limit 0,1
		$data = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return json_encode($data[0]);
	}

	public function getTestButtons($test_id) {
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
		$query->select('test_id, button_text, button_hint, score, css_class');
		$query->from($db->quoteName('#__dnagifts_list_testbuttons'));
		$query->where('test_id = '.$test_id);
		$db->setQuery($query);
		$data = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return $data;
	}

}
