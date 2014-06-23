<?php

/**
 * @version     1.0.12
 * @package     com_breedable
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Stephen Bishop <dazzle.software@gmail.com> - http://dazzlesoftware.org
 */
// No direct access
defined('_JEXEC') or die;

require_once JPATH_COMPONENT . '/controller.php';

/**
 * Configuration controller class.
 */
class BreedableControllerConfiguration extends BreedableController
{
	public function configure() {
		// Set the data
		$data = array(
			'breedable_type' => $this->input->getString('breedable_type'),
			'owner_name' => $this->input->getString('owner_name'),
			'owner_key' => $this->input->getString('owner_key'),
			'previous_status' => $this->input->getString('previous_status'),
			'current_status' => $this->input->getString('current_status')
		);


        // Get the model.
        $model = $this->getModel('Configuration', 'BreedableModel');

        // Check out the item
        if ($data) {
            $model->configure($data);
        }
		else
		{
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
		}
	}

	public function delivery() {
		// Set the data
		$data = array(
			'breedable_type' => $this->input->getString('breedable_type'),
			'owner_name' => $this->input->getString('owner_name'),
			'owner_key' => $this->input->getString('owner_key'),
			'previous_status' => $this->input->getString('previous_status'),
			'current_status' => $this->input->getString('current_status')
		);


        // Get the model.
        $model = $this->getModel('Configuration', 'BreedableModel');

        // Check out the item
        if ($data) {
            $model->delivery($data);
        }
		else
		{
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
		}
	}

	public function information() {

		// Set the data
		$data = array(
			'id' => $this->input->getString('id')
		);

        // Get the model.
        $model = $this->getModel('Configuration', 'BreedableModel');

        // Check out the item
        if ($data) {
            $model->information($data);
        }
		else
		{
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
		}
	}
    /**
     * Method to check out an item for editing and redirect to the edit form.
     *
     * @since	1.6
	 * @link http://hellzfire.cu.cc/index.php?option=com_breedable&view=configuration&task=configuration.register
     */
    public function register() {

		// Set the data
		$data = array(
			'owner_name' => $this->input->getString('owner_name'),
			'owner_key' => $this->input->getString('owner_key'),
			'breedable_type' => $this->input->getString('breedable_type'),
			'breedable_name' => $this->input->getString('breedable_name'),
			'breedable_config' => $this->input->getString('breedable_config'),
			'location' => $this->input->getString('location'),
			'generation' => $this->input->getInt('generation'),
			'status' => $this->input->getString('status')
		);

        // Get the model.
        $model = $this->getModel('Configuration', 'BreedableModel');

        // Check out the item
        if ($data) {
            $model->register($data);
        }
		else
		{
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
		}

        // Check for previous insert.
        //if ($previousId && $previousId !== $editId) {
        //    $model->checkin($previousId);
        //}
	}

    /**
     * Method to check out an item for editing and redirect to the edit form.
     *
     * @since	1.6
	 * @link http://hellzfire.cu.cc/index.php?option=com_breedable&view=configuration&task=configuration.birth
     */
/*
http://hellzfire.cu.cc/index.php?option=com_breedable&view=configuration&task=configuration.birth&breedable_type=oYo%20Horses&breedable_coat=Blackwalker&breedable_eyes=Inferno&breedable_dob=1402383946&breedable_gender=Female&breedable_food=100&breedable_health=100&breedable_fevor=0&breedable_range=10&breedable_sound=0&breedable_walk=0&breedable_title=1&breedable_pregnant=0&father_name=Starter%20Dad&mother_name=Starter%20Mom&breedable_mane=B1&breedable_mate=0&breedable_terrain=0&format=raw
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
*/

    public function birth() {

		// Set the data
		$data = array(
			'owner_name'     => $this->input->getString('owner_name'),
			'owner_key'      => $this->input->getString('owner_key'),
			'breedable_type' => $this->input->getString('breedable_type'),
			'father_name'    => $this->input->getString('father_name'),
			'father_id'      => $this->input->getInt('father_id'),
			'father_config'    => $this->input->getString('father_config'),
			'mother_name'    => $this->input->getString('mother_name'),
			'mother_id'      => $this->input->getInt('mother_id'),
			'mother_config'    => $this->input->getString('mother_config'),
			'generation'     => $this->input->getInt('generation'),
			'status'     => $this->input->getString('status')
		);

        // Get the model.
        $model = $this->getModel('Configuration', 'BreedableModel');

		// Check out the item
        if ($data) {
            $model->birth($data);
        }
		else
		{
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
		}

        // Check for previous insert.
        //if ($previousId && $previousId !== $editId) {
        //    $model->checkin($previousId);
        //}
	}

    /**
     * Method to check out an item for editing and redirect to the edit form.
     *
     * @since	1.6
     */
    public function edit() {
        $app = JFactory::getApplication();

        // Get the previous edit id (if any) and the current edit id.
        $previousId = (int) $app->getUserState('com_breedable.edit.configuration.id');
        $editId = JFactory::getApplication()->input->getInt('id', null, 'array');

        // Set the user id for the user to edit in the session.
        $app->setUserState('com_breedable.edit.configuration.id', $editId);

        // Get the model.
        $model = $this->getModel('Configuration', 'BreedableModel');

        // Check out the item
        if ($editId) {
            $model->checkout($editId);
        }

        // Check in the previous user.
        if ($previousId && $previousId !== $editId) {
            $model->checkin($previousId);
        }

        // Redirect to the edit screen.
        $this->setRedirect(JRoute::_('index.php?option=com_breedable&view=configurationform&layout=edit', false));
    }

    /**
     * Method to save a user's profile data.
     *
     * @return	void
     * @since	1.6
     */
    public function publish() {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('Configuration', 'BreedableModel');

        // Get the user data.
        $data = JFactory::getApplication()->input->get('jform', array(), 'array');

        // Attempt to save the data.
        $return = $model->publish($data['id'], $data['state']);

        // Check for errors.
        if ($return === false) {
            $this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
        } else {
            // Check in the profile.
            if ($return) {
                $model->checkin($return);
            }

            // Clear the profile id from the session.
            $app->setUserState('com_entrusters.edit.bid.id', null);

            // Redirect to the list screen.
            $this->setMessage(JText::_('COM_ENTRUSTERS_ITEM_SAVED_SUCCESSFULLY'));
        }

        // Clear the profile id from the session.
        $app->setUserState('com_breedable.edit.configuration.id', null);

        // Flush the data from the session.
        $app->setUserState('com_breedable.edit.configuration.data', null);

        // Redirect to the list screen.
        $this->setMessage(JText::_('COM_BREEDABLE_ITEM_SAVED_SUCCESSFULLY'));
        $menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));
    }

    public function remove() {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Initialise variables.
        $app = JFactory::getApplication();
        $model = $this->getModel('Configuration', 'BreedableModel');

        // Get the user data.
        $data = JFactory::getApplication()->input->get('jform', array(), 'array');

        // Attempt to save the data.
        $return = $model->delete($data['id']);

        // Check for errors.
        if ($return === false) {
            $this->setMessage(JText::sprintf('Delete failed', $model->getError()), 'warning');   
        } else {
            // Check in the profile.
            if ($return) {
                $model->checkin($return);
            }

            // Clear the profile id from the session.
            $app->setUserState('com_breedable.edit.configuration.id', null);

            // Flush the data from the session.
            $app->setUserState('com_breedable.edit.configuration.data', null);
            
            $this->setMessage(JText::_('COM_BREEDABLE_ITEM_DELETED_SUCCESSFULLY'));
        }

        // Redirect to the list screen.
        $menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));
    }

}
