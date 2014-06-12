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

jimport('joomla.application.component.controllerform');

/**
 * Configuration controller class.
 */
class BreedableControllerConfiguration extends JControllerForm
{

    function __construct() {
        $this->view_list = 'configurations';
        parent::__construct();
    }

}