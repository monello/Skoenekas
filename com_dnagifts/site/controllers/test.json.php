<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
require_once JPATH_COMPONENT.'/helpers/dnagifts.php';

/**
 * Tests Controller
 */
class DnaGiftsControllerTest extends JControllerForm
{
  public function saveAnswer() {
    $user_test_id = JRequest::getCmd('user_test_id');
    $question_id  = JRequest::getCmd('question_id');
    $score        = JRequest::getCmd('score');
    
    $db   = JFactory::getDbo();
    $user	= JFactory::getUser();
    
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
    // No need to return anyhting
    
    $answer_id = $db->insertid();
    
    if (!$user_test_id) {
			echo json_encode(array("success"=> false));
		} else {
			echo json_encode(array("success" => true, "answer_id" => $answer_id));
		}
  }
  
  public function logUserTest() {
    $test_id  = JRequest::getCmd('test_id');
    
    $db       = JFactory::getDbo();
    $user	    = JFactory::getUser();
    $sessionID = DnaGiftsHelper::getSessionID();
    
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
    
    // Log the new Session ID
    $query    = $db->getQuery(true);
    $query->insert('#__dnagifts_lnk_user_tests');
    $query->columns('session_id, user_id, test_id');
    $query->values($db->quote($sessionID) . ',' .(int) $user->get('id') . ',' . (int) $test_id);
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
  }
}
