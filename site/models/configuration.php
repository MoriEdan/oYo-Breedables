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
/*
a.breedable_type as type, a.breedable_name as name, a.breedable_key as id,
a.owner_name as name, a.owner_key as owner_key

a.status as status
a.version as version
a.generation as generation
a.breedable_dob as dob
a.breedable_gender as gender
a.breedable_coat as coat
a.breedable_eyes as eyes
a.breedable_food as food, a.breedable_health as health
a.breedable_fevor as fevor, a.breedable_walk as walk, a.breedable_range as range, a.breedable_terrain as terrain
a.breedable_sound as sound, a.breedable_title as title
a.breedable_pregnant as pregnant, a.breedable_mane as mane, a.breedable_mate as mate
a.bundle_key as bundle_key
a.mother_name as mother_name, a.mother_id as mother_id, a.father_name as father_name, a.father_id as father_id
a.location as location
*/
class BreedableModelConfiguration extends JModelItem
{
/*
0    breed
1    coat
2    eyes
3    birthday (integer value)
4    gender: "F" or "M"
5    food 0...100
6    health 0...100
7    fevor (0...100)
8    walk range (5...255)
9    sound on/off: 0 or 1
10    walk on/off: 0 or 1
11    title 0=off 1=on 2=compact
12    pregnant: 0 or mating time as integer
13    father name
14    mother name
15    mane type: B1 for normal, B2 for long mane (only for horses)
16    mate all/owners: 0 or 1
17    walk on terraint: 0 or 1
18    generation: 0....n
19    id: database primary key
*/
	public function configure( $data = null ) {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select('a.id as configure_id')
			->select('a.breedable_type as breedable_type')         // 0
			->select('a.breedable_name as breedable_name')         // 1
			->select('a.breedable_key as breedable_key')           // 2
			->select('a.owner_name as owner_name')                 // 3
			->select('a.owner_key as owner_key')                   // 4
			->select('a.status as status')                         // 5
			->select('a.version as version')                       // 6
			->select('a.generation as generation')                 // 7
			->select('a.breedable_dob as breedable_dob')           // 8
			->select('a.breedable_gender as breedable_gender')     // 9
			->select('a.breedable_coat as breedable_coat')         // 10
			->select('a.breedable_eyes as breedable_eyes')         // 11
			->select('a.breedable_food as breedable_food')         // 12
			->select('a.breedable_health as breedable_health')     // 13
			->select('a.breedable_fevor as breedable_fevor')       // 14
			->select('a.breedable_walk as breedable_walk')         // 15
			->select('a.breedable_range as breedable_range')       // 16
			->select('a.breedable_terrain as breedable_terrain')   // 17
			->select('a.breedable_sound as breedable_sound')       // 18
			->select('a.breedable_title as breedable_title')       // 19
			->select('a.breedable_pregnant as breedable_pregnant') // 20
			->select('a.breedable_mane as breedable_mane')         // 21
			->select('a.breedable_mate as breedable_mate')         // 22
			->select('a.bundle_key as bundle_key')                 // 23
			->select('a.mother_name as mother_name')               // 24
			->select('a.mother_id as mother_id')                   // 25
			->select('a.father_name as father_name')               // 26
			->select('a.father_id as father_id')                   // 27
			->select('a.location as location')                     // 28
			->from($db->quoteName('#__breedable') . ' AS a');

		// Join with the category
		$query->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=a.breedable_type')
			->select('cat.title as category_title');

		$query->where($db->quoteName('cat.title') . '=' . $db->quote($data['breedable_type']))
			->where($db->quoteName('a.owner_name') . '=' . $db->quote($data['owner_name']))
			->where($db->quoteName('a.owner_key') . '=' . $db->quote($data['owner_key']))
			->where($db->quoteName('a.status') . '=' . $db->quote($data['previous_status']));
		$db->setQuery($query);
		$configure = $db->loadAssoc();

		$query2 = $db->getQuery(true);

		// Fields to update.
		$fields = array(
			$db->quoteName('status') . ' = ' . $db->quote($data['current_status'])
		);

		// Conditions for which records should be updated.
		$conditions = array(
			$db->quoteName('id') . ' = ' . $db->quote($configure['configure_id'])
		);

		$query2->update($db->quoteName('#__breedable'))->set($fields)->where($conditions);

		$db->setQuery($query2);

		$result = $db->query();

		//echo print_r($configure, true);

		$output  = $configure['category_title'] . "-";
		$output .= $configure['breedable_coat'] . "-";
		$output .= $configure['breedable_eyes'] . "-";
		$output .= strtotime( $configure['breedable_dob'] ) . "-";
		$output .= $configure['breedable_gender'] . "-";
		$output .= $configure['breedable_food'] . "-";
		$output .= $configure['breedable_health'] . "-";
		$output .= $configure['breedable_fevor'] . "-";
		$output .= $configure['breedable_range'] . "-";
		$output .= $configure['breedable_sound'] . "-";
		$output .= $configure['breedable_walk'] . "-";
		$output .= $configure['breedable_title'] . "-";
		$output .= $configure['breedable_pregnant'] . "-";
		$output .= $configure['father_name'] . "-";
		$output .= $configure['mother_name'] . "-";
		$output .= $configure['breedable_mane'] . "-";
		$output .= $configure['breedable_mate'] . "-";
		$output .= $configure['breedable_terrain'] . "-";
		$output .= $configure['generation'];

		echo $output;
	}

