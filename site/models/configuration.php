<?php

/**
 * @version     1.0.12
 * @package     com_breedable
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Stephen Bishop <dazzle.software@gmail.com> - http://dazzlesoftware.org
 */
// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modelitem');
jimport('joomla.event.dispatcher');

/**
 * Breedable model.
 */
class BreedableModelConfiguration extends JModelItem
{
    /**
     * Method to birth the model state.
     *
     * Note. Calling birth in this method will result in recursion.
     *
     * @since	1.6
     */
/*
0 - Breed - (Type of breed oYo Horse,oYo Cat etc) = oYo
1 - Coat - (Breed Skin) = Blackwalker
2 - Eyes - (Breed Eye type) =Inferno
3 - Unix Time Stamp = 1402383946
4 - Gender - (Male, Female, or other) = F
5 - food - (0.....100) = 100
6 - health - (0.....100) = 100
7 - Fevor = 0
8 - Walk Range - = 10
9 - sound on/off: 0 or 1 = 0
10 - Walk  - (on or off) = 0
11 - title 0=off 1=on 2=compact = 1
12 - pregnant: 0 or mating time as integer = 0
13 - Father Name - (Name of Father or Starter) = Father Name
14 - Mother Name - (Name of Mother or Starter) = Mother Name
15 - Mane - (B1 for normal,B2 for long mane) = B1
16 - mate all/owners: 0 or 1 = 0
17 - walk on terraint: 0 or 1 =0
oYo-Blackwalker-Inferno-1402383946-Female-100-100-0-10-0-0-1-0-Starter Dad-Starter Mom-B1-0-0
*/

    public function birth( $data = null ) {

	//echo $data['breedable_type'];
		// Get a db connection.
		$db = JFactory::getDbo();
		
		$db->setQuery('SELECT category.id FROM #__categories category WHERE category.title=' . $db->quote($data['breedable_type']));
		$category_id = $db->loadResult();
		
		$db->setQuery('SELECT breed.mother_id FROM #__breedable breed WHERE breed.mother_name=' . $db->quote($data['mother_name']));
		$mother_id = $db->loadResult();
		
		$db->setQuery('SELECT breed.father_id FROM #__breedable breed WHERE breed.mother_name=' . $db->quote($data['father_name']));
		$father_id = $db->loadResult();
			   
			   //echo "id = {$category_id} for " . $data['breedable_type'];
		// Insert columns.
		$columns = array(
			'breedable_type',     // 0
			'breedable_coat',     // 1
			'breedable_eyes',     // 2 
			'breedable_dob',      // 3
			'breedable_gender',   // 4
			'breedable_food',     // 5
			'breedable_health'    // 6
			'breedable_fevor',    // 7
			'breedable_range',    // 8
			'breedable_sound',    // 9
			'breedable_walk',     // 10
			'breedable_title',    // 11
			'breedable_pregnant', // 12
			'mother_name',        // 13
			'mother_id',        // 13b
			'father_name',        // 14
			'father_id',        // 14b
			'breedable_mane'      // 15
			'breedable_mate'      // 16
			'breedable_terrain'    // 17



		);
 
		// Insert values.
		$values = array(
			$category_id,
			$data['breedable_coat'],
			$data['breedable_eyes'],
			date("Y-m-d H:i:s", $data['breedable_dob']),
			$data['breedable_gender'],
			$data['breedable_food'],
			$data['breedable_health'],
			$data['breedable_fevor'],
			$data['breedable_range'],
			$data['breedable_sound'],
			$data['breedable_walk'],
			$data['breedable_title'],
			$data['breedable_pregnant'],
			$data['mother_name'],
			$mother_id,
			$data['father_name'],
			$father_id,
			$data['breedable_mane'],
			$data['breedable_mate'],
			$data['breedable_terrain'],
		)
 
		// Prepare the insert query.
		$query = $db->getQuery(true)
			->insert($db->quoteName('#__breedable'))
			->columns($db->quoteName($columns))
			->values($db->quoteName($values));

		// Set the query using our newly populated query object and execute it.
		$db->setQuery($query);
		$db->query();

	//birth.php?owner,moth_id,moth_name,moth_config,fath_id,fath_name,fath_config
		echo print_r($data, true);
		
		//echo strtotime($data['breedable_dob']);
		//echo $data['breedable_dob'];
		//echo date("Y-m-d H:i:s", $data['breedable_dob']); //unix to mysql time
		//echo strtotime( date("Y-m-d H:i:s", $mysql_row['breedable_dob']) ); //mysql time to unixtime
	}
    /**
     * Method to auto-populate the model state.
     *
     * Note. Calling getState in this method will result in recursion.
     *
     * @since	1.6
     */
    protected function populateState() {
        $app = JFactory::getApplication('com_breedable');

        // Load state from the request userState on edit or from the passed variable on default
        if (JFactory::getApplication()->input->get('layout') == 'edit') {
            $id = JFactory::getApplication()->getUserState('com_breedable.edit.configuration.id');
        } else {
            $id = JFactory::getApplication()->input->get('id');
            JFactory::getApplication()->setUserState('com_breedable.edit.configuration.id', $id);
        }
        $this->setState('configuration.id', $id);

        // Load the parameters.
        $params = $app->getParams();
        $params_array = $params->toArray();
        if (isset($params_array['item_id'])) {
            $this->setState('configuration.id', $params_array['item_id']);
        }
        $this->setState('params', $params);
    }

