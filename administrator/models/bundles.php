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
class BreedableModelBundles extends JModelList {

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
                'breed', 'a.breed',
                'coat', 'a.coat',
                'eyes', 'a.eyes',
                'bundle', 'a.bundle',
                'gender', 'a.gender',
                'food', 'a.food',
                'health', 'a.health',
                'fevor', 'a.fevor',
                'range', 'a.range',
                'sound', 'a.sound',
                'walk', 'a.walk',
                'title', 'a.title',
                'pregnant', 'a.pregnant',
                'father_id', 'a.father_id',
                'father_name', 'a.father_name',
                'mother_id', 'a.mother_id',
                'mother_name', 'a.mother_name',
                'mane', 'a.mane',
                'mate', 'a.mate',
                'terrain', 'a.terrain',
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

        
		//Filtering breed
		$this->setState('filter.breed', $app->getUserStateFromRequest($this->context.'.filter.breed', 'filter_breed', '', 'string'));

		//Filtering gender
		$this->setState('filter.gender', $app->getUserStateFromRequest($this->context.'.filter.gender', 'filter_gender', '', 'string'));

		//Filtering range
		$this->setState('filter.range', $app->getUserStateFromRequest($this->context.'.filter.range', 'filter_range', '', 'string'));

		//Filtering sound
		$this->setState('filter.sound', $app->getUserStateFromRequest($this->context.'.filter.sound', 'filter_sound', '', 'string'));

		//Filtering walk
		$this->setState('filter.walk', $app->getUserStateFromRequest($this->context.'.filter.walk', 'filter_walk', '', 'string'));

		//Filtering title
		$this->setState('filter.title', $app->getUserStateFromRequest($this->context.'.filter.title', 'filter_title', '', 'string'));

		//Filtering pregnant
		$this->setState('filter.pregnant', $app->getUserStateFromRequest($this->context.'.filter.pregnant', 'filter_pregnant', '', 'string'));

		//Filtering mother_id
		$this->setState('filter.mother_id', $app->getUserStateFromRequest($this->context.'.filter.mother_id', 'filter_mother_id', '', 'string'));

		//Filtering mane
		$this->setState('filter.mane', $app->getUserStateFromRequest($this->context.'.filter.mane', 'filter_mane', '', 'string'));

		//Filtering mate
		$this->setState('filter.mate', $app->getUserStateFromRequest($this->context.'.filter.mate', 'filter_mate', '', 'string'));

		//Filtering terrain
		$this->setState('filter.terrain', $app->getUserStateFromRequest($this->context.'.filter.terrain', 'filter_terrain', '', 'string'));


        // Load the parameters.
        $params = JComponentHelper::getParams('com_breedable');
        $this->setState('params', $params);

        // List state information.
        parent::populateState('a.breed', 'asc');
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
        $query->from('`#__breedable_bundle` AS a');

        
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
                $query->where('( a.breed LIKE '.$search.'  OR  a.coat LIKE '.$search.'  OR  a.eyes LIKE '.$search.'  OR  a.bundle LIKE '.$search.'  OR  a.gender LIKE '.$search.'  OR  a.food LIKE '.$search.'  OR  a.health LIKE '.$search.'  OR  a.fevor LIKE '.$search.'  OR  a.range LIKE '.$search.'  OR  a.sound LIKE '.$search.'  OR  a.walk LIKE '.$search.'  OR  a.title LIKE '.$search.'  OR  a.pregnant LIKE '.$search.' )');
            }
        }

        

		//Filtering breed

		//Filtering gender
		$filter_gender = $this->state->get("filter.gender");
		if ($filter_gender != '') {
			$query->where("a.gender = '".$db->escape($filter_gender)."'");
		}

		//Filtering range

		//Filtering sound
		$filter_sound = $this->state->get("filter.sound");
		if ($filter_sound != '') {
			$query->where("a.sound = '".$db->escape($filter_sound)."'");
		}

		//Filtering walk

		//Filtering title
		$filter_title = $this->state->get("filter.title");
		if ($filter_title != '') {
			$query->where("a.title = '".$db->escape($filter_title)."'");
		}

		//Filtering pregnant

		//Filtering mother_id

		//Filtering mane

		//Filtering mate

		//Filtering terrain
		$filter_terrain = $this->state->get("filter.terrain");
		if ($filter_terrain != '') {
			$query->where("a.terrain = '".$db->escape($filter_terrain)."'");
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
