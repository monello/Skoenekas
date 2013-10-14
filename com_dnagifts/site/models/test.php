<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');
 
class DnaGiftsModelTest extends JModel
{
	public function logUserTest($test_id)
	{
		$db		 		= JFactory::getDbo();
		$user	 		= JFactory::getUser();
		$sessionID		= DnaGiftsHelper::getSessionID();
		$browser 		= get_browser(null, true);
		
		if (!$user || $user->id == 0 || !$sessionID || strlen($sessionID) < 5) {		
			return null;
		}
		
		// Check if the test user question timing.
		// Track to use in the future for debugging problematic test results
		$query = "SELECT use_timing
			FROM ".$db->nameQuote('#__dnagifts_test')."
			WHERE ".$db->nameQuote('id')." = ".$db->quote($test_id);
		$db->setQuery($query);
		$use_timing = $db->loadResult();
		
		// Count the questions for this test
		$query = "SELECT howmany
			FROM ".$db->nameQuote('#__dnagifts_count_testquestions')."
			WHERE ".$db->nameQuote('test_id')." = ".$db->quote($test_id);
		$db->setQuery($query);
		$question_count = $db->loadResult();
		
		// Log the new Session ID
		$query = $db->getQuery(true);
		$query->insert('#__dnagifts_lnk_user_tests');
		$query->columns('session_id, user_id, test_id, user_browser, user_platform, is_timing_on, question_count');
		$query->values($db->quote($sessionID) . ',' 
						. (int) $user->get('id') . ',' 
						. (int) $test_id . ',' 
						. $db->quote($browser['parent']) . ','
						. $db->quote($browser['platform']) . ','
						. (int) $use_timing .','
						. (int) $question_count
					);
		$db->setQuery($query);
		if (!$db->query()) {
			$this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_USERTEST'));
			echo json_encode(array("success"=> false, "message" => JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_ANSWER')));
			return null;
		}
		$user_test_id = $db->insertid();
		
		// Update test Hits
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_test');
		$query->set('hits = hits + 1');
		$query->where('id = ' . (int) $test_id);
		$db->setQuery($query);
		$db->query();
		
		return $user_test_id;
	}
	
	public function getNextQuestion($test_id, $user_test_id)
	{
		// First check for non-skipped questions
		$db = $this->getDbo();
		$sql = "SELECT * 
			FROM #__dnagifts_list_testquestions
			WHERE question_id NOT IN (
				SELECT question_id FROM #__dnagifts_lnk_user_test_answers 
				WHERE lnk_user_test_id = $user_test_id
			)
			AND test_id = $test_id
			ORDER BY ordering
			LIMIT 1";
			
		$db->setQuery($sql);
		$nextQuestionObj = $db->loadObject();
		
		if ($nextQuestionObj) {
			$this->prepareAnswer($user_test_id, $nextQuestionObj);
			return $nextQuestionObj;
		}
		
		// If there are no more NON-skipped questions, look for the skipped questions
		// Each time a question gets skipped the is_skipped field gets incremented 
		$sql = "SELECT a.*, b.is_skipped
			FROM #__dnagifts_list_testquestions a
			LEFT JOIN #__dnagifts_lnk_user_test_answers b ON a.question_id = b.question_id
			WHERE a.test_id = $test_id
			AND b.lnk_user_test_id = $user_test_id
			AND b.is_skipped > 0
			ORDER BY b.is_skipped, a.ordering
			LIMIT 1";
		$db->setQuery($sql);
		$nextQuestionObj = $db->loadObject();
		
		// prepare the answer record
		$this->prepareAnswer($user_test_id, $nextQuestionObj);
		
		return $nextQuestionObj;
	}
	
	public function logAnswer($user_test_id, $question_id, $answer_score)
	{
		$db = $this->getDbo();
		
		$sql = "SELECT id 
			FROM #__dnagifts_lnk_user_test_answers
			WHERE lnk_user_test_id = $user_test_id
			AND question_id = ". (int) $question_id;
		$db->setQuery($sql);
		$answer_id = $db->loadResult();
		
		// Check if there is a new answer that needs to be saved
		// - if the answer score >= 0 then the user clicked an answer button
		// - if the answer score < 0 then the pass button was clicked
		if ($answer_score < 0) {
			$query = $db->getQuery(true);
			$query->update('#__dnagifts_lnk_user_test_answers');
			$query->set('is_skipped = is_skipped + 1');
			$query->set('answer_startdatetime = Now()');
			$query->where('id = ' . (int) $answer_id);
			$db->setQuery($query);
			$db->query();
		} else {
			$query = $db->getQuery(true);
			$query->update('#__dnagifts_lnk_user_test_answers');
			$query->set('answer_score = '.$answer_score);
			$query->set('answer_datetime = Now()');
			$query->set('is_skipped = 0');
			$query->set('duration = TIMESTAMPDIFF(SECOND, answer_startdatetime, Now())');
			$query->where('id = ' . (int) $answer_id);
			$db->setQuery($query);
			$db->query();
			
			$progress = $this->getUserTestProgress($user_test_id);
			
			$query = $db->getQuery(true);
			$query->update('#__dnagifts_lnk_user_tests');
			$query->set('progress = ' . ceil($progress[0]));
			$query->where('id = ' . (int) $user_test_id);
			$db->setQuery($query);
			$db->query();
		}
	}
	
	protected function prepareAnswer($user_test_id, $nextQuestionObj)
	{
		$db = $this->getDbo();
		$sql = "SELECT id 
			FROM #__dnagifts_lnk_user_test_answers
			WHERE lnk_user_test_id = $user_test_id
			AND question_id = ". (int) $nextQuestionObj->question_id;
		$db->setQuery($sql);
		$answer_id = $db->loadResult();
		
		if ($nextQuestionObj) {
			$query = $db->getQuery(true);
			if(!$answer_id) {
				$query->insert('#__dnagifts_lnk_user_test_answers');
				$query->columns('lnk_user_test_id, question_id, answer_score, answer_startdatetime');
				$query->values((int) $user_test_id . ',' . (int) $nextQuestionObj->question_id . ', -1, Now()');
				$db->setQuery($query);
				$db->query();
			} else {
				$query->update('#__dnagifts_lnk_user_test_answers');
				$query->set('answer_startdatetime = Now()');
				$query->where('id = ' . (int) $answer_id);
				$db->setQuery($query);
				$db->query();
			}
		}
	}
	
	public function getUserTestProgress($user_test_id) 
	{
		$db = $this->getDbo();
		
		$sql = "SELECT test_id, howmany FROM #__dnagifts_count_testanswers WHERE lnk_user_test_id = $user_test_id";
		$db->setQuery($sql);
		$data = $db->loadObject();
		$done = $data->howmany;
		$test_id = $data->test_id;
		
		if (!$test_id) {
			$sql = "SELECT test_id FROM #__dnagifts_lnk_user_tests WHERE id = $user_test_id";
			$db->setQuery($sql);
			$data = $db->loadObject();
			$done = $data->howmany;
			$test_id = $data->test_id;
		}
		
		$sql = "SELECT howmany FROM #__dnagifts_count_testquestions WHERE test_id = $test_id";
		$db->setQuery($sql);
		$total = $db->loadResult();
		
		$progress = round($done / $total * 100, 1);
		
		$togo = $total - $done;
		
		return array($progress, $total, $done, $togo);
	}
	/* OLD
	public function getUserTestProgress($test_id, $user_test_id)
	{
		$total = $progress = 0;
		
		$db = $this->getDbo();
		
		$sql = "SELECT COUNT(*) FROM #__dnagifts_list_testquestions WHERE test_id = $test_id";
		$db->setQuery($sql);
		$total = $db->loadResult();
		
		if ($total == 0) {
			return array(0,0,0);
		}
		
		// First check for non-skipped questions
		$sql = "SELECT count(*) 
			FROM #__dnagifts_list_testquestions
			WHERE question_id NOT IN (
				SELECT question_id FROM #__dnagifts_lnk_user_test_answers 
				WHERE lnk_user_test_id = $user_test_id
			)
			AND test_id = $test_id";
			
		$db->setQuery($sql);
		$togo1 = $db->loadResult();
		
		// If there are no more-non-skipped questions, look for the skipped questions
		$db = $this->getDbo();
		$sql = "SELECT COUNT(*) 
			FROM #__dnagifts_list_testquestions
			WHERE question_id IN (
				SELECT question_id FROM #__dnagifts_lnk_user_test_answers 
				WHERE lnk_user_test_id = $user_test_id
				AND answer_score < 0
			)
			AND test_id = $test_id";
		$db->setQuery($sql);
		$togo2 = $db->loadResult();
		
		$total_togo = $togo1 + $togo2;
		
		$done = $total - $total_togo;
		
		if ($total > 0) {
			$progress = round($done / $total * 100, 1);
		}
		
		return array($progress, $total, $done, $total_togo);
	}
	*/
	
	public function getTestConfig($test_id) {
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
		$query->select('id, use_timing, default_duration, show_progressbar');
		$query->from($db->quoteName('#__dnagifts_test'));
		$query->where('id = '.$test_id);
		$db->setQuery($query, 0, 1); // <- applies a limit 0,1
		
		$data = $db->loadObject();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return json_encode($data);
	}
	
	public function getTestButtons($test_id)
	{
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
