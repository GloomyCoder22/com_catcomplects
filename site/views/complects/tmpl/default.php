<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
//$form = JHTML::_("Catcomplects.Complects.simplepostform", "formname");
//echo JLayoutHelper::render('joomla.content.categories_default', $this);
//$this->loadTemplate('categories');

//$app = JFactory::getApplication();
//$menu = $app->getMenu();
//$Itemid	= $menu->getActive()->id;

$model = $this->getModel();

$flag = 'complects';
$count_line = 0;
$class_color = 'line_color';
?>
<!-- <script src="components/com_catcomplects/assets/js/complects.js" type="text/javascript"></script> -->
<!--
<h1>У нас вы можете купить готовую вывеску и рекламные комплекты для вашего бизнеса</h1>
<h2>Комплекты готовых решений наружной рекламы</h2>
-->
<h1>Купить вывеску для наружной рекламы</h1>
<div class="block-text">
  У нас Вы можете купить <strong>готовые вывески</strong> или <strong>наборы вывесок</strong> для наружной рекламы.<br />
  А также <a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&Itemid=230'); ?>" title="Каталог объемных световых букв">объемные световые буквы</a>, <a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&Itemid=232'); ?>" title="Каталог световых коробов">световые короба</a>, <a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&Itemid=234'); ?>" title="Каталог круглых световых коробов (консольные)">круглые световые короба (консольные)</a>, <a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&Itemid=233'); ?>" title="Каталог композитных световых коробов">композитные световые короба </a>, <a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&Itemid=238'); ?>" title="Каталог щитов композитных">щиты композитные</a>, <a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&Itemid=235'); ?>" title="Каталог светодиодных крестов">светодиодные кресты</a> и <a href="/items" title="Каталог продукции для наружной рекламы">другую рекламную продукцию</a>.
</div>
<h2>Наборы вывесок для открытия:</h2>
<!-- <div class="lozung">Не теряйте время, закажите сейчас и сэкономьте до 70%!</div> -->
<div id="complects" class="">
  <div id="items" class="">
  <?php 
    foreach ($this->complects as $complect ) {
      if ($complect->state == 1) {
        $items = array();
        // $items = $model->getItemsComplect($complect->items);
        $items_arr = explode(',', $complect->items);
        foreach ($items_arr as $item) {
          $items[] = $model->getItemsComplect($item);
        }
        
        if ($count_line > 0) {
          $count_line = -1;
          $class_color = 'line_color';
        } else {
          $class_color = 'line_nocolor';
        }
        include(JPATH_COMPONENT . "/views/complect/tmpl/complect.php");
        $count_line = $count_line + 1;
      }
    } 
  ?>
  </div>
  <div id="cmpl_items_tooltip"></div>
</div>
<div class="clear"></div>
<div class="vs_hr"></div>
<?php include("media/zvonok_vs/zvonok_vs.php"); ?>
<div class="clear"></div>
<!--
<div class="share42init"></div>
<script type="text/javascript" src="http://www.vyveski.me/components/com_catcomplects/assets/js/share42.js" defer="defer" async="async"></script>
-->