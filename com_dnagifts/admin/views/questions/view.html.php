<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Tests View
 */
class DnaGiftsViewQuestions extends JView
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
		// Assign data to the view. Get data from Model
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))){
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
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
		require_once JPATH_COMPONENT . '/helpers/dnagifts.php';
		
		$state = $this->get('State');
		$canDo = DnagiftsHelper::getActions();
		$user = JFactory::getUser();
		
		JToolBarHelper::title(JText::_('COM_DNAGIFTS_QUESTIONS_MANAGER_HEADING'), 'dnaquestions48x48');
		
		JToolBarHelper::addNew('question.add');
		JToolBarHelper::editList('question.edit');
		
		if ($canDo->get('core.edit.state'))
		{
			JToolBarHelper::divider();
			JToolBarHelper::publish('questions.publish', 'JTOOLBAR_PUBLISH', true);
			JToolBarHelper::unpublish('questions.unpublish', 'JTOOLBAR_UNPUBLISH', true);
		}
		
		JToolBarHelper::divider();
		JToolBarHelper::deleteList('', 'questions.delete');
	}
}