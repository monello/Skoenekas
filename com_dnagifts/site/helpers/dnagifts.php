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
	
	public static function hasPretestInfo()
	{
		$user = JFactory::getUser();
		
		if (!$user) {
			return 0;
		}
		
		$db = JFactory::getDBO();
		$query = "
			SELECT COUNT(*)
				FROM ".$db->nameQuote('#__dnagifts_pretest_info')."
				WHERE ".$db->nameQuote('user_id')." = ".$db->quote($user->get("id")).";
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
			return 'undefined';
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
		$query = "
			SELECT COUNT(*)
			FROM ".$db->nameQuote('#__dnagifts_testquestions_and_answers')." AS a
			WHERE ".$db->nameQuote('lnk_user_test_id')." = ".$db->quote($user_test_id)."
			AND ".$db->nameQuote('test_id')." = ".$db->quote($test_id);
			
		$db->setQuery($query);
		$progress['answers'] = $db->loadResult();
		
		// get percentage complete
		$progress['percent'] = round($progress['answers'] / $progress['howmany'] * 100);
		
		// check if the test is still in-progres for this user
		if ((int) $progress['percent'] > 0 && (int) $progress['percent'] < 100) {
			$progress['inprogress'] = true;
		} else {
			$progress['inprogress'] = false;
		}
		
		return $progress;
	}
	
	
	
	
	public static function generatepdf($author='Nicola Asuni', $title='TCPDF Example 001',
				$subject='TCPDF Tutorial', $keywords='TCPDF, PDF, example, test, guide',
				$documentname='example001', $displaytype='I')
  {
    @ob_end_clean();      
    
    require_once(JPATH_ROOT.DS.'tcpdf'.DS.'config/lang/eng.php');
    require_once(JPATH_ROOT.DS.'tcpdf'.DS.'tcpdf.php');
          
    // create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    
    // set document information
    //$pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor($author);
    $pdf->SetTitle($title);
    $pdf->SetSubject($subject);
    $pdf->SetKeywords($keywords);
    
    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
    
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    
    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    
    //set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    
    //set some language-dependent strings
    $pdf->setLanguageArray($l);
    
    // ---------------------------------------------------------
    
    // set default font subsetting mode
    $pdf->setFontSubsetting(true);
    
    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('dejavusans', '', 14, '', true);
    
    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage();
    
    // Set some content to print
    $html = <<<EOD
<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
<i>This is the first example of TCPDF library.</i>
<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
<p>Please check the source code documentation and other examples for further information.</p>
<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
EOD;
    
    // Print text using writeHTMLCell()
    //$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		
		// Print text using writeHTML()
    $pdf->writeHTML($html);
    
    // ---------------------------------------------------------
    
    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    $pdf->Output($documentname.'.pdf', $displaytype);
	}
}
