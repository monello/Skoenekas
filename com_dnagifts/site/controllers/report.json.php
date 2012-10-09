<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
//require_once JPATH_COMPONENT.'/helpers/reports.php';
JLoader::register('ReportsHelper', JPATH_COMPONENT.'/helpers/reports.php');

/**
 * Reports JSON (Ajax) Controller
 */
class DnaGiftsControllerReport extends JControllerForm
{
    public function dispatchReport()
	{
		$displaytype	= 'F'; //use 'F' for emailing not 'E' as I want to save a real file to a folder and attache that to the email
        $svgData		= $_POST['svgData'];
        $userTestID		= $_POST['userTestID'];
		$imgChartSRC	= $_POST['imgChartSRC'];
		$user 			= JFactory::getUser();
		ReportsHelper::generateReportPDF($displaytype, $svgData, $imgChartSRC, $userTestID, $user->name);
		//ReportsHelper::emailReportPDF($userTestID);
		echo json_encode(array("success" => true, "message" => jText::_('COM_DNAGIFTS_REPORT_SENTEMAIL')));
	}
	public function dispatchMSIEReport()
	{
		$displaytype	= 'F'; //use 'F' for emailing not 'E' as I want to save a real file to a folder and attache that to the email
        $userTestID		= $_POST['userTestID'];
		$user 			= JFactory::getUser();
		ReportsHelper::generateReportMSIEPDF($displaytype, $userTestID, $user->name);
		//ReportsHelper::emailReportPDF($userTestID);
		echo json_encode(array("success" => true, "message" => jText::_('COM_DNAGIFTS_REPORT_SENTEMAIL')));
	}
	
//	public function generateReportPDF()
//	{
//		$displaytype	= 'F'; //use 'F' for emailing not 'E' as I want to save a real file to a folder and attache that to the email
//        $svgData		= $_POST['svgData'];
//        $userTestID		= $_POST['userTestID'];
//		ReportsHelper::generateReportPDF($displaytype, $svgData, $userTestID);
//	}
//	
	public function emailReportPDF()
	{
		$userTestID	= $_POST['userTestID'];
		ReportsHelper::emailReportPDF($userTestID);
		echo json_encode(array("success" => true, "message" => jText::_('COM_DNAGIFTS_REPORT_SENTEMAIL')));
    }
}
