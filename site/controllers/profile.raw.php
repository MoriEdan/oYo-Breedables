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
 * Profile controller class.
 */
class BreedableControllerProfile extends BreedableController {

	public function account() {
		// Set the data
		$data = array(
			'username'     => $this->input->getString('username'),
			'name'     => $this->input->getString('name'),
			'email1'      => $this->input->getString('email1'),
			'password1' => $this->input->getString('password1'),
			'password2' => $this->input->getString('password2'),
			'block'      => $this->input->getInt('block'),
			'requireReset'      => $this->input->getInt('requireReset'),
			'avatar_name' => $this->input->getString('avatar_name'),
			'avatar_key' => $this->input->getString('avatar_key'),
		);

        // Get the model.
        $model = $this->getModel('Registration', 'BreedableModel');

		// Check out the item
        if ($data) {
            $model->register($data);
        }
		else
		{
			$this->setMessage(JText::sprintf('Save failed', $model->getError()), 'warning');
		}
	}
	
	public function password() {
		// Set the data
		$data = array(
			'username'     => $this->input->getString('username'),
			'email'      => $this->input->getString('email'),
			'password' => $this->input->getString('password'),
			'block'      => $this->input->getInt('block'),
			'requireReset'      => $this->input->getInt('requireReset')
		);

        // Get the model.
        $model = $this->getModel('Registration', 'BreedableModel');

		// Check out the item
        if ($data) {
            $model->password($data);
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
     */
    public function edit() {
        $app = JFactory::getApplication();

        // Get the previous edit id (if any) and the current edit id.
        $previousId = (int) $app->getUserState('com_breedable.edit.profile.id');
        $editId = JFactory::getApplication()->input->getInt('id', null, 'array');

        // Set the user id for the user to edit in the session.
        $app->setUserState('com_breedable.edit.profile.id', $editId);

        // Get the model.
        $model = $this->getModel('Profile', 'BreedableModel');

        // Check out the item
        if ($editId) {
            $model->checkout($editId);
        }

        // Check in the previous user.
        if ($previousId && $previousId !== $editId) {
            $model->checkin($previousId);
        }

        // Redirect to the edit screen.
        $this->setRedirect(JRoute::_('index.php?option=com_breedable&view=profileform&layout=edit', false));
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
        $model = $this->getModel('Profile', 'BreedableModel');

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
        $app->setUserState('com_breedable.edit.profile.id', null);

        // Flush the data from the session.
        $app->setUserState('com_breedable.edit.profile.data', null);

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
        $model = $this->getModel('Profile', 'BreedableModel');

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
            $app->setUserState('com_breedable.edit.profile.id', null);

            // Flush the data from the session.
            $app->setUserState('com_breedable.edit.profile.data', null);
            
            $this->setMessage(JText::_('COM_BREEDABLE_ITEM_DELETED_SUCCESSFULLY'));
        }

        // Redirect to the list screen.
        $menu = & JSite::getMenu();
        $item = $menu->getActive();
        $this->setRedirect(JRoute::_($item->link, false));
    }
}
