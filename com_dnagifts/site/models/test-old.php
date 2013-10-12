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
		
		$survey_data = array();
		
		$query->select('*');
		$query->from($db->quoteName('#__dnagifts_list_testquestions'));
		$query->where($db->quoteName('test_id') . " = " . $db->quote($test_id));
		$db->setQuery($query);
		$data = $db->loadObjectList();
		
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
		
		if (!$user_test_id) {
			return json_encode($survey_data);
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
	
	public function getAutoSuggestData() {
		$db = $this->getDbo();
		
		// Get the Church List
		$query = $db->getQuery(true);
		$query->select('church_name');
		$query->from($db->quoteName('#__dnagifts_churchlist'));
		$db->setQuery($query);
		$churchList = $db->loadResultArray();
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		// Get the City List
		$query = $db->getQuery(true);
		$query->select('your_city');
		$query->from($db->quoteName('#__dnagifts_citylist'));
		$db->setQuery($query);
		$cityList = $db->loadResultArray();
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		// Get the Pastor List
		$query = $db->getQuery(true);
		$query->select('pastor_reverend');
		$query->from($db->quoteName('#__dnagifts_pastorlist'));
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