	public function information( $data = null ) {
/*
		$query = $db->getQuery(true)
				->select('id')
				->from($db->quoteName('#__breedable'))
				->where($db->quoteName('id') . '=' . $db->quote($data['id']));
		$db->setQuery($query);
		$row = $db->loadRow();
*/
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select('a.breedable_type as breedable_type')       // 0
			->select('a.breedable_name as breedable_name')         // 1
			->select('a.breedable_key as breedable_key')           // 2
			->select('a.owner_name as owner_name')                 // 3
			->select('a.owner_key as owner_key')                   // 4
			->select('a.status as status')                         // 5
			->select('a.version as version')                       // 6
			->select('a.generation as generation')                 // 7
			->select('a.breedable_dob as breedable_dob')           // 8
			->select('a.breedable_gender as breedable_gender')     // 9
			->select('a.breedable_coat as breedable_coat')         // 10
			->select('a.breedable_eyes as breedable_eyes')         // 11
			->select('a.breedable_food as breedable_food')         // 12
			->select('a.breedable_health as breedable_health')     // 13
			->select('a.breedable_fevor as breedable_fevor')       // 14
			->select('a.breedable_walk as breedable_walk')         // 15
			->select('a.breedable_range as breedable_range')       // 16
			->select('a.breedable_terrain as breedable_terrain')   // 17
			->select('a.breedable_sound as breedable_sound')       // 18
			->select('a.breedable_title as breedable_title')       // 19
			->select('a.breedable_pregnant as breedable_pregnant') // 20
			->select('a.breedable_mane as breedable_mane')         // 21
			->select('a.breedable_mate as breedable_mate')         // 22
			->select('a.bundle_key as bundle_key')                 // 23
			->select('a.mother_name as mother_name')               // 24
			->select('a.mother_id as mother_id')                   // 25
			->select('a.father_name as father_name')               // 26
			->select('a.father_id as father_id')                   // 27
			->select('a.location as location')                     // 28
			->from($db->quoteName('#__breedable') . ' AS a');

		// Join with the category
		$query->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=a.breedable_type')
			->select('cat.title as category_title');

		$query->where($db->quoteName('a.id') . '=' . $db->quote($data['id']));
		$db->setQuery($query);
		$row = $db->loadAssoc();

		$output  = JText::_('COM_BREEDABLE_INFO_BREEDABLE_TYPE') . $row['category_title'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_NAME') . $row['breedable_name'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_KEY') . $row['breedable_key'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_OWNER_NAME') . $row['owner_name'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_OWNER_KEY') . $row['owner_key'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_STATUS') . $row['status'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_VERSION') . $row['version'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_GENERATION') . $row['generation'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_DOB') . $row['breedable_dob'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_GENDER') . $row['breedable_gender'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_COAT') . $row['breedable_coat'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_EYES') . $row['breedable_eyes'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_FOOD') . $row['breedable_food'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_HEALTH') . $row['breedable_health'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_FEVOR') . $row['breedable_fevor'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_WALK') . $row['breedable_walk'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_RANGE') . $row['breedable_range'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_TERRAIN') . $row['breedable_terrain'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_SOUND') . $row['breedable_sound'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_TITLE') . $row['breedable_title'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_PREGNANT') . $row['breedable_pregnant'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_MANE') . $row['breedable_mane'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_BREEDABLE_MATE') . $row['breedable_mate'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_BUNDLE_KEY') . $row['bundle_key'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_MOTHER_NAME') . $row['mother_name'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_MOTHER_ID') . $row['mother_id'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_FATHER_NAME') . $row['father_name'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_FATHER_ID') . $row['father_id'] . "\r\n";
		$output .= JText::_('COM_BREEDABLE_INFO_BREEDABLE_LOCATION') . $row['location'] . "\r\n";

		echo nl2br($output, true);
	}
/*
0    breed
1    coat
2    eyes
3    birthday (integer value)
4    gender: "F" or "M"
5    food 0...100
6    health 0...100
7    fevor (0...100)
8    walk range (5...255)
9    sound on/off: 0 or 1
10    walk on/off: 0 or 1
11    title 0=off 1=on 2=compact
12    pregnant: 0 or mating time as integer
13    father name
14    mother name
15    mane type: B1 for normal, B2 for long mane (only for horses)
16    mate all/owners: 0 or 1
17    walk on terraint: 0 or 1
18    generation: 0....n
19    id: database primary key

oYo-Blackwalker-Inferno-1402383946-Female-100-100-0-10-0-0-1-0-Starter Dad-Starter Mom-B1-0-0
*/
    public function register( $data = null ) {
		// Get a db connection.
		$db = JFactory::getDbo();

		$breedable_config = explode("-", $data['breedable_config']);
/*
		echo print_r($breedable_config, true);
*/
		$query1 = $db->getQuery(true)
				->select('id')
				->from($db->quoteName('#__categories'))
				->where($db->quoteName('title') . '=' . $db->quote($data['breedable_type']));
		$db->setQuery($query1);
		$category_id = $db->loadResult();

		$query2 = $db->getQuery(true)
				->select('id')
				->from($db->quoteName('#__breedable'))
				->where($db->quoteName('breedable_name') . '=' . $db->quote($breedable_config[14]));
		$db->setQuery($query2);
		$mother_id = $db->loadResult();

		
		$query3 = $db->getQuery(true)
				->select('id')
				->from($db->quoteName('#__breedable'))
				->where($db->quoteName('breedable_name') . '=' . $db->quote($breedable_config[13]));
		$db->setQuery($query3);
		$father_id = $db->loadResult();

		// Insert columns.
		$columns = array(
			'breedable_name',
			'breedable_type',                    // 0
			'breedable_coat',                    // 1
			'breedable_eyes',                    // 2
			'breedable_dob',                     // 3
			'breedable_gender',                  // 4
			'breedable_food',                    // 5
			'breedable_health',                  // 6
			'breedable_fevor',                   // 7
			'breedable_range',                   // 8
			'breedable_sound',                   // 9
			'breedable_walk',                    // 10
			'breedable_title',                   // 11
			'breedable_pregnant',                // 12
			'father_name',                       // 13
			'father_id',
			'mother_name',                       // 14
			'mother_id',
			'breedable_mane',                    // 15
			'breedable_mate',                    // 16
			'breedable_terrain',                 // 17
			'owner_name',
			'owner_key',
			'generation',                        // 18
			'location',
			'status'
		);
		// Insert values.
		$values = array(
			$db->quote($data['breedable_name']),
			(int)$category_id,                                            // 0
			$db->quote($breedable_config[1]),                             // 1
			$db->quote($breedable_config[2]),                             // 2
			$db->quote(date("Y-m-d H:i:s", $breedable_config[3])),        // 3
			$db->quote($breedable_config[4]),                             // 4
			(int)$breedable_config[5],                                    // 5
			(int)$breedable_config[6],                                    // 6
			(int)$breedable_config[7],                                    // 7
			(int)$breedable_config[8],                                    // 8
			(int)$breedable_config[9],                                    // 9
			(int)$breedable_config[10],                                   // 10
			(int)$breedable_config[11],                                   // 11
			(int)$breedable_config[12],                                   // 12
			$db->quote($breedable_config[13]),                            // 13
			(int)$father_id,
			$db->quote($breedable_config[14]),                            // 14
			(int)$mother_id,
			$db->quote($breedable_config[15]),                            // 15
			(int)$breedable_config[16],                                   // 16
			(int)$breedable_config[17],                                   // 17
			$db->quote($data['owner_name']),
			$db->quote($data['owner_key']),
			(int)$data['generation'],
			$db->quote($data['location']),
			$db->quote($data['status'])
		);

		// Prepare the insert query.
		$query4 = $db->getQuery(true)
			->insert($db->quoteName('#__breedable'))
			->columns($db->quoteName($columns))
			->values(implode(',', $values ));

		// Set the query using our newly populated query object and execute it.
		$db->setQuery($query4);
		$db->query();
		$breedable_id = $db->insertid();
		echo $breedable_id;
	}

    /**
     * Method to birth the model state.
     *
     * Note. Calling birth in this method will result in recursion.
     *
     * @since	1.6
     */
    public function birth( $data = null ) {

		// Get a db connection.
		$db = JFactory::getDbo();

		$query1 = $db->getQuery(true);

		// Select the required fields from the table.
		$query1->select('a.id as birth_id')       // 0
			->select('a.breedable_type as breedable_type')       // 0
			->select('a.breedable_name as breedable_name')         // 1
			->select('a.breedable_key as breedable_key')           // 2
			->select('a.owner_name as owner_name')                 // 3
			->select('a.owner_key as owner_key')                   // 4
			->select('a.status as status')                         // 5
			->select('a.version as version')                       // 6
			->select('a.generation as generation')                 // 7
			->select('a.breedable_dob as breedable_dob')           // 8
			->select('a.breedable_gender as breedable_gender')     // 9
			->select('a.breedable_coat as breedable_coat')         // 10
			->select('a.breedable_eyes as breedable_eyes')         // 11
			->select('a.breedable_food as breedable_food')         // 12
			->select('a.breedable_health as breedable_health')     // 13
			->select('a.breedable_fevor as breedable_fevor')       // 14
			->select('a.breedable_walk as breedable_walk')         // 15
			->select('a.breedable_range as breedable_range')       // 16
			->select('a.breedable_terrain as breedable_terrain')   // 17
			->select('a.breedable_sound as breedable_sound')       // 18
			->select('a.breedable_title as breedable_title')       // 19
			->select('a.breedable_pregnant as breedable_pregnant') // 20
			->select('a.breedable_mane as breedable_mane')         // 21
			->select('a.breedable_mate as breedable_mate')         // 22
			->select('a.bundle_key as bundle_key')                 // 23
			->select('a.mother_name as mother_name')               // 24
			->select('a.mother_id as mother_id')                   // 25
			->select('a.father_name as father_name')               // 26
			->select('a.father_id as father_id')                   // 27
			->select('a.location as location')                     // 28
			->from($db->quoteName('#__breedable') . ' AS a');

		// Join with the category
		$query1->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=a.breedable_type')
			->where($db->quoteName('cat.title') . '=' . $db->quote($data['breedable_type']))
			->where($db->quoteName('a.owner_name') . '=' . $db->quote($data['owner_name']))
			->where($db->quoteName('a.owner_key') . '=' . $db->quote($data['owner_key']))
			->where($db->quoteName('a.mother_name') . '=' . $db->quote($data['mother_name']))
			->where($db->quoteName('a.father_name') . '=' . $db->quote($data['father_name']))
			->where($db->quoteName('a.generation') . '=' . $db->quote($data['generation']));
		
		$db->setQuery($query1);
		$birth = $db->loadAssoc();
		$birth_id = $db->loadResult();

		echo "breed id = " . $birth['birth_id'];
		echo print_r($birth, true);

		$query2 = $db->getQuery(true);

		// Fields to update.
		$fields = array(
			$db->quoteName('status') . ' = ' . $db->quote($data['status'])
		);

		// Conditions for which records should be updated.
		$conditions = array(
			$db->quoteName('id') . ' = ' . $db->quote($birth['birth_id'])
		);

		$query2->update($db->quoteName('#__breedable'))->set($fields)->where($conditions);

		$db->setQuery($query2);

		$result = $db->query();

	}

	public function delivery( $data = null ) {
		// Get a db connection.
		$db = JFactory::getDbo();

		$query1 = $db->getQuery(true);
		
		// Select the required fields from the table.
		$query1->select('a.id as delivery_id')       // 0
			->select('a.breedable_type as breedable_type')       // 0
			->select('a.breedable_name as breedable_name')         // 1
			->select('a.breedable_key as breedable_key')           // 2
			->select('a.owner_name as owner_name')                 // 3
			->select('a.owner_key as owner_key')                   // 4
			->select('a.status as status')                         // 5
			->select('a.version as version')                       // 6
			->select('a.generation as generation')                 // 7
			->select('a.breedable_dob as breedable_dob')           // 8
			->select('a.breedable_gender as breedable_gender')     // 9
			->select('a.breedable_coat as breedable_coat')         // 10
			->select('a.breedable_eyes as breedable_eyes')         // 11
			->select('a.breedable_food as breedable_food')         // 12
			->select('a.breedable_health as breedable_health')     // 13
			->select('a.breedable_fevor as breedable_fevor')       // 14
			->select('a.breedable_walk as breedable_walk')         // 15
			->select('a.breedable_range as breedable_range')       // 16
			->select('a.breedable_terrain as breedable_terrain')   // 17
			->select('a.breedable_sound as breedable_sound')       // 18
			->select('a.breedable_title as breedable_title')       // 19
			->select('a.breedable_pregnant as breedable_pregnant') // 20
			->select('a.breedable_mane as breedable_mane')         // 21
			->select('a.breedable_mate as breedable_mate')         // 22
			->select('a.bundle_key as bundle_key')                 // 23
			->select('a.mother_name as mother_name')               // 24
			->select('a.mother_id as mother_id')                   // 25
			->select('a.father_name as father_name')               // 26
			->select('a.father_id as father_id')                   // 27
			->select('a.location as location')                     // 28
			->from($db->quoteName('#__breedable') . ' AS a');

		// Join with the category
		$query1->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=a.breedable_type')
			->where($db->quoteName('cat.title') . '=' . $db->quote($data['breedable_type']))
			->where($db->quoteName('a.owner_name') . '=' . $db->quote($data['owner_name']))
			->where($db->quoteName('a.owner_key') . '=' . $db->quote($data['owner_key']));
		
		$db->setQuery($query1);
		$delivery = $db->loadAssoc();

		echo print_r($delivery, true);

		$query2 = $db->getQuery(true);

		// Fields to update.
		$fields = array(
			$db->quoteName('status') . ' = ' . $db->quote($data['status'])
		);

		// Conditions for which records should be updated.
		$conditions = array(
			$db->quoteName('id') . ' = ' . $db->quote($delivery['delivery_id'])
		);

		$query2->update($db->quoteName('#__breedable'))->set($fields)->where($conditions);

		$db->setQuery($query2);

		$result = $db->query();
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
