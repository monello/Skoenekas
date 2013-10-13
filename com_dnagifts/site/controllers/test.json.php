<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
JLoader::register('DnagiftsHelper', JPATH_COMPONENT.'/helpers/dnagifts.php');

/**
 * Tests JSON (Ajax) Controller
 */
class DnaGiftsControllerTest extends JControllerForm
{
	public function saveAndFetch()
	{
		$test_id = JRequest::getVar('test_id');
		$question_id = JRequest::getVar('question_id', -1);
		$answer_score = JRequest::getVar('answer_score', -1);
		
		$model = $this->getModel( 'test' );
		
		// get the user-test-id
		// this will also tell us if it is an active test for this user session
		$user_test_id = DnagiftsHelper::getUserTestID($test_id);
		
		if (is_null($user_test_id)) {
			// If this is a new test, then log the user-test to the db
			$user_test_id = $model->logUserTest($test_id);
			if (!$user_test_id) {
				$app = JFactory::getApplication();
				$error = $app->logout();
				echo json_encode(array(
					"success" => false,
					"message" => JText::_('COM_DNAGIFTS_TEST_ERROR_NOUSEROBJECT')
				));
				return false;
			}
		} else {
			if ($question_id > 0) {
				$model->logAnswer($user_test_id, $question_id, $answer_score);
			}
		}
		
		$nextQuestion = false;
		// Check if there are more questions to load
		$nextQuestionObj = $model->getNextQuestion($test_id, $user_test_id);
		
		// set the next question flag to true if you found a next question
		if ($nextQuestionObj) {
			$nextQuestion = true;
		}
		
		// calculate the user's test progress
		// return the progress values
		//	- progress percentage
		//	- questions done
		//	- questions to go (INCLUDES passed questions)
		list ($progress, $total, $done, $togo) = $model->getUserTestProgress($user_test_id);
		
		echo json_encode(array(
			"success" => true,
			"nextQuestion" => $nextQuestion,
			"user_test_id" => (int) $user_test_id,
			"question_id" => (int) $nextQuestionObj->question_id,
			"question_text" => $nextQuestionObj->question_text,
			"show_duration" => (int) $nextQuestionObj->show_duration,
			"question_hint" => $nextQuestionObj->question_hint,
			"progress" => (float) $progress,
			"total" => (int) $total,
			"done" => (int) $done,
			"togo" => (int) $togo
		));
		return false;
	}
	
	public function logTestComplete()
	{
		$test_id  = JRequest::getCmd('test_id');
		$user_test_id  = JRequest::getCmd('user_test_id');
		$progress  = JRequest::getCmd('progress');
		
		$db       = JFactory::getDbo();
		$query    = $db->getQuery(true);
		$query->update('#__dnagifts_test');
		$query->set('complete = complete + 1');
		$query->where('id = ' . (int) $test_id);
		$db->setQuery($query);
		$db->query();
		
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_lnk_user_tests');
		$query->set('ended_datetime = Now()');
		$query->set('duration = TIMESTAMPDIFF(SECOND, started_datetime, Now())');
		$query->set('progress = '. (int) $progress);
		$query->where('id = ' . (int) $user_test_id);
		$db->setQuery($query);
		$db->query();
		
		echo json_encode(array("success" => true, "message" => '<img src="'.JURI::root(true).'/media/com_dnagifts/images/spinner16x16.gif" /> '.jText::_('COM_DNAGIFTS_TEST_PROCESSING')));
	}
}
