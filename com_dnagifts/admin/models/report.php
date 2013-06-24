<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * DnaGiftsReport Model
 */
class DnaGiftsModelReport extends JModelList
{
	/**
	* Constructor.
	*
	* @param array An optional associative array of configuration settings.
	* @see JController
	* @since 2.5
	*/
	public function __construct($config = array())
	{
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array('id', 'button_name', 'button_text', 'description', 'score', 'css_class', 'ordering', 'language', 'created', 'published');
		}
		parent::__construct($config);
	}
	
	/**
	* Method to auto- populate the model state.
	*
	* Note. Calling getState in this method will result in recursion.
	*
	*/
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');
		
		// Load the filter state.
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);
		
		$published = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);
		
		$language = $this->getUserStateFromRequest($this->context.'.filter.language', 'filter_language', '', 'string');
		$this->setState('filter.language', $language);
		
		$ordering = $this->getUserStateFromRequest($this->context.'.filter.ordering', 'filter_ordering', '', 'string');
		$this->setState('filter.ordering', $ordering);
		
		// Load the parameters.
		$params = JComponentHelper::getParams('com_dnagifts');
		$this->setState('params', $params);
		
		// List state information.
		parent::populateState('score', 'asc');
	}
	
	/**
	* Method to get a store id based on model configuration state.
	*
	* This is necessary because the model is used by the component and
	* different modules that might need different sets of data or different
	* ordering requirements.
	*
	* @param string $id A prefix for the store id.
	* @return string A store id.
	*/
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id.= ':' . $this->getState('filter.search');
		$id.= ':' . $this->getState('filter.state');
		$id.= ':' . $this->getState('filter.language');
		return parent::getStoreId($id);
	}

	/**
	* Build a SQL query to load the list data.
	*
	* @return JDatabaseQuery
	*/
	protected function getListQuery()
	{
		echo "HELLO FROM getListQuery<br/>";
		
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
		// Select the required fields from the table.
		$query->select('id, button_name, button_text, description, score, css_class, ordering, language, created, published');
		$query->from($db->quoteName('#__dnagifts_option_button'));
		
		// Filter by published state
		$published = $this->getState('filter.state');
		if (is_numeric($published)) {
			$query->where('published = '.(int) $published);
		} else if ($published === '') {
			$query->where('published IN (0, 1)');
		}
		
		// Filter by language
		$language = $this->getState('filter.language');
		if ($language && $language != 'all') {
			$query->where('language = \''.$language.'\'');
		}
		
		// Filter by search in code
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('button_name LIKE '.$search.'');
			}
		}
		
		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');
		$query->order($db->getEscaped($orderCol.' '.$orderDirn));
		return $query;
	}
	
}