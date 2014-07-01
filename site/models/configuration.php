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
/*
		if($data['mode'] == "sibling") {

			$query1 = $db->getQuery(true);

			// Select the required fields from the table.
			$query1->select('a.id as configure_id')
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
			$query1->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=a.breedable_type')
				->select('cat.title as category_title');

			$query1->where($db->quoteName('cat.title') . '=' . $db->quote($data['breedable_type']))
				->where($db->quoteName('a.owner_name') . '=' . $db->quote($data['owner_name']))
				->where($db->quoteName('a.owner_key') . '=' . $db->quote($data['owner_key']));
				//->where($db->quoteName('a.status') . '=' . $db->quote($data['previous_status']));
			$db->setQuery($query1);
			$configure = $db->loadAssoc();
			//echo "config";
			//echo print_r($configure, true);

			$query2 = $db->getQuery(true);

		// Select the required fields from the table.
			$query2->select('f.breedable_coat')
				->select('f.breedable_eyes')
				->select('f.breedable_mane')
				->from($db->quoteName('#__breedable') . ' AS f');

			$query2->where($db->quoteName('f.breedable_name') . '=' . $db->quote($configure['father_name']))
				->where($db->quoteName('f.id') . '=' . $db->quote($configure['father_id']));
			$db->setQuery($query2);
			$father = $db->loadAssoc();

			$query3 = $db->getQuery(true);

			$query3->select('m.breedable_coat')
				->select('m.breedable_eyes')
				->select('m.breedable_mane')
				->from($db->quoteName('#__breedable') . ' AS m');

			$query3->where($db->quoteName('m.breedable_name') . '=' . $db->quote($configure['mother_name']))
				->where($db->quoteName('m.id') . '=' . $db->quote($configure['mother_id']));
			$db->setQuery($query3);
			$mother = $db->loadAssoc();

			$input_coat = array(
				$mother['breedable_coat'],
				$father['breedable_coat']
			);
			$rand_coat = array_rand($input_coat);
		
			$input_eyes = array(
				$mother['breedable_eyes'],
				$father['breedable_eyes']
			);
			$rand_eyes = array_rand($input_eyes);

			$input_mane = array(
				$mother['breedable_mane'],
				$father['breedable_mane']
			);
			$rand_mane = array_rand($input_mane);

			$query4 = $db->getQuery(true);

			// Fields to update.
			$fields = array(
				$db->quoteName('status') . ' = ' . $db->quote($data['current_status']),
				$db->quoteName('breedable_coat') . ' = ' . $db->quote($input_coat[$rand_coat]),
				$db->quoteName('breedable_eyes') . ' = ' . $db->quote($input_eyes[$rand_eyes]),
				$db->quoteName('breedable_mane') . ' = ' . $db->quote($input_mane[$rand_mane])
			);

			// Conditions for which records should be updated.
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($configure['configure_id'])
			);

			$query4->update($db->quoteName('#__breedable'))->set($fields)->where($conditions);

			$db->setQuery($query4);

			$result = $db->query();

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
			$output .= $configure['generation']. "-";
			$output .= $configure['configure_id'];

			echo $output;
		}
*/
		if($data['mode'] == "sibling") {

			$query1 = $db->getQuery(true);

			// Select the required fields from the table.
			$query1->select('c.id')
				->select('c.breedable_type')
				->select('c.breedable_name')
				->select('c.breedable_key')
				->select('c.owner_name')
				->select('c.owner_key')
				->select('c.status')
				->select('c.version')
				->select('c.generation')
				->select('c.breedable_dob')
				->select('c.breedable_gender')
				->select('c.breedable_coat')
				->select('c.breedable_eyes')
				->select('c.breedable_food')
				->select('c.breedable_health')
				->select('c.breedable_fevor')
				->select('c.breedable_walk')
				->select('c.breedable_range')
				->select('c.breedable_terrain')
				->select('c.breedable_sound')
				->select('c.breedable_title')
				->select('c.breedable_pregnant')
				->select('c.breedable_mane')
				->select('c.breedable_mate')
				->select('c.bundle_key')
				->select('c.mother_name')
				->select('c.mother_id')
				->select('c.father_name')
				->select('c.father_id')
				->select('c.location')
				->from($db->quoteName('#__breedable') . ' AS c');

			// Join with the category
			$query1->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=c.breedable_type')
				->select('cat.title as category_title');

			$query1->where($db->quoteName('cat.title') . '=' . $db->quote($data['breedable_type']))
				->where($db->quoteName('c.owner_name') . '=' . $db->quote($data['owner_name']))
				->where($db->quoteName('c.owner_key') . '=' . $db->quote($data['owner_key']))
				->where($db->quoteName('c.status') . '=' . $db->quote($data['delivered_status']));
			$db->setQuery($query1);
			$sibling_configure = $db->loadAssoc();

			$query2 = $db->getQuery(true);

			// Fields to update.
			$fields = array(
				$db->quoteName('status') . ' = ' . $db->quote($data['sibling_status'])
			);

			// Conditions for which records should be updated.
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($sibling_configure['id'])
			);

			$query2->update($db->quoteName('#__breedable'))->set($fields)->where($conditions);

			$db->setQuery($query2);

			$result = $db->query();

			//echo print_r($sibling_configure, true);
			// output sibling configure database
			$output  = $sibling_configure['category_title'] . "-";
			$output .= $sibling_configure['breedable_coat'] . "-";
			$output .= $sibling_configure['breedable_eyes'] . "-";
			$output .= strtotime( $sibling_configure['breedable_dob'] ) . "-";
			$output .= $sibling_configure['breedable_gender'] . "-";
			$output .= $sibling_configure['breedable_food'] . "-";
			$output .= $sibling_configure['breedable_health'] . "-";
			$output .= $sibling_configure['breedable_fevor'] . "-";
			$output .= $sibling_configure['breedable_range'] . "-";
			$output .= $sibling_configure['breedable_sound'] . "-";
			$output .= $sibling_configure['breedable_walk'] . "-";
			$output .= $sibling_configure['breedable_title'] . "-";
			$output .= $sibling_configure['breedable_pregnant'] . "-";
			$output .= $sibling_configure['father_name'] . "-";
			$output .= $sibling_configure['mother_name'] . "-";
			$output .= $sibling_configure['breedable_mane'] . "-";
			$output .= $sibling_configure['breedable_mate'] . "-";
			$output .= $sibling_configure['breedable_terrain'] . "-";
			$output .= $sibling_configure['generation'] . "-";
			$output .= $sibling_configure['id'];
			echo $output;
		}
		if($data['mode'] == "father") {

			$query3 = $db->getQuery(true);

			// Select the required fields from the table.
			$query3->select('c.id as configure_id')
				->select('c.breedable_type as breedable_type')         // 0
				->select('c.breedable_name as breedable_name')         // 1
				->select('c.breedable_key as breedable_key')           // 2
				->select('c.owner_name as owner_name')                 // 3
				->select('c.owner_key as owner_key')                   // 4
				->select('c.status as status')                         // 5
				->select('c.version as version')                       // 6
				->select('c.generation as generation')                 // 7
				->select('c.breedable_dob as breedable_dob')           // 8
				->select('c.breedable_gender as breedable_gender')     // 9
				->select('c.breedable_coat as breedable_coat')         // 10
				->select('c.breedable_eyes as breedable_eyes')         // 11
				->select('c.breedable_food as breedable_food')         // 12
				->select('c.breedable_health as breedable_health')     // 13
				->select('c.breedable_fevor as breedable_fevor')       // 14
				->select('c.breedable_walk as breedable_walk')         // 15
				->select('c.breedable_range as breedable_range')       // 16
				->select('c.breedable_terrain as breedable_terrain')   // 17
				->select('c.breedable_sound as breedable_sound')       // 18
				->select('c.breedable_title as breedable_title')       // 19
				->select('c.breedable_pregnant as breedable_pregnant') // 20
				->select('c.breedable_mane as breedable_mane')         // 21
				->select('c.breedable_mate as breedable_mate')         // 22
				->select('c.bundle_key as bundle_key')                 // 23
				->select('c.mother_name as mother_name')               // 24
				->select('c.mother_id as mother_id')                   // 25
				->select('c.father_name as father_name')               // 26
				->select('c.father_id as father_id')                   // 27
				->select('c.location as location')                     // 28
				->from($db->quoteName('#__breedable') . ' AS c');

			// Join with the category
			$query3->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=c.breedable_type')
				->select('cat.title as category_title');

			$query3->where($db->quoteName('cat.title') . '=' . $db->quote($data['breedable_type']))
				->where($db->quoteName('c.owner_name') . '=' . $db->quote($data['owner_name']))
				->where($db->quoteName('c.owner_key') . '=' . $db->quote($data['owner_key']))
				->where($db->quoteName('c.status') . '=' . $db->quote($data['delivered_status']));
			$db->setQuery($query3);
			$father_configure = $db->loadAssoc();
			
			$query4 = $db->getQuery(true);

			// Select the required fields from the table.
			$query4->select('f.id')
				->select('f.breedable_type')
				->select('f.breedable_name')
				->select('f.breedable_key')
				->select('f.owner_name')
				->select('f.owner_key')
				->select('f.status')
				->select('f.version')
				->select('f.generation')
				->select('f.breedable_dob')
				->select('f.breedable_gender')
				->select('f.breedable_coat')
				->select('f.breedable_eyes')
				->select('f.breedable_food')
				->select('f.breedable_health')
				->select('f.breedable_fevor')
				->select('f.breedable_walk')
				->select('f.breedable_range')
				->select('f.breedable_terrain')
				->select('f.breedable_sound')
				->select('f.breedable_title')
				->select('f.breedable_pregnant')
				->select('f.breedable_mane')
				->select('f.breedable_mate')
				->select('f.bundle_key')
				->select('f.mother_name')
				->select('f.mother_id')
				->select('f.father_name')
				->select('f.father_id')
				->select('f.location')
				->from($db->quoteName('#__breedable') . ' AS f');

			// Join with the category
			$query4->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=f.breedable_type')
				->select('cat.title as category_title');

			$query4->where($db->quoteName('cat.title') . '=' . $db->quote($data['breedable_type']))
				->where($db->quoteName('f.breedable_name') . '=' . $db->quote($father_configure['father_name']))
				->where($db->quoteName('f.id') . '=' . $db->quote($father_configure['father_id']));
				//->where($db->quoteName('f.status') . '=' . $db->quote($data['delivered_status']));
			$db->setQuery($query4);
			$father = $db->loadAssoc();

			//echo print_r($father, true);
			// output father database
			$output  = $father['category_title'] . "-";
			$output .= $father['breedable_coat'] . "-";
			$output .= $father['breedable_eyes'] . "-";
			$output .= strtotime( $father['breedable_dob'] ) . "-";
			$output .= $father['breedable_gender'] . "-";
			$output .= $father['breedable_food'] . "-";
			$output .= $father['breedable_health'] . "-";
			$output .= $father['breedable_fevor'] . "-";
			$output .= $father['breedable_range'] . "-";
			$output .= $father['breedable_sound'] . "-";
			$output .= $father['breedable_walk'] . "-";
			$output .= $father['breedable_title'] . "-";
			$output .= $father['breedable_pregnant'] . "-";
			$output .= $father['father_name'] . "-";
			$output .= $father['mother_name'] . "-";
			$output .= $father['breedable_mane'] . "-";
			$output .= $father['breedable_mate'] . "-";
			$output .= $father['breedable_terrain'] . "-";
			$output .= $father['generation'] . "-";
			$output .= $father['id'];
			echo $output;
		}
		if($data['mode'] == "mother") {

			$query5 = $db->getQuery(true);

			// Select the required fields from the table.
			$query5->select('c.id as configure_id')
				->select('c.breedable_type as breedable_type')         // 0
				->select('c.breedable_name as breedable_name')         // 1
				->select('c.breedable_key as breedable_key')           // 2
				->select('c.owner_name as owner_name')                 // 3
				->select('c.owner_key as owner_key')                   // 4
				->select('c.status as status')                         // 5
				->select('c.version as version')                       // 6
				->select('c.generation as generation')                 // 7
				->select('c.breedable_dob as breedable_dob')           // 8
				->select('c.breedable_gender as breedable_gender')     // 9
				->select('c.breedable_coat as breedable_coat')         // 10
				->select('c.breedable_eyes as breedable_eyes')         // 11
				->select('c.breedable_food as breedable_food')         // 12
				->select('c.breedable_health as breedable_health')     // 13
				->select('c.breedable_fevor as breedable_fevor')       // 14
				->select('c.breedable_walk as breedable_walk')         // 15
				->select('c.breedable_range as breedable_range')       // 16
				->select('c.breedable_terrain as breedable_terrain')   // 17
				->select('c.breedable_sound as breedable_sound')       // 18
				->select('c.breedable_title as breedable_title')       // 19
				->select('c.breedable_pregnant as breedable_pregnant') // 20
				->select('c.breedable_mane as breedable_mane')         // 21
				->select('c.breedable_mate as breedable_mate')         // 22
				->select('c.bundle_key as bundle_key')                 // 23
				->select('c.mother_name as mother_name')               // 24
				->select('c.mother_id as mother_id')                   // 25
				->select('c.father_name as father_name')               // 26
				->select('c.father_id as father_id')                   // 27
				->select('c.location as location')                     // 28
				->from($db->quoteName('#__breedable') . ' AS c');

			// Join with the category
			$query5->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=c.breedable_type')
				->select('cat.title as category_title');

			$query5->where($db->quoteName('cat.title') . '=' . $db->quote($data['breedable_type']))
				->where($db->quoteName('c.owner_name') . '=' . $db->quote($data['owner_name']))
				->where($db->quoteName('c.owner_key') . '=' . $db->quote($data['owner_key']))
				->where($db->quoteName('c.status') . '=' . $db->quote($data['delivered_status']));
			$db->setQuery($query5);
			$parent_configure = $db->loadAssoc();
			
			$query6 = $db->getQuery(true);

			// Select the required fields from the table.
			$query6->select('m.id')
				->select('m.breedable_type')
				->select('m.breedable_name')
				->select('m.breedable_key')
				->select('m.owner_name')
				->select('m.owner_key')
				->select('m.status')
				->select('m.version')
				->select('m.generation')
				->select('m.breedable_dob')
				->select('m.breedable_gender')
				->select('m.breedable_coat')
				->select('m.breedable_eyes')
				->select('m.breedable_food')
				->select('m.breedable_health')
				->select('m.breedable_fevor')
				->select('m.breedable_walk')
				->select('m.breedable_range')
				->select('m.breedable_terrain')
				->select('m.breedable_sound')
				->select('m.breedable_title')
				->select('m.breedable_pregnant')
				->select('m.breedable_mane')
				->select('m.breedable_mate')
				->select('m.bundle_key')
				->select('m.mother_name')
				->select('m.mother_id')
				->select('m.father_name')
				->select('m.father_id')
				->select('m.location')
				->from($db->quoteName('#__breedable') . ' AS m');

			// Join with the category
			$query6->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=m.breedable_type')
				->select('cat.title as category_title');

			$query6->where($db->quoteName('cat.title') . '=' . $db->quote($data['breedable_type']))
				->where($db->quoteName('m.breedable_name') . '=' . $db->quote($parent_configure['mother_name']))
				->where($db->quoteName('m.id') . '=' . $db->quote($parent_configure['mother_id']));
				//->where($db->quoteName('m.status') . '=' . $db->quote($data['delivered_status']));
			$db->setQuery($query6);
			$mother = $db->loadAssoc();

			//echo print_r($mother, true);
			// output mother database
			$output  = $mother['category_title'] . "-";
			$output .= $mother['breedable_coat'] . "-";
			$output .= $mother['breedable_eyes'] . "-";
			$output .= strtotime( $mother['breedable_dob'] ) . "-";
			$output .= $mother['breedable_gender'] . "-";
			$output .= $mother['breedable_food'] . "-";
			$output .= $mother['breedable_health'] . "-";
			$output .= $mother['breedable_fevor'] . "-";
			$output .= $mother['breedable_range'] . "-";
			$output .= $mother['breedable_sound'] . "-";
			$output .= $mother['breedable_walk'] . "-";
			$output .= $mother['breedable_title'] . "-";
			$output .= $mother['breedable_pregnant'] . "-";
			$output .= $mother['father_name'] . "-";
			$output .= $mother['mother_name'] . "-";
			$output .= $mother['breedable_mane'] . "-";
			$output .= $mother['breedable_mate'] . "-";
			$output .= $mother['breedable_terrain'] . "-";
			$output .= $mother['generation'] . "-";
			$output .= $mother['id'];
			echo $output;
		}
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

	public function Update( $data = null ) {

		// Get a db connection.
		$db = JFactory::getDbo();

		if($data['mode'] == "location") {
			$query1 = $db->getQuery(true);

			// Fields to update.
			$fields = array(
				$db->quoteName('location') . ' = ' . $db->quote($data['location'])
			);

			// Conditions for which records should be updated.
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($data['id']),
				$db->quoteName('owner_name') . ' = ' . $db->quote($data['owner_name']),
				$db->quoteName('owner_key') . ' = ' . $db->quote($data['owner_key'])
			);

			$query1->update($db->quoteName('#__breedable'))->set($fields)->where($conditions);

			$db->setQuery($query1);

			$result = $db->query();
		}
		if($data['mode'] == "rename") {
			$query2 = $db->getQuery(true);

			// Fields to update.
			$fields = array(
				$db->quoteName('breedable_name') . ' = ' . $db->quote($data['breedable_name'])
			);

			// Conditions for which records should be updated.
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($data['id']),
				$db->quoteName('owner_name') . ' = ' . $db->quote($data['owner_name']),
				$db->quoteName('owner_key') . ' = ' . $db->quote($data['owner_key'])
			);

			$query2->update($db->quoteName('#__breedable'))->set($fields)->where($conditions);

			$db->setQuery($query2);

			$result = $db->query();
		}
		if($data['mode'] == "setup") {
			$query3 = $db->getQuery(true);

			// Fields to update.
			$fields = array(
				//$db->quoteName('breedable_dob') . ' = ' . $db->quote($data['breedable_dob']),
				//$db->quoteName('breedable_gender') . ' = ' . $db->quote($data['breedable_gender']),
				//$db->quoteName('breedable_coat') . ' = ' . $db->quote($data['breedable_coat']),
				//$db->quoteName('breedable_eyes') . ' = ' . $db->quote($data['breedable_eyes']),
				$db->quoteName('breedable_food') . ' = ' . $db->quote($data['breedable_food']),
				$db->quoteName('breedable_health') . ' = ' . $db->quote($data['breedable_health']),
				$db->quoteName('breedable_fevor') . ' = ' . $db->quote($data['breedable_fevor']),
				$db->quoteName('breedable_walk') . ' = ' . $db->quote($data['breedable_walk']),
				$db->quoteName('breedable_range') . ' = ' . $db->quote($data['breedable_range']),
				$db->quoteName('breedable_terrain') . ' = ' . $db->quote($data['breedable_terrain']),
				$db->quoteName('breedable_sound') . ' = ' . $db->quote($data['breedable_sound']),
				$db->quoteName('breedable_title') . ' = ' . $db->quote($data['breedable_title']),
				$db->quoteName('breedable_pregnant') . ' = ' . $db->quote($data['breedable_pregnant']),
				//$db->quoteName('breedable_mane') . ' = ' . $db->quote($data['breedable_mane']),
				$db->quoteName('breedable_mate') . ' = ' . $db->quote($data['breedable_mate']),
				$db->quoteName('breedable_name') . ' = ' . $db->quote($data['breedable_name']),
				//$db->quoteName('breedable_key') . ' = ' . $db->quote($data['breedable_key']),
				$db->quoteName('generation') . ' = ' . $db->quote($data['generation']),
				//$db->quoteName('owner_name') . ' = ' . $db->quote($data['owner_name']),
				//$db->quoteName('owner_key') . ' = ' . $db->quote($data['owner_key']),
				$db->quoteName('location') . ' = ' . $db->quote($data['location']),
				//$db->quoteName('mode') . ' = ' . $db->quote($data['mode']),
				$db->quoteName('status') . ' = ' . $db->quote($data['status']),
				$db->quoteName('version') . ' = ' . $db->quote($data['version']),
				//$db->quoteName('breedable_name') . ' = ' . $db->quote($data['breedable_name'])
			);

			// Conditions for which records should be updated.
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($data['id']),
				$db->quoteName('owner_name') . ' = ' . $db->quote($data['owner_name']),
				$db->quoteName('owner_key') . ' = ' . $db->quote($data['owner_key'])
			);

			$query3->update($db->quoteName('#__breedable'))->set($fields)->where($conditions);

			$db->setQuery($query3);

			$result = $db->query();
		}
		if($data['mode'] == "birth") {
			$query4 = $db->getQuery(true);

			// Fields to update.
			$fields = array(
				$db->quoteName('breedable_dob') . ' = ' . $db->quote($data['breedable_dob']),
				$db->quoteName('breedable_gender') . ' = ' . $db->quote($data['breedable_gender']),
				$db->quoteName('breedable_coat') . ' = ' . $db->quote($data['breedable_coat']),
				$db->quoteName('breedable_eyes') . ' = ' . $db->quote($data['breedable_eyes']),
				$db->quoteName('breedable_food') . ' = ' . $db->quote($data['breedable_food']),
				$db->quoteName('breedable_mane') . ' = ' . $db->quote($data['breedable_mane']),
				$db->quoteName('breedable_name') . ' = ' . $db->quote($data['breedable_name']),
				$db->quoteName('breedable_key') . ' = ' . $db->quote($data['breedable_key']),
				$db->quoteName('generation') . ' = ' . $db->quote($data['generation']),
				$db->quoteName('location') . ' = ' . $db->quote($data['location']),
				$db->quoteName('status') . ' = ' . $db->quote($data['status']),
				$db->quoteName('version') . ' = ' . $db->quote($data['version'])
			);

			// Conditions for which records should be updated.
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($data['id']),
				$db->quoteName('owner_name') . ' = ' . $db->quote($data['owner_name']),
				$db->quoteName('owner_key') . ' = ' . $db->quote($data['owner_key'])
			);

			$query4->update($db->quoteName('#__breedable'))->set($fields)->where($conditions);

			$db->setQuery($query4);

			$result = $db->query();
		}
		if($data['mode'] == "owner") {
			$query5 = $db->getQuery(true);

			// Fields to update. owner chage: updating owner name and key
			$fields = array(
				$db->quoteName('owner_name') . ' = ' . $db->quote($data['owner_name']),
				$db->quoteName('owner_key') . ' = ' . $db->quote($data['owner_key'])
			);

			// Conditions for which records should be updated. no owner condition here
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($data['id'])
			);

			$query5->update($db->quoteName('#__breedable'))->set($fields)->where($conditions);

			$db->setQuery($query5);

			$result = $db->query();
		}
	}

    /**
     * Method to birth the model state.
     *
     * Note. Calling birth in this method will result in recursion.
     *
     * @since	1.6
     */
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
    public function birth( $data = null ) {

		// Get a db connection.
		$db = JFactory::getDbo();

		$father_config = explode("-", $data['father_config']);
		$mother_config = explode("-", $data['mother_config']);

		//echo print_r($father_config);

		// check father exists
		$query1 = $db->getQuery(true);

		// Select the required fields from the table.
		$query1->select('father.id')
			->select('father.breedable_type')
			->select('father.breedable_coat')
			->select('father.breedable_eyes')
			->select('father.breedable_dob')
			->select('father.breedable_gender')
			->select('father.breedable_food')
			->select('father.breedable_health')
			->select('father.breedable_fevor')
			->select('father.breedable_range')
			->select('father.breedable_sound')
			->select('father.breedable_walk')
			->select('father.breedable_title')
			->select('father.breedable_pregnant')
			->select('father.father_name')
			->select('father.mother_name')
			->select('father.breedable_mane')
			->select('father.breedable_mate')
			->select('father.breedable_terrain')
			->select('father.generation')
			->from($db->quoteName('#__breedable') . ' AS father');

		// Join with the category
		$query1->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=father.breedable_type')
			->where($db->quoteName('cat.title') . '=' . $db->quote($father_config[0]))
			->where($db->quoteName('father.id') . '=' . $db->quote($data['father_id']))
			->where($db->quoteName('father.breedable_name') . '=' . $db->quote($data['father_name']))
			->where($db->quoteName('father.owner_name') . '=' . $db->quote($data['owner_name']))
			->where($db->quoteName('father.owner_key') . '=' . $db->quote($data['owner_key']));
		$db->setQuery($query1);
		$check_father = $db->loadAssoc();
		echo $query1;
		if(!empty($check_father)) {
			echo "no tables exists check_father";
		}
		//echo print_r($check_father, true);

		// check mother exists
		$query2 = $db->getQuery(true);

		// Select the required fields from the table.
		$query2->select('mother.id')       // 0
			->select('mother.breedable_type')       // 0
			->select('mother.breedable_coat')          // 1
			->select('mother.breedable_eyes')         // 2
			->select('mother.breedable_dob')           // 3
			->select('mother.breedable_gender')     // 4
			->select('mother.breedable_food')         // 5
			->select('mother.breedable_health')     // 6
			->select('mother.breedable_fevor')       // 7
			->select('mother.breedable_range')       // 8
			->select('mother.breedable_sound')       // 9
			->select('mother.breedable_walk')         // 10
			->select('mother.breedable_title')       // 11
			->select('mother.breedable_pregnant') // 12
			->select('mother.father_name')               // 13
			->select('mother.mother_name')               // 14
			->select('mother.breedable_mane')         // 15
			->select('mother.breedable_mate')         // 16
			->select('mother.breedable_terrain')   // 17
			->select('mother.generation')                 // 18
			->from($db->quoteName('#__breedable') . ' AS mother');

		// Join with the category
		$query2->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=mother.breedable_type')
			->where($db->quoteName('cat.title') . '=' . $db->quote($mother_config[0]))
			->where($db->quoteName('mother.id') . '=' . $db->quote($data['mother_id']))
			->where($db->quoteName('mother.breedable_name') . '=' . $db->quote($data['mother_name']))
			->where($db->quoteName('mother.owner_name') . '=' . $db->quote($data['owner_name']))
			->where($db->quoteName('mother.owner_key') . '=' . $db->quote($data['owner_key']));
		$db->setQuery($query2);
		$check_mother = $db->loadAssoc();
		
		if(!empty($check_mother)) {
			echo "no tables exists check_mother";
		}
/*
		if(empty($check_father)) {
			// Insert columns.
			$columns = array(
				'id',
				'breedable_name',
				'breedable_type',
				'breedable_coat',
				'breedable_eyes',
				'breedable_dob',
				'breedable_gender',
				'breedable_food',
				'breedable_health',
				'breedable_fevor',
				'breedable_range',
				'breedable_sound',
				'breedable_walk',
				'breedable_title',
				'breedable_pregnant',
				'breedable_mane',
				'breedable_mate',
				'breedable_terrain',
				'owner_name',
				'owner_key',
				'status'
			);

			// Insert values.
			$values = array(
				$db->quote($data['father_id']),
				$db->quote($data['father_name']),
				(int)$data['breedable_type'],
				$db->quote($father_config[1]),
				$db->quote($father_config[2]),
				$db->quote(date("Y-m-d H:i:s", $father_config[3])),
				$db->quote($father_config[4]),
				(int)$father_config[5],
				(int)$father_config[6],
				(int)$father_config[7],
				(int)$father_config[8],
				(int)$father_config[9],
				(int)$father_config[10],
				(int)$father_config[11],
				(int)$father_config[12],
				$db->quote($father_config[15]),
				(int)$father_config[16],
				(int)$father_config[17],
				$db->quote($data['owner_name']),
				$db->quote($data['owner_key']),
				$db->quote($data['current_status'])
			);

			// Prepare the insert query.
			$query3 = $db->getQuery(true)
				->insert($db->quoteName('#__breedable'))
				->columns($db->quoteName($columns))
				->values(implode(',', $values ));

			// Set the query using our newly populated query object and execute it.
			$db->setQuery($query3);
			$db->query();
		}
		if(empty($check_mother)) {
			// Insert columns.
			$columns = array(
				'id',
				'breedable_name',                    // 0
				'breedable_type',                    // 1
				'breedable_coat',                    // 2
				'breedable_eyes',                    // 3
				'breedable_dob',                     // 4
				'breedable_gender',                  // 5
				'breedable_food',                    // 6
				'breedable_health',                  // 7
				'breedable_fevor',                   // 8
				'breedable_range',                   // 9
				'breedable_sound',                   // 10
				'breedable_walk',                    // 11
				'breedable_title',                   // 12
				'breedable_pregnant',                // 13
				'breedable_mane',                    // 14
				'breedable_mate',                    // 15
				'breedable_terrain',                 // 16
				'owner_name',
				'owner_key',
				'status'
			);

			// Insert values.
			$values = array(
				$db->quote($data['mother_id']),                              // 0
				$db->quote($data['mother_name']),                            // 0
				(int)$data['breedable_type'],                            // 1
				$db->quote($mother_config[1]),                               // 2
				$db->quote($mother_config[2]),                               // 3
				$db->quote(date("Y-m-d H:i:s", $mother_config[3])),          // 4
				$db->quote($mother_config[4]),                               // 5
				(int)$mother_config[5],                                      // 6
				(int)$mother_config[6],                                      // 7
				(int)$mother_config[7],                                      // 8
				(int)$mother_config[8],                                      // 9
				(int)$mother_config[9],                                      // 10
				(int)$mother_config[10],                                     // 11
				(int)$mother_config[11],                                     // 12
				(int)$mother_config[12],                                     // 13
				$db->quote($mother_config[15]),                              // 14
				(int)$mother_config[16],                                     // 15
				(int)$mother_config[17],                                     // 16
				$db->quote($data['owner_name']),
				$db->quote($data['owner_key']),
				$db->quote($data['current_status'])
			);

			// Prepare the insert query.
			$query12 = $db->getQuery(true)
				->insert($db->quoteName('#__breedable'))
				->columns($db->quoteName($columns))
				->values(implode(',', $values ));

			// Set the query using our newly populated query object and execute it.
			$db->setQuery($query12);
			$db->query();
		}

		// check father exists
		$query4 = $db->getQuery(true);

		// Select the required fields from the table.
		$query4->select('father.id')       // 0
			->select('father.breedable_name')                 // 18
			->from($db->quoteName('#__breedable') . ' AS father');

		// Join with the category
		$query4->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=father.breedable_type')
			->where($db->quoteName('cat.title') . '=' . $db->quote($father_config[0]))
			->where($db->quoteName('father.breedable_name') . '=' . $db->quote($data['father_name']))
			->where($db->quoteName('father.owner_name') . '=' . $db->quote($data['owner_name']))
			->where($db->quoteName('father.owner_key') . '=' . $db->quote($data['owner_key']));
		$db->setQuery($query4);
		$update_father = $db->loadAssoc();

		// check mother exists
		$query5 = $db->getQuery(true);

		// Select the required fields from the table.
		$query5->select('mother.id')
			->select('mother.breedable_name')
			->from($db->quoteName('#__breedable') . ' AS mother');

		// Join with the category
		$query5->join('LEFT', $db->quoteName('#__categories') . ' as cat ON cat.id=mother.breedable_type')
			->where($db->quoteName('cat.title') . '=' . $db->quote($mother_config[0]))
			->where($db->quoteName('mother.breedable_name') . '=' . $db->quote($data['mother_name']))
			->where($db->quoteName('mother.owner_name') . '=' . $db->quote($data['owner_name']))
			->where($db->quoteName('mother.owner_key') . '=' . $db->quote($data['owner_key']));
		$db->setQuery($query5);
		$update_mother = $db->loadAssoc();

		if(!empty($update_father)) {
			$query6 = $db->getQuery(true);

			// Fields to update.
			$fields = array(
				$db->quoteName('mother_name') . ' = ' . $db->quote($update_grandmother['breedable_name']),
				$db->quoteName('mother_id') . ' = ' . $db->quote($update_grandmother['id']),
				$db->quoteName('father_name') . ' = ' . $db->quote($update_grandfather['breedable_name']),
				$db->quoteName('father_id') . ' = ' . $db->quote($update_grandfather['id'])
			);

			// Conditions for which records should be updated.
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($update_father['id'])
			);

			$query6->update($db->quoteName('#__breedable'))->set($fields)->where($conditions);

			$db->setQuery($query6);

			$result = $db->query();
		}
		if(!empty($update_mother)) {
			$query7 = $db->getQuery(true);

			// Fields to update.
			$fields = array(
				$db->quoteName('mother_name') . ' = ' . $db->quote($update_grandmother['breedable_name']),
				$db->quoteName('mother_id') . ' = ' . $db->quote($update_grandmother['id']),
				$db->quoteName('father_name') . ' = ' . $db->quote($update_grandfather['breedable_name']),
				$db->quoteName('father_id') . ' = ' . $db->quote($update_grandfather['id'])
			);

			// Conditions for which records should be updated.
			$conditions = array(
				$db->quoteName('id') . ' = ' . $db->quote($update_mother['id'])
			);

			$query7->update($db->quoteName('#__breedable'))->set($fields)->where($conditions);

			$db->setQuery($query7);

			$result = $db->query();
		}

		// Insert columns.
		$columns = array(
			'breedable_name',
			'father_name',
			'father_id',
			'mother_name',
			'mother_id',
			'owner_name',
			'owner_key',
			'status'
		);
		// Insert values.
		$values = array(
			$db->quote($data['breedable_name']),
			$db->quote($update_father['breedable_name']),
			(int)$update_father['id'],
			$db->quote($update_mother['breedable_name']),
			(int)$update_mother['id'],
			$db->quote($data['owner_name']),
			$db->quote($data['owner_key']),
			$db->quote($data['status'])
		);

		// Prepare the insert query.
		$query8 = $db->getQuery(true)
			->insert($db->quoteName('#__breedable'))
			->columns($db->quoteName($columns))
			->values(implode(',', $values ));

		// Set the query using our newly populated query object and execute it.
		$db->setQuery($query8);
		$db->query();
*/
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
			->where($db->quoteName('a.owner_key') . '=' . $db->quote($data['owner_key']))
			->where($db->quoteName('a.status') . '=' . $db->quote($data['previous_status']));
		
		$db->setQuery($query1);
		$delivery = $db->loadAssoc();

		echo $delivery['delivery_id'] . "^" . $delivery['owner_key'];
		//echo print_r($delivery, true);

		$query2 = $db->getQuery(true);

		// Fields to update.
		$fields = array(
			$db->quoteName('status') . ' = ' . $db->quote($data['current_status'])
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