    /**
     * Method to get an ojbect.
     *
     * @param	integer	The id of the object to get.
     *
     * @return	mixed	Object on success, false on failure.
     */
    public function &getData($id = null) {
        if ($this->_item === null) {
            $this->_item = false;

            if (empty($id)) {
                $id = $this->getState('configuration.id');
            }

            // Get a level row instance.
            $table = $this->getTable();

            // Attempt to load the row.
            if ($table->load($id)) {
                // Check published state.
                if ($published = $this->getState('filter.published')) {
                    if ($table->state != $published) {
                        return $this->_item;
                    }
                }

                // Convert the JTable to a clean JObject.
                $properties = $table->getProperties(1);
                $this->_item = JArrayHelper::toObject($properties, 'JObject');
            } elseif ($error = $table->getError()) {
                $this->setError($error);
            }
        }

        
		if ( isset($this->_item->created_by) ) {
			$this->_item->created_by_name = JFactory::getUser($this->_item->created_by)->name;
		}

        return $this->_item;
    }

    public function getTable($type = 'Configuration', $prefix = 'BreedableTable', $config = array()) {
        $this->addTablePath(JPATH_COMPONENT_ADMINISTRATOR . '/tables');
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Method to check in an item.
     *
     * @param	integer		The id of the row to check out.
     * @return	boolean		True on success, false on failure.
     * @since	1.6
     */
    public function checkin($id = null) {
        // Get the id.
        $id = (!empty($id)) ? $id : (int) $this->getState('configuration.id');

        if ($id) {

            // Initialise the table
            $table = $this->getTable();

            // Attempt to check the row in.
            if (method_exists($table, 'checkin')) {
                if (!$table->checkin($id)) {
                    $this->setError($table->getError());
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Method to check out an item for editing.
     *
     * @param	integer		The id of the row to check out.
     * @return	boolean		True on success, false on failure.
     * @since	1.6
     */
    public function checkout($id = null) {
        // Get the user id.
        $id = (!empty($id)) ? $id : (int) $this->getState('configuration.id');

        if ($id) {

            // Initialise the table
            $table = $this->getTable();

            // Get the current user object.
            $user = JFactory::getUser();

            // Attempt to check the row out.
            if (method_exists($table, 'checkout')) {
                if (!$table->checkout($user->get('id'), $id)) {
                    $this->setError($table->getError());
                    return false;
                }
            }
        }

        return true;
    }

    public function getCategoryName($id) {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
                ->select('title')
                ->from('#__categories')
                ->where('id = ' . $id);
        $db->setQuery($query);
        return $db->loadObject();
    }

    public function publish($id, $state) {
        $table = $this->getTable();
        $table->load($id);
        $table->state = $state;
        return $table->store();
    }

    public function delete($id) {
        $table = $this->getTable();
        return $table->delete($id);
    }

}
