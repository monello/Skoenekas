<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.model');

class DnaGiftsModelReport extends JModel
{
	
	public function makeSortFunction($field)
	{
		$code = "return strnatcmp(\$a['$field'], \$b['$field']);";
		return create_function('$a,$b', $code);
	}
	
	public function getResultsObject($test_user_id) {
		
		// loop through all the answers
		// use the view "ccblm_dnagifts_testquestions_and_answers"
		//	- where test_user_id is matched
		//	- order by gift_id
		$db = $this->getDbo();
		
		$query1 = $db->getQuery(true);
		$giftObj = array();
		$query1->select('*');
		$query1->from($db->quoteName('#__dnagifts_lst_gift'));
		$db->setQuery($query1);
		$giftdata = $db->loadObjectList();
		foreach($giftdata as $i => $gift) {
			$giftObj[$gift->id] = $gift;
		}
		
		$query = $db->getQuery(true);
		$query->select('gift_id, sum(answer_score) as total_score');
		$query->from($db->quoteName('#__dnagifts_testquestions_and_answers'));
		$query->where($db->quoteName('lnk_user_test_id') . " = " . $db->quote($test_user_id));
		$query->group($db->quoteName('gift_id'));
		$query->order($db->getEscaped('total_score DESC'));
		$db->setQuery($query);
		$data = $db->loadObjectList();
		
		$dnaResults = array();
		foreach($data as $position => $result) {
			$gift_id = $result->gift_id;
			$hash = '/\#/';
			$dnaResults[] = array(
				'ordering' => $giftObj[$gift_id]->ordering,
				'label' => $giftObj[$gift_id]->name,
				'abbr'=> $giftObj[$gift_id]->code,
				'score'=> (int) $result->total_score,
				'position'=> (int) $position,
				'redColor'=> preg_replace($hash, '', $giftObj[$gift_id]->color_hex),
				'yellowColor'=> preg_replace($hash, '', $giftObj[$gift_id]->color_hex_medium),
				'greenColor' => preg_replace($hash, '', $giftObj[$gift_id]->color_hex_light),
				'characterImg' => $giftObj[$gift_id]->characters_image,
				'textImg' => $giftObj[$gift_id]->text_image,
				'tagLine' => $giftObj[$gift_id]->tag_line,
				'position1Html' => $giftObj[$gift_id]->position1_html,
				'position2Html' => $giftObj[$gift_id]->position2_html,
				'position3Html' => $giftObj[$gift_id]->position3_html,
				'position4Html' => $giftObj[$gift_id]->position4_html,
				'position5Html' => $giftObj[$gift_id]->position5_html,
				'position6Html' => $giftObj[$gift_id]->position6_html,
				'position7Html' => $giftObj[$gift_id]->position7_html
			);
		}
		
		$compare = $this->makeSortFunction('ordering');
		usort($dnaResults, $compare);
		
		return $dnaResults;
	}

}
