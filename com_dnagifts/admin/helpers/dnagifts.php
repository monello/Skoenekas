<?php
defined('_JEXEC') or die;

/**
 * Banners component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_dnagifts
 * @since		1.6
 */
class DnagiftsHelper
{
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
		
		$query->select('a.id As value, a.question_text AS text, a.language AS language, b.show_duration AS show_duration');
		$query->from($db->quoteName('#__dnagifts_question').' AS a');
		$query->select('b.id As id, b.ordering AS ordering');
		$query->join('LEFT', $db->quoteName('#__dnagifts_lnk_test_question').' AS b ON b.question_id = a.id');
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
	
	public static function getButtonOptions($record_id, $language)
	{
		// Initialize variables.
		$options = array();
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		
		$query->select('id As value, button_text AS text');
		$query->from($db->quoteName('#__dnagifts_option_button'));
		$query->where('published = 1');
		
		$query->where('id NOT IN (SELECT button_id FROM '.$db->quoteName('#__dnagifts_lnk_test_buttonset').' WHERE test_id = '.$record_id.')');
		
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
		
		// set some global property
		$document = JFactory::getDocument();
		
		$document->addStyleDeclaration('.icon-16-dnagifts16x16-test ' .
		    '{background-image: url(../media/com_dnagifts/images/Tests-16x16.png);}');
		$document->addStyleDeclaration('.icon-16-dnagifts16x16-question ' .
		    '{background-image: url(../media/com_dnagifts/images/Options-16x16.png);}');
		$document->addStyleDeclaration('.icon-16-dnagifts16x16-gift ' .
		    '{background-image: url(../media/com_dnagifts/images/gift-16x16.png);}');
		$document->addStyleDeclaration('.icon-16-dnagifts16x16-answer ' .
		    '{background-image: url(../media/com_dnagifts/images/answers-16x16.png);}');
		
		$document->addStyleDeclaration('.icon-48-dnatests48x48 ' .
		    '{background-image: url(../media/com_dnagifts/images/Tests-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-dnagifts48x48 ' .
		    '{background-image: url(../media/com_dnagifts/images/gift-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-dnaquestions48x48 ' .
		    '{background-image: url(../media/com_dnagifts/images/Options-48x48.png);}');
		$document->addStyleDeclaration('.icon-48-dnaanswers48x48 ' .
		    '{background-image: url(../media/com_dnagifts/images/answers-48x48.png);}');
		
		$document->addStyleDeclaration('.colorpatch {float: right; display: inline; height: 15px; width: 30px;}');
	}
	
}
