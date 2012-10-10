<?php
defined('_JEXEC') or die;

/**
 * Banners component helper.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_dnagifts
 * @since		1.6
 */

//require_once(JPATH_ROOT.DS.'tcpdf'.DS.'config/lang/eng.php');
//require_once(JPATH_ROOT.DS.'tcpdf'.DS.'tcpdf.php');

//// Extra header voor background color
//class MYPDF extends TCPDF {
//	//Page header public
//	function Header() {
//		// Background color
//		$this->Rect(0,0,210,297,'F','',$fill_color = array(255, 170, 96));
//	}
//}
 
class ReportsHelper
{
	public static function &documentSetup($userTestID)
	{
		$author             = JText::_( 'COM_DNAGIFTS_PDF_AUTHOR' );
        $title              = JText::_( 'COM_DNAGIFTS_PDF_TITLE' );
		$subject            = JText::_( 'COM_DNAGIFTS_PDF_SUBJECT' );
        $keywords           = JText::_( 'COM_DNAGIFTS_PDF_KEYWORDS' );
        $bannerImage        = JText::_( 'COM_DNAGIFTS_PDF_BANNERIMAGE' );
        $bannerTitle        = JText::_( 'COM_DNAGIFTS_PDF_BANNERTITLE' );
        $bannerText         = JText::_( 'COM_DNAGIFTS_PDF_BANNERTEXT' );
        $bannerImageWidth   = 100;
        
		require_once(JPATH_ROOT.DS.'tcpdf'.DS.'config/lang/eng.php');
		require_once(JPATH_ROOT.DS.'tcpdf'.DS.'tcpdf.php');
		
		// Generate the PDF
        @ob_end_clean();

		// ----------------- document setup ---------------------
		
		// create new PDF document
		//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        
        // set document information
        $pdf->SetAuthor($author);
        $pdf->SetTitle($title);
        $pdf->SetSubject($subject);
        $pdf->SetKeywords($keywords);
        
        // set default header data
        $pdf->SetHeaderData($bannerImage, $bannerImageWidth, $bannerTitle, $bannerText);
		
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
	
	public static function prepareData($userTestID)
	{
		$documentname       = JText::_( 'COM_DNAGIFTS_PDF_FILENAME' );
		$report				= new DnaGiftsControllerReport();
		$model				= $report->getModel('Report', 'DnaGiftsModel');
		$dnaResults			= $model->getResultsObject($userTestID);
		
		// Generate the report's document name
        $user = JFactory::getUser();
		$user_id = $user->get("id");
        
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
        
		// Log the report name in next to the user-test record
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
		$pdf =& ReportsHelper::documentSetup($userTestID);
		list ($documentname, $dnaResults) = ReportsHelper::prepareData($userTestID);
		
		// prepare the image charts
		$dnaChartSrc		= ReportsHelper::generateDNAChart($dnaResults);
		$dnaPieChartSrc		= ReportsHelper::generateImagePieChart($dnaResults);
		$dnaLineChartSrc	= ReportsHelper::generateImageLineChart($dnaResults);
		
		$html = '';
		
		// get html from template
		$linestyle = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => '2,1', 'phase' => 0, 'color' => array(211, 211, 211));
		
		$pdf->SetXY(15, 30);
		$pdf->Write(0, 'Hi '.$username, '', 0, 'L', true, 0, false, false, 0);

		
		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_HEREYOURESULTS	= JText::_('COM_DNAGIFTS_REPORT_HEREYOURESULTS');
		$COM_DNAGIFTS_REPORT_INTRO			= JText::_('COM_DNAGIFTS_REPORT_INTRO');
		$COM_DNAGIFTS_REPORT_THGIFT			= JText::_('COM_DNAGIFTS_REPORT_THGIFT');
		$COM_DNAGIFTS_REPORT_THSCORE		= JText::_('COM_DNAGIFTS_REPORT_THSCORE');
		$COM_DNAGIFTS_REPORT_THYOURGIFT		= JText::_('COM_DNAGIFTS_REPORT_THYOURGIFT');
		
		$html = <<<EOD
		<table border="0" width="620" cellspacing="3" cellpadding="0" style="font-size:8pt">
			<tr>
				<td width="350">
					<p style="font-size: 14pt">$COM_DNAGIFTS_REPORT_HEREYOURESULTS</p>
					$COM_DNAGIFTS_REPORT_INTRO
				</td>
				<td width="15">&nbsp;</td>
				<td width="255">
				
				<table width="255" cellspacing="3" cellpadding="3" id="tblScores" style="border: 1px solid #c5c5c5;">
					<tr style="background-color: #000000; color: #ffffff; text-align: center;">
						<td width="75">$COM_DNAGIFTS_REPORT_THGIFT</td>
						<td width="75">$COM_DNAGIFTS_REPORT_THSCORE</td>
						<td>$COM_DNAGIFTS_REPORT_THYOURGIFT</td>
					</tr>
EOD;

		foreach($dnaResults as $data):
			$tdcolor = '';
			if ( in_array($data['abbr'], array('R','M')) ):
				$tdcolor = 'color: #ffffff;';
			endif;
			$html .= '<tr style="text-align: center; color: #333333; background-color: #'.$data['redColor'].';">'.
					'<td style="'.$tdcolor.'">'.$data['abbr'].'</td>'.
					'<td style="background-color: LightGrey;">'.$data['score'].'</td>'.
					'<td style="text-align: left;'.$tdcolor.'">'.$data['label'].'</td>'.
				'</tr>';
		endforeach;
		
		$html .= '</table></td></tr></table>';
        
		// Print text using writeHTML()
        $pdf->writeHTML($html);
				
		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_YOURLINEPROFILE	= JText::_('COM_DNAGIFTS_REPORT_YOURLINEPROFILE');
		$COM_DNAGIFTS_REPORT_DNACHART_HEAD		= JText::_('COM_DNAGIFTS_REPORT_DNACHART_HEAD');
		$COM_DNAGIFTS_REPORT_DNACHART_TEXT		= JText::_('COM_DNAGIFTS_REPORT_DNACHART_TEXT');
		$primsecimg = '<img width="350" height="52" src="'.JURI::base(true).'/media/com_dnagifts/images/primary-secondary-'.JText::_('COM_DNAGIFTS_REPORT_DNACHART_PRIMSECIMG').'-2.png" />';
		$html = <<<EOD
		<table border="0" width="620" cellspacing="3" cellpadding="0" style="font-size:8pt">
			<tr>
				<td colspan="3">
					<p style="font-size: 14pt">$COM_DNAGIFTS_REPORT_YOURLINEPROFILE</p>
				</td>
			</tr>
			<tr>
				<td width="350">
					<table id="tblDNAChart">
						<tr>
							<td align="center">
								<strong>$COM_DNAGIFTS_REPORT_DNACHART_HEAD</strong>
							</td>
						</tr>
						<tr>	
							<td>
								<img src="$dnaChartSrc" />
								$primsecimg
							</td>
						</tr>
					</table>
				</td>
				<td width="15">&nbsp;</td>
				<td width="255">
					$COM_DNAGIFTS_REPORT_DNACHART_TEXT
				</td>
			</tr>	
		</table>	
EOD;

		// Print text using writeHTML()
        $pdf->writeHTML($html);

		//###################################################################################################################
		
		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_DNACOMP_HEAD	= JText::_('COM_DNAGIFTS_REPORT_DNACOMP_HEAD');
		$COM_DNAGIFTS_REPORT_DNACOMP_TEXT	= JText::_('COM_DNAGIFTS_REPORT_DNACOMP_TEXT');
		$html = <<<EOD
		<table border="0" width="620" cellspacing="3" cellpadding="0" style="font-size:8pt">
			<tr>
				<td colspan="3">
					<p style="font-size: 14pt">$COM_DNAGIFTS_REPORT_DNACOMP_HEAD</p>
				</td>
			</tr>
			<tr>
				<td width="350">
					<img src="$dnaPieChartSrc" />
				</td>
				<td width="15">&nbsp;</td>
				<td width="255">
					$COM_DNAGIFTS_REPORT_DNACOMP_TEXT
				</td>
			</tr>	
		</table>	
EOD;

		// Print text using writeHTML()
        $pdf->writeHTML($html);
		
		//###################################################################################################################
		
		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_MOTIFLOW_HEAD	= JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_HEAD');
		$COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT	= JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT');
		$html = <<<EOD
		<br/><br/><br/><br/>
		<table border="0" width="620" cellspacing="3" cellpadding="0" style="font-size:8pt">
			<tr>
				<td colspan="3">
					<p style="font-size: 14pt">$COM_DNAGIFTS_REPORT_MOTIFLOW_HEAD</p>
				</td>
			</tr>
			<tr>
				<td width="350">
					<img src="$dnaLineChartSrc" />
				</td>
				<td width="15">&nbsp;</td>
				<td width="255">
					$COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT
				</td>
			</tr>	
		</table>	
EOD;

		// Print text using writeHTML()
        $pdf->writeHTML($html);
		
		//###################################################################################################################
		
		$dnaMaxScore = 60;
		
		// TEXT REPLACEMENT VARIABLES
		$position								= 0;
		$COM_DNAGIFTS_REPORT_MOTIFLOW_DETAIL	= JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_DETAIL');
		$COM_DNAGIFTS_REPORT_MOTIFLOW_PRIMARY	= JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_PRIMARY');
		$COM_DNAGIFTS_REPORT_PRIMARY_GIFT		= JText::_('COM_DNAGIFTS_REPORT_PRIMARY_GIFT');
		$GIFT1_TEXT								= ReportsHelper::getGiftDescription($dnaResults, $position);
		$GIFT1_LABEL							= ReportsHelper::getGiftLabel($dnaResults, $position);
		$GIFT1_CHARACTER_SRC					= ReportsHelper::getCharacterImg($dnaResults, $position);
		$GIFT1_HEADER_SRC						= ReportsHelper::getHeaderImg($dnaResults, $position);
		$GIFT1_GUAGE 							= ReportsHelper::generateGaugeChart($dnaMaxScore, $dnaResults, $position);
		$html = <<<EOD
		<br/><br/>
		<table border="0" width="620" cellspacing="3" cellpadding="0" style="font-size:8pt">
			<tr>
				<td colspan="3">
					<p style="font-size: 16pt">$COM_DNAGIFTS_REPORT_MOTIFLOW_DETAIL</p>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<p style="font-size: 14pt">$COM_DNAGIFTS_REPORT_MOTIFLOW_PRIMARY $GIFT1_LABEL</p>
				</td>
			</tr>
			<tr>
				<td width="350">
					<p>$COM_DNAGIFTS_REPORT_PRIMARY_GIFT</p>
					<table>
						<tr>
							<td><img src="$GIFT1_CHARACTER_SRC" /></td>
							<td><img src="$GIFT1_GUAGE"></td>
						</tr>
					</table>
				</td>
				<td width="15">&nbsp;</td>
				<td width="255">
					<img style="border: 1px solid black" src="$GIFT1_HEADER_SRC" />
					$GIFT1_TEXT
				</td>
			</tr>	
		</table>	
EOD;

		// Print text using writeHTML()
        $pdf->writeHTML($html);
		
		//-----------------------------------------------------------------------------------------------------------------
		
		// TEXT REPLACEMENT VARIABLES
		$position								+= 1;
		$COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY	= JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY');
		$GIFT2_TEXT								= ReportsHelper::getGiftDescription($dnaResults, $position);
		$GIFT2_CHARACTER_SRC					= ReportsHelper::getCharacterImg($dnaResults, $position);
		$GIFT2_HEADER_SRC						= ReportsHelper::getHeaderImg($dnaResults, $position);
		$GAUGE2 								= ReportsHelper::generateGaugeChart($dnaMaxScore, $dnaResults, $position);
		$html = <<<EOD
		<br/><br/>
		<table border="0" width="620" cellspacing="3" cellpadding="0" style="font-size:8pt">
			<tr>
				<td colspan="3">
					<p style="font-size: 14pt">$COM_DNAGIFTS_REPORT_MOTIFLOW_SECONDARY</p>
				</td>
			</tr>
			<tr>
				<td width="350">
					<table>
						<tr>
							<td><img src="$GIFT2_CHARACTER_SRC" /></td>
							<td><img src="$GAUGE2"></td>
						</tr>
					</table>
				</td>
				<td width="15">&nbsp;</td>
				<td width="255">
					<img style="border: 1px solid black" src="$GIFT2_HEADER_SRC" />
					$GIFT2_TEXT
				</td>
			</tr>	
		</table>	
EOD;

		// Print text using writeHTML()
        $pdf->writeHTML($html);
		
		//-----------------------------------------------------------------------------------------------------------------
		
		// TEXT REPLACEMENT VARIABLES
		$position				+= 1;
		$GIFT3_TEXT				= ReportsHelper::getGiftDescription($dnaResults, $position);
		$GIFT3_CHARACTER_SRC	= ReportsHelper::getCharacterImg($dnaResults, $position);
		$GIFT3_HEADER_SRC		= ReportsHelper::getHeaderImg($dnaResults, $position);
		$GAUGE3 				= ReportsHelper::generateGaugeChart($dnaMaxScore, $dnaResults, $position);
		$html = <<<EOD
		<br/><br/><br/><br/><br/>
		<table border="0" width="620" cellspacing="3" cellpadding="0" style="font-size:8pt">
			<tr>
				<td width="350">
					<table>
						<tr>
							<td><img src="$GIFT3_CHARACTER_SRC" /></td>
							<td><img src="$GAUGE3"></td>
						</tr>
					</table>
				</td>
				<td width="15">&nbsp;</td>
				<td width="255">
					<img style="border: 1px solid black" src="$GIFT3_HEADER_SRC" />
					$GIFT3_TEXT
				</td>
			</tr>	
		</table>	
EOD;

		// Print text using writeHTML()
        $pdf->writeHTML($html);
		
		$filename = ReportsHelper::getFilename($displaytype, $documentname);
        $pdf->Output($filename, $displaytype);
	}
	
