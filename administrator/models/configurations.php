<?php

/**
 * @version     1.0.2
 * @package     com_breedable
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Stephen Bishop <support@dazzlesoftware.org> - http://dazzlesoftware.org
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Breedable records.
 */
class BreedableModelConfigurations extends JModelList {

    /**
     * Constructor.
     *
     * @param    array    An optional associative array of configuration settings.
     * @see        JController
     * @since    1.6
     */
    public function __construct($config = array()) {
        if (empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                                'id', 'a.id',
                'owner_name', 'a.owner_name',
                'owner_key', 'a.owner_key',
                'version', 'a.version',
                'status', 'a.status',
                'generation', 'a.generation',
                'mother_id', 'a.mother_id',
                'father_id', 'a.father_id',
                'location', 'a.location',
                'created_by', 'a.created_by',

            );
        }

        parent::__construct($config);
    }

    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     */
    protected function populateState($ordering = null, $direction = null) {
        // Initialise variables.
        $app = JFactory::getApplication('administrator');

        // Load the filter state.
        $search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
        $this->setState('filter.search', $search);

        $published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
        $this->setState('filter.state', $published);

        
		//Filtering id
		$this->setState('filter.id', $app->getUserStateFromRequest($this->context.'.filter.id', 'filter_id', '', 'string'));

		//Filtering owner_name
		$this->setState('filter.owner_name', $app->getUserStateFromRequest($this->context.'.filter.owner_name', 'filter_owner_name', '', 'string'));

		//Filtering generation
		$this->setState('filter.generation', $app->getUserStateFromRequest($this->context.'.filter.generation', 'filter_generation', '', 'string'));

		//Filtering mother_id
		$this->setState('filter.mother_id', $app->getUserStateFromRequest($this->context.'.filter.mother_id', 'filter_mother_id', '', 'string'));

		//Filtering father_id
		$this->setState('filter.father_id', $app->getUserStateFromRequest($this->context.'.filter.father_id', 'filter_father_id', '', 'string'));

		//Filtering location
		$this->setState('filter.location', $app->getUserStateFromRequest($this->context.'.filter.location', 'filter_location', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_breedable');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.owner_name', 'asc');
    }

    /**
     * Method to get a store id based on model configuration state.
     *
     * This is necessary because the model is used by the component and
     * different modules that might need different sets of data or different
     * ordering requirements.
     *
     * @param	string		$id	A prefix for the store id.
     * @return	string		A store id.
     * @since	1.6
     */
    protected function getStoreId($id = '') {
        // Compile the store id.
        $id.= ':' . $this->getState('filter.search');
        $id.= ':' . $this->getState('filter.state');

        return parent::getStoreId($id);
    }

    /**
     * Build an SQL query to load the list data.
     *
     * @return	JDatabaseQuery
     * @since	1.6
     */
    protected function getListQuery() {
        // Create a new query object.
        $db = $this->getDbo();
        $query = $db->getQuery(true);

        // Select the required fields from the table.
        $query->select(
                $this->getState(
                        'list.select', 'a.*'
                )
        );
        $query->from('`#__breedable_configuration` AS a');

        
		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

        

        // Filter by search in title
        $search = $this->getState('filter.search');
        if (!empty($search)) {
            if (stripos($search, 'id:') === 0) {
                $query->where('a.id = ' . (int) substr($search, 3));
            } else {
                $search = $db->Quote('%' . $db->escape($search, true) . '%');
                $query->where('( a.owner_name LIKE '.$search.'  OR  a.owner_key LIKE '.$search.'  OR  a.version LIKE '.$search.'  OR  a.status LIKE '.$search.'  OR  a.generation LIKE '.$search.'  OR  a.location LIKE '.$search.' )');
            }
        }

        

		//Filtering id

		//Filtering owner_name

		//Filtering generation

		//Filtering mother_id

		//Filtering father_id

		//Filtering location


        // Add the list ordering clause.
        $orderCol = $this->state->get('list.ordering');
        $orderDirn = $this->state->get('list.direction');
        if ($orderCol && $orderDirn) {
            $query->order($db->escape($orderCol . ' ' . $orderDirn));
        }

        return $query;
    }

    public function getItems() {
        $items = parent::getItems();
        
        return $items;
    }

}
