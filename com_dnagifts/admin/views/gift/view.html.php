<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Gift View
 */
class DnaGiftsViewGift extends JView
{
	/**
	 * display method of DNAGIFT view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;
 
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
		JRequest::setVar('hidemainmenu', true);
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew ? JText::_('COM_DNAGIFTS_GIFT_NEW_HEADING') : JText::_('COM_DNAGIFTS_GIFT_EDIT_HEADING'), 'dnagifts48x48');
		
		JToolBarHelper::apply('gift.apply', $isNew ? 'JTOOLBAR_APPLY' : 'COM_DNAGIFTS_TOOLBAR_APPLY');
		JToolBarHelper::save2new('gift.save2new');
		if (!$isNew) {
			JToolBarHelper::save2copy('gift.save2copy');
		}
		JToolBarHelper::save('gift.save');
		
		JToolBarHelper::divider();
		JToolBarHelper::cancel('gift.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
}
