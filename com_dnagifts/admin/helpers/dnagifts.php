<?php
defined('_JEXEC') or die;

/**
 * DNA Gifts component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_dnagifts
 * @since		1.6
 */
class DnagiftsHelper
{
	public static function getGiftImages($type)
	{
		$options	= array();
		$options[]	= JHtml::_('select.option', '', '- select image -');
		$directory = implode(DS, array(JPATH_ROOT,"media","com_dnagifts","images",$type));
		$pattern = '/\.(gif|png|jpg)$/i';
		if ($handle = opendir($directory)) {
			while (false !== ($file = readdir($handle))) {
				if ( !preg_match($pattern, $file) ){
					continue;
				}
				$options[] = JHtml::_('select.option', $file, $file);
			}
			closedir($handle);
		}
		
		return $options;
	}
	
	public static function getLanguageOptions()
	{
		// Build the active state filter options.
		$options	= array();
		$options[]	= JHtml::_('select.option', 'all', 'All');
		$options[]	= JHtml::_('select.option', 'English', 'English');
		$options[]	= JHtml::_('select.option', 'Afrikaans', 'Afrikaans');

		return $options;
	}
	
	public static function getGiftOptions()
	{
		// Initialize variables.
		$options = array();
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('id As value, CONCAT_WS(": ",code,name) AS text');
		$query->from('#__dnagifts_lst_gift');
		$query->order('code');
		
		// Get the options.
		$db->setQuery($query);
		
		$options = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_DNAGIFTS_NO_GIFTS')));
		
		return $options;
	}
	
	public static function getCurrentQuestions($record_id)
	{
		// Initialize variables.
		$options = array();
		
		if (!$record_id || $record_id < 1) {
			return $options;
		}
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('a.id As value, a.question_text AS text, a.language AS language, b.show_duration AS show_duration, a.question_code AS question_code');
		$query->from($db->quoteName('#__dnagifts_question').' AS a');
		$query->select('b.id As id, b.ordering AS ordering');
		$query->join('LEFT', $db->quoteName('#__dnagifts_lnk_test_question').' AS b ON b.question_id = a.id');
		$query->select('g.code AS gift_code, g.name AS gift_name, g.color_hex as color_hex');
		$query->join('LEFT', $db->quoteName('#__dnagifts_lst_gift').' AS g ON g.id = a.gift_id');
		$query->where('b.test_id = '.$record_id);
		$query->order('b.ordering');
		
		// Get the options.
		$db->setQuery($query);
		
		$options = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return $options;
	}
	
	public static function getCurrentButtons($record_id)
	{
		// Initialize variables.
		$options = array();
		
		if (!$record_id || $record_id < 1) {
			return $options;
		}
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('a.id As value, a.button_text AS text, a.language AS language');
		$query->from($db->quoteName('#__dnagifts_option_button').' AS a');
		$query->select('b.id As id, b.ordering AS ordering');
		$query->join('LEFT', $db->quoteName('#__dnagifts_lnk_test_buttonset').' AS b ON b.button_id = a.id');
		$query->where('b.test_id = '.$record_id);
		$query->order('b.ordering');
		
		// Get the options.
		$db->setQuery($query);
		
		$options = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return $options;
	}
	
	public static function getButtonOptions($record_id, $language, $is_update, $button_id=0)
	{
		// Initialize variables.
		$options = array();
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('id As value, button_text AS text');
		$query->from($db->quoteName('#__dnagifts_option_button'));
		$query->where('published = 1');
		
		if ($is_update == 'false') {
			$query->where('id NOT IN ('.
										'SELECT button_id FROM '.$db->quoteName('#__dnagifts_lnk_test_buttonset').
										' WHERE test_id = '.$record_id.')');
		} else {
			$query->where('id NOT IN ('.
										'SELECT button_id FROM '.$db->quoteName('#__dnagifts_lnk_test_buttonset').
										' WHERE test_id = '.$record_id.
										' AND button_id != '.$button_id.
										')');
		}
		
		if ($language && $language != 'all') {
			$query->where('language = \''.$language.'\'');
		}
		$query->order('ordering');
		
		// Get the options.
		$db->setQuery($query);
		
		$options = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return $options;
	}
	
