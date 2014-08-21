<?php

/**
 * @version     1.0.12
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
class BreedableModelConfigurations extends JModelList
{
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
                'breedable_type', 'a.breedable_type',
                'breedable_name', 'a.breedable_name',
                'breedable_key', 'a.breedable_key',
                'owner_name', 'a.owner_name',
                'owner_key', 'a.owner_key',
                'status', 'a.status',
                'version', 'a.version',
                'generation', 'a.generation',
                'breedable_dob', 'a.breedable_dob',
                'breedable_gender', 'a.breedable_gender',
                'breedable_coat', 'a.breedable_coat',
                'breedable_eyes', 'a.breedable_eyes',
                'breedable_food', 'a.breedable_food',
                'breedable_health', 'a.breedable_health',
                'breedable_fevor', 'a.breedable_fevor',
                'breedable_walk', 'a.breedable_walk',
                'breedable_range', 'a.breedable_range',
                'breedable_terrain', 'a.breedable_terrain',
                'breedable_sound', 'a.breedable_sound',
                'breedable_title', 'a.breedable_title',
                'breedable_pregnant', 'a.breedable_pregnant',
                'breedable_mane', 'a.breedable_mane',
                'breedable_mate', 'a.breedable_mate',
                'bundle_key', 'a.bundle_key',
                'mother_name', 'a.mother_name',
                'mother_id', 'a.mother_id',
                'father_name', 'a.father_name',
                'father_id', 'a.father_id',
                'location', 'a.location',
                'ordering', 'a.ordering',
                'created_by', 'a.created_by'
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

		// Filtering owner_name
		$this->setState('filter.owner_name', $app->getUserStateFromRequest($this->context.'.filter.owner_name', 'filter_owner_name', '', 'string'));

		// Filtering status
		$this->setState('filter.status', $app->getUserStateFromRequest($this->context.'.filter.status', 'filter_status', '', 'string'));

		// Filtering generation
		$this->setState('filter.generation', $app->getUserStateFromRequest($this->context.'.filter.generation', 'filter_generation', '', 'string'));

		// Filtering breedable_gender
		$this->setState('filter.breedable_gender', $app->getUserStateFromRequest($this->context.'.filter.breedable_gender', 'filter_breedable_gender', '', 'string'));

		// Filtering breedable_eyes
		$this->setState('filter.breedable_eyes', $app->getUserStateFromRequest($this->context.'.filter.breedable_eyes', 'filter_breedable_eyes', '', 'string'));

		// Filtering breedable_fevor
		$this->setState('filter.breedable_fevor', $app->getUserStateFromRequest($this->context.'.filter.breedable_fevor', 'filter_breedable_fevor', '', 'string'));

		// Filtering breedable_pregnant
		$this->setState('filter.breedable_pregnant', $app->getUserStateFromRequest($this->context.'.filter.breedable_pregnant', 'filter_breedable_pregnant', '', 'string'));

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
				$query->where('( a.status LIKE '.$search.'  OR a.id LIKE '.$search.'  OR a.breedable_name LIKE '.$search.'  OR  a.mother_name LIKE '.$search.'  OR  a.father_name LIKE '.$search.' OR  a.owner_name LIKE '.$search.'  OR  a.owner_key LIKE '.$search.'  OR  a.breedable_gender LIKE '.$search.' )');
                
            }
        }

		//Filtering owner_name
		$filter_owner_name = $this->state->get("filter.owner_name");
		if ($filter_owner_name != '') {
			$query->where("a.owner_name = '".$db->escape($filter_owner_name)."'");
		}
		//Filtering status

		//Filtering generation

		//Filtering breedable_gender
		$filter_breedable_gender = $this->state->get("filter.breedable_gender");
		if ($filter_breedable_gender != '') {
			$query->where("a.breedable_gender = '".$db->escape($filter_breedable_gender)."'");
		}

		//Filtering breedable_eyes

		//Filtering breedable_fevor

		//Filtering breedable_pregnant


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
