<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

class DnaGiftsControllerReport extends JControllerForm
{
    public function emailReportPDF() {
        $displaytype        = 'F'; //use 'F' for emailing not 'E' as I want to save a real file to the tmp folder
        $svgData            = $_POST['svgData'];

        $svgDisplayOrder    = JRequest::getCmd( 'svgDisplayOrder' );
        $author             = JText::_( 'COM_DNAGIFTS_PDF_AUTHOR' );
        $title              = JText::_( 'COM_DNAGIFTS_PDF_TITLE' );
		$subject            = JText::_( 'COM_DNAGIFTS_PDF_SUBJECT' );
        $keywords           = JText::_( 'COM_DNAGIFTS_PDF_KEYWORDS' );
		$documentname       = JText::_( 'COM_DNAGIFTS_PDF_FILENAME' );
        $bannerImage        = JText::_( 'COM_DNAGIFTS_PDF_BANNERIMAGE' );
        $bannerTitle        = JText::_( 'COM_DNAGIFTS_PDF_BANNERTITLE' );
        $bannerText         = JText::_( 'COM_DNAGIFTS_PDF_BANNERTEXT' );
        $bannerImageWidth   = 100;
        $html               = '';
    
        @ob_end_clean();      
        
        require_once(JPATH_ROOT.DS.'tcpdf'.DS.'config/lang/eng.php');
        require_once(JPATH_ROOT.DS.'tcpdf'.DS.'tcpdf.php');
              
        // create new PDF document
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
        $charttype = 'lxy';
        $chartsize = '400x300';
        $chartdata = 't:7,15,23,30,38,46,53|23,18,16,49,35,40,19';
        $chartscale = '0,60';
        $seriescolors = 'FF0000|FFC000|FFFF00|00B050|538ED5|333391|990099';
        $linestyle = '1';
        $visibleaxes = 'x,x,y'; // (x,y,t,b) (x-axis, y-axis, top, bottom)
        $axeslabels = '0:| |P|S|T|E|G|R|M| |1:| |23|18|16|49|35|40|19| |2:|0|10|20|30|40|50|60';
        $chartgrid = '100.0,25.0';
        $chartfill = 'bg,ls,0,FFFFFF,0.09,CC6666,0.10,FFCC99,0.095,FFFF99,0.095,99CC99,0.10,66CCCC,0.10,6666CC,0.09,9966CC,0.09,FFFFFF,0.2';
        $markers = 'd,FF0000,0,0,10|d,FFC000,0,1,10|d,FFFF00,0,2,10|d,00B050,0,3,10|d,538ED5,0,4,10|d,333391,0,5,10|d,990099,0,6,10'; // marker type, color, series index, which points, size
        $legends = 'Perceiver|Servant|Teacher|Exhorter|Giver|Ruler|Mercy';
        $primarybubble = 'y;s=bubble_text_small;d=bb,Primary+Gift,FF8,000;ds=0;dp=3';
        $secondarybubble = 'y;s=bubble_text_small;d=bb,Secondary+Gift,FF8,000;ds=0;dp=5';
        
        $charturl = "https://chart.googleapis.com/chart?cht=".$charttype."&chs=".$chartsize."&chd=".$chartdata."&chds=".$chartscale."&chco=".$seriescolors."&chls=".$linestyle."&chxt=".$visibleaxes."&chxl=".$axeslabels."&chg=".$chartgrid."&chf=".$chartfill."&chm=".$markers."&chdl=".$legends."&chem=".$primarybubble."|".$secondarybubble;
        $pdf->Image($charturl, '', '', 100);
        //$pdf->Image(<IMAGE URL>, <left>, <top>, <width>);
    	//$pdf->Image('http://chart.apis.google.com/chart?cht=ls&chd=t:1366,1459,2534,2551,2589&chco=76A4FB&chls=2.0,0.0,0.0&chxt=x&chxl=0:|19|20|21|22|23&chs=600x150&chds=1366,2589', 50, 150, 100);
    	//$pdf->Image('http://chart.apis.google.com/chart?cht=bvg&chs=200×125&chd=s:hello,world&chco=cc0000,00aa00', '', '', 100);
        
        // ---------------------------------------------------------
        
    	//$pdf->ImageSVG($file='@<svg width="400" height="300" style="overflow: hidden;"><defs id="defs"/><rect x="0" y="0" width="400" height="300" stroke="none" stroke-width="0" fill="#ffffff"/><g><text text-anchor="start" x="77" y="38.35" font-family="Arial" font-size="11" font-weight="bold" stroke="none" stroke-width="0" fill="#000000">How Much Pizza I Ate Last Night</text></g><g><rect x="248" y="58" width="76" height="83" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"/><g><rect x="248" y="58" width="76" height="11" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"/><g><text text-anchor="start" x="263" y="67.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#222222">Mushrooms</text></g><rect x="248" y="58" width="11" height="11" stroke="none" stroke-width="0" fill="#3366cc"/></g><g><rect x="248" y="76" width="76" height="11" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"/><g><text text-anchor="start" x="263" y="85.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#222222">Onions</text></g><rect x="248" y="76" width="11" height="11" stroke="none" stroke-width="0" fill="#dc3912"/></g><g><rect x="248" y="94" width="76" height="11" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"/><g><text text-anchor="start" x="263" y="103.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#222222">Olives</text></g><rect x="248" y="94" width="11" height="11" stroke="none" stroke-width="0" fill="#ff9900"/></g><g><rect x="248" y="112" width="76" height="11" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"/><g><text text-anchor="start" x="263" y="121.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#222222">Zucchini</text></g><rect x="248" y="112" width="11" height="11" stroke="none" stroke-width="0" fill="#109618"/></g><g><rect x="248" y="130" width="76" height="11" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"/><g><text text-anchor="start" x="263" y="139.35" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#222222">Pepperoni</text></g><rect x="248" y="130" width="11" height="11" stroke="none" stroke-width="0" fill="#990099"/></g></g><g><path d="M154,151L154,75A76,76,0,0,1,207.74011537017762,204.7401153701776L154,151A0,0,0,0,0,154,151" stroke="#ffffff" stroke-width="1" fill="#3366cc"/><text text-anchor="start" x="183.37241046222232" y="136.26323901017514" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#ffffff">37.5%</text></g><g><path d="M154,151L78,151A76,76,0,0,1,154,75L154,151A0,0,0,0,0,154,151" stroke="#ffffff" stroke-width="1" fill="#990099"/><text text-anchor="start" x="105.37040213776933" y="117.22040213776936" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#ffffff">25%</text></g><g><path d="M154,151L100.2598846298224,204.74011537017762A76,76,0,0,1,78,151L154,151A0,0,0,0,0,154,151" stroke="#ffffff" stroke-width="1" fill="#109618"/><text text-anchor="start" x="93.62758953777768" y="173.43676098982488" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#ffffff">12.5%</text></g><g><path d="M154,151L154,227A76,76,0,0,1,100.2598846298224,204.74011537017762L154,151A0,0,0,0,0,154,151" stroke="#ffffff" stroke-width="1" fill="#ff9900"/><text text-anchor="start" x="118.28323932673234" y="203.65757780465376" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#ffffff">12.5%</text></g><g><path d="M154,151L207.74011537017762,204.7401153701776A76,76,0,0,1,154,227L154,151A0,0,0,0,0,154,151" stroke="#ffffff" stroke-width="1" fill="#dc3912"/><text text-anchor="start" x="158.71676067326766" y="203.65757780465373" font-family="Arial" font-size="11" stroke="none" stroke-width="0" fill="#ffffff">12.5%</text></g><g/></svg>', $x=30, $y=100, $w='', $h=100, $link='', $align='', $palign='', $border=0, $fitonpage=false);
        $pdf->ImageSVG($file='@'.htmlspecialchars_decode($svgData['chart_div']), $x='', $y='', $w='', $h=200, $link='', $align='', $palign='', $border=0, $fitonpage=false);
        $pdf->ImageSVG($file='@'.htmlspecialchars_decode($svgData['piechart_div']), $x='', $y='', $w='', $h=100, $link='', $align='', $palign='', $border=0, $fitonpage=false);
        
        $pdf->writeHTML($html);
        
        // Close and output PDF document
        // This method has several options, check the source code documentation for more information.
        //$filename = $pdf->Output($documentname.'.pdf', $displaytype);
        
        if ($displaytype == 'F') {
            $filename = JPATH_SITE.DS."tmp".DS.$documentname.".pdf";
        } else {
            $filename = $documentname.".pdf";
        }
        $pdf->Output($filename, $displaytype);
        
        
        $subject = JText::_( 'COM_DNAGIFTS_REPORT_EMAILSUBJECT' ); 
        $body = JText::_( 'COM_DNAGIFTS_REPORT_EMAILMESSAGE' ); 
        $to = "louw.morne@gmail.com";
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
        
        unlink($filename);
        
        echo json_encode(array("success" => true, "message" => 'Your report is sent to you by email'));
    }
}
