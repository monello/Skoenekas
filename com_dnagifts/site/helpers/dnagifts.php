<?php
defined('_JEXEC') or die;

class DnagiftsHelper
{
	public static function getSessionID()
	{
		$user = JFactory::getUser();
		
		if (!$user) {
			return 0;
		}
		
		$db = JFactory::getDBO();
		$query = "SELECT session_id
				FROM ".$db->nameQuote('#__session')."
				WHERE ".$db->nameQuote('userid')." = ".$db->quote($user->get("id"))."
				AND ".$db->nameQuote('client_id')." = 0";
		$db->setQuery($query);
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		if ($session_id = $db->loadResult()) {
			return $session_id;
		} else {
			return '0';
		}
	}
	public static function addEllipsis($string, $length, $end='...')
  {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($end )) . $end : $string;
  }
	
	public static function loadLanguageSwitch()
	{
		$document = &JFactory::getDocument();
		$renderer   = $document->loadRenderer('modules');
		$position   = 'myLanguageSwitch';
		$options   = array('style' => 'raw');
		return $renderer->render($position, $options, null);
	}
	
	public static function isLoggedIn()
	{
		$user = JFactory::getUser();
		if ($user->get("id")) {
			return True;
		} else {
			return False;
		}
	}
	
	public static function authenticate()
	{
		$user = JFactory::getUser();
		$document = &JFactory::getDocument();
		$renderer   = $document->loadRenderer('modules');
		$position   = 'myBtLogin';
		$options   = array('style' => 'raw');
		if ($user->get("id")) {
			return array(True, $renderer->render($position, $options, null));
		} else {
			return array(False, $renderer->render($position, $options, null));
		}
	}
	
  public static function pretestFlightChecks()
	{
		$user = JFactory::getUser();
		
		if (!$user) {
			return 0;
		}
		$data = Null;
		$db = JFactory::getDBO();
		$query = "SELECT * FROM ".$db->nameQuote('#__dnagifts_pretest_info')." WHERE ".$db->nameQuote('user_id')." = ".$db->quote($user->get("id")).";";
    $db->setQuery($query);
    $data = $db->loadObject();
    
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
    if (!$data) {
      return False;
    }
    
    $checks = array();
    if ($data->is_christian !== Null) {
      $checks[] = 1;
    }
    
    if ($data->in_church !== Null && $data->in_church > -1) {
      $checks[] = array(2, $data->in_church);
      if ($data->church_name !== Null) {
        $checks[] = 3;
      }
      if ($data->pastor_reverend !== Null) {
        $checks[] = 4;
      }
    }
    
    if ($data->your_city !== Null) {
      $checks[] = 5;
    }
    
    if ($data->your_country !== Null) {
      $checks[] = 6;
    }
    
    if ($data->believe_divine !== Null) {
      $checks[] = 7;
    }
    
    return $checks;
	}
  
	public static function hasPretestInfo()
	{
		$user = JFactory::getUser();
		
		if (!$user) {
			return 0;
		}
		$data = Null;
		$db = JFactory::getDBO();
		$query = "SELECT * FROM ".$db->nameQuote('#__dnagifts_pretest_info')." WHERE ".$db->nameQuote('user_id')." = ".$db->quote($user->get("id")).";";
		$db->setQuery($query);
		$data = $db->loadObject();
    
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
    if (!$data) {
      return 0;
    }
    
    if ($data->is_christian === Null || $data->in_church === Null || $data->in_church < 0 || 
        $data->your_city === Null || $data->your_country === Null || $data->believe_divine === Null)
    {
      return 0;
    }
    
    if ($data->in_church == 1) {
      if ($data->church_name === Null || $data->pastor_reverend === Null) {
        return 0;
      }
    }
    
    return 1;
	}
	
  public static function hasPretestID($userid)
	{
		$db = JFactory::getDBO();
		$query = "
			SELECT id
				FROM ".$db->nameQuote('#__dnagifts_pretest_info')."
				WHERE ".$db->nameQuote('user_id')." = ".$db->quote($userid).";
			";
		$db->setQuery($query);
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return($db->loadResult());
	}
  
	public static function getUserTestID($test_id = 0)
	{
		$session_id = DnagiftsHelper::getSessionID();
		if (!$session_id || !$test_id) {
			return 0;
		}
		
		$db = JFactory::getDBO();
		$query = "SELECT id
				FROM ".$db->nameQuote('#__dnagifts_lnk_user_tests')."
				WHERE ".$db->nameQuote('session_id')." = ".$db->quote($session_id)."
				AND ".$db->nameQuote('test_id')." = ".$db->quote($test_id);
		
		$db->setQuery($query);
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		if ($test_user_id = $db->loadResult()) {
			return $test_user_id;
		} else {
			return null;
		}
	}
	
	public static function getCountryOptions()
	{
		// Initialize variables.
		$options = array();
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('id As value, common_name AS text');
		$query->from($db->quoteName('#__dnagifts_lst_countries'));
		$query->order('ordering');
		
		// Get the options.
		$db->setQuery($query);
		
		$options = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		array_unshift($options, JHtml::_('select.option', '', JText::_('COM_DNAGIFTS_NO_COUNTRIES')));
		
		return $options;
	}
	
	public static function getCurrentLanguageCode()
	{
		$lang_code = JFactory::getLanguage()->getTag();
    $sef = explode('-',$lang_code);
		return $sef[0];
	}
	
	public static function getCurrentLanguageString()
	{
		$lang_code = DnagiftsHelper::getCurrentLanguageCode();
		
		$db = JFactory::getDBO();
		$query = "
			SELECT language_string
				FROM ".$db->nameQuote('#__dnagifts_lst_language_codes')."
				WHERE ".$db->nameQuote('language_code')." = ".$db->quote($lang_code).";
			";
			
		$db->setQuery($query);
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return($db->loadResult());
	}
	
	public static function getUserProgress($user_test_id, $test_id)
	{
		$db		= JFactory::getDBO();
		
		$progress = array();
		
		// count the number of questions
		$query = "
			SELECT howmany
				FROM ".$db->nameQuote('#__dnagifts_count_testquestions')."
				WHERE ".$db->nameQuote('test_id')." = ".$db->quote($test_id).";";
		$db->setQuery($query);
		$progress['howmany'] = $db->loadResult();
		
		// count the number of answers
		if ($user_test_id) {
			$query = "SELECT COUNT(DISTINCT(question_id))
				FROM ".$db->nameQuote('#__dnagifts_lnk_user_test_answers').
				" WHERE ".$db->nameQuote('lnk_user_test_id')." = ".$db->quote($user_test_id);
			
			$db->setQuery($query);
			
			$progress['answers'] = $db->loadResult();
		} else {
			$progress['answers'] = 0;
		}
		
		// get percentage complete
		$progress['percent'] = 0;
		if ($progress['howmany']) {
			$progress['percent'] = round($progress['answers'] / $progress['howmany'] * 100);
		}
    
		// check if the test is still in-progres for this user
		if ((int) $progress['percent'] > 0 && (int) $progress['percent'] < 100) {
			$progress['inprogress'] = true;
		} else {
			$progress['inprogress'] = false;
		}
		
		return $progress;
	}
	
	public static function hasCompletedTests()
	{
		$user = JFactory::getUser();
		
		if (!$user) {
			return 0;
		}
		
		$db	= JFactory::getDBO();
		
		$query = "
			SELECT *
			FROM ".$db->nameQuote('#__dnagifts_lnk_user_tests')."
			WHERE ".$db->nameQuote('user_id')." = ".$db->quote($user->get("id"));
		$db->setQuery($query);
		$data = $db->loadObjectList();
		
		foreach($data as $i => $lut) {
			$progress = DnagiftsHelper::getUserProgress($lut->id, $lut->test_id);
			if ((int) $progress['percent'] >= 100) {
				return 1;
			}
		}
		return 0;
	}
	
	function getBrowser()
	{
		return get_browser(null, true);
	}
}
