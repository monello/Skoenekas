<?php
defined('_JEXEC') or die;

require(JPATH_ROOT.DS.'tcpdf'.DS.'config/lang/eng.php');
require(JPATH_ROOT.DS.'tcpdf'.DS.'tcpdf.php');
JLoader::register('UtilsHelper', JPATH_COMPONENT.'/helpers/utils.php');

class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        //$image_file = K_PATH_IMAGES.JText::_( 'COM_DNAGIFTS_PDF_BANNERIMAGE' );
		$image_file = JPATH_ROOT."/media/com_dnagifts/images/".JText::_( 'COM_DNAGIFTS_PDF_BANNERIMAGE' );
        $this->Image($image_file, 15, 10, 180, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    }
	
	// Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Footer Text
        $html = JText::_( 'COM_DNAGIFTS_PDF_FOOTERTEXT_P1' ).'<a href="'.JURI::root().'purchase">'.
			JText::_( 'COM_DNAGIFTS_PDF_FOOTERTEXT_P2' ).'</a> '.
			JText::_( 'COM_DNAGIFTS_PDF_FOOTERTEXT_P3' );
        $this->writeHTML($html);
    }
}

class ReportsHelper
{
	public static function aOrAn($string)
	{
		$vowels = array('a','e','i','o','u');
		$letter = strtolower(substr($string, 0, 1));
		$result = 'a';
		if (in_array($letter, $vowels)) {
		    $result = 'an';
		}
		return $result;
	}
	