	public static function generateReportPDF($displaytype, $svgData, $imgChartSRC, $userTestID, $username)
	{
		$pdf =& ReportsHelper::documentSetup($userTestID);
		
		list ($documentname, $dnaResults) = ReportsHelper::prepareData($userTestID);
		$html = '';
		
		$linestyle = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => '2,1', 'phase' => 0, 'color' => array(211, 211, 211));
		
		// ######################################### PAGE 1 ##########################################################
		
		$pdf->SetXY(15, 30);
		$pdf->Write(0, 'Hi '.$username, '', 0, 'L', true, 0, false, false, 0);

		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_HEREYOURESULTS	= JText::_('COM_DNAGIFTS_REPORT_HEREYOURESULTS');
		$COM_DNAGIFTS_REPORT_INTRO			= JText::_('COM_DNAGIFTS_REPORT_INTRO');
		$COM_DNAGIFTS_REPORT_THGIFT			= JText::_('COM_DNAGIFTS_REPORT_THGIFT');
		$COM_DNAGIFTS_REPORT_THSCORE		= JText::_('COM_DNAGIFTS_REPORT_THSCORE');
		$COM_DNAGIFTS_REPORT_THYOURGIFT		= JText::_('COM_DNAGIFTS_REPORT_THYOURGIFT');
		
