<?php

/**
 * @version     1.0.9
 * @package     com_breedable
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Stephen Bishop <dazzle.software@gmail.com> - http://dazzlesoftware.org
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
                'breedable_id', 'a.breedable_id',
                'breedable_type', 'a.breedable_type',
                'breedable_gender', 'a.breedable_gender',
                'breedable_coat', 'a.breedable_coat',
                'breedable_eyes', 'a.breedable_eyes',
                'breedable_food', 'a.breedable_food',
                'breedable_health', 'a.breedable_health',
                'breedable_fevor', 'a.breedable_fevor',
                'breedable_range', 'a.breedable_range',
                'breedable_sound', 'a.breedable_sound',
                'breedable_walk', 'a.breedable_walk',
                'breedable_title', 'a.breedable_title',
                'breedable_pregnant', 'a.breedable_pregnant',
                'breedable_mane', 'a.breedable_mane',
                'breedable_mate', 'a.breedable_mate',
                'breedable_terrain', 'a.breedable_terrain',
                'owner_name', 'a.owner_name',
                'owner_key', 'a.owner_key',
                'bundle_key', 'a.bundle_key',
                'version', 'a.version',
                'status', 'a.status',
                'generation', 'a.generation',
                'mother_id', 'a.mother_id',
                'mother_name', 'a.mother_name',
                'father_id', 'a.father_id',
                'father_name', 'a.father_name',
                'location', 'a.location',
                'dob', 'a.dob',
                'ordering', 'a.ordering',
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

        

        // Load the parameters.
        $params = JComponentHelper::getParams('com_breedable');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.id', 'asc');
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
        $query->from('`#__breedable` AS a');

        
		// Join over the users for the checked out user
		$query->select("uc.name AS editor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		// Join over the category 'breedable_type'
		$query->select('breedable_type.title AS breedable_type');
		$query->join('LEFT', '#__categories AS breedable_type ON breedable_type.id = a.breedable_type');
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
                
            }
        }

        


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