	public static function getQuestionOptions($record_id, $language, $is_update, $question_id=0)
	{
		// Initialize variables.
		$options = array();
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('id As value, question_code AS code, question_text As text');
		$query->from($db->quoteName('#__dnagifts_question'));
		$query->where('published = 1');
		
		if ($is_update == 'false') {
			$query->where('id NOT IN ('.
										'SELECT question_id FROM '.$db->quoteName('#__dnagifts_lnk_test_question').
										' WHERE test_id = '.$record_id.')');
		} else {
			$query->where('id NOT IN ('.
										'SELECT question_id FROM '.$db->quoteName('#__dnagifts_lnk_test_question').
										' WHERE test_id = '.$record_id.
										' AND question_id != '.$question_id.
										')');
		}
		
		if ($language && $language != 'all') {
			$query->where('language = \''.$language.'\'');
		}
		$query->order('ordering');
		
		// Get the options.
		$db->setQuery($query);
		
		$options = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return $options;
	}
	
	public static function getTestUserOptions()
	{
		// Initialize variables.
		$options = array();
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('a.user_id As value');
		$query->from($db->quoteName('#__dnagifts_lnk_user_tests'). ' AS a');
		$query->where('a.user_id IS NOT NULL');
		$query->where('a.resolved = 0');
		
		$query->select('b.name AS text');
		$query->where('b.name IS NOT NULL');
		$query->join('LEFT', $db->quoteName('#__users').' AS b ON b.id = a.user_id');
		
		$query->group('a.user_id');
		$query->order('b.name');
		
		// Get the options.
		$db->setQuery($query);
		
		$options = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		array_unshift($options, JHtml::_('select.option', '', '- Select User -'));
		
		return $options;
	}
	
	public static function getTestsDoneOptions()
	{
		// Initialize variables.
		$options = array();
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('a.test_id As value');
		$query->from($db->quoteName('#__dnagifts_lnk_user_tests'). ' AS a');
		$query->where('a.test_id IS NOT NULL');
		$query->where('a.resolved = 0');
		
		$query->select('CONCAT(b.test_name, " (test_id: ", b.id, ")") AS text');
		$query->where('b.test_name IS NOT NULL');
		$query->join('LEFT', $db->quoteName('#__dnagifts_test').' AS b ON b.id = a.test_id');
		$query->group('a.test_id');
		$query->order('b.test_name');
		
		// Get the options.
		$db->setQuery($query);
		
		$options = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		array_unshift($options, JHtml::_('select.option', '', '- Select Test -'));
		
		return $options;
	}
	
	public static function getTestProgressOptions()
	{
		// Initialize variables.
		$options = array();
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('progress As value, CONCAT(progress,"%") AS text');
		$query->from($db->quoteName('#__dnagifts_lnk_user_tests'));
		$query->where('resolved = 0');
		$query->group('progress');
		$query->order('progress');
		
		// Get the options.
		$db->setQuery($query);
		
		$options = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		array_unshift($options, JHtml::_('select.option', '', '- Select Progress -'));
		
		return $options;
	}
	
	public static function getUserBrowserOptions()
	{
		// Initialize variables.
		$options = array();
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('user_browser As value, user_browser AS text');
		$query->from($db->quoteName('#__dnagifts_lnk_user_tests'));
		$query->where('resolved = 0');
		$query->where('user_browser IS NOT NULL');
		$query->group('user_browser');
		$query->order('user_browser');
		
		// Get the options.
		$db->setQuery($query);
		
		$options = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		array_unshift($options, JHtml::_('select.option', '', '- Select Browser -'));
		
		return $options;
	}
	
	public static function getUserPlatformOptions()
	{
		// Initialize variables.
		$options = array();
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('user_platform As value, user_platform AS text');
		$query->from($db->quoteName('#__dnagifts_lnk_user_tests'));
		$query->where('resolved = 0');
		$query->where('user_platform IS NOT NULL');
		$query->group('user_platform');
		$query->order('user_platform');
		
		// Get the options.
		$db->setQuery($query);
		
		$options = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		array_unshift($options, JHtml::_('select.option', '', '- Select Platform -'));
		
		return $options;
	}
	