	public static function &documentSetup()
	{
		$author             = JText::_( 'COM_DNAGIFTS_PDF_AUTHOR' );
        $title              = JText::_( 'COM_DNAGIFTS_PDF_TITLE' );
		$subject            = JText::_( 'COM_DNAGIFTS_PDF_SUBJECT' );
        $keywords           = JText::_( 'COM_DNAGIFTS_PDF_KEYWORDS' );
        
		// Generate the PDF
        @ob_end_clean();

		// ----------------- document setup ---------------------
		
		// create new PDF document
        //$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // set document information
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
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(PDF_MARGIN_LEFT, 50, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        
        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        
        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        //set some language-dependent strings
        global $l;
        $pdf->setLanguageArray($l);
        
        // set default font subsetting mode
        $pdf->setFontSubsetting(true);
        
        // Set font
        // dejavusans is a UTF-8 Unicode font, if you only need to
        // print standard ASCII chars, you can use core fonts like
        // helvetica or times to reduce file size.
        $pdf->SetFont('dejavusans', '', 10, '', true);

        // Add a page
        // This method has several options, check the source code documentation for more information.
        $pdf->AddPage();
        
		// ----------------- end document setup ---------------------
		
		return $pdf;
	}
		
	public static function getFilename($displaytype, $documentname)
	{
		// ------------- write the document to disk -------------------
        if ($displaytype == 'F') {
            $filename = JPATH_SITE.DS."components".DS."com_dnagifts".DS."store".DS.$documentname;
        } else {
            $filename = $documentname.".pdf";
        }
		
        return $filename;
	}
	
	public static function uniqueDNAChartFilename($userTestID)
	{
		$data = UtilsHelper::reverseUserTestId($userTestID);
		$user_id = $data[1];
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('test_id, started_datetime');
		$query->from($db->quoteName('#__dnagifts_lnk_user_tests'));
		$query->where('id = '.$userTestID);
		$db->setQuery($query);
		$result = $db->loadObject();
		
		$timeblah = array('-',':',' ');
		$timestamp = str_replace($timeblah, "", $result->started_datetime);
		$documentname = 'dnachart_'.$user_id."-".$timestamp."-".$result->test_id;
		
		return $documentname;
	}
  
	public static function generatePDFName($userTestID)
	{
		$documentname       = JText::_( 'COM_DNAGIFTS_PDF_FILENAME' );
		// Generate the report's document name
		$data = UtilsHelper::reverseUserTestId($userTestID);
		$user_id = $data[1];
        
        $db = JFactory::getDbo();
		$query = $db->getQuery(true);
        $query->select('test_id, started_datetime');
		$query->from($db->quoteName('#__dnagifts_lnk_user_tests'));
		$query->where('id = '.$userTestID);
        $db->setQuery($query);
        $result = $db->loadObject();
        $timeblah = array('-',':',' ');
        $timestamp = str_replace($timeblah, "", $result->started_datetime);
        
        $documentname = $documentname." (".$user_id."-".$timestamp."-".$result->test_id.")".".pdf";
		return $documentname;
	}
  
	public static function prepareData($userTestID)
	{
		$report				= new DnaGiftsControllerReport();
		$model				= $report->getModel('Report', 'DnaGiftsModel');
		$dnaResults			= $model->getResultsObject($userTestID);
		
		$documentname = ReportsHelper::generatePDFName($userTestID);
        
		// Log the report name in next to the user-test record
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_lnk_user_tests');
		$query->set('report_name = '.$db->quote($documentname));
		$query->where('id = ' . (int) $userTestID);
		
		$db->setQuery($query);
		$db->query();
		
		return array($documentname, $dnaResults);
	}
	
	public static function generateReportMSIEPDF($displaytype, $userTestID, $username)
	{
		$column1_left = 15;
		$column2_left = 107;
		
		$pdf =& ReportsHelper::documentSetup();
		list ($result, $user_id, $test_id) = UtilsHelper::reverseUserTestId($userTestID);
		
		list ($documentname, $dnaResults) = ReportsHelper::prepareData($userTestID);
		
		// prepare the image charts
		$imgChartSRC		= ReportsHelper::generateDNAChart($dnaResults, $userTestID);
		$dnaPieChartSrc		= ReportsHelper::generateImagePieChart($dnaResults);
		$dnaLineChartSrc	= ReportsHelper::generateImageLineChart($dnaResults);
		
		// ######################################### PAGE 1 ##########################################################
		
		ReportsHelper::generatePDF_Section1($pdf, $column1_left, $column2_left, $dnaResults, $username);
		
		ReportsHelper::reportSeperator($pdf);
		
		ReportsHelper::generatePDF_Section2($pdf, $column1_left, $column2_left, $imgChartSRC);
		
		ReportsHelper::reportSeperator($pdf);
		
		ReportsHelper::generatePDF_Section3($pdf, $column1_left, $column2_left, $dnaPieChartSrc, true);
		
		
		// ######################################### PAGE 2 ##########################################################
		
		$pdf->AddPage();
		
		ReportsHelper::generatePDF_Section4($pdf, $column1_left, $column2_left, $dnaLineChartSrc, true);
		
		ReportsHelper::reportSeperator($pdf);
		
		ReportsHelper::generatePDF_Section5($pdf, $column1_left, $dnaResults, $userTestID);
		
		// ######################################### PAGE 3 ##########################################################
		
		$pdf->AddPage();
		
		ReportsHelper::generatePDF_Section6($pdf, $column1_left, $column2_left, $dnaResults, $svgData, $userTestID, $user_id);
		
		ReportsHelper::reportSeperator($pdf);
		
		ReportsHelper::generatePDF_Section7($pdf, $column1_left, $dnaResults, $svgData, $userTestID);

		// ######## FINALIZE DOCUMENT #########
		$filename = ReportsHelper::getFilename($displaytype, $documentname);

		/*
		 * $pdf->Output() takes a second parameter $dest, which accepts a single character.
		 * The default, $dest='I' opens the PDF in the browser.
		 * Use F to save to file
		 */
        $pdf->Output($filename, $displaytype);
	}
	
	public static function generateReportPDF($displaytype, $svgData, $imgChartSRC, $userTestID, $username)
	{
		$column1_left = 15;
		$column2_left = 107;
		
		$pdf =& ReportsHelper::documentSetup();
		list ($result, $user_id, $test_id) = UtilsHelper::reverseUserTestId($userTestID);
		list ($documentname, $dnaResults) = ReportsHelper::prepareData($userTestID);
		
		// ######################################### PAGE 1 ##########################################################
		
		ReportsHelper::generatePDF_Section1($pdf, $column1_left, $column2_left, $dnaResults, $username);
		
		ReportsHelper::reportSeperator($pdf);
		
		ReportsHelper::generatePDF_Section2($pdf, $column1_left, $column2_left, $imgChartSRC);
		
		ReportsHelper::reportSeperator($pdf);
		
		ReportsHelper::generatePDF_Section3($pdf, $column1_left, $column2_left, $svgData, false);
		
		// ######################################### PAGE 2 ##########################################################
		
		$pdf->AddPage();
		
		ReportsHelper::generatePDF_Section4($pdf, $column1_left, $column2_left, $svgData, false);
		
		ReportsHelper::reportSeperator($pdf);
		
		ReportsHelper::generatePDF_Section5($pdf, $column1_left, $dnaResults, $userTestID);
		
		// ######################################### PAGE 3 ##########################################################
		
		$pdf->AddPage();
		
		ReportsHelper::generatePDF_Section6($pdf, $column1_left, $column2_left, $dnaResults, $svgData, $userTestID, $user_id);
		
		ReportsHelper::reportSeperator($pdf);
		
		ReportsHelper::generatePDF_Section7($pdf, $column1_left, $dnaResults, $svgData, $userTestID);

		// ######## FINALIZE DOCUMENT #########
		$filename = ReportsHelper::getFilename($displaytype, $documentname);
		/*
		 * $pdf->Output() takes a second parameter $dest, which accepts a single character.
		 * The default, $dest='I' opens the PDF in the browser.
		 * Use F to save to file
		 */
        $pdf->Output($filename, $displaytype);
	}
	
	public static function generatePDF_Section1($pdf, $column1_left, $column2_left, $dnaResults, $username)
	{
		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_SCORINGTABLEHEADER	= JText::_('COM_DNAGIFTS_REPORT_SCORINGTABLEHEADER');
		$COM_DNAGIFTS_REPORT_INTRO	= ReportsHelper::generatePDF_ReportIntroHeader();
		
		$pdf->SetXY($column1_left, 50);
		$pdf->SetFont('', 'B', 12, '', true);
		$pdf->SetTextColor(128, 128, 128); // RGB - Grey
		$pdf->Write(0, $COM_DNAGIFTS_REPORT_SCORINGTABLEHEADER, '', 0, 'L', true, 0, false, false, 0);
		
		$pdf->SetXY($column2_left, 50);
		$pdf->SetFont('', '', 10, '', true);
		$pdf->SetTextColor(0, 0, 0); // RGB - Black
		$pdf->Write(0, 'Hi '.$username, '', 0, 'L', true, 0, false, false, 0);
		
		$html = '<table border="0" width="910" cellspacing="3" cellpadding="0" style="font-size:8pt;">
			<tr>
				<td width="305">';
		
		$html .= ReportsHelper::generatePDF_DNAScoringTable($dnaResults);	
		
		$html .= '</td>
				<td width="15">&nbsp;</td>
				<td><p>'.$COM_DNAGIFTS_REPORT_INTRO.'</p></td>		
			</tr>
		</table>';
		
		// Print text using writeHTML()
        $pdf->writeHTML($html);
	}
	
	public static function generatePDF_Section2($pdf, $column1_left, $column2_left, $imgChartSRC)
	{
		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_YOURLINEPROFILE		= JText::_('COM_DNAGIFTS_REPORT_YOURLINEPROFILE');
		$COM_DNAGIFTS_REPORT_YOURLINEPROFILE_INTERP	= JText::_('COM_DNAGIFTS_REPORT_YOURLINEPROFILE_INTERP');
		$COM_DNAGIFTS_REPORT_DNACHART_HEAD			= JText::_('COM_DNAGIFTS_REPORT_DNACHART_HEAD');
		$COM_DNAGIFTS_REPORT_DNACHART_TEXT			= JText::_('COM_DNAGIFTS_REPORT_DNACHART_TEXT');
		$primsecimg = '<img width="234" height="35" src="'.JURI::base(true).'/media/com_dnagifts/images/primary-secondary-'.JText::_('COM_DNAGIFTS_REPORT_DNACHART_PRIMSECIMG').'-2.png" />';
		
		$y = $pdf->GetY() + 7;
		
		$pdf->SetXY($column1_left, $y);
		$pdf->SetFont('', 'B', 12, '', true);
		$pdf->SetTextColor(128, 128, 128); // RGB - Grey
		$pdf->Write(0, $COM_DNAGIFTS_REPORT_YOURLINEPROFILE, '', 0, 'L', true, 0, false, false, 0);
		
		$pdf->SetXY($column2_left, $y);
		$pdf->SetFont('', '', 10, '', true);
		$pdf->SetTextColor(0, 0, 0); // RGB - Black
		$pdf->Write(0, $COM_DNAGIFTS_REPORT_YOURLINEPROFILE_INTERP, '', 0, 'L', true, 0, false, false, 0);
		
		$html = '<table border="0" width="910" cellspacing="3" cellpadding="0" style="font-size:8pt;">
			<tr>
				<td width="305">
				
					<table id="tblDNAChart">
						<tr>
							<td align="center">'.
								$COM_DNAGIFTS_REPORT_DNACHART_HEAD
							.'</td>
						</tr>
						<tr>	
							<td>
								<img src="'.$imgChartSRC.'" />'.
								$primsecimg
							.'</td>
						</tr>
					</table>
		
				</td>
				<td width="15">&nbsp;</td>
				<td>'.$COM_DNAGIFTS_REPORT_DNACHART_TEXT.'</td>		
			</tr>
		</table>';

		
		// Print text using writeHTML()
        $pdf->writeHTML($html);
	}
	
	public static function generatePDF_Section3($pdf, $column1_left, $column2_left, $svgData, $is_MSIE)
	{
		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_DNACOMP_HEAD	= JText::_('COM_DNAGIFTS_REPORT_DNACOMP_HEAD');
		$COM_DNAGIFTS_REPORT_DNACOMP_INTERP	= JText::_('COM_DNAGIFTS_REPORT_DNACOMP_INTERP');
		$COM_DNAGIFTS_REPORT_DNACOMP_TEXT	= JText::_('COM_DNAGIFTS_REPORT_DNACOMP_TEXT');
		
		$y = $pdf->GetY() + 7;
		
		$pdf->SetXY($column1_left, $y);
		$pdf->SetFont('', 'B', 12, '', true);
		$pdf->SetTextColor(128, 128, 128); // RGB - Grey
		$pdf->Write(0, $COM_DNAGIFTS_REPORT_DNACOMP_HEAD, '', 0, 'L', true, 0, false, false, 0);
		
		$pdf->SetXY($column2_left, $y);
		$pdf->SetFont('', '', 10, '', true);
		$pdf->SetTextColor(0, 0, 0); // RGB - Black
		$pdf->Write(0, $COM_DNAGIFTS_REPORT_DNACOMP_INTERP, '', 0, 'L', true, 0, false, false, 0);
		
		$y = $pdf->GetY() + 3;
		$x = $pdf->GetX() - 7;
		
		$html = '<table border="0" width="910" cellspacing="3" cellpadding="0" style="font-size:8pt;">
			<tr>
				<td width="305">';
		
		if ($is_MSIE) {
			$html .= '<img src="'.$svgData.'" />';
		} else {
			$html .= "&nbsp;";	
		}
		
		$html .= '		</td>
				<td width="15">&nbsp;</td>
				<td><p>'.$COM_DNAGIFTS_REPORT_DNACOMP_TEXT.'</p></td>		
			</tr>
		</table>';

		// Print text using writeHTML()
        $pdf->writeHTML($html);
		
		if (!$is_MSIE) {
			$pdf->ImageSVG($file='@'.htmlspecialchars_decode($svgData['piechart_div_hidden']), $x, $y, 
					   $w='', $h=50, $link='', $align='', $palign='', $border=0, $fitonpage=false);
		}
	}
	
	public static function generatePDF_Section4($pdf, $column1_left, $column2_left, $svgData, $is_MSIE)
	{
		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_MOTIFLOW_HEAD		= JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_HEAD');
		$COM_DNAGIFTS_REPORT_MOTIFLOW_INTERP	= JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_INTERP_PDF');
		$COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT		= JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT');
		
		$y = $pdf->GetY();
		
		$pdf->SetXY($column1_left, $y);
		$pdf->SetFont('', 'B', 12, '', true);
		$pdf->SetTextColor(128, 128, 128); // RGB - Grey
		$pdf->Write(0, $COM_DNAGIFTS_REPORT_MOTIFLOW_HEAD, '', 0, 'L', true, 0, false, false, 0);
		
		$pdf->SetXY($column2_left, $y);
		$pdf->SetFont('', '', 10, '', true);
		$pdf->SetTextColor(0, 0, 0); // RGB - Black
		$pdf->Write(0, $COM_DNAGIFTS_REPORT_MOTIFLOW_INTERP, '', 0, 'L', true, 0, false, false, 0);
		
		$y = $pdf->GetY();
		$x = $pdf->GetX();
		
		$html = '<table border="0" width="910" cellspacing="3" cellpadding="0" style="font-size:8pt">
			<tr>';
		
		if ($is_MSIE) {
			$html .= '<td width="305"><img src="'.$svgData.'" />';
			$col1w = '5';
			$col2w = '40';
			$col3w = '40';
			$col4w = '95';
			$col5w = '115';
		} else {
			$html .= '<td width="305" height="155">&nbsp;';
			$col1w = '15';
			$col2w = '40';
			$col3w = '40';
			$col4w = '90';
			$col5w = '100';
		}
		
		$html .= '</td>
		
				<td width="15">&nbsp;</td>
				<td><p>'.$COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT.'</p></td>		
			</tr>
			<tr>
				<td>
					<table style="font-size: 6pt"><tr>
						<td width="'.$col1w.'">&nbsp;</td>
						<td width="'.$col2w.'" align="center" style="background-color: black;color:white;">Authority</td>
						<td width="'.$col3w.'" align="center" style="background-color: darkgrey;">Strength</td>
						<td width="'.$col4w.'">&nbsp;</td>
						<td width="'.$col5w.'"align="center" style="background-color: grey;">The Valley</td>
					</tr></table>
				</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
		</table>';

		// Print text using writeHTML()
        $pdf->writeHTML($html);
		
		if (!$is_MSIE) {
			$pdf->ImageSVG($file='@'.htmlspecialchars_decode($svgData['linechart_div']), $x, $y, 
				$w='', $h=57, $link='', $align='', $palign='', $border=0, $fitonpage=false);
		}
	}
	
	public static function generatePDF_Section5($pdf, $column1_left, $dnaResults, $userTestID)
	{
		$position = 0;

		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_MOTIFLOW_PRIMARY	= JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_PRIMARY');;
		$COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT		= JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT');
		$HEADIMG_SRC 		= ReportsHelper::getHeaderImg($dnaResults, $position);
		$MANIMG_SRC 		= ReportsHelper::getCharacterImg($dnaResults, $position);
		$STRENGTHMETER 		= JText::_('COM_DNAGIFTS_STRENGTHMETER');
		$GIFT_DESC 			= ReportsHelper::getGiftDescription($dnaResults, $position);
		$gauge1chart_svg 	= ReportsHelper::getGaugeSVG($userTestID, $dnaResults, $position);
		
		$y = $pdf->GetY() + 10;
		
		$pdf->SetXY($column1_left, $y);
		$pdf->SetFont('', 'B', 12, '', true);
		$pdf->SetTextColor(128, 128, 128); // RGB - Grey
		$pdf->Write(0, $COM_DNAGIFTS_REPORT_MOTIFLOW_PRIMARY, '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetTextColor(0, 0, 0); // RGB - Black
		$pdf->SetFont('', '', 8, '', true);
		
		$y = $pdf->GetY();
		$x = $pdf->GetX();
		
		$html = '<table border="0" width="910" cellspacing="3" cellpadding="0">
			<tr>
				<td width="305">	
					<img src="'.$HEADIMG_SRC.'"/><br/>
					<img height="245px" src="'.$MANIMG_SRC.'" />
					<p>'.$STRENGTHMETER.'</p>
				</td>
				<td width="15">&nbsp;</td>
				<td>'.$GIFT_DESC.'</td>		
			</tr>
		</table>';

		// Print text using writeHTML()
        $pdf->writeHTML($html);
		
		$pdf->ImageSVG($file='@'.htmlspecialchars_decode($gauge1chart_svg), $x, $y + 90, 
			$w='', $h=35, $link='', $align='', $palign='', $border=0, $fitonpage=false);
	}

	public static function generatePDF_Section6($pdf, $column1_left, $column2_left, $dnaResults, $svgData, $userTestID, $user_id)
	{
		$first_name 		= ReportsHelper::extractFirstName($user_id);
		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY = strtoupper($first_name).JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY');
		$COM_DNAGIFTS_2NDDNAGIFT = JText::_('COM_DNAGIFTS_2NDDNAGIFT');
		$COM_DNAGIFTS_3RDDNAGIFT = JText::_('COM_DNAGIFTS_3RDDNAGIFT');
		$HEADIMG2_SRC 		= ReportsHelper::getHeaderImg($dnaResults, 1);;
		$MANIMG2_SRC 		= ReportsHelper::getCharacterImg($dnaResults, 1);
		$HEADIMG3_SRC 		= ReportsHelper::getHeaderImg($dnaResults, 2);;
		$MANIMG3_SRC 		= ReportsHelper::getCharacterImg($dnaResults, 2);
		$STRENGTHMETER 		= JText::_('COM_DNAGIFTS_STRENGTHMETER');
		$gauge2chart_svg 	= ReportsHelper::getGaugeSVG($userTestID, $dnaResults, 1);
		$gauge3chart_svg 	= ReportsHelper::getGaugeSVG($userTestID, $dnaResults, 2);
		$COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY_SUMMARY = JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY_SUMMARY');
		
		$y = $pdf->GetY();
		
		$pdf->SetXY($column1_left, $y);
		$pdf->SetFont('', 'B', 12, '', true);
		$pdf->SetTextColor(128, 128, 128); // RGB - Grey
		$pdf->Write(0, $COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY, '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetTextColor(0, 0, 0); // RGB - Black
		$pdf->SetFont('', '', 8, '', true);
		
		$y = $pdf->GetY();
		$x = $pdf->GetX();
		
		$html = '<table border="0" width="910" cellspacing="3" cellpadding="0">
			<tr>
				<td width="305">
					<span style="font-size:12pt;font-weight:bold;color:#999">'.$COM_DNAGIFTS_2NDDNAGIFT.'</span><br/>
					<img src="'.$HEADIMG2_SRC.'"/><br/>
					<img height="245px" src="'.$MANIMG2_SRC.'" />
					<p>'.$STRENGTHMETER.'</p>
					<img height="110px" width="110px" src="'.JPATH_SITE.'/media/com_dnagifts/images/spacer10x10.jpg" />
				</td>
				<td width="15">&nbsp;</td>
				<td>
					<span style="font-size:12pt;font-weight:bold;color:#999">'.$COM_DNAGIFTS_3RDDNAGIFT.'</span><br/>
					<img src="'.$HEADIMG3_SRC.'"/><br/>
					<img height="245px" src="'.$MANIMG3_SRC.'" />
					<p>'.$STRENGTHMETER.'</p>
					<img height="110px" width="110px" src="'.JPATH_SITE.'/media/com_dnagifts/images/spacer10x10.jpg" />
				</td>		
			</tr>
			<tr>
				<td colspan="3">'.$COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY_SUMMARY.'</td>
			</tr>
		</table>';

		// Print text using writeHTML()
        $pdf->writeHTML($html);
		
		$pdf->ImageSVG($file='@'.htmlspecialchars_decode($gauge2chart_svg), $x, $y + 97, 
				$w='', $h=35, $link='', $align='', $palign='', $border=0, $fitonpage=false);
		$pdf->ImageSVG($file='@'.htmlspecialchars_decode($gauge3chart_svg), $x + $column2_left - 15, $y + 97, 
				$w='', $h=35, $link='', $align='', $palign='', $border=0, $fitonpage=false);
	}
	
	public static function generatePDF_Section7($pdf, $column1_left, $dnaResults, $svgData, $userTestID)
	{
		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_MOTIFLOW_SERVICE = JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_SERVICE');
		$COM_DNAGIFTS_4THDNAGIFT = JText::_('COM_DNAGIFTS_4THDNAGIFT');
		$COM_DNAGIFTS_5THDNAGIFT = JText::_('COM_DNAGIFTS_5THDNAGIFT');
		$COM_DNAGIFTS_6THDNAGIFT = JText::_('COM_DNAGIFTS_6THDNAGIFT');
		$COM_DNAGIFTS_7THDNAGIFT = JText::_('COM_DNAGIFTS_7THDNAGIFT');
		$MANIMG4_SRC 			 = ReportsHelper::getCharacterImg($dnaResults, 3);
		$MANIMG5_SRC 			 = ReportsHelper::getCharacterImg($dnaResults, 4);
		$MANIMG6_SRC 			 = ReportsHelper::getCharacterImg($dnaResults, 5);
		$MANIMG7_SRC 			 = ReportsHelper::getCharacterImg($dnaResults, 6);
		$COM_DNAGIFTS_VALLEYLACKMOTIVATION = JText::_('COM_DNAGIFTS_VALLEYLACKMOTIVATION');
		
		$y = $pdf->GetY() + 10;
		
		$pdf->SetXY($column1_left, $y);
		$pdf->SetFont('', 'B', 12, '', true);
		$pdf->SetTextColor(128, 128, 128); // RGB - Grey
		$pdf->Write(0, $COM_DNAGIFTS_REPORT_MOTIFLOW_SERVICE, '', 0, 'L', true, 0, false, false, 0);
		$pdf->SetTextColor(0, 0, 0); // RGB - Black
		$pdf->SetFont('', '', 8, '', true);
		
		$html = '<table border="0" width="650" cellspacing="0" cellpadding="0">
			<tr>
				<td width="25%">
					<span style="font-size:12pt;font-weight:bold;color:#999">'.$COM_DNAGIFTS_4THDNAGIFT.'</span><br/>
					<img height="155px" src="'.$MANIMG4_SRC.'" />
				</td>
				<td width="25%">
					<span style="font-size:12pt;font-weight:bold;color:#999">'.$COM_DNAGIFTS_5THDNAGIFT.'</span><br/>
					<img height="155px" src="'.$MANIMG5_SRC.'" />
				</td>
				<td width="25%">
					<span style="font-size:12pt;font-weight:bold;color:#999">'.$COM_DNAGIFTS_6THDNAGIFT.'</span><br/>
					<img height="155px" src="'.$MANIMG6_SRC.'" />
				</td>
				<td width="25%">
					<span style="font-size:12pt;font-weight:bold;color:#999">'.$COM_DNAGIFTS_7THDNAGIFT.'</span><br/>
					<img height="155px" src="'.$MANIMG7_SRC.'" />
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
				<td colspan="2" style="background-color: #999; color:#fff; text-align: center;font-size:10pt">
					'.$COM_DNAGIFTS_VALLEYLACKMOTIVATION.'
				</td>
			</tr>
		</table>';

		// Print text using writeHTML()
        $pdf->writeHTML($html);	
	}

	public static function extractFirstName($user_id)
	{
		$user = UtilsHelper::getUserObject($user_id);
		$name1st=explode(" ",$user->name);
		return $name1st[0];
	}
	
	public static function generatePDF_ReportIntroHeader()
	{
		return JText::_('COM_DNAGIFTS_REPORT_INTRO_P1').
			'<br/><br/><strong>'.JText::_('COM_DNAGIFTS_REPORT_HEREYOURESULTS').'</strong><br/>'.
			JText::_('COM_DNAGIFTS_REPORT_INTRO_P2');
	}
	
	public static function generatePDF_DNAScoringTable($dnaResults) 
	{
		$COM_DNAGIFTS_REPORT_THGIFT				= JText::_('COM_DNAGIFTS_REPORT_THGIFT');
		$COM_DNAGIFTS_REPORT_THSCORE			= JText::_('COM_DNAGIFTS_REPORT_THSCORE');
		$COM_DNAGIFTS_REPORT_THYOURGIFT			= JText::_('COM_DNAGIFTS_REPORT_THYOURGIFT');
		
		$html = '<table width="255" cellspacing="3" cellpadding="3" id="tblScores" style="border: 1px solid #c5c5c5;">
					<tr style="background-color: #000000; color: #ffffff; text-align: center;">
						<td width="75" >'.$COM_DNAGIFTS_REPORT_THGIFT.'</td>
						<td width="75" >'.$COM_DNAGIFTS_REPORT_THSCORE.'</td>
						<td>'.$COM_DNAGIFTS_REPORT_THYOURGIFT.'</td>
					</tr>';

		foreach($dnaResults as $data):
			$tdcolor = '';
			if ( in_array($data['abbr'], array('R','M')) ):
				$tdcolor = 'color: #ffffff;';
			endif;
			$html .= '<tr style="text-align: center; color: #333333; background-color: #'.$data['redColor'].';">
					<td style="'.$tdcolor.'">'.$data['abbr'].'</td>
					<td style="background-color: LightGrey;">'.$data['score'].'</td>
					<td style="text-align: left;'.$tdcolor.'">'.$data['label'].'</td>
				</tr>';
		endforeach;
		
		$html .= '</table>';
		
		return $html;
	}
	
	public static function reportSeperator($pdf, $yPlus=0) 
	{
		$image_file = JPATH_SITE.'/media/com_dnagifts/images/seperator900x11.jpg';
		$x = 15;
		$y = $pdf->GetY() + $yPlus;
		$width = 180;
		$height = '';
		$imagetype = 'JPG';
		$pdf->Image($image_file, $x, $y, $width, $height, $imagetype, 
			'', 'T', false, 300, '', false, false, 0, false, false, false);
	}
	
	public static function generateDNAChart($dnaResults, $userTestID)
	{
		$chartdataArr = array();
		$seriescolorsArr = array();
		$axeslabelsAbbrArr = array();
		$axeslabelsScoresArr = array();
		$chartfillArr = array();
		$markersArr = array();
		$legendsArr = array();
		$primaryDatapoint = 0;
		$secondaryDatapoint = 0;
		
		$dnaMaxScore = ReportsHelper::getDnaMaxScore($userTestID);
		
		$cntr = 0;
		foreach($dnaResults as $data) {
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
		
		$chartParams = array(
			'chartdata' 			=> implode(",",$chartdataArr),
			'seriescolors'			=> implode("|",$seriescolorsArr),
			'axeslabelsAbbr'		=> implode("|",$axeslabelsAbbrArr),
			'axeslabelsScores'		=> implode("|",$axeslabelsScoresArr),
			'legends'				=> implode("|",$legendsArr),
			'chartfillArr'			=> $chartfillArr,
			'markersArr'			=> $markersArr,
			'primaryDatapoint'		=> $primaryDatapoint,
			'secondaryDatapoint'	=> $secondaryDatapoint
		);
		
		$scoreline = array();
		$x_increments = $dnaMaxScore / 4;
		for($i=0; $i<=$dnaMaxScore;$i+=$x_increments) {
			$scoreline[] = round($i,1);
		}
		
		$giftcount = 7;
		$y_spacing = array();
		$y_muliplier = $dnaMaxScore / ($giftcount + 1);
		for($i=1; $i<=$giftcount + 2;$i++) {
			$y_spacing[] = $y_muliplier * $i;
		}
		
		$charttype = 'lxy';
		$chartsize = '400x300';
		$chartdata = 't:'.implode(',',$y_spacing).'|'.$chartParams['chartdata'];
		$chartscale = '0,'.$dnaMaxScore;
		$linestyle = '1';
		$visibleaxes = 'x,x,y'; // (x,y,t,b) (x-axis, y-axis, top, bottom)
		$axeslabels = '0:| |'.$chartParams['axeslabelsAbbr'].
			'| |1:| |'.$chartParams['axeslabelsScores'].
			'| |2:|'.implode('|',$scoreline);
		$chartgrid = '100.0,33.3';
		$chartfill = 'c,ls,0,FFFFFF,0.07,'.$chartParams['chartfillArr'][0].
			',0.12,'.$chartParams['chartfillArr'][1].
			',0.13,'.$chartParams['chartfillArr'][2].
			',0.12,'.$chartParams['chartfillArr'][3].
			',0.12,'.$chartParams['chartfillArr'][4].
			',0.13,'.$chartParams['chartfillArr'][5].
			',0.13,'.$chartParams['chartfillArr'][6].
			',0.13,FFFFFF,0.2';
		//$chartfill='c,ls,0,FFFFFF,0.07,FF6262,0.1,FFCC99,0.095,FFFF99,0.095,99CC99,0.1,66CCCC,0.1,6666CC,0.09,9966CC,0.09,FFFFFF,0.2';
		$markers = 'd,'.$chartParams['markersArr'][0].
			',0,0,10|d,'.$chartParams['markersArr'][1].
			',0,1,10|d,'.$chartParams['markersArr'][2].
			',0,2,10|d,'.$chartParams['markersArr'][3].
			',0,3,10|d,'.$chartParams['markersArr'][4].
			',0,4,10|d,'.$chartParams['markersArr'][5].
			',0,5,10|d,'.$chartParams['markersArr'][6].
			',0,6,10'; // marker type, color, series index, which points, size
		$primarybubble = 'y;s=bubble_text_small_withshadow;d=bb,'.JText::_('COM_DNAGIFTS_REPORT_PRIMARYGIFTBUBBLE').',FF8,000;ds=0;dp='.$chartParams['primaryDatapoint'];
		$secondarybubble = 'y;s=bubble_text_small_withshadow;d=bb,'.JText::_('COM_DNAGIFTS_REPORT_SECONDARYGIFTBUBBLE').',FF8,000;ds=0;dp='.$chartParams['secondaryDatapoint'];
		
		$dnaChart="https://chart.googleapis.com/chart".
			"?cht=".$charttype.
			"&chs=".$chartsize.
			"&chd=".$chartdata.
			"&chds=".$chartscale.
			"&chco=".$chartParams['seriescolors'].
			"&chls=".$linestyle.
			"&chxt=".$visibleaxes.
			"&chxl=".$axeslabels.
			"&chg=".$chartgrid.
			"&chf=".$chartfill.
			"&chm=".$markers.
			"&chdl=".$chartParams['legends'].
			"&chem=".$primarybubble."|".$secondarybubble;
		return $dnaChart;
	}
	
	public static function generateImageLineChart($dnaResults)
	{
		$chartdataArr = array();
		$legendsArr = array();
		$yLabels = array();
		$max = 0;
		foreach($dnaResults as $data) {
			if ((int) $data['score'] > $max) {
				$max = $data['score'];
			}
		}
		
		$max = (int) (ceil($max / 10) + 2) * 10;
		$ygrid = ceil((100 / ($max - 10)) * 10);
		$nextStep = 0;
		for ($i=0; $i<$max/10; $i++) {
			array_push($yLabels, $nextStep);
			$nextStep += 10;
		}
		
		for ($i=0; $i<7; $i++) {
			$position = ReportsHelper::getResultsByPosition($dnaResults, $i);
			array_push($chartdataArr, (int) $dnaResults[$position]['score']/ (int) ($max - 10) * 100);
			array_push($legendsArr, $dnaResults[$position]['label']);
		}
		
		$charttype = 'lxy';
		$chartsize = '300x200';
		
		$dnaChart="https://chart.googleapis.com/chart".
			"?cht=$charttype".
			"&chs=$chartsize".
			"&chd=t:0,17,34,51,68,85,100|".implode(",",$chartdataArr).
			"&chxt=x,y".
			"&chxl=0:|".implode("|",$legendsArr)."|1:|".implode("|",$yLabels).
			"&chm=c,000000,0,-1,5".
			"&chg=17,$ygrid,1,5";
			
		return $dnaChart;
	}
	
	public static function generateGaugeChart($dnaMaxScore, $dnaResults, $position)
	{
		$position 	= ReportsHelper::getResultsByPosition($dnaResults, $position);
		$REDCOLOR	= $dnaResults[$position]['redColor'];
		$SCORE		= round((int) $dnaResults[$position]['score']/$dnaMaxScore*100);
		$HEIGHT		= ReportsHelper::getGuageHeight($SCORE);
		$dnaChart="https://chart.googleapis.com/chart".
			"?chs=200x$HEIGHT".
			"&cht=gom".
			"&chd=t:$SCORE".
			"&chco=FFFFFF,$REDCOLOR".
			"&chxt=x,y".
			"&chxl=0:|$SCORE%|1:|weak|medium|strong".
			"&chf=c,s,B1B1B1".
			"&chtt=Gift+Strength";
		return $dnaChart;
	}
	
	public static function getGiftDescription($dnaResults, $position)
	{
		for ($i=0; $i<count($dnaResults); $i++) {
			if ($dnaResults[$i]['position'] == $position) {
				$giftDesc = $dnaResults[$i]['position' . ((int) $position + 1) . 'Html'];
				if (strlen($giftDesc) < 8) {
					$giftDesc = "Description not available";
				}
				return $giftDesc;
			}
		}
		return '<p>Unable to find description, please contact the webmaster</p>';
	}
	
	public static function getGiftLabel($dnaResults, $position)
	{
		for ($i=0; $i<count($dnaResults); $i++) {
			if ($dnaResults[$i]['position'] == $position) {
				return $dnaResults[$i]['label'];
			}
		}
		return 'ERROR';
	}
	
	public static function getGaugeSVG($userTestID, $dnaResults, $position)
	{
		$db = JFactory::getDbo();
		$dnaMaxScore = ReportsHelper::getDnaMaxScore($userTestID);
		for ($i=0; $i<count($dnaResults); $i++) {
			if ($dnaResults[$i]['position'] == $position) {
				$score = $dnaResults[$i]['score'];
				$target_id = round($score/$dnaMaxScore*100);
				
				$query = $db->getQuery(true);
				$query->select('svg');
				$query->from($db->quoteName('#__dnagifts_guages_svg'));
				$query->where('id = '. (int) $target_id);
				$db->setQuery($query);
				$data = $db->loadObject();
				$svg = $data->svg;
				
				$svg = preg_replace('/DNASCORETEXT/', $target_id, $svg);
				$svg = preg_replace('/DNAGAUGELABEL/', $dnaResults[$i]['label'], $svg);
				$svg = preg_replace('/DNALIGHTCOLOUR/', "#".$dnaResults[$i]['greenColor'], $svg);
				$svg = preg_replace('/DNAMEDIUMCOLOUR/', "#".$dnaResults[$i]['yellowColor'], $svg);
				$svg = preg_replace('/DNADARKCOLOUR/', "#".$dnaResults[$i]['redColor'], $svg);
				
				return $svg;
			}
		}
		return 'ERROR';
	}
	
	public static function getCharacterImg($dnaResults, $position)
	{
		for ($i=0; $i<count($dnaResults); $i++) {
			if ($dnaResults[$i]['position'] == $position) {
				return JURI::base(true)."/media/com_dnagifts/images/characters/".$dnaResults[$i]['characterImg'];
			}
		}
		return 'ERROR';
	}
	
	public static function getHeaderImg($dnaResults, $position)
	{
		for ($i=0; $i<count($dnaResults); $i++) {
			if ($dnaResults[$i]['position'] == $position) {
				return JURI::base(true)."/media/com_dnagifts/images/text/".$dnaResults[$i]['textImg'];
			}
		}
		return 'ERROR';
	}
	
	public static function getResultsByPosition($dnaResults, $position)
	{
		for ($i=0; $i<count($dnaResults); $i++) {
			if ($dnaResults[$i]['position'] == $position) {
				return $i;
			}
		}
		return -1;
	}
	
	public static function generateImagePieChart($dnaResults)
	{
		$chartdataArr = array();
		$seriescolorsArr = array();
		$legendsArr = array();
		
		$total = 0;
		foreach($dnaResults as $data) {
			$total += (int) $data['score'];	
		}
		
		$cntr = 0;
		foreach($dnaResults as $data) {
			$percentage = round((int) $data['score'] / $total * 100, 1);
			array_push($chartdataArr,$data['score']);
			array_push($seriescolorsArr,$data['redColor']);
			array_push($legendsArr,$data['label']." (".$percentage."%)");
			$cntr++;
		}
		
		$chartParams = array(
			'chartdata' 	=> implode(",",$chartdataArr),
			'seriescolors'	=> implode("|",$seriescolorsArr),
			'legends'		=> implode("|",$legendsArr)
		);
		
		$charttype = 'p3';
		$chartsize = '300x150';
		$rotateAngle = 4.7;
		
		$dnaChart="https://chart.googleapis.com/chart".
			"?cht=".$charttype.
			"&chs=".$chartsize.
			"&chd=t:".$chartParams['chartdata'].
			//"&chl=11.5%|9%|8%|24.5%|17.5%|20%|9.5%".
			"&chdl=".$chartParams['legends'].
			"&chco=".$chartParams['seriescolors'].
			"&chp=".$rotateAngle;
			
		return $dnaChart;
	}
	
	public static function getGuageHeight($score) {
		$height = 130;
		if ((int) $score >= 30 && (int) $score <= 60) {
			$height = 140;
		}
		return $height;
	}
	
	public static function emailReportPDF($userTestID, $user_id, $is_raw)
	{
		if ($is_raw > 0) {
			$user = UtilsHelper::getUserObject($user_id);
		} else {
			$user = UtilsHelper::getUserObject();
		}
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
        $query->select('test_id, started_datetime, report_name, date_sent');
		$query->from($db->quoteName('#__dnagifts_lnk_user_tests'));
		$query->where('id = '.$userTestID);
        $db->setQuery($query);
		
        $result = $db->loadObject();
		
		if ($result->date_sent && $is_raw < 1) {
			return;
		}
		
		$filename = JPATH_SITE.DS."components".DS."com_dnagifts".DS."store".DS.$result->report_name;
		
        $subject = JText::_( 'COM_DNAGIFTS_REPORT_EMAILSUBJECT' ); 
		list($body, $images) = ReportsHelper::getEmailBodyAndImages($user->id);
        $to = $user->get("email");
        $from = array('no-reply@dnagifts,co.za', JText::_( 'COM_DNAGIFTS_PDF_AUTHOR' ));
        
        # Invoke JMail Class
        $mailer = JFactory::getMailer();
         
        # Set sender array so that my name will show up neatly in your inbox
        $mailer->setSender($from);
         
        # Add a recipient -- this can be a single address (string) or an array of addresses
        $mailer->addRecipient($to);
		if($is_raw < 1) {
			$mailer->addBCC('reports@dnagifts.net');
		}
		
		$mailer->setSubject($subject);
        $mailer->setBody($body);
        
		# If you would like to send as HTML, include this line; otherwise, leave it out
        $mailer->isHTML(true);
		$mailer->Encoding = 'base64';
        // embed images
		foreach($images as $image) {
			$mailer->AddEmbeddedImage($image[3], $image[2], $image[1], 'base64', $image[5]);
        }
		
        //$attachment = JPATH_SITE."/README.txt";
        $mailer->addAttachment($filename);
				
        # Send once you have set all of your options
        $mailer->send();
		
		// Log the report name in next to the user-test record
		$query = $db->getQuery(true);
		$query->update('#__dnagifts_lnk_user_tests');
		$query->set('date_sent = NOW()');
		$query->where('id = ' . (int) $userTestID);
		
		$db->setQuery($query);
		$db->query();
	}
	
	public static function getEmailBodyAndImages($user_id)
	{
		$template_id = 9;
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
        $query->select('stylesheet, body');
		$query->from($db->quoteName('#__acymailing_template'));
		$query->where('tempid = '.$template_id);
        $db->setQuery($query);
        $result		 = $db->loadObject();
		
		$html 		 = '<html><head><style>'.$result->stylesheet.'</style></head><body>'.
						$result->body.'</body></html>';
						
		$pattern 	 = '/\{subtag\:name\}/i';
		$replacement = ReportsHelper::extractFirstName($user_id);
		$html 		 = preg_replace($pattern, $replacement, $html);
		$images 	 = ReportsHelper::extractEmailImages($html);
		$html 		 = ReportsHelper::srcToCid($html, $images);
		
		return array($html,$images);
	}
	
	public static function srcToCid($html, $images)
	{
		// replace image src's with CIDs
		foreach($images as $image) {
			$html = preg_replace("/".preg_quote($image[0],'/')."/Ui", "cid:".$image[2], $html, 1);
		}
		return $html;
	}
	
	public static function extractEmailImages($page)
	{
		$doc = new DOMDocument(); 
		$doc->loadHTML($page);
		$images = $doc->getElementsByTagName('img'); 
		$data = array();
		foreach($images as $image) {
			$src 	 	= $image->getAttribute('src');
			$imgname 	= ReportsHelper::extractImageName($src);
			$ext	 	= ReportsHelper::extractImageExtention($imgname);
			$mimeType  	= ReportsHelper::getImageMimeType($ext);
			$path 		= ReportsHelper::imgSrcToPath($src);
			$cid 	 	= ReportsHelper::generateCID();
			
			$data[]  	= array($src, $imgname, $cid, $path, $ext, $mimeType);
		}
		return $data;
	}
	
	public static function getImageMimeType($ext) 
	{
		$mimetypes = array( 'bmp'   =>  'image/bmp',
							'gif'   =>  'image/gif',
							'jpeg'  =>  'image/jpeg',
							'jpg'   =>  'image/jpeg',
							'jpe'   =>  'image/jpeg',
							'png'   =>  'image/png',
							'tiff'  =>  'image/tiff',
							'tif'   =>  'image/tiff' );
		return $mimetypes[$ext];
	}
	
	public static function generateCID()
	{
		return "IMAGE_".md5(mt_rand());
	}
	
	public static function imgSrcToPath($src)
	{
		if (substr( $src, 0, 7 ) === "http://") {
			preg_match("/(\/images\/).+/", $src, $matches);
			return $_SERVER['DOCUMENT_ROOT'].$matches[0];
		}
		return $_SERVER['DOCUMENT_ROOT'].'/'.$src;
	}
	
	public static function extractImageExtention($imgname)
	{
		return  strtolower(array_pop(explode('.', $imgname)));
	}
	
	public static function extractImageName($src)
	{
		return  array_pop(explode('/', $src));
	}
	
	public static function getDnaMaxScore($user_test_id)
	{
		$db = JFactory::getDbo();
		
		// get the test id
		$query = $db->getQuery(true);
		$query->select('test_id');
		$query->from($db->quoteName('#__dnagifts_lnk_user_tests'));
		$query->where('id = '. (int) $user_test_id);
		$db->setQuery($query);
		$test_id = $db->loadResult();
		
		// Get the maximum times a category/gift is repeated in a test
		// - questions are linked to categories/gifts
		$query = $db->getQuery(true);
		$query->select('COUNT(c.code) AS maximum');
		$query->from($db->quoteName('#__dnagifts_lnk_test_question').' AS a');
		$query->join('LEFT', $db->quoteName('#__dnagifts_question').' AS b ON a.question_id = b.id');
		$query->join('LEFT', $db->quoteName('#__dnagifts_lst_gift').' AS c ON b.gift_id = c.id');
		$query->where('a.test_id = '. (int) $test_id);
		$query->group('c.id');
		$query->order('maximum DESC');
		$db->setQuery($query, 0, 1);
		$maximum = $db->loadResult();
		
		// Get the score of the button with the highest score used in the test
		$query = $db->getQuery(true);
		$query->select('MAX(b.score) AS highscore');
		$query->from($db->quoteName('#__dnagifts_lnk_test_buttonset').' AS a');
		$query->join('LEFT', $db->quoteName('#__dnagifts_option_button').' AS b ON a.button_id = b.id');
		$query->where('a.test_id = '. (int) $test_id);
		$db->setQuery($query, 0, 1);
		$high_score = $db->loadResult();
		
		// Calculate the max score
		$dnaMaxScore = (int) $maximum * (int) $high_score;
		
		return $dnaMaxScore;
	}
}
