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
  /* The URL view list variable.
	*
	* @var string
	*/
	protected $view_list = 'tests';
  
	public function getCurrentButtons() {
		$record_id = JRequest::getCmd('record_id');
		$data = array("results" => array(
				"buttons" => DnaGiftsHelper::getCurrentButtons($record_id)
		));
		echo json_encode($data);
	}
	
	public function getButtonsByLanguage() {
		$record_id = JRequest::getCmd('record_id');
		$language = JRequest::getCmd('language');
		$is_update = JRequest::getCmd('is_update', false);
		$button_id = JRequest::getCmd('button_id', 0);
		$data = array("results" => array(
				"buttons" => DnaGiftsHelper::getButtonOptions($record_id, $language, $is_update, $button_id)
		));
		echo json_encode($data);
	}
	public function getQuestionsByLanguage() {
		$record_id = JRequest::getCmd('record_id');
		$language = JRequest::getCmd('language');
		$is_update = JRequest::getCmd('is_update', false);
		$question_id = JRequest::getCmd('question_id', 0);
		$data = array("results" => array(
				"questions" => DnaGiftsHelper::getQuestionOptions($record_id, $language, $is_update, $question_id)
		));
		echo json_encode($data);
	}
	
	public function updateTestButton() {
		$link_id = JRequest::getCmd('link_id');
		$button_id = JRequest::getCmd('button_id');
		$show_duration = JRequest::getCmd('show_duration', 0);
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_lnk_test_buttonset');
		$query->set('button_id = ' . (int) $button_id);
		$query->set('show_duration = ' . (int) $show_duration);
		$query->where('id = ' . (int) $link_id);
		$db->setQuery($query);
		$db->query();
		
		// get button details
		$query = $db->getQuery(true);
		$query->select('button_text');
		$query->from($db->quoteName('#__dnagifts_option_button'));
		$query->where('id = '. (int) $button_id);
		$db->setQuery($query);
		$data = $db->loadObject();
		
		$text = $data->button_text;
		
		echo json_encode(array("success" => true,"text" => $text));
	}
	
	public function updateTestQuestion() {
		$link_id = JRequest::getCmd('link_id');
		$question_id = JRequest::getCmd('question_id');
		$show_duration = JRequest::getCmd('show_duration', 0);
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_lnk_test_question');
		$query->set('question_id = ' . (int) $question_id);
		$query->set('show_duration = ' . (int) $show_duration);
		$query->where('id = ' . (int) $link_id);
		$db->setQuery($query);
		$db->query();
		
		// get button details
		$query = $db->getQuery(true);
		$query->select('a.question_text as question_text, a.question_code as question_code');
		$query->from($db->quoteName('#__dnagifts_question').' AS a');
		$query->select('g.code AS gift_code, g.name AS gift_name, g.color_hex as color_hex');
		$query->join('LEFT', $db->quoteName('#__dnagifts_lst_gift').' AS g ON g.id = a.gift_id');
		$query->where('a.id = '. (int) $question_id);
		$db->setQuery($query);
		$data = $db->loadObject();
		
		$gift_name		= $data->gift_name;
		$color_hex		= $data->color_hex;
		$gift_code		= $data->gift_code;
		$question_code	= $data->question_code;
		$colorpatch 	= "<div class=\"hasTip\" title=\"Gifting::This question is linked to ".$gift_name."\" style=\"display:inline; margin-right:5px; color:black; background-color: ".$color_hex."\">&nbsp;".$gift_code."&nbsp;</div>";
		$text 			= DnagiftsHelper::addEllipsis($data->question_text,30);
		
		echo json_encode(array("success" => true,"text" => $colorpatch.$question_code.": ".$text));
	}
	
	public function saveNewTestButton() {
		$test_id = JRequest::getCmd('test_id');
		$button_id = JRequest::getCmd('button_id');
		
		$db = JFactory::getDbo();
		
		$query = $db->getQuery(true);
		$query->select('MAX(ordering) + 1 As ordering');
		$query->from($db->quoteName('#__dnagifts_lnk_test_buttonset'));
		$query->where('test_id = '. (int) $test_id);
		$db->setQuery($query);
		$data = $db->loadObject();
		
		// Insert the new record
		$query = $db->getQuery(true);
		$query->insert('#__dnagifts_lnk_test_buttonset ');
		$query->columns('test_id, button_id, ordering');
		$query->values((int) $test_id . ',' . (int) $button_id . ','. (int) $data->ordering);
		$db->setQuery($query);
		if (!$db->query()) {
			$this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_BUTTON'));
			echo json_encode(array("success"=> false, "message" => JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_BUTTON')));
			return false;
		}
		$link_id = $db->insertid();
		
		// get button details
		$query = $db->getQuery(true);
		$query->select('id, button_text, language');
		$query->from($db->quoteName('#__dnagifts_option_button'));
		$query->where('id = '. (int) $button_id);
		$query->order('ordering');
		$db->setQuery($query);
		$data = $db->loadObject();
		
		$button_text = $data->button_text;
		$language = $data->language;
		
		$html = '<li id="test-button-'.$link_id.'" data="{link_id: \''.$link_id.'\', test_id: \''.$test_id.'\', button_id: \''.$button_id.'\', language: \''.$language.'\'}" class="ui-state-default">'.
			'<div class="buttonDetailsContainer">'.
				'<a class="ui-icon ui-icon-arrowthick-2-n-s " title="Click and drag Button to new position" href="#" style="float:left">Drag Button</a>'.
				'<div class="testButtonText">'.$button_text.'</div>'.
				'<div class="testButtonLanguage"> ('.$language.')</div>'.
			'</div>'.
			'<div class="actionButtonsContainer">'.
				'<a class="ui-icon ui-icon-arrowthickstop-1-s actionBtn toBottomBtn" title="To Bottom" href="#" style="float:right">To Bottom</a>'.
				'<a class="ui-icon ui-icon-arrowthick-1-s actionBtn downOneBtn" title="Down One" href="#" style="float:right">Down One</a>'.
				'<a class="ui-icon ui-icon-arrowthick-1-n actionBtn upOneBtn" title="Up One" href="#" style="float:right">Up One</a>'.
				'<a class="ui-icon ui-icon-arrowthickstop-1-n actionBtn toTopBtn" title="To Top" href="#" style="float:right">To Top</a>'.
				'<strong class="actionButtonSpacer">&nbsp;</strong>'.
				'<a class="ui-icon ui-icon-close actionBtn goDeleteBtn" title="Delete" href="#" style="float:right">Delete</a>'.
				'<a class="ui-icon ui-icon-pencil actionBtn goEditBtn" title="Edit" href="#" style="float:right">Edit</a>'.
			'</div></li>';
		
		echo json_encode(array("success" => true, "html" => $html));
	}
	
	public function saveNewTestQuestion() {
		$test_id = JRequest::getCmd('test_id');
		$question_id = JRequest::getCmd('question_id');
		$show_duration = JRequest::getCmd('show_duration');
		
		$db = JFactory::getDbo();
		$user	= JFactory::getUser();
		
		$query = $db->getQuery(true);
		$query->select('MAX(ordering) + 1 As ordering');
		$query->from($db->quoteName('#__dnagifts_lnk_test_question'));
		$query->where('test_id = '. (int) $test_id);
		$db->setQuery($query);
		$data = $db->loadObject();
		
		// Insert the new record
		$query = $db->getQuery(true);
		$query->insert('#__dnagifts_lnk_test_question ');
		$query->columns('test_id, question_id, show_duration, ordering, created_by, published');
		$query->values((int) $test_id . ',' . (int) $question_id . ',' . (int) $show_duration . ',' .(int) $data->ordering . ',' . $user->get('id') . ', 1');
		$db->setQuery($query);
		if (!$db->query()) {
			$this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_QUESTION'));
			echo json_encode(array("success"=> false, "message" => JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_QUESTION')));
			return false;
		}
		$link_id = $db->insertid();
		
		// get question details
		$query = $db->getQuery(true);
		$query->select('a.id as id, a.question_code as question_code, a.question_text as question_text, a.language as language');
		$query->from($db->quoteName('#__dnagifts_question'). 'AS a');
		
		$query->select('g.code AS gift_code, g.name AS gift_name, g.color_hex as color_hex');
		$query->join('LEFT', $db->quoteName('#__dnagifts_lst_gift').' AS g ON g.id = a.gift_id');
		
		$query->where('a.id = '. (int) $question_id);
		$query->order('a.ordering');
		$db->setQuery($query);
		$data = $db->loadObject();
		
		$question_text	= $data->question_text;
		$question_code	= $data->question_code;
		$language 		= $data->language;
		$gift_name		= $data->gift_name;
		$color_hex		= $data->color_hex;
		$gift_code		= $data->gift_code;
		$colorpatch 	= "<div class=\"hasTip\" title=\"Gifting::This question is linked to ".$gift_name."\"style=\"display:inline; margin-right:5px; color:black; background-color: ".$color_hex."\">&nbsp;".$gift_code."&nbsp;</div>";
		
		$html = '<li id="test-question-'.$link_id.'" data="{link_id: \''.$link_id.'\', test_id: \''.$test_id.'\', question_id: \''.$question_id.'\', language: \''.$language.'\', show_duration: '.$show_duration.'}" class="ui-state-default">'.
			'<div class="questionDetailsContainer">'.
				'<a class="ui-icon ui-icon-arrowthick-2-n-s hasTip" title="Drag and Drop::Click and drag Question to new position" href="#" style="float:left">Drag Question</a>'.
				'<div class="testQuestionText">'.$colorpatch.$question_code.": ".DnagiftsHelper::addEllipsis($question_text,30).'</div>'.
				'<div class="testQuestionLanguage"> ('.$language.')</div>'.
				'<div class="testShowDuration"> ('.$show_duration.' sec)</div>'.
			'</div>'.
			'<div class="actionQuestionsContainer">'.
				'<a class="ui-icon ui-icon-arrowthickstop-1-s actionBtn toBottomBtn hasTip" title="Quick Move::Question to bottom of list" href="#" style="float:right">To Bottom</a>'.
				'<a class="ui-icon ui-icon-arrowthick-1-s actionBtn downOneBtn hasTip" title="Quick Move::Question down one position" href="#" style="float:right">Down One</a>'.
				'<a class="ui-icon ui-icon-arrowthick-1-n actionBtn upOneBtn hasTip" title="Quick Move::Question up one position" href="#" style="float:right">Up One</a>'.
				'<a class="ui-icon ui-icon-arrowthickstop-1-n actionBtn toTopBtn hasTip" title="Quick Move::Question to top of list" href="#" style="float:right">To Top</a>'.
				'<strong class="actionButtonSpacer">&nbsp;</strong>'.
				'<a class="ui-icon ui-icon-close actionBtn goDeleteBtn hasTip" title="Action::Click to Delete question" href="#" style="float:right">Delete</a>'.
				'<a class="ui-icon ui-icon-pencil actionBtn goEditBtn hasTip" title="Action::Click to Edit question" href="#" style="float:right">Edit</a>'.
			'</div></li>';
		
		echo json_encode(array("success" => true, "html" => $html));
	}
	
	public function reorderTestButtons() {
		$buttons = JRequest::getVar('buttons',array(),'post','ARRAY');
		$db = JFactory::getDbo();
		$i = 1;
		foreach($buttons as $id) {
			$query = $db->getQuery(true);
			$query->update('#__dnagifts_lnk_test_buttonset');
			$query->set('ordering = ' . (int) $i);
			$query->where('id = ' . (int) $id);
			$db->setQuery($query);
			$db->query();
			$i++;
		}
	}
	
	public function reorderTestQuestions() {
		$questions = JRequest::getVar('questions',array(),'post','ARRAY');
		$db = JFactory::getDbo();
		$i = 1;
		foreach($questions as $id) {
			$query = $db->getQuery(true);
			$query->update('#__dnagifts_lnk_test_question');
			$query->set('ordering = ' . (int) $i);
			$query->where('id = ' . (int) $id);
			$db->setQuery($query);
			$db->query();
			$i++;
		}
	}
	
	public function deleteTestButton() {
		$link_id = JRequest::getCmd('link_id');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->delete();
		$query->from('#__dnagifts_lnk_test_buttonset');
		$query->where('id = ' . (int) $link_id);
		$db->setQuery($query);
		if (!$db->query()) {
			$this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_DELETE_BUTTON'));
			echo json_encode(array("success"=> false));
		} else {
			echo json_encode(array("success" => true));
		}
	}
	
	public function deleteTestQuestion() {
		$link_id = JRequest::getCmd('link_id');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->delete();
		$query->from('#__dnagifts_lnk_test_question');
		$query->where('id = ' . (int) $link_id);
		$db->setQuery($query);
		if (!$db->query()) {
			$this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_DELETE_QUESTION'));
			echo json_encode(array("success"=> false));
		} else {
			echo json_encode(array("success" => true));
		}
	}
	
	public function saveUseTiming() {
		$test_id = JRequest::getCmd('test_id');
		$use_timing = JRequest::getCmd('use_timing');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_test');
		$query->set('use_timing = ' . (int) $use_timing);
		$query->where('id = ' . (int) $test_id);
		$db->setQuery($query);
		if (!$db->query()) {
			$this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_UPDATE_USETIMING'));
			echo json_encode(array("success"=> false));
		} else {
			echo json_encode(array("success" => true));
		}
	}
	
	public function saveDefaultDuration() {
		$test_id = JRequest::getCmd('test_id');
		$default_duration = JRequest::getCmd('default_duration');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_test');
		$query->set('default_duration = ' . (int) $default_duration);
		$query->where('id = ' . (int) $test_id);
		$db->setQuery($query);
		if (!$db->query()) {
			$this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_UPDATE_DEFAULTDURATION'));
			echo json_encode(array("success"=> false));
		} else {
			echo json_encode(array("success" => true));
		}
	}
	
	public function saveTestDuration() {
		$test_id = JRequest::getCmd('test_id');
		$test_duration = JRequest::getCmd('test_duration');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_test');
		$query->set('test_duration = \'' . $test_duration.'\'');
		$query->where('id = ' . (int) $test_id);
		$db->setQuery($query);
		if (!$db->query()) {
			$this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_UPDATE_TESTDURATION'));
			echo json_encode(array("success"=> false));
		} else {
			echo json_encode(array("success" => true));
		}
	}
	
	public function saveShowProgressbar() {
		$test_id = JRequest::getCmd('test_id');
		$show_progressbar= JRequest::getCmd('show_progressbar');
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_test');
		$query->set('show_progressbar = ' . (int) $show_progressbar);
		$query->where('id = ' . (int) $test_id);
		$db->setQuery($query);
		if (!$db->query()) {
			$this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_UPDATE_SHOWPROGRESSBAR'));
			echo json_encode(array("success"=> false));
		} else {
			echo json_encode(array("success" => true));
		}
	}
}