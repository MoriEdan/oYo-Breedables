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

            			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_ID'); ?>:
			<?php echo $this->item->id; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_OWNER_NAME'); ?>:
			<?php echo $this->item->owner_name; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_OWNER_KEY'); ?>:
			<?php echo $this->item->owner_key; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_VERSION'); ?>:
			<?php echo $this->item->version; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_STATUS'); ?>:
			<?php echo $this->item->status; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_GENERATION'); ?>:
			<?php echo $this->item->generation; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_MOTHER_ID'); ?>:
			<?php echo $this->item->mother_id; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_FATHER_ID'); ?>:
			<?php echo $this->item->father_id; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_LOCATION'); ?>:
			<?php echo $this->item->location; ?></li>
			<li><?php echo JText::_('COM_BREEDABLE_FORM_LBL_CONFIGURATION_CREATED_BY'); ?>:
			<?php echo $this->item->created_by_name; ?></li>


        </ul>

    </div>
    
<?php
else:
    echo JText::_('COM_BREEDABLE_ITEM_NOT_LOADED');
endif;
?>
