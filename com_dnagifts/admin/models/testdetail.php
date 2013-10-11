<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * DnaGifts Model
 */
class DnaGiftsModelTestdetail extends JModelList
{
	function getTestQuestions($test_id) 
	{
		$db = $this->getDBO();
		$sql = "SELECT a.*, g.name, g.color_hex, g.color_hex_medium, g.color_hex_light
			FROM #__dnagifts_list_testquestions a
			LEFT JOIN #__dnagifts_lst_gift g ON a.gift_id = g.id
			WHERE a.test_id = $test_id
			ORDER BY a.ordering";
		$db->setQuery($sql);
		$data = $db->loadObjectList();
		return $data;
	}
	
	function getTestSummary($user_test_id) {
		$db = $this->getDBO();
		$sql = "SELECT *
			FROM #__dnagifts_lnk_user_tests
			WHERE id = $user_test_id";
		$db->setQuery($sql);
		return $db->loadObject();
	}
	
	function getUserAnswers($user_test_id) 
	{
		$db = $this->getDBO();
		$sql = "SELECT *
			FROM #__dnagifts_lnk_user_test_answers
			WHERE lnk_user_test_id = $user_test_id";
		$db->setQuery($sql);
		$data = $db->loadObjectList();
		return $data;
	}
	
	function getButtonScores($test_id) 
	{
		$db = $this->getDBO();
		$sql = "SELECT score, button_text
			FROM #__dnagifts_list_testbuttons
			WHERE test_id = $test_id";
		$db->setQuery($sql);
		$data = $db->loadObjectList();
		return $data;
	}
	
	function getTestScoreGroups($user_test_id) 
	{
		$db = $this->getDBO();
		$sql = "SELECT a.answer_score, b.button_text, COUNT(*) AS howmany
			FROM #__dnagifts_lnk_user_test_answers a 
			LEFT JOIN #__dnagifts_option_button b ON b.score = a.answer_score
			WHERE lnk_user_test_id = $user_test_id
			GROUP BY a.answer_score
			ORDER BY a.answer_score";
		$db->setQuery($sql);
		$data = $db->loadObjectList();
		return $data;
	}
}
