<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla controller library
jimport('joomla.application.component.controllerform');
JLoader::register('DnaGiftsHelper', JPATH_COMPONENT.'/helpers/dnagifts.php');

/**
 * DNA Gifts Component Controller
 */
class DnaGiftsController extends JControllerForm
{
  public function getModel($name = '', $prefix = '', $config = array('ignore_request' => true))
  {
    return parent::getModel($name, $prefix, array('ignore_request' => false));
  }

  public function submit()
  {
    // Check for request forgeries.
    JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
    
    // Initialise variables.
    $app = JFactory::getApplication();
    $model = $this->getModel('dnagifts');
    
    // Get the data from the form POST
    $data = JRequest::getVar('jform', array(), 'post', 'array');
    
    
    // Now update the loaded data to the database via a function in the model
    $saveditem = $model->saveItem($data);
    
    // check if ok and display appropriate message.  This can also have a redirect if desired.
    if ($saveditem) {
      $lang_code = DnagiftsHelper::getCurrentLanguageCode();
      $app->redirect(JURI::base(true).'/index.php/'.$lang_code.'/?Itemid='.$data['menuid']);
    }
    return true;
  }

}
