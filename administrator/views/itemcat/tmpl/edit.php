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
?>
<script type="text/javascript">
  jQuery(document).ready(function() {

  });

  Joomla.submitbutton = function(task) {
    if (task == 'itemcat.cancel') {
      Joomla.submitform(task, document.getElementById('itemcat-form'));
    } else {
      if (task != 'itemcat.cancel' && document.formvalidator.isValid(document.id('itemcat-form'))) {
        Joomla.submitform(task, document.getElementById('itemcat-form'));
      } else {
        alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
      }
    }
  }
</script>

<form action="<?php echo JRoute::_('index.php?option=com_catcomplects&layout=edit&id=' . (int) $this->item->id); ?>" method="post" enctype="multipart/form-data" name="adminForm" id="itemcat-form" class="form-validate">
  <div class="form-horizontal">
  <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>
  <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_CATCOMPLECTS_TITLE_CATEGORY', true)); ?>
    <div class="row-fluid">
      <div class="span10 form-horizontal">
        <fieldset class="adminform">
          <input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
          <div class="control-group">
            <div class="control-label"><?php echo $this->form->getLabel('name'); ?></div>
            <div class="controls"><?php echo $this->form->getInput('name'); ?></div>
          </div>
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
          <?php } else { ?>
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