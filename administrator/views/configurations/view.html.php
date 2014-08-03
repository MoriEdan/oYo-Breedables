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

jimport('joomla.application.component.view');

/**
 * View class for a list of Breedable.
 */
class BreedableViewConfigurations extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		BreedableHelper::addSubmenu('configurations');
        
		$this->addToolbar();
        
        $this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/breedable.php';

		$state	= $this->get('State');
		$canDo	= BreedableHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_BREEDABLE_TITLE_CONFIGURATIONS'), 'configurations.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/configuration';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('configuration.add','JTOOLBAR_NEW');
		    }

		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    JToolBarHelper::editList('configuration.edit','JTOOLBAR_EDIT');
		    }

        }

		if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('configurations.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('configurations.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'configurations.delete','JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::archiveList('configurations.archive','JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
            	JToolBarHelper::custom('configurations.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    JToolBarHelper::deleteList('', 'configurations.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    JToolBarHelper::trash('configurations.trash','JTOOLBAR_TRASH');
			    JToolBarHelper::divider();
		    }
        }

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_breedable');
		}
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_breedable&view=configurations');
        
        $this->extra_sidebar = '';

		//Filter for the field breedable_gender
		$select_label = JText::sprintf('COM_BREEDABLE_FILTER_SELECT_LABEL', 'Gender');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "F";
		$options[0]->text = "Female";
		$options[1] = new stdClass();
		$options[1]->value = "M";
		$options[1]->text = "Male";
		$options[2] = new stdClass();
		$options[2]->value = "other";
		$options[2]->text = "Other";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_breedable_gender',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.breedable_gender'), true)
		);

	}
    
	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.breedable_type' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_TYPE'),
		'a.breedable_name' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_NAME'),
		'a.breedable_key' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_KEY'),
		'a.owner_name' => JText::_('COM_BREEDABLE_CONFIGURATIONS_OWNER_NAME'),
		'a.status' => JText::_('COM_BREEDABLE_CONFIGURATIONS_STATUS'),
		//'a.version' => JText::_('COM_BREEDABLE_CONFIGURATIONS_VERSION'),
		//'a.generation' => JText::_('COM_BREEDABLE_CONFIGURATIONS_GENERATION'),
		//'a.breedable_dob' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_DOB'),
		'a.breedable_gender' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_GENDER'),
		//'a.breedable_coat' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_COAT'),
		//'a.breedable_eyes' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_EYES'),
		//'a.breedable_food' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_FOOD'),
		//'a.breedable_health' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_HEALTH'),
		//'a.breedable_fevor' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_FEVOR'),
		//'a.breedable_title' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_TITLE'),
		//'a.breedable_pregnant' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_PREGNANT'),
		//'a.breedable_mane' => JText::_('COM_BREEDABLE_CONFIGURATIONS_BREEDABLE_MANE'),
		'a.location' => JText::_('COM_BREEDABLE_CONFIGURATIONS_LOCATION'),
		//'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		//'a.checked_out' => JText::_('COM_BREEDABLE_CONFIGURATIONS_CHECKED_OUT'),
		//'a.checked_out_time' => JText::_('COM_BREEDABLE_CONFIGURATIONS_CHECKED_OUT_TIME'),
		//'a.created_by' => JText::_('COM_BREEDABLE_CONFIGURATIONS_CREATED_BY'),

		);
	}

    
}
