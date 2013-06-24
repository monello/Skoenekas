<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Report View
 */
class DnaGiftsViewReport extends JView
{
	protected $items;
	protected $pagination;
	protected $state;
	
	/**
	 * DnaGifts view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		$type = JRequest::getVar( 'type', 'results' );
		
		// Assign data to the view. Get data from Model
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$this->assignRef( 'type', $type );
		
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
	}
	
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('COM_DNAGIFTS_ANSWER_MANAGER_HEADING'), 'dnaanswers48x48');
	}
}
