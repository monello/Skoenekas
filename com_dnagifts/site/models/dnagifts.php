<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// Include dependancy of the main model form
jimport('joomla.application.component.modelform');
// import Joomla modelitem library
jimport('joomla.application.component.modelitem');
// Include dependancy of the dispatcher
jimport('joomla.event.dispatcher');


/**
* DnaGiftsModel Model
*/
class DnaGiftsModelDnaGifts extends JModelForm
{
	/**
  * @var object item
  */
  protected $item;
	
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 * @return	JTable	A database object
	 * @since	2.5
	 */
	public function getTable($type = 'Test', $prefix = 'DnaGiftsTable', $config = array()) 
	{
		return JTable::getInstance($type, $prefix, $config);
	}
	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	2.5
	 */
	public function getForm($data = array(), $loadData = true) 
	{
		// Get the form.
		$form = $this->loadForm('com_dnagifts.dnagifts', 'dnagifts',
		                        array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) 
		{
			return false;
		}
		return $form;
	}
	
	/**
  * Get the message
  * @return object The message to be displayed to the user
  */
  function &getItem()
  {
    if (!isset($this->_item)) {
      $cache = JFactory::getCache('com_dnagifts', '');
      $id = $this->getState('dnagifts.id');
      $this->_item =  $cache->get($id);
    }
    return $this->_item;
  }
	
	public function saveItem($data)
  {
		$db = JFactory::getDbo();
		$user = JFactory::getUser();
		$user_id = $user->get("id");
		$is_christian = $data['is_christian'];
		$in_church = $data['in_church'];
		$church_name = ($data['church_name']) ? $data['church_name'] : '';
		$your_city = ($data['your_city']) ? $data['your_city'] : '';
		$your_country = ($data['your_country']) ? $data['your_country'] : '';
		$pastor_reverend = ($data['pastor_reverend']) ? $data['pastor_reverend'] : '';
		$believe_divine = ($data['believe_divine']) ? $data['believe_divine'] : '';
		
		$query = $db->getQuery(true);
		$query->insert('#__dnagifts_pretest_info ');
		$query->columns('user_id, is_christian, in_church, church_name, your_city, your_country, pastor_reverend, believe_divine');
		$query->values((int) $user_id . "," . (int) $is_christian . ",". (int) $in_church . ", '" . $church_name . "', '" . $your_city . "', '" . $your_country . "', '" . $pastor_reverend . "'," . (int) $believe_divine );
		$db->setQuery($query);
		if (!$db->query()) {
			$this->setError(JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_BUTTON'));
			echo json_encode(array("success"=> false, "message" => JText::_('COM_DNAGIFTS_TEST_ERROR_SAVE_BUTTON')));
			return false;
		}
		
		return true;
  }

	
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	2.5
	 */
	protected function loadFormData() 
	{
		// Check the session for previously entered form data.
		//$data = JFactory::getApplication()->getUserState('com_dnagifts.edit.test.data', array());
		//if (empty($data)) 
		//{
		//	$data = $this->getItem();
		//}
		//return $data;
	}
	
	public function getAllActiveTests()
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
		$language = DnagiftsHelper::getCurrentLanguageString();
		
		// Select the required fields from the table.
		$query->select('*');
		$query->from($db->quoteName('#__dnagifts_test'));
		$query->where('published = 1');
		$query->where('language = \''.$language.'\'');
		$query->order($db->getEscaped('ordering ASC'));
		
		$db->setQuery($query);
		
		$data = $db->loadObjectList();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		return $data;
	}
	
}
 