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

    /**
     * Method to check out an item for editing and redirect to the edit form.
     *
     * @since	1.6
	 * @link http://hellzfire.cu.cc/index.php?option=com_breedable&view=configuration&task=configuration.birth
     */
    public function birth() {

		// Set the data
		$data = array(
		// 'breedable_type' => "bar",
			'breedable_type' => $this->input->getString('breedable_type'),
			'breedable_name' => $this->input->getString('breedable_name'),
			'breedable_id' => $this->input->getString('breedable_id'),
			'owner_name' => $this->input->getString('owner_name'),
			'owner_key' => $this->input->getString('owner_key'),
			'status' => $this->input->getString('status'),
			'version' => $this->input->getFloat('version'),
			'generation' => $this->input->getInt('generation'),
			'breedable_dob' => $this->input->getString('breedable_dob'),
			'breedable_gender' => $this->input->getString('breedable_gender'),
			'breedable_coat' => $this->input->getString('breedable_coat'),
			'breedable_eyes' => $this->input->getString('breedable_eyes'),
			'breedable_food' => $this->input->getInt('breedable_food'),
			'breedable_health' => $this->input->getInt('breedable_health'),
			'breedable_fevor' => $this->input->getInt('breedable_fevor'),
			'breedable_walk' => $this->input->getString('breedable_walk'),
			'breedable_range' => $this->input->getInt('breedable_range'),
			'breedable_terrain' => $this->input->getString('breedable_terrain'),
			'breedable_sound' => $this->input->getString('breedable_sound'),
			'breedable_title' => $this->input->getString('breedable_title'),
			'breedable_pregnant' => $this->input->getInt('breedable_pregnant'),
			'breedable_mane' => $this->input->getString('breedable_mane'),
			'breedable_mate' => $this->input->getString('breedable_mate'),
			'bundle_key' => $this->input->getString('bundle_key'),
			'mother_name' => $this->input->getString('mother_name'),
			'mother_id' => $this->input->getInt('mother_id'),
			'father_name' => $this->input->getString('father_name'),
			'father_id' => $this->input->getInt('father_id'),
			'location' => $this->input->getString('location'),
		);

        // Get the model.
        $model = $this->getModel('Configuration', 'BreedableModel');

		//echo $this->input->getString('test');
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
