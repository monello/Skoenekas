<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controlleradmin library
jimport('joomla.application.component.controlleradmin');
 
/**
 * Questions Controller
 */
class DnaGiftsControllerGifts extends JControllerAdmin
{
	protected $default_view = 'gifts';
  
  /**
	* Proxy for getModel.
	* @since	2.5
	*/
	public function getModel($name = 'Gift', $prefix = 'DnaGiftsModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}