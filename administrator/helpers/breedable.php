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

/**
 * Breedable helper.
 */
class BreedableHelper
{
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
			JText::_('COM_BREEDABLE_TITLE_QUEUES'),
			'index.php?option=com_breedable&view=queues',
			$vName == 'queues'
		);
		JHtmlSidebar::addEntry(
			'Breedable (Types)',
			"index.php?option=com_categories&extension=com_breedable",
			$vName == 'categories'
		);
		if ($vName=='categories') {
			JToolBarHelper::title('Breedable For Second Life: Breedable (Types)');
		}
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
