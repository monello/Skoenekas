<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HTML View class for the DnaGifts Component
 */
class DnaGiftsViewReport extends JView
{
	public function display($tpl = null) 
	{	
		$model		= $this->getModel();
		$app		= JFactory::getApplication();
	    $params    	= $app->getParams();
    	$dispatcher	= JDispatcher::getInstance();
		
		$test_user_id = 1; //mrl: provide real test_user_id
		
		$this->assignRef( 'dnaResults', $model->getResultsObject($test_user_id));
		$this->assignRef( 'user', JFactory::getUser() );
		
		$chartdataArr = array();
		$seriescolorsArr = array();
		$axeslabelsAbbrArr = array();
		$axeslabelsScoresArr = array();
		$chartfillArr = array();
		$markersArr = array();
		$legendsArr = array();
		$primaryDatapoint = 0;
		$secondaryDatapoint = 0;
		
		$cntr = 0;
		foreach($this->dnaResults as $data) {
			array_push($chartdataArr,$data['score']);
			array_push($seriescolorsArr,$data['redColor']);
			array_push($axeslabelsAbbrArr,$data['abbr']);
			array_push($axeslabelsScoresArr,$data['score']);
			array_push($chartfillArr,$data['yellowColor']);
			array_push($markersArr,$data['redColor']);
			array_push($legendsArr,$data['label']);
			if ((int) $data['position'] == 0) {
				$primaryDatapoint = $cntr;
			}
			if ((int) $data['position'] == 1) {
				$secondaryDatapoint = $cntr;
			}
			$cntr++;
		}
		
		$this->assignRef( 'chartdata', implode(",",$chartdataArr));
		$this->assignRef( 'seriescolors', implode("|",$seriescolorsArr));
		$this->assignRef( 'axeslabelsAbbr', implode("|",$axeslabelsAbbrArr));
		$this->assignRef( 'axeslabelsScores', implode("|",$axeslabelsScoresArr));
		$this->assignRef( 'legends', implode("|",$legendsArr));
		$this->assignRef( 'chartfillArr', $chartfillArr);
		$this->assignRef( 'markersArr', $markersArr);
		$this->assignRef( 'primaryDatapoint', $primaryDatapoint);
		$this->assignRef( 'secondaryDatapoint', $secondaryDatapoint);
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$html = $this->loadTemplate($tpl);
		if ($html instanceof Exception)
		{
			return $html;
		}

		echo $html;
		
		/*DnagiftsHelper::generatepdf('Morne Louw', 'DNA Gifts - Report',
				'Test Results', 'DNA Gifts, Free Test',
				'results001', $html, 'I');
		*/
		
		// Set the document
		$this->setDocument();
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		
		/**
		 * NOTE: Only add stylesheets and scripts here that are applicable ONLY to
		 * 		this page. If it is needed on multiple pages add it to <base>/dnagifts.php
		**/
		// Stylesheets
		$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/dnagifts.report.css');
		
		// Javascripts
		$document->addScript('https://www.google.com/jsapi');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.report.js');
	}
}
