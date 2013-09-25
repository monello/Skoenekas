<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import the Joomla modellist library
jimport('joomla.application.component.modellist');

/**
 * DnaGifts Model
 */
class DnaGiftsModelTesthistory extends JModelList
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
			$config['filter_fields'] = array(
				'id', 'status', 'user_id', 'test_id', 'progress', 'started_datetime'
			);
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
		
		$status = $this->getUserStateFromRequest($this->context.'.filter.status', 'filter_status', '', 'string');
		$this->setState('filter.status', $status);
		
		$user_id = $this->getUserStateFromRequest($this->context.'.filter.user_id', 'filter_user_id', '', 'string');
		$this->setState('filter.user_id', $user_id);
		
		$test_id = $this->getUserStateFromRequest($this->context.'.filter.test_id', 'filter_test_id', '', 'string');
		$this->setState('filter.test_id', $test_id);
		
		$progress = $this->getUserStateFromRequest($this->context.'.filter.progress', 'filter_progress', '', 'string');
		$this->setState('filter.progress', $progress);
		
		// Load the parameters.
		$params = JComponentHelper::getParams('com_dnagifts');
		$this->setState('params', $params);
		
		// List state information.
		parent::populateState('started_datetime', 'desc');
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
		$id.= ':' . $this->getState('filter.status');
		$id.= ':' . $this->getState('filter.user_id');
		$id.= ':' . $this->getState('filter.test_id');
		$id.= ':' . $this->getState('filter.progress');
		return parent::getStoreId($id);
	}

	/**
	* Build a SQL query to load the list data.
	*
	* @return JDatabaseQuery
	*/
	protected function getListQuery()
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);
		
		// Select the required fields from the table.
		$query->select('a.id, a.user_id, a.test_id, a.progress, a.started_datetime, a.report_name, c.test_name,
			IF(a.progress = 100 && a.report_name IS NULL, 3, 
				IF(a.progress = 100 && a.report_name IS NOT NULL , 1, 
					IF(a.progress < 100, 2,4))) AS status');
		$query->from($db->quoteName('#__dnagifts_lnk_user_tests'). ' AS a');
		
		// Join over the users
		$query->select('b.name, b.username');
		$query->join('LEFT', $db->quoteName('#__users').' AS b ON b.id = a.user_id');
		
		// Join over the users
		$query->select('c.test_name');
		$query->join('LEFT', $db->quoteName('#__dnagifts_test').' AS c ON c.id = a.test_id');
		
		// Filter by user_id state
		$status = $this->getState('filter.status');
		if (is_numeric($status)) {
			switch ($status) {
				case 1:
					$query->where('a.progress = 100 AND a.report_name IS NOT NULL');
					break;
				case 2:
					$query->where('a.progress < 100');
					break;
				case 3:
					$query->where('a.progress = 100 AND a.report_name IS NULL');
					break;
				case 4:
					$query->where('a.progress > 100');
					break;
			}
		}
		
		// Filter by user_id state
		$user_id = $this->getState('filter.user_id');
		if (is_numeric($user_id)) {
			$query->where('a.user_id = '.(int) $user_id);
		}
		
		// Filter by test_id
		$test_id = $this->getState('filter.test_id');
		if (is_numeric($test_id)) {
			$query->where('a.test_id = '.(int) $test_id);
		}
		
		// Filter by progress
		$progress = $this->getState('filter.progress');
		if (is_numeric($progress)) {
			$query->where('a.progress = '.(int) $progress);
		}
		
		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
			$query->where('c.test_name LIKE '.$search.'');
		}
		
		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');
		$query->order($db->getEscaped($orderCol.' '.$orderDirn));
		return $query;
	}
	
}