		$html = <<<EOD
		<table border="0" width="620" cellspacing="3" cellpadding="0" style="font-size:8pt">
			<tr>
				<td width="350">
					<p style="font-size: 14pt">$COM_DNAGIFTS_REPORT_HEREYOURESULTS</p>
					$COM_DNAGIFTS_REPORT_INTRO
				</td>
				<td width="15">&nbsp;</td>
				<td width="255">
				
				<table width="255" cellspacing="3" cellpadding="3" id="tblScores" style="border: 1px solid #c5c5c5;">
					<tr style="background-color: #000000; color: #ffffff; text-align: center;">
						<td width="75" >$COM_DNAGIFTS_REPORT_THGIFT</td>
						<td width="75" >$COM_DNAGIFTS_REPORT_THSCORE</td>
						<td>$COM_DNAGIFTS_REPORT_THYOURGIFT</td>
					</tr>
EOD;

		foreach($dnaResults as $data):
			$tdcolor = '';
			if ( in_array($data['abbr'], array('R','M')) ):
				$tdcolor = 'color: #ffffff;';
			endif;
			$html .= '<tr style="text-align: center; color: #333333; background-color: #'.$data['redColor'].';">'.
					'<td style="'.$tdcolor.'">'.$data['abbr'].'</td>'.
					'<td style="background-color: LightGrey;">'.$data['score'].'</td>'.
					'<td style="text-align: left;'.$tdcolor.'">'.$data['label'].'</td>'.
				'</tr>';
		endforeach;
		
		$html .= '</table></td></tr>';
		
		
		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_YOURLINEPROFILE	= JText::_('COM_DNAGIFTS_REPORT_YOURLINEPROFILE');
		$COM_DNAGIFTS_REPORT_DNACHART_HEAD		= JText::_('COM_DNAGIFTS_REPORT_DNACHART_HEAD');
		$COM_DNAGIFTS_REPORT_DNACHART_TEXT		= JText::_('COM_DNAGIFTS_REPORT_DNACHART_TEXT');
		$primsecimg = '<img width="234" height="35" src="'.JURI::base(true).'/media/com_dnagifts/images/primary-secondary-'.JText::_('COM_DNAGIFTS_REPORT_DNACHART_PRIMSECIMG').'-2.png" />';
		$html .= <<<EOD
			<tr><td colspan="3"></td></tr>
			<tr>
				<td colspan="3">
					<p style="font-size: 14pt">$COM_DNAGIFTS_REPORT_YOURLINEPROFILE</p>
				</td>
			</tr>
			<tr>
				<td>
					<table id="tblDNAChart">
						<tr>
							<td align="center">
								$COM_DNAGIFTS_REPORT_DNACHART_HEAD
							</td>
						</tr>
						<tr>	
							<td>
								<img src="$imgChartSRC" />
								$primsecimg
							</td>
						</tr>
					</table>
				</td>
				<td>&nbsp;</td>
				<td>
					$COM_DNAGIFTS_REPORT_DNACHART_TEXT
				</td>
			</tr>	
		
EOD;

		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_DNACOMP_HEAD	= JText::_('COM_DNAGIFTS_REPORT_DNACOMP_HEAD');
		$COM_DNAGIFTS_REPORT_DNACOMP_TEXT	= JText::_('COM_DNAGIFTS_REPORT_DNACOMP_TEXT');
		$html .= <<<EOD
			<tr><td colspan="3">&nbsp;</td></tr>
			<tr>
				<td colspan="3"><p style="font-size: 14pt">$COM_DNAGIFTS_REPORT_DNACOMP_HEAD</p></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>
					$COM_DNAGIFTS_REPORT_DNACOMP_TEXT
				</td>
			</tr>
		</table>
EOD;

		// Print text using writeHTML()
        $pdf->writeHTML($html);
		
		$pdf->ImageSVG($file='@'.htmlspecialchars_decode($svgData['piechart_div']), $x='', $y=$pdf->GetY() - 35, $w='', $h=75, $link='', $align='', $palign='', $border=0, $fitonpage=false);
	
	
		// ######################################### PAGE 2 ##########################################################
		
		$pdf->AddPage();
		
		// TEXT REPLACEMENT VARIABLES
		$COM_DNAGIFTS_REPORT_MOTIFLOW_HEAD	= JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_HEAD');
		$COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT	= JText::_('COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT');
		$html = <<<EOD
		<br/><br/>
		<table border="0" width="620" cellspacing="3" cellpadding="0" style="font-size:8pt">
			<tr>
				<td colspan="3">
					<p style="font-size: 14pt">$COM_DNAGIFTS_REPORT_MOTIFLOW_HEAD</p>
				</td>
			</tr>
			<tr>
				<td width="350" height="260">&nbsp;</td>
				<td width="15">&nbsp;</td>
				<td width="255">
					$COM_DNAGIFTS_REPORT_MOTIFLOW_TEXT
				</td>
			</tr>	
		</table>	
EOD;

		// Print text using writeHTML()
        $pdf->writeHTML($html);
		
		$pdf->ImageSVG($file='@'.htmlspecialchars_decode($svgData['linechart_div']), $x=$pdf->GetX() + 1, $y=$pdf->GetY() - 80, $w='', $h=75, $link='', $align='', $palign='', $border=0, $fitonpage=false);
		
		
		
		
		
		$html = "THIS IS THE NEXT LINE";
		$pdf->writeHTML($html);
		
		// ######################################### DONE ##########################################################
        
		$filename = ReportsHelper::getFilename($displaytype, $documentname);
        $pdf->Output($filename, $displaytype);
	}
	
	public static function generateDNAChart($dnaResults)
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
		
		$charttype = 'lxy';
		$chartsize = '400x300';
		$chartdata = 't:7,15,23,30,38,46,53|'.$chartParams['chartdata'];
		$chartscale = '0,60';
		$linestyle = '1';
		$visibleaxes = 'x,x,y'; // (x,y,t,b) (x-axis, y-axis, top, bottom)
		$axeslabels = '0:| |'.$chartParams['axeslabelsAbbr'].
			'| |1:| |'.$chartParams['axeslabelsScores'].
			'| |2:|0|10|20|30|40|50|60';
		$chartgrid = '100.0,25.0';
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
		$chartsize = '300x150';
		
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
				return JText::_($dnaResults[$i]['textToken']);
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
	
	public static function getCharacterImg($dnaResults, $position)
	{
		for ($i=0; $i<count($dnaResults); $i++) {
			if ($dnaResults[$i]['position'] == $position) {
				return JURI::base(true)."/media/com_dnagifts/images/".$dnaResults[$i]['characterImg'];
			}
		}
		return 'ERROR';
	}
	
	public static function getHeaderImg($dnaResults, $position)
	{
		for ($i=0; $i<count($dnaResults); $i++) {
			if ($dnaResults[$i]['position'] == $position) {
				return JURI::base(true)."/media/com_dnagifts/images/".$dnaResults[$i]['textImg'];
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
	
	public static function emailReportPDF($userTestID)
	{
		$user = JFactory::getUser();
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
        $query->select('test_id, started_datetime, report_name');
		$query->from($db->quoteName('#__dnagifts_lnk_user_tests'));
		$query->where('id = '.$userTestID);
        $db->setQuery($query);
        $result = $db->loadObject();
		
		$filename = JPATH_SITE.DS."components".DS."com_dnagifts".DS."store".DS.$result->report_name;
		
        $subject = JText::_( 'COM_DNAGIFTS_REPORT_EMAILSUBJECT' ); 
        $body = JText::_( 'COM_DNAGIFTS_REPORT_EMAILMESSAGE' ); 
        $to = $user->get("email"); //louw.morne@gmail.com";
        $from = array('no-reply@dnagifts,co.za', JText::_( 'COM_DNAGIFTS_PDF_AUTHOR' ));
        
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
	}
}
