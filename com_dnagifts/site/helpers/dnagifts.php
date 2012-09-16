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
		$progress['percent'] = 0;
		if ($progress['howmany']) {
			$progress['percent'] = round($progress['answers'] / $progress['howmany'] * 100);
		}
    
		// check if the test is still in-progres for this user
		if ((int) $progress['percent'] > 0 && (int) $progress['percent'] < 100) {
			$progress['inprogress'] = true;
		} else {
			$progress['inprogress'] = false;
		}
		
		return $progress;
	}
	
	public static function hasCompletedTests()
	{
		$user = JFactory::getUser();
		
		if (!$user) {
			return 0;
		}
		
		$db	= JFactory::getDBO();
		
		$query = "
			SELECT *
			FROM ".$db->nameQuote('#__dnagifts_lnk_user_tests')."
			WHERE ".$db->nameQuote('user_id')." = ".$db->quote($user->get("id"));
		$db->setQuery($query);
		$data = $db->loadObjectList();
		
		foreach($data as $i => $lut) {
			$progress = DnagiftsHelper::getUserProgress($lut->id, $lut->test_id);
			if ((int) $progress['percent'] >= 100) {
				return 1;
			}
		}
		return 0;
	}
	
/*	
	public static function generatepdf($author='Nicola Asuni', $title='TCPDF Example 001',
				$subject='TCPDF Tutorial', $keywords='TCPDF, PDF, example, test, guide',
				$documentname='example001', $html='No content', $displaytype='I')
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
//    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
	$pdf->SetHeaderData('dna_banner1.jpg', 100, 'Your DNA Gifts Report', "by Juan Nel - DNAGifts.co.za\nwww.dnagifts.co.za");
    
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
//    $html = <<<EOD
//<h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;">&nbsp;<span style="color:black;">TC</span><span style="color:white;">PDF</span>&nbsp;</a>!</h1>
//<i>This is the first example of TCPDF library.</i>
//<p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
//<p>Please check the source code documentation and other examples for further information.</p>
//<p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
//EOD;
    
    // Print text using writeHTMLCell()
    //$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
		
		// Print text using writeHTML()
    $pdf->writeHTML($html);

    // ---------------------------------------------------------

	//$pdf->Image(<IMAGE URL>, <left>, <top>, <width>);
//	$pdf->Image('http://chart.apis.google.com/chart?cht=ls&chd=t:1366,1459,2534,2551,2589&chco=76A4FB&chls=2.0,0.0,0.0&chxt=x&chxl=0:|19|20|21|22|23&chs=600x150&chds=1366,2589', 50, 150, 100);
//	$pdf->Image('http://chart.apis.google.com/chart?cht=bvg&chs=200×125&chd=s:hello,world&chco=cc0000,00aa00', '', '', 100);
    
    // ---------------------------------------------------------
    
//	$pdf->ImageSVG($file='@<svg width="400" height="300" style="overflow: hidden;"><defs id="defs"/><rect x="0" y="0" width="400" height="300" stroke="none" stroke-width="0" fill="#ffffff"/><g><text text-anchor="start" x="77" y="38.35" font-family="Arial" font-size="11" font-weight="bold" stroke="none" stroke-width="0" fill="#000000">How Much Pizza I Ate Last Night</text></g><g><rect x="248" y="58" width="76" height="83" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"/><g><rect x="248" y="58" width="76" height="11" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"/><g><text text-anchor="start" x="263" y="67.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#222222">Mushrooms</text></g><rect x="248" y="58" width="11" height="11" stroke="none" stroke-width="0" fill="#3366cc"/></g><g><rect x="248" y="76" width="76" height="11" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"/><g><text text-anchor="start" x="263" y="85.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#222222">Onions</text></g><rect x="248" y="76" width="11" height="11" stroke="none" stroke-width="0" fill="#dc3912"/></g><g><rect x="248" y="94" width="76" height="11" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"/><g><text text-anchor="start" x="263" y="103.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#222222">Olives</text></g><rect x="248" y="94" width="11" height="11" stroke="none" stroke-width="0" fill="#ff9900"/></g><g><rect x="248" y="112" width="76" height="11" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"/><g><text text-anchor="start" x="263" y="121.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#222222">Zucchini</text></g><rect x="248" y="112" width="11" height="11" stroke="none" stroke-width="0" fill="#109618"/></g><g><rect x="248" y="130" width="76" height="11" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"/><g><text text-anchor="start" x="263" y="139.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#222222">Pepperoni</text></g><rect x="248" y="130" width="11" height="11" stroke="none" stroke-width="0" fill="#990099"/></g></g><g><path d="M154,151L154,75A76,76,0,0,1,207.74011537017762,204.7401153701776L154,151A0,0,0,0,0,154,151" stroke="#ffffff" stroke-width="1" fill="#3366cc"/><text text-anchor="start" x="183.37241046222232" y="136.26323901017514" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#ffffff">37.5%</text></g><g><path d="M154,151L78,151A76,76,0,0,1,154,75L154,151A0,0,0,0,0,154,151" stroke="#ffffff" stroke-width="1" fill="#990099"/><text text-anchor="start" x="105.37040213776933" y="117.22040213776936" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#ffffff">25%</text></g><g><path d="M154,151L100.2598846298224,204.74011537017762A76,76,0,0,1,78,151L154,151A0,0,0,0,0,154,151" stroke="#ffffff" stroke-width="1" fill="#109618"/><text text-anchor="start" x="93.62758953777768" y="173.43676098982488" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#ffffff">12.5%</text></g><g><path d="M154,151L154,227A76,76,0,0,1,100.2598846298224,204.74011537017762L154,151A0,0,0,0,0,154,151" stroke="#ffffff" stroke-width="1" fill="#ff9900"/><text text-anchor="start" x="118.28323932673234" y="203.65757780465376" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#ffffff">12.5%</text></g><g><path d="M154,151L207.74011537017762,204.7401153701776A76,76,0,0,1,154,227L154,151A0,0,0,0,0,154,151" stroke="#ffffff" stroke-width="1" fill="#dc3912"/><text text-anchor="start" x="158.71676067326766" y="203.65757780465373" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#ffffff">12.5%</text></g><g/></svg>', $x=30, $y=100, $w='', $h=100, $link='', $align='', $palign='', $border=0, $fitonpage=false);
	$pdf->ImageSVG($file='@<svg style="overflow: hidden;" height="500" width="900"><defs id="defs"><clipPath id="_ABSTRACT_RENDERER_ID_0"><rect height="309" width="579" y="96" x="161"></rect></clipPath></defs><rect fill="#ffffff" stroke-width="0" stroke="none" height="500" width="900" y="0" x="0"></rect><g><text fill="#000000" stroke-width="0" stroke="none" font-weight="bold" font-size="14" font-family="Arial" y="70.9" x="161" text-anchor="start">Company Performance</text></g><g><rect fill="#ffffff" fill-opacity="0" stroke-width="0" stroke="none" height="37" width="132" y="96" x="754"></rect><g><rect fill="#ffffff" fill-opacity="0" stroke-width="0" stroke="none" height="14" width="132" y="96" x="754"></rect><g><text fill="#222222" stroke-width="0" stroke="none" font-size="14" font-family="Arial" y="107.9" x="773" text-anchor="start">Sales</text></g><rect fill="#3366cc" stroke-width="0" stroke="none" height="14" width="14" y="96" x="754"></rect></g><g><rect fill="#ffffff" fill-opacity="0" stroke-width="0" stroke="none" height="14" width="132" y="119" x="754"></rect><g><text fill="#222222" stroke-width="0" stroke="none" font-size="14" font-family="Arial" y="130.9" x="773" text-anchor="start">Expenses</text></g><rect fill="#dc3912" stroke-width="0" stroke="none" height="14" width="14" y="119" x="754"></rect></g></g><g><rect fill="#ffffff" fill-opacity="0" stroke-width="0" stroke="none" height="309" width="579" y="96" x="161"></rect><g clip-path="url(#_ABSTRACT_RENDERER_ID_0)"><g><rect fill="#cccccc" stroke-width="0" stroke="none" height="1" width="579" y="404" x="161"></rect><rect fill="#cccccc" stroke-width="0" stroke="none" height="1" width="579" y="327" x="161"></rect><rect fill="#cccccc" stroke-width="0" stroke="none" height="1" width="579" y="250" x="161"></rect><rect fill="#cccccc" stroke-width="0" stroke="none" height="1" width="579" y="173" x="161"></rect><rect fill="#cccccc" stroke-width="0" stroke="none" height="1" width="579" y="96" x="161"></rect></g><g><rect fill="#333333" stroke-width="0" stroke="none" height="1" width="579" y="404" x="161"></rect></g><g><path fill="none" fill-opacity="1" stroke-width="2" stroke="#3366cc" d="M233.75,173.5L378.25,108.05000000000001L522.75,304.4L667.25,161.95"></path><path fill="none" fill-opacity="1" stroke-width="2" stroke="#dc3912" d="M233.75,404.5L378.25,381.4L522.75,127.30000000000001L667.25,350.6"></path></g></g><g></g><g><g><text fill="#222222" stroke-width="0" stroke="none" font-size="14" font-family="Arial" y="425.9" x="233.75" text-anchor="middle">2004</text></g><g><text fill="#222222" stroke-width="0" stroke="none" font-size="14" font-family="Arial" y="425.9" x="378.25" text-anchor="middle">2005</text></g><g><text fill="#222222" stroke-width="0" stroke="none" font-size="14" font-family="Arial" y="425.9" x="522.75" text-anchor="middle">2006</text></g><g><text fill="#222222" stroke-width="0" stroke="none" font-size="14" font-family="Arial" y="425.9" x="667.25" text-anchor="middle">2007</text></g><g><text fill="#444444" stroke-width="0" stroke="none" font-size="14" font-family="Arial" y="409.4" x="147" text-anchor="end">400</text></g><g><text fill="#444444" stroke-width="0" stroke="none" font-size="14" font-family="Arial" y="332.4" x="147" text-anchor="end">600</text></g><g><text fill="#444444" stroke-width="0" stroke="none" font-size="14" font-family="Arial" y="255.4" x="147" text-anchor="end">800</text></g><g><text fill="#444444" stroke-width="0" stroke="none" font-size="14" font-family="Arial" y="178.4" x="147" text-anchor="end">1,000</text></g><g><text fill="#444444" stroke-width="0" stroke="none" font-size="14" font-family="Arial" y="101.4" x="147" text-anchor="end">1,200</text></g></g></g><g></g></svg>', $x=30, $y=100, $w='', $h=100, $link='', $align='', $palign='', $border=0, $fitonpage=false);
	
    // Close and output PDF document
    // This method has several options, check the source code documentation for more information.
    //$filename = $pdf->Output($documentname.'.pdf', $displaytype);
	
	if ($displaytype == 'F') {
		$filename = JPATH_SITE.DS."tmp".DS.$documentname.".pdf";
	} else {
		$filename = $documentname.".pdf";
	}
	$pdf->Output($filename, $displaytype);
	
	
	$subject = "You have a new message";
	$body = "Here is the body of your message.";
	$to = "louw.morne@gmail.com";
	$from = array("louw.morne@ymail.com", "Morne Louw");
	 
	# Invoke JMail Class
	$mailer = JFactory::getMailer();
	 
	# Set sender array so that my name will show up neatly in your inbox
	$mailer->setSender($from);
	 
	# Add a recipient -- this can be a single address (string) or an array of addresses
	$mailer->addRecipient($to);
	 
	$mailer->setSubject($subject);
	$mailer->setBody($body);
	 
	# If you would like to send as HTML, include this line; otherwise, leave it out
	$mailer->isHTML();
	
	//$attachment = JPATH_SITE."/README.txt";
	$mailer->addAttachment($filename);
	
	# Send once you have set all of your options
	$mailer->send();
	
	unlink($filename);
	
	echo "PDF EMAIL SENT 8";
	}
*/
	
}
