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

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Profiles list controller class.
 */
class BreedableControllerProfiles extends BreedableController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Profiles', $prefix = 'BreedableModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}