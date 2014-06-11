<?php

/**
 * @version     1.0.2
 * @package     com_breedable
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Stephen Bishop <support@dazzlesoftware.org> - http://dazzlesoftware.org
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Breedable helper.
 */
class BreedableBackendHelper {

    /**
     * Configure the Linkbar.
     */
    public static function addSubmenu($vName = '') {
        		JHtmlSidebar::addEntry(
			JText::_('COM_BREEDABLE_TITLE_CONFIGURATIONS'),
			'index.php?option=com_breedable&view=configurations',
			$vName == 'configurations'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_BREEDABLE_TITLE_BUNDLES'),
			'index.php?option=com_breedable&view=bundles',
			$vName == 'bundles'
		);
		JHtmlSidebar::addEntry(
			JText::_('COM_BREEDABLE_TITLE_BIRTHSS'),
			'index.php?option=com_breedable&view=birthss',
			$vName == 'birthss'
		);

    }

    /**
     * Gets a list of the actions that can be performed.
     *
     * @return	JObject
     * @since	1.6
     */
    public static function getActions() {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_breedable';

        $actions = array(
            'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
        );

        foreach ($actions as $action) {
            $result->set($action, $user->authorise($action, $assetName));
        }

        return $result;
    }


}
