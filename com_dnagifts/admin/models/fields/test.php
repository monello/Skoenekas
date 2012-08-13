<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * DnaGifts Form Field class for the DnaGifts component
 */
class JFormFieldDnaTest extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Test';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id, test_name');
		$query->from('#__dnagifts_test');
		$db->setQuery((string)$query);
		$tests = $db->loadObjectList();
		$options = array();
		if ($tests)
		{
			foreach($tests as $test) 
			{
				$options[] = JHtml::_('select.option', $test->id, $test->test_name);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}