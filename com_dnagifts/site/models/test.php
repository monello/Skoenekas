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
	public function getTestData($test_id, $user_test_id) {
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
		$query->select('*');
		$query->from($db->quoteName('#__dnagifts_list_testquestions'));
		$query->where($db->quoteName('test_id') . " = " . $db->quote($test_id));
		$db->setQuery($query);
		$data = $db->loadObjectList();
		
		$survey_data = array();
		
		foreach($data as $i => $test) {
			$tmpdata = array(
				'id' => $test->question_id,
				'duration' => $test->show_duration,
				'question' => $test->question_text,
				'hint' => $test->question_hint,
				'catid' => $test->gift_id
			);
			$survey_data[] = $tmpdata;
		}
		
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__dnagifts_lnk_user_test_answers'));
		$query->where($db->quoteName('lnk_user_test_id') . " = " . $db->quote($user_test_id));
		$db->setQuery($query);
		$data = $db->loadObjectList();
		foreach($data as $i => $answer) {
			foreach($survey_data as $ii => $survdat){
				if($survdat['id'] == $answer->question_id) {
					$survey_data[$ii]['answer'] = $answer->answer_score;
				}
			}
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
