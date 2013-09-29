<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
require_once JPATH_COMPONENT.'/helpers/dnagifts.php';

/**
 * Tests JSON (Ajax) Controller
 */
class DnaGiftsControllerTest extends JControllerForm
{
  public function saveAnswer()
	{
    $user_test_id = JRequest::getCmd('user_test_id');
    $question_id  = JRequest::getCmd('question_id');
    $score        = JRequest::getCmd('score');
    
    $db   = JFactory::getDbo();
    $user	= JFactory::getUser();
    
	$query = "SELECT id
		FROM ".$db->nameQuote('#__dnagifts_lnk_user_test_answers').
		" WHERE ".$db->nameQuote('lnk_user_test_id')." = ".$db->quote($user_test_id).
		" AND ".$db->nameQuote('question_id')." = ".$db->quote($question_id);
			
	$db->setQuery($query);
	$answer_id = $db->loadResult();
	
	if (!$answer_id) {	
		$query = $db->getQuery(true);
		$query->insert('#__dnagifts_lnk_user_test_answers');
		$query->columns('lnk_user_test_id, question_id, answer_score');
		$query->values((int) $user_test_id . ',' . (int) $question_id . ',' . (int) $score);
		$db->setQuery($query);
		if (!$db->query()) {
		  $this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_ANSWER'));
		  echo json_encode(array("success"=> false, "message" => JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_ANSWER')));
		  return false;
		}
		
		$answer_id = $db->insertid();
	}
	
	// Get test_id
	$query = "
		SELECT test_id
			FROM ".$db->nameQuote('#__dnagifts_lnk_user_tests')."
			WHERE id = ".$db->quote($user_test_id);
	$db->setQuery($query);
	$test_id = $db->loadResult();
	
	// Calculate test progress
	$progress = DnaGiftsHelper::getUserProgress($user_test_id, $test_id);
	
	// Update the progress
	$query = $db->getQuery(true);
	$query->update('#__dnagifts_lnk_user_tests');
	$query->set('progress = '. (int) $progress['percent']);
	$query->where('id = ' . (int) $user_test_id);
	$db->setQuery($query);
	$db->query();
	
    echo json_encode(array("success" => true, "answer_id" => $answer_id));
  }
  
  public function logUserTest()
	{
    $test_id		= JRequest::getCmd('test_id');
    $db		 		= JFactory::getDbo();
    $user	 		= JFactory::getUser();
    $sessionID		= DnaGiftsHelper::getSessionID();
	$browser 		= get_browser(null, true);
	
    $query = "
	  SELECT id
		FROM ".$db->nameQuote('#__dnagifts_lnk_user_tests')."
		WHERE ".$db->nameQuote('session_id')." = ".$db->quote($sessionID)."
		AND ".$db->nameQuote('test_id')." = ".$db->quote($test_id);
	$db->setQuery($query);

	// Check for a database error.
	if ($db->getErrorNum()) {
	  JError::raiseWarning(500, $db->getErrorMsg());
	}
    $user_test_id = $db->loadResult();
    
    if ($user_test_id) {
      echo json_encode(array("success" => true, "user_test_id" => $user_test_id));
	  return;
    }
    
    // Update test Hits
    $query = $db->getQuery(true);
	$query->update('#__dnagifts_test');
	$query->set('hits = hits + 1');
	$query->where('id = ' . (int) $test_id);
	$db->setQuery($query);
	$db->query();
    
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
      return false;
    }
    $user_test_id = $db->insertid();
    
    if (!$user_test_id) {
	  echo json_encode(array("success"=> false));
	} else {
	  echo json_encode(array("success" => true, "user_test_id" => $user_test_id));
	}
  }
  
  public function logTestComplete()
  {
    $test_id  = JRequest::getCmd('test_id');
    $db       = JFactory::getDbo();
    $query    = $db->getQuery(true);
	$query->update('#__dnagifts_test');
	$query->set('complete = complete + 1');
	$query->where('id = ' . (int) $test_id);
	$db->setQuery($query);
	$db->query();
	echo json_encode(array("success" => true, "message" => '<img src="'.JURI::root(true).'/media/com_dnagifts/images/spinner16x16.gif" /> '.jText::_('COM_DNAGIFTS_TEST_PROCESSING')));
  }
}
