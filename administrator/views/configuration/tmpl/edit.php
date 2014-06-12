<?php
/**
 * @version     1.0.9
 * @package     com_breedable
 * @copyright   Copyright (C) 2014. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Stephen Bishop <dazzle.software@gmail.com> - http://dazzlesoftware.org
 */
// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_breedable/assets/css/breedable.css');
?>
<script type="text/javascript">
    js = jQuery.noConflict();
    js(document).ready(function() {
        
    });

    Joomla.submitbutton = function(task)
    {
        if (task == 'configuration.cancel') {
            Joomla.submitform(task, document.getElementById('configuration-form'));
        }
        else {
            
            if (task != 'configuration.cancel' && document.formvalidator.isValid(document.id('configuration-form'))) {
                
                Joomla.submitform(task, document.getElementById('configuration-form'));
            }
            else {
                alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
            }
        }
    }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_breedable&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="configuration-form" class="form-validate">

    <div class="form-horizontal">
        <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_BREEDABLE_TITLE_CONFIGURATION', true)); ?>
        <div class="row-fluid">
            <div class="span10 form-horizontal">
                <fieldset class="adminform">

                    			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_type'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_type'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_gender'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_gender'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_coat'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_coat'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_eyes'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_eyes'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_food'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_food'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_health'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_health'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_fevor'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_fevor'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_range'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_range'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_sound'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_sound'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_walk'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_walk'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_title'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_title'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_pregnant'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_pregnant'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_mane'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_mane'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_mate'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_mate'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('breedable_terrain'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('breedable_terrain'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('owner_name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('owner_name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('owner_key'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('owner_key'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('bundle_key'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('bundle_key'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('version'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('version'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('status'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('status'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('generation'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('generation'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('mother_id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('mother_id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('mother_name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('mother_name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('father_id'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('father_id'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('father_name'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('father_name'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('location'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('location'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('dob'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('dob'); ?></div>
			</div>
			<div class="control-group">
				<div class="control-label"><?php echo $this->form->getLabel('created_by'); ?></div>
				<div class="controls"><?php echo $this->form->getInput('created_by'); ?></div>
			</div>


                </fieldset>
            </div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>
        
        

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>

    </div>
</form>