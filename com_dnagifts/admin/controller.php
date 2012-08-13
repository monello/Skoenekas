<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controller');
 
/**
 * General Controller of DnaGifts component
 */
class DnaGiftsController extends JController
{
	
	/**
	* @var string The default view.
	* @since 2.5
	*/
	protected $default_view = 'tests';
	
	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false) 
	{
		require_once JPATH_COMPONENT.'/helpers/dnagifts.php';
		
		// Load the submenu.
		DnaGiftsHelper::addSubmenu(JRequest::getCmd('view', 'tests'));
		
		$view = JRequest::getCmd('view', 'tests');
		$layout = JRequest::getCmd('layout', 'default');
		$id = JRequest::getInt('id');
		
		// Check for edit form.
		if ($view == 'test' && $layout == 'edit' && !$this->checkEditId('com_dnagifts.edit.test', $id)) {
			// Somehow the person just went to the form - we don’t allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_dnagifts&view=tests', false));
			return false;
		}
		
		// call parent behavior
		parent::display($cachable);
		
		return $this;
	}
}