<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Test View
 */
class DnaGiftsViewTest extends JView
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
		
		// Set the document
		$this->setDocument();
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JRequest::setVar('hidemainmenu', true);
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title($isNew ? JText::_('COM_DNAGIFTS_TEST_NEW_HEADING') : JText::_('COM_DNAGIFTS_TEST_EDIT_HEADING'), 'dnatests48x48');
		
		JToolBarHelper::apply('test.apply', $isNew ? 'JTOOLBAR_APPLY' : 'COM_DNAGIFTS_TOOLBAR_APPLY');
		if (!$isNew) {
			JToolBarHelper::save2new('test.save2new');
			JToolBarHelper::save2copy('test.save2copy');
			JToolBarHelper::save('test.save');
		}
		
		JToolBarHelper::divider();
		JToolBarHelper::cancel('test.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
	
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$document = JFactory::getDocument();
		
		// Stylesheets
		$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/themes/base/jquery.ui.all.css');
		$document->addStyleSheet(JURI::base(true).'/components/com_dnagifts/css/dnagifts.test.css');
		
		// Javascripts
		// - JQuery
		//$document->addScript(JURI::base(true).'/components/com_dnagifts/js/jquery-1.7.2.min.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/jquery-1.9.0.min.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/jquery.noconflict.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/jquery.metadata.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/jquery.watermark.min.js');
		
		// - JQuery - UI
		// -- core
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/ui/jquery.ui.core.min.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/ui/jquery.ui.widget.min.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/ui/jquery.ui.mouse.min.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/ui/jquery.ui.position.min.js');
		// -- Interactions
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/ui/jquery.ui.sortable.min.js');		
		// -- Widgets
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/ui/jquery.ui.dialog.min.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/ui/jquery.ui.button.min.js');
		
		// - Other
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/Namespace.min.js');
		
		// - DNA Gifts
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.base.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.init.js');
		$document->addScript(JURI::base(true).'/components/com_dnagifts/js/dnagifts.tests.js');
	}
}

