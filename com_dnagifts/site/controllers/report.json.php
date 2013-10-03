<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');
//require_once JPATH_COMPONENT.'/helpers/reports.php';
JLoader::register('ReportsHelper', JPATH_COMPONENT.'/helpers/reports.php');
JLoader::register('UtilsHelper', JPATH_COMPONENT.'/helpers/utils.php');

/**
 * Reports JSON (Ajax) Controller
 */
class DnaGiftsControllerReport extends JControllerForm
{
    public function dispatchReport()
	{
		$displaytype	= 'F'; //use 'F' for emailing not 'E' as I want to save a real file to a folder and attached that to the email
        $svgData		= $_POST['svgData'];
        $userTestID		= $_POST['userTestID'];
		$imgChartSRC	= $_POST['imgChartSRC'];
		$is_raw			= (int) $_POST['israw'];
		if ($is_raw > 0) {
			$user = UtilsHelper::getUserObject($_POST['uid']);
		} else {
			$user = UtilsHelper::getUserObject();
		}
		
		ReportsHelper::generateReportPDF($displaytype, $svgData, $imgChartSRC, $userTestID, $user->name);
		if ($is_raw < 1) {
			ReportsHelper::emailReportPDF($userTestID, $user_id, $is_raw);
			echo json_encode(array("success" => true, "message" => jText::_('COM_DNAGIFTS_REPORT_SENTEMAIL')));
		} else {
			// we don't want to send an email at this stage.
			// emails are sent manually from the modal in Admin
			echo json_encode(array("success" => true, "message" => jText::_('COM_DNAGIFTS_REPORT_PDFREADY')));
		}
		
	}
	public function dispatchMSIEReport()
	{
		$displaytype	= 'F'; //use 'F' for emailing not 'E' as I want to save a real file to a folder and attached that to the email
        $userTestID		= $_POST['userTestID'];
		$is_raw			= (int) $_POST['israw'];
		if ($is_raw > 0) {
			$user = UtilsHelper::getUserObject($_POST['uid']);
		} else {
			$user = UtilsHelper::getUserObject();
		}
		
		ReportsHelper::generateReportMSIEPDF($displaytype, $userTestID, $user->name);
		if ($is_raw < 1) {
			ReportsHelper::emailReportPDF($userTestID, $user_id, $is_raw);
			echo json_encode(array("success" => true, "message" => jText::_('COM_DNAGIFTS_REPORT_SENTEMAIL')));
		} else {
			echo json_encode(array("success" => true, "message" => jText::_('COM_DNAGIFTS_REPORT_PDFREADY')));
		}
	}
	
	
	public function emailReportPDF()
	{
		$userTestID	= $_POST['userTestID'];
		$user_id 	= $_POST['uid'];
		ReportsHelper::emailReportPDF($userTestID, $user_id, 1);
		echo json_encode(array("success" => true, "message" => jText::_('COM_DNAGIFTS_REPORT_SENTEMAIL')));
    }
	
}
