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

jimport('joomla.application.component.view');

/**
 * View class for a list of Breedable.
 */
class BreedableViewBirthss extends JViewLegacy
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
        
		BreedableBackendHelper::addSubmenu('birthss');
        
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
		$canDo	= BreedableBackendHelper::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_BREEDABLE_TITLE_BIRTHSS'), 'birthss.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/births';
        if (file_exists($formPath)) {

            if ($canDo->get('core.create')) {
			    JToolBarHelper::addNew('births.add','JTOOLBAR_NEW');
		    }

		    if ($canDo->get('core.edit') && isset($this->items[0])) {
			    JToolBarHelper::editList('births.edit','JTOOLBAR_EDIT');
		    }

        }

		if ($canDo->get('core.edit.state')) {

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::custom('birthss.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			    JToolBarHelper::custom('birthss.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
            } else if (isset($this->items[0])) {
                //If this component does not use state then show a direct delete button as we can not trash
                JToolBarHelper::deleteList('', 'birthss.delete','JTOOLBAR_DELETE');
            }

            if (isset($this->items[0]->state)) {
			    JToolBarHelper::divider();
			    JToolBarHelper::archiveList('birthss.archive','JTOOLBAR_ARCHIVE');
            }
            if (isset($this->items[0]->checked_out)) {
            	JToolBarHelper::custom('birthss.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
            }
		}
        
        //Show trash and delete for components that uses the state field
        if (isset($this->items[0]->state)) {
		    if ($state->get('filter.state') == -2 && $canDo->get('core.delete')) {
			    JToolBarHelper::deleteList('', 'birthss.delete','JTOOLBAR_EMPTY_TRASH');
			    JToolBarHelper::divider();
		    } else if ($canDo->get('core.edit.state')) {
			    JToolBarHelper::trash('birthss.trash','JTOOLBAR_TRASH');
			    JToolBarHelper::divider();
		    }
        }

		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_breedable');
		}
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_breedable&view=birthss');
        
        $this->extra_sidebar = '';
        
		//Filter for the field gender
		$select_label = JText::sprintf('COM_BREEDABLE_FILTER_SELECT_LABEL', 'Gender');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "female";
		$options[0]->text = "Female";
		$options[1] = new stdClass();
		$options[1]->value = "male";
		$options[1]->text = "Male";
		$options[2] = new stdClass();
		$options[2]->value = "other";
		$options[2]->text = "Other";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_gender',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.gender'), true)
		);

		//Filter for the field sound
		$select_label = JText::sprintf('COM_BREEDABLE_FILTER_SELECT_LABEL', 'Sound');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "1";
		$options[0]->text = "On";
		$options[1] = new stdClass();
		$options[1]->value = "0";
		$options[1]->text = "Off";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_sound',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.sound'), true)
		);

		//Filter for the field title
		$select_label = JText::sprintf('COM_BREEDABLE_FILTER_SELECT_LABEL', 'Title');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "0";
		$options[0]->text = "Off";
		$options[1] = new stdClass();
		$options[1]->value = "1";
		$options[1]->text = "On";
		$options[2] = new stdClass();
		$options[2]->value = "2";
		$options[2]->text = "Compact";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_title',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.title'), true)
		);

		//Filter for the field terrain
		$select_label = JText::sprintf('COM_BREEDABLE_FILTER_SELECT_LABEL', 'Terrain');
		$options = array();
		$options[0] = new stdClass();
		$options[0]->value = "0";
		$options[0]->text = "No";
		$options[1] = new stdClass();
		$options[1]->value = "1";
		$options[1]->text = "Yes";
		JHtmlSidebar::addFilter(
			$select_label,
			'filter_terrain',
			JHtml::_('select.options', $options , "value", "text", $this->state->get('filter.terrain'), true)
		);

        
	}
    
	protected function getSortFields()
	{
		return array(
		'a.id' => JText::_('JGRID_HEADING_ID'),
		'a.breed' => JText::_('COM_BREEDABLE_BIRTHSS_BREED'),
		'a.coat' => JText::_('COM_BREEDABLE_BIRTHSS_COAT'),
		'a.eyes' => JText::_('COM_BREEDABLE_BIRTHSS_EYES'),
		'a.bundle' => JText::_('COM_BREEDABLE_BIRTHSS_BUNDLE'),
		'a.gender' => JText::_('COM_BREEDABLE_BIRTHSS_GENDER'),
		'a.food' => JText::_('COM_BREEDABLE_BIRTHSS_FOOD'),
		'a.health' => JText::_('COM_BREEDABLE_BIRTHSS_HEALTH'),
		'a.fevor' => JText::_('COM_BREEDABLE_BIRTHSS_FEVOR'),
		'a.range' => JText::_('COM_BREEDABLE_BIRTHSS_RANGE'),
		'a.sound' => JText::_('COM_BREEDABLE_BIRTHSS_SOUND'),
		'a.walk' => JText::_('COM_BREEDABLE_BIRTHSS_WALK'),
		'a.title' => JText::_('COM_BREEDABLE_BIRTHSS_TITLE'),
		'a.pregnant' => JText::_('COM_BREEDABLE_BIRTHSS_PREGNANT'),
		'a.father_id' => JText::_('COM_BREEDABLE_BIRTHSS_FATHER_ID'),
		'a.father_name' => JText::_('COM_BREEDABLE_BIRTHSS_FATHER_NAME'),
		'a.mother_id' => JText::_('COM_BREEDABLE_BIRTHSS_MOTHER_ID'),
		'a.mother_name' => JText::_('COM_BREEDABLE_BIRTHSS_MOTHER_NAME'),
		'a.mane' => JText::_('COM_BREEDABLE_BIRTHSS_MANE'),
		'a.mate' => JText::_('COM_BREEDABLE_BIRTHSS_MATE'),
		'a.terrain' => JText::_('COM_BREEDABLE_BIRTHSS_TERRAIN'),
		'a.dob' => JText::_('COM_BREEDABLE_BIRTHSS_DOB'),
		'a.created_by' => JText::_('COM_BREEDABLE_BIRTHSS_CREATED_BY'),
		);
	}

    
}
