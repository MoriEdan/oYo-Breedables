<?php
/**
 * @version     1.0.2
 * @package     com_breedable
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Stephen Bishop <support@dazzlesoftware.org> - http://dazzlesoftware.org
 */
// no direct access
defined('_JEXEC') or die;

//Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_breedable', JPATH_ADMINISTRATOR);

?>
<?php if ($this->item) : ?>

    <div class="item_fields">

        <ul class="fields_list">

            			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_ID'); ?>:
			<?php echo $this->item->id; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_BREED'); ?>:
			<?php echo $this->item->breed; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_COAT'); ?>:
			<?php echo $this->item->coat; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_EYES'); ?>:
			<?php echo $this->item->eyes; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_BUNDLE'); ?>:
			<?php echo $this->item->bundle; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_GENDER'); ?>:
			<?php echo $this->item->gender; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_FOOD'); ?>:
			<?php echo $this->item->food; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_HEALTH'); ?>:
			<?php echo $this->item->health; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_FEVOR'); ?>:
			<?php echo $this->item->fevor; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_RANGE'); ?>:
			<?php echo $this->item->range; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_SOUND'); ?>:
			<?php echo $this->item->sound; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_WALK'); ?>:
			<?php echo $this->item->walk; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_TITLE'); ?>:
			<?php echo $this->item->title; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_PREGNANT'); ?>:
			<?php echo $this->item->pregnant; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_FATHER_ID'); ?>:
			<?php echo $this->item->father_id; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_FATHER_NAME'); ?>:
			<?php echo $this->item->father_name; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_MOTHER_ID'); ?>:
			<?php echo $this->item->mother_id; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_MOTHER_NAME'); ?>:
			<?php echo $this->item->mother_name; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_MANE'); ?>:
			<?php echo $this->item->mane; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_MATE'); ?>:
			<?php echo $this->item->mate; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_TERRAIN'); ?>:
			<?php echo $this->item->terrain; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_DOB'); ?>:
			<?php echo $this->item->dob; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_BIRTHS_CREATED_BY'); ?>:
			<?php echo $this->item->created_by_name; ?></li>


        </ul>

    </div>
    
<?php
else:
    echo JText::_('COM_BREEDABLE_ITEM_NOT_LOADED');
endif;
?>
