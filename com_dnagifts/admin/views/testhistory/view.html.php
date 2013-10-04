<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

class DnaGiftsViewTesthistory extends JView
{	
    protected $items;
	protected $pagination;
	protected $state;
	
	function display($tpl = null) 
	{
		// Assign data to the view. Get data from Model
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		$this->addToolBar();
		
		parent::display($tpl);
		
		$this->setDocument();
	}
	
	protected function addToolBar() 
	{	
		$state = $this->get('State');
		JToolBarHelper::title(JText::_('COM_DNAGIFTS_TESTHISTORY_HEADING'), 'dnareports48x48');
	}
	
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/dnagifts.testhistory.css');
	}
	
}