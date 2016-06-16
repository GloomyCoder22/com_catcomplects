<?php
/**
 * @version     1.0.0
 * @package     com_catcomplects
 * @copyright   © 2015. Demin Artem. Все права защищены.
 * @license     GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
 * @author      Demin Artem <ademin1982@gmail.com> - http://
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
$document->addStyleSheet('components/com_catcomplects/assets/css/catcomplects.css');
$document->addStyleSheet('/media/jui/css/jquery-ui.css');
$document->addStyleSheet('/media/jui/css/jquery-ui.theme.css');
$document->addScript('/media/jui/js/jquery-ui.min.js', 'text/javascript');
?>
<script type="text/javascript">
/*
  js = jQuery.noConflict();
  js(document).ready(function() {
  });
*/
  jQuery(document).ready(function() {
    var form_name = jQuery('#jform_name').val();
    var form_height = jQuery('#jform_height').val();
    var form_width = jQuery('#jform_width').val();
    var form_price = jQuery('#jform_price').val();
    var form_desc = jQuery('#jform_description').val();
   
    jQuery('#jform_name, #jform_height, #jform_width, #jform_price, #jform_description').blur(function () {
      var form_name = jQuery('#jform_name').val();
      var form_height = jQuery('#jform_height').val();
      var form_width = jQuery('#jform_width').val();
      var form_price = jQuery('#jform_price').val();
      var form_desc = jQuery('#jform_description').val();
    });
  });
  
  Joomla.submitbutton = function(task) {
    if (task == 'item.cancel') {
      Joomla.submitform(task, document.getElementById('item-form'));
    } else {
      if (task != 'item.cancel' && document.formvalidator.isValid(document.id('item-form'))) {
        Joomla.submitform(task, document.getElementById('item-form'));
      } else {
        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
      }
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_catcomplects&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="item-form" class="form-validate">
  <div class="form-horizontal">
    <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
    <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CATCOMPLECTS_TITLE_ITEM', true)); ?>
    <div class="row-fluid">
      <div class="span10 form-horizontal">
        <fieldset class="adminform">
          <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
          <div class="control-group">
            <img src="/images/items/min/<?php echo $this->item->article; ?>_min.jpg" />
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('name'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('article'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('article'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('catid'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('catid'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('price'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('price'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('price_old'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('price_old'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('height'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('height'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('width'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('width'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('color_back'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('color_back'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('color_word'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('color_word'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('address'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('address'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('time_work'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('time_work'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('description'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('meta_title'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('meta_title'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('meta_desc'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('meta_desc'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('meta_keywords'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('meta_keywords'); ?></div>
          </div>


          <input id="jform_title" type="hidden" name="jform[title]" value="" />
          <input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				  <input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				  <input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				  <input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />
          
          <?php if(empty($this->item->created_by)){ ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo JFactory::getUser()->id; ?>" />
          <?php } 
          else { ?>
					<input type="hidden" name="jform[created_by]" value="<?php echo $this->item->created_by; ?>" />
				  <?php } ?>
        </fieldset>
      </div>
    </div>
    <?php echo JHtml::_('bootstrap.endTab'); ?>
    <?php echo JHtml::_('bootstrap.endTabSet'); ?>
    <input type="hidden" name="task" value="" />
    <?php echo JHtml::_('form.token'); ?>
  </div>
</form>