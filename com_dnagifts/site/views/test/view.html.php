<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the DnaGifts Component
 */
class DnaGiftsViewTest extends JView
{
	/**
	 * display method of DNAGIFT view
	 * @return void
	 */
	protected $survey_data;
	
	public function display($tpl = null) 
	{
		/**
		* The entite test is handled by ajax from here onward.
		*  So I will not be loading the forms through normal Joomla functions
		**/
		$this->survey_data = <<<EOD
		var surveydata = [
  {
    id: 1,
    catid: 1,
    question: 'I present truth and facts in a logical arranged and systematic way',
    answer: undefined,
    duration: 100
  },
  {
    id: 2,
    catid: 2,
    question: 'I make provision for future generations (e.g. children, grandchildren, etc.)',
    answer: undefined,
    duration: 8
  },
  {
    id: 3,
    catid: 3,
    question: 'I am highly motivated to organize and implement plans',
    answer: undefined,
    duration: 7
  },
  {
    id: 4,
    catid: 4,
    question: 'I am capable of having significant disagreements without offence',
    answer: undefined,
    duration: 7
  },
  {
    id: 5,
    catid: 5,
    question: 'I have a tremendous capacity to show love',
    answer: undefined,
    duration: 7
  },
  {
    id: 6,
    catid: 6,
    question: 'I quickly and accurately discern right and wrong, true and false',
    answer: undefined,
    duration: 7
  },
  {
    id: 7,
    catid: 7,
    question: 'I am very quick to recognize practical needs and respond quickly to meet them',
    answer: undefined,
    duration: 8
  },
  {
    id: 8,
    catid: 1,
    question: 'I  have a tendency to validate truth by weighing it against the facts',
    answer: undefined,
    duration: 8
  },
  {
    id: 9,
    catid: 2,
    question: 'I am able to accommodate people with diverse viewpoints from all walks of life',
    answer: undefined,
    duration: 8
  },
  {
    id: 10,
    catid: 3,
    question: 'I Prefer to be under authority in order to have authority',
    answer: undefined,
    duration: 7
  },
  {
    id: 11,
    catid: 4,
    question: 'I avoid being alone, I don’t like spending long periods alone, I thrive being around people',
    answer: undefined,
    duration: 8
  },
  {
    id: 12,
    catid: 5,
    question: 'I can intuitively sense the emotional atmosphere of a group or an individual, |I pick up the emotional frequency and status of people.',
    answer: undefined,
    duration: 9
  },
  {
    id: 13,
    catid: 6,
    question: 'I see everything as either black or white, there is no grey areas',
    answer: undefined,
    duration: 7
  },
  {
    id: 14,
    catid: 7,
    question: 'I derive great joy from showing hospitality',
    answer: undefined,
    duration: 7
  }
];
EOD;

		// Display the template
		parent::display($tpl);
		
		// Set the document
		$this->setDocument();
	}
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		
		/**
		 * NOTE: Only add stylesheets and scripts here that are applicable ONLY to
		 * 		this page. If it is needed on multiple pages add it to <root>/dnagifts.php
		**/
		// Stylesheets
		$document->addStyleSheet(JURI::root(true).'/components/com_dnagifts/css/dnagifts.test.css');
		
		// Javascripts
		$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/ui/jquery.effects.core.min.js');
		$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.widget.min.js');
		$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/ui/jquery.ui.progressbar.min.js');
		$document->addScript(JURI::root(true).'/administrator/components/com_dnagifts/js/jquery.countdown.min.js');
		//$document->addScript(JURI::root(true).'/components/com_dnagifts/js/temp.surveydata.js');
		$document->addScript(JURI::root(true).'/components/com_dnagifts/js/dnagifts.test.countdown.js');
		$document->addScript(JURI::root(true).'/components/com_dnagifts/js/dnagifts.test.js');
	}
}