<?php
// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');
JLoader::register('DnaGiftsHelper', JPATH_COMPONENT.'/helpers/dnagifts.php');

class DnaGiftsControllerReports extends JControllerForm
{
    /* download pdf */
    function dlpdf() {
        $f = JRequest::getVar('f');
        $filename = JPATH_COMPONENT."/store/".$f;
        $dlFilename = str_replace(" ","_", $f);
		 if (is_file($filename))
		 {
			 if (file_exists($filename))
			 {
				 header('Content-Description: File Transfer');
				 header('Content-Type: application/octet-stream');
				 header('Content-Disposition: attachment; filename=' . $dlFilename);
				 header('Content-Transfer-Encoding: binary');
				 header('Expires: 0');
				 header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				 header('Pragma: public');
				 header('Content-Length: ' . filesize($filename));
				 ob_clean();
				 flush();
				 readfile($filename);
				 exit;
			 }
		 }
    }
}
