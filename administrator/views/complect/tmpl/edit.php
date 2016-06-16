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
// Загружаем тултипы.
JHtml::_('bootstrap.tooltip');
//JHtml::_('behavior.tooltip');

// Загружаем проверку формы.
JHtml::_('behavior.formvalidation');
// Загружаем украшательства формы.
// JHtml::_('formbehavior.chosen', 'select');
JHtml::_('formbehavior.chosen');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_catcomplects/assets/css/catcomplects.css');
$document->addStyleSheet('/media/jui/css/jquery-ui.css');
$document->addStyleSheet('/media/jui/css/jquery-ui.theme.css');
$document->addScript('/media/jui/js/jquery-ui.min.js', 'text/javascript');
?>
<script type="text/javascript">
  jQuery(document).ready(function() {
  
    var select_item = jQuery('#jform_items');

    var choices_cnt = 0;
    var choices_arr = new Array();    
    jQuery('input:hidden.items').each(function() {
      var name = jQuery(this).attr("name");
      var value = jQuery(this).attr("value");
      if (name.indexOf('itemshidden')) {
        jQuery('#jform_items option[value="'+jQuery(this).val()+'"]').attr("selected",true);
        
        jQuery('option',select_item).each(function(i) {
          if (jQuery(this).attr("value") == value) choices_arr[choices_cnt] = i;
        });
        choices_cnt = choices_cnt + 1;
      }
    });
    updateSelect(choices_arr,select_item);

    jQuery('#jform_items').chosen({
      no_results_text : 'Эх, ничего не найдено! - '
    });
     
    jQuery('.chzn-choices').sortable({
      revert: false
    });
    
    jQuery('.chzn-choices').on('sortupdate', function(event, ui) {
      var choices_cnt = 0;
      var choices_arr = new Array();
      var select_this = jQuery(this).parent().prev('select');
      
      jQuery('li a',this).each(function() {
        choices_arr[choices_cnt] = jQuery(this).attr('data-option-array-index');
        choices_cnt = choices_cnt + 1;
      });
      updateSelect(choices_arr,select_this);
    });
    
    function updateSelect(choices_arr,select) {
      var options_cnt = 0;
      var options_val = new Array();
      var options_text = new Array();
      var options_html = '';
      
      jQuery('option',select).each(function() {
        options_val[options_cnt] = jQuery(this).attr("value");
        options_text[options_cnt] = jQuery(this).html();
        options_cnt = options_cnt + 1;
      });
      
      for (var y = 0, max = choices_arr.length; y < max; y++) {
        options_html += '<option value="'+options_val[choices_arr[y]]+'" selected="selected">'+options_text[choices_arr[y]]+'</option>\n';
        options_val[i] = '';
        options_text[i] = '';
      }
      
      for (var i = 0, max = options_val.length; i < max; i++) {
        if (options_val[i] != '') options_html += '<option value="'+options_val[i]+'">'+options_text[i]+'</option>\n';
      }
      
      select.empty().html(options_html);
      select.trigger("liszt:updated");      
    }

  });
    
  Joomla.submitbutton = function(task) {
    if (task == 'complect.cancel') {
      Joomla.submitform(task, document.getElementById('complect-form'));
    } else {
      if (task != 'complect.cancel' && document.formvalidator.isValid(document.id('complect-form'))) {
        Joomla.submitform(task, document.getElementById('complect-form'));
      } else {
        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
      }
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_catcomplects&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="complect-form" class="form-validate">
  <div class="form-horizontal">
  <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
  <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CATCOMPLECTS_TITLE_COMPLECT', true)); ?>
    <div class="row-fluid">
      <div class="span10 form-horizontal">
        <fieldset class="adminform">
          <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('name'); ?></div>
          </div>
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('items'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('items'); ?></div>
          </div>
          <?php
          foreach((array)$this->item->items as $value):
            if (!is_array($value)):
              echo '<input type="hidden" class="items" name="jform[itemshidden]['.$value.']" value="'.$value.'" />';
            endif;
          endforeach;
          ?>
          
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('description'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('description'); ?></div>
          </div>
          
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('alias'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('alias'); ?></div>
          </div>
          <?php echo JLayoutHelper::render('joomla.edit.name_alias', $this); ?>
          
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