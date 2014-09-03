<?php

/**
 * @version     1.0.0
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
class BreedableViewQueues extends JViewLegacy {

    protected $items;
    protected $pagination;
    protected $state;

    /**
     * Display the view
     */
    public function display($tpl = null) {
        $this->state = $this->get('State');
        $this->items = $this->get('Items');
        $this->pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            throw new Exception(implode("\n", $errors));
        }

        BreedableHelper::addSubmenu('queues');

        $this->addToolbar();

        $this->sidebar = JHtmlSidebar::render();
        parent::display($tpl);
    }

    /**
     * Add the page title and toolbar.
     *
     * @since	1.6
     */
    protected function addToolbar() {
        require_once JPATH_COMPONENT . '/helpers/breedable.php';

        $state = $this->get('State');
        $canDo = BreedableHelper::getActions($state->get('filter.category_id'));

        JToolBarHelper::title(JText::_('COM_BREEDABLE_TITLE_QUEUES'), 'queues.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/queued';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
                JToolBarHelper::addNew('queued.add', 'JTOOLBAR_NEW');
            }

            if ($canDo->get('core.edit') && isset($this->items[0])) {
                JToolBarHelper::editList('queued.edit', 'JTOOLBAR_EDIT');
            }
        }

        if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::custom('queues.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
                JToolBarHelper::custom('queues.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'queues.delete', 'JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
                JToolBarHelper::divider();
                JToolBarHelper::archiveList('queues.archive', 'JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
                JToolBarHelper::custom('queues.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
        }

        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
            if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
                JToolBarHelper::deleteList('', 'queues.delete', 'JTOOLBAR_EMPTY_TRASH');
                JToolBarHelper::divider();
            } else if ($canDo->get('core.edit.state')) {
                JToolBarHelper::trash('queues.trash', 'JTOOLBAR_TRASH');
                JToolBarHelper::divider();
            }
        }

        if ($canDo->get('core.admin')) {
            JToolBarHelper::preferences('com_breedable');
        }

        //Set sidebar action - New in 3.0
        JHtmlSidebar::setAction('index.php?option=com_breedable&view=queues');

        $this->extra_sidebar = '';
        
		//Filter for the field status
		$select_label = JText::sprintf('COM_BREEDABLE_FILTER_SELECT_LABEL', 'Status');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "Created";
		$options[0]->text = "Created";
		$options[1] = new stdClass();
		$options[1]->value = "Delivered";
		$options[1]->text = "Delivered";
		$options[2] = new stdClass();
		$options[2]->value = "Born";
		$options[2]->text = "Born";
		$options[3] = new stdClass();
		$options[3]->value = "Configured";
		$options[3]->text = "Configured";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_status',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.status'), true)
		);

		JHtmlSidebar::addFilter(

			JText::_('JOPTION_SELECT_PUBLISHED'),

			'filter_published',

			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)

		);

    }

	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.breedable_id' => JText::_('COM_BREEDABLE_QUEUES_BREEDABLE_ID'),
		'a.mother_name' => JText::_('COM_BREEDABLE_QUEUES_MOTHER_NAME'),
		'a.mother_id' => JText::_('COM_BREEDABLE_QUEUES_MOTHER_ID'),
		'a.father_name' => JText::_('COM_BREEDABLE_QUEUES_FATHER_NAME'),
		'a.father_id' => JText::_('COM_BREEDABLE_QUEUES_FATHER_ID'),
		'a.status' => JText::_('COM_BREEDABLE_QUEUES_STATUS'),
		'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
		'a.state' => JText::_('JSTATUS'),
		);
	}

}
