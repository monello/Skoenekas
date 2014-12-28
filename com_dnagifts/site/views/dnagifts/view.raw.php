<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
JLoader::register('DnaGiftsHelper', JPATH_COMPONENT.'/helpers/dnagifts.php');
/**
 * HTML View class for the DnaGifts Component
 */
class DnaGiftsViewDnaGifts extends JView
{
	public function display($tpl = null) 
	{
		$html = $this->loadTemplate($tpl);
		if ($html instanceof Exception)
		{
			return $html;
		}
		
		$sas = $this->getScriptsAndStyles();
		$html = $sas.$html;
		
		echo $html;
		
	}
	
	protected function getScriptsAndStyles()
	{
		$styles = '<link rel="stylesheet" href="'.JURI::base(true).'/components/com_dnagifts/css/dnagifts.css" type="text/css">';
		
		$scripts = '<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery-1.9.1.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery.noconflict.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/jquery.metadata.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/Namespace.min.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/dnagifts.base.js" type="text/javascript"></script>
			<script src="'.JURI::base(true).'/administrator/components/com_dnagifts/js/dnagifts.init.js" type="text/javascript"></script>
			
			<script src="'.JURI::base(true).'/components/com_dnagifts/js/dnagifts.js" type="text/javascript"></script>';
		return $styles.$scripts;
	}
}