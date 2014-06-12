<?php
/**
 * @version     1.0.12
 * @package     com_breedable
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Stephen Bishop <dazzle.software@gmail.com> - http://dazzlesoftware.org
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

            			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_ID'); ?>:
			<?php echo $this->item->id; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_TYPE'); ?>:
			<?php echo $this->item->breedable_type_title; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_NAME'); ?>:
			<?php echo $this->item->breedable_name; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_ID'); ?>:
			<?php echo $this->item->breedable_id; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_OWNER_NAME'); ?>:
			<?php echo $this->item->owner_name; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_OWNER_KEY'); ?>:
			<?php echo $this->item->owner_key; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_STATUS'); ?>:
			<?php echo $this->item->status; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_VERSION'); ?>:
			<?php echo $this->item->version; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_GENERATION'); ?>:
			<?php echo $this->item->generation; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_DOB'); ?>:
			<?php echo $this->item->breedable_dob; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_GENDER'); ?>:
			<?php echo $this->item->breedable_gender; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_COAT'); ?>:
			<?php echo $this->item->breedable_coat; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_EYES'); ?>:
			<?php echo $this->item->breedable_eyes; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_FOOD'); ?>:
			<?php echo $this->item->breedable_food; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_HEALTH'); ?>:
			<?php echo $this->item->breedable_health; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_FEVOR'); ?>:
			<?php echo $this->item->breedable_fevor; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_WALK'); ?>:
			<?php echo $this->item->breedable_walk; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_RANGE'); ?>:
			<?php echo $this->item->breedable_range; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_TERRAIN'); ?>:
			<?php echo $this->item->breedable_terrain; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_SOUND'); ?>:
			<?php echo $this->item->breedable_sound; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_TITLE'); ?>:
			<?php echo $this->item->breedable_title; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_PREGNANT'); ?>:
			<?php echo $this->item->breedable_pregnant; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_MANE'); ?>:
			<?php echo $this->item->breedable_mane; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BREEDABLE_MATE'); ?>:
			<?php echo $this->item->breedable_mate; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_BUNDLE_KEY'); ?>:
			<?php echo $this->item->bundle_key; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_MOTHER_NAME'); ?>:
			<?php echo $this->item->mother_name; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_MOTHER_ID'); ?>:
			<?php echo $this->item->mother_id; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_FATHER_NAME'); ?>:
			<?php echo $this->item->father_name; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_FATHER_ID'); ?>:
			<?php echo $this->item->father_id; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_LOCATION'); ?>:
			<?php echo $this->item->location; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_ORDERING'); ?>:
			<?php echo $this->item->ordering; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_CHECKED_OUT'); ?>:
			<?php echo $this->item->checked_out; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_CHECKED_OUT_TIME'); ?>:
			<?php echo $this->item->checked_out_time; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_CREATED_BY'); ?>:
			<?php echo $this->item->created_by_name; ?></li>


        </ul>

    </div>
    
<?php
else:
    echo JText::_('COM_BREEDABLE_ITEM_NOT_LOADED');
endif;
?>
