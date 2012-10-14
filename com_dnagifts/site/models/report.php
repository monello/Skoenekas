<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.model');

class DnaGiftsModelReport extends JModel
{
	public function getResultsObject($test_user_id) {
		$dnaResults = array(
			array(
				'label' => 'Perceiver',
				'abbr'=> 'P',
				'score'=> 23,
				'position'=> 3,
				'redColor'=> 'FF0000',
				'yellowColor'=> 'FF6262',
				'greenColor' => 'FF7F7F',
				'characterImg' => 'perceiver.png',
				'textImg' => 'perceiver.png',
				'textToken' => 'COM_DNAGIFTS_REPORT_PERCEIVER'
			),
			array(
				'label'=> 'Servant',
				'abbr'=> 'S',
				'score'=> 18,
				'position'=> 5,
				'redColor'=> 'FFC000',
				'yellowColor'=> 'FFCC99',
				'greenColor' =>'FFEAB8',
				'characterImg' => 'servant.png',
				'textImg' => 'servant.png',
				'textToken' => 'COM_DNAGIFTS_REPORT_SERVANT'
			),
			array(
				'label' => 'Teacher',
				'abbr'=> 'T',
				'score'=> 16,
				'position'=> 6,
				'redColor'=> 'FFFF00',
				'yellowColor'=> 'FFFF99',
				'greenColor' =>'FFFCCD',
				'characterImg' => 'teacher.png',
				'textImg' => 'teacher.png',
				'textToken' => 'COM_DNAGIFTS_REPORT_TEACHER'
			),
			array(
				'label' => 'Exhorter',
				'abbr'=> 'E',
				'score'=> 49,
				'position'=> 0,
				'redColor'=> '00B050',
				'yellowColor'=> '99CC99',
				'greenColor' =>'BFFFBF',
				'characterImg' => 'exhorter.png',
				'textImg' => 'exhorter.png',
				'textToken' => 'COM_DNAGIFTS_REPORT_EXHORTER'
			),
			array(
				'label' => 'Giver',
				'abbr'=> 'G',
				'score'=> 35,
				'position'=> 2,
				'redColor'=> '538ED5',
				'yellowColor'=> '66CCCC',
				'greenColor' =>'AEF5FF',
				'characterImg' => 'giver.png',
				'textImg' => 'giver.png',
				'textToken' => 'COM_DNAGIFTS_REPORT_GIVER'
			),
			array(
				'label' => 'Ruler',
				'abbr'=> 'R',
				'score'=> 40,
				'position'=> 1,
				'redColor'=> '333391',
				'yellowColor'=> '6666CC',
				'greenColor' =>'ADAAFF',
				'characterImg' => 'ruler.png',
				'textImg' => 'ruler.png',
				'textToken' => 'COM_DNAGIFTS_REPORT_RULER'
			),
			array(
				'label' => 'Mercy',
				'abbr'=> 'M',
				'score'=> 19,
				'position'=> 4,
				'redColor'=> '990099',
				'yellowColor'=> '9966CC',
				'greenColor' =>'D9B4FF',
				'characterImg' => 'mercy.png',
				'textImg' => 'mercy.png',
				'textToken' => 'COM_DNAGIFTS_REPORT_MERCY'
			)
		);
		return $dnaResults;
	}

}
