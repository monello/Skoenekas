<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.model');

class DnaGiftsModelReport extends JModel
{
	public function getResultsObject() {
		$dnaResults = array(
			array(
				'label' => 'Perceiver',
				'abbr'=> 'P',
				'score'=> 23,
				'position'=> 3,
				'redColor'=> 'FF0000',
				'yellowColor'=> 'FF6262',
				'greenColor' =>'FF7F7F'
			),
			array(
				'label'=> 'Servant',
				'abbr'=> 'S',
				'score'=> 18,
				'position'=> 5,
				'redColor'=> 'FFC000',
				'yellowColor'=> 'FFCC99',
				'greenColor' =>'FFEAB8'
			),
			array(
				'label' => 'Teacher',
				'abbr'=> 'T',
				'score'=> 16,
				'position'=> 6,
				'redColor'=> 'FFFF00',
				'yellowColor'=> 'FFFF99',
				'greenColor' =>'FFFCCD'
			),
			array(
				'label' => 'Exhorter',
				'abbr'=> 'E',
				'score'=> 49,
				'position'=> 0,
				'redColor'=> '00B050',
				'yellowColor'=> '99CC99',
				'greenColor' =>'BFFFBF'
			),
			array(
				'label' => 'Giver',
				'abbr'=> 'G',
				'score'=> 35,
				'position'=> 2,
				'redColor'=> '538ED5',
				'yellowColor'=> '66CCCC',
				'greenColor' =>'AEF5FF'
			),
			array(
				'label' => 'Ruler',
				'abbr'=> 'R',
				'score'=> 40,
				'position'=> 1,
				'redColor'=> '333391',
				'yellowColor'=> '6666CC',
				'greenColor' =>'ADAAFF'
			),
			array(
				'label' => 'Mercy',
				'abbr'=> 'M',
				'score'=> 19,
				'position'=> 4,
				'redColor'=> '990099',
				'yellowColor'=> '9966CC',
				'greenColor' =>'D9B4FF'
			)
		);
		return $dnaResults;
	}

}