	public static function getTestStatusOptions()
	{
		// Build the active state filter options.
		$options	= array();
		$options[]	= JHtml::_('select.option', '', '- Select Status -');
		$options[]	= JHtml::_('select.option', 1, 'Good');
		$options[]	= JHtml::_('select.option', 2, 'Incomplete >=80%');
		$options[]	= JHtml::_('select.option', 5, 'Incomplete <80%');
		$options[]	= JHtml::_('select.option', 3, 'No Report');
		$options[]	= JHtml::_('select.option', 4, 'Extra Answers');

		return $options;
	}
	
	/**
	 * Gets a list of the actions that can be performed.
	 * 
	 * @return	JObject
	 * @since	1.6
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_dnagifts';
		
		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit',
			'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
	
	public static function getHealhCheckData()
	{
		//$result	= new JObject;
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('*');
		$query->from($db->quoteName('#__dnagifts_healthchecks'));
		$query->order($db->nameQuote('generated_datetime').' DESC');
		$db->setQuery($query,0,1); // LIMIT 1
		$results = $db->loadObject();
		return $results;
	}
	
  public static function addEllipsis($string, $length, $end='...')
  {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($end )) . $end : $string;
  }

	/**
	* Configure the Linkbar.
	*
	* @param string The name of the active view.
	*/
	public static function addSubmenu($vName = 'submanager')
	{
		JSubMenuHelper::addEntry(
			JText::_('COM_DNAGIFTS_TESTS'),
			'index.php?option=com_dnagifts&view=tests',
			$vName == 'tests'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_DNAGIFTS_QUESTIONS'),
			'index.php?option=com_dnagifts&view=questions',
			$vName == 'questions'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_DNAGIFTS_GIFTS'),
			'index.php?option=com_dnagifts&view=gifts',
			$vName == 'gifts'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_DNAGIFTS_ANSWERS'),
			'index.php?option=com_dnagifts&view=answers',
			$vName == 'answers'
		);
		
		JSubMenuHelper::addEntry(
			JText::_('COM_DNAGIFTS_REPORTS'),
			'index.php?option=com_dnagifts&view=reports',
			$vName == 'reports'
		);

		// set some global property
		$document = JFactory::getDocument();
		
		$document->addStyleDeclaration('.icon-16-dnagifts16x16-test ' .
		    '{background-image: url('.JURI::root(true).'/media/com_dnagifts/images/Tests-16x16.png);}');
		$document->addStyleDeclaration('.icon-16-dnagifts16x16-question ' .
		    '{background-image: url('.JURI::root(true).'/media/com_dnagifts/images/Options-16x16.png);}');
		$document->addStyleDeclaration('.icon-16-dnagifts16x16-gift ' .
		    '{background-image: url('.JURI::root(true).'/media/com_dnagifts/images/gift-16x16.png);}');
		$document->addStyleDeclaration('.icon-16-dnagifts16x16-answer ' .
		    '{background-image: url('.JURI::root(true).'/media/com_dnagifts/images/answers-16x16.png);}');
		$document->addStyleDeclaration('.icon-16-dnagifts16x16-report ' .
		    '{background-image: url('.JURI::root(true).'/media/com_dnagifts/images/reports-16x16.png);}');
		
		$document->addStyleDeclaration('.icon-48-dnatests48x48 ' .
		    '{background-image: url('.JURI::root(true).'/media/com_dnagifts/images/Tests-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-dnagifts48x48 ' .
		    '{background-image: url('.JURI::root(true).'/media/com_dnagifts/images/gift-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-dnaquestions48x48 ' .
		    '{background-image: url('.JURI::root(true).'/media/com_dnagifts/images/Options-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-dnaanswers48x48 ' .
		    '{background-image: url('.JURI::root(true).'/media/com_dnagifts/images/answers-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-dnareports48x48 ' .
		    '{background-image: url('.JURI::root(true).'/media/com_dnagifts/images/reports-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-dnatesthist48x48 ' .
		    '{background-image: url('.JURI::root(true).'/media/com_dnagifts/images/archive-iton-48x48.png);}');
		
		$document->addStyleDeclaration('.colorpatch {float: right; display: inline; height: 15px; width: 30px;}');
	}
	
}
