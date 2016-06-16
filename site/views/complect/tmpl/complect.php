<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
// JHtml::_('behavior.caption');
// JHtml::_('behavior.framework', true);
// JHtml::_('jquery.framework', true);
// JHtml::stylesheet(JURI::root(true) . 'components/com_catcomplects/assets/css/style.css');

// JHtml::stylesheet(JURI::root(true) . 'components/com_catcomplects/assets/css/items.css');
// JHtml::script(JURI::root(true) . 'components/com_catcomplects/assets/js/vscripts.js', false, false);
// JHtml::script(JURI::root(true) . 'components/com_catcomplects/assets/js/items.js', false, false);
global $color_hex;

if (!isset($items)) $items = $this->items;
if (!isset($class_color)) $class_color = '';

$items2 = $items;
$item_name = '';
$item_count = 1;
$row_cnt = 1;
?>
<div id="complect_<?php echo $complect->article; ?>" class="cmpl">
<div class="cmpl_box">
  <div class="cmpl_header <?php echo $class_color; ?>">
    <div class="cmpl_icons" style="background: url(/images/icons/<?php echo $complect->article.'.jpg'; ?>) 0 0 no-repeat;"></div>
    <h4><span class="href_dashed"><?php echo $complect->name; ?></span></h4>
    <div class="clear"></div>
  </div>
  <div class="cmpl_type">
  <?php 
    foreach ($items as $item) {
      $cat = $model->getCat($item[0]->catid);
      $menu_arr = getItemid("alias",$cat->alias);
      $itemid = $menu_arr['0'];
      
      if ($item_name != $item[0]->name) {
        $item_img = $item[0]->article.'.jpg';
        $item_img_min = $item[0]->article.'_min.jpg';
        
        $color_cur = '';
        $style_cur = array();
        $item_color_arr[0] = '';
        if ($item[0]->color != '') {
          $item_color_arr = explode(",", $item[0]->color);
          $item_img = $item[0]->article.'-'.$item_color_arr[0].'.jpg';
          $item_img_min = $item[0]->article.'-'.$item_color_arr[0].'_min.jpg';
          $color_cur = '-'.$item_color_arr[0];
          $item_color_cur = $item_color_arr[0];
          if ($item[0]->color_default != '') {
            $item_img = $item[0]->article.'-'.$item[0]->color_default.'.jpg';
            $item_img_min = $item[0]->article.'-'.$item[0]->color_default.'_min.jpg';
            $color_cur = '-'.$item[0]->color_default;
            $item_color_cur = $item[0]->color_default;
          }
        }          
  ?>
  <div class="span3 cmpl_item" itemprop="itemListElement" itemscope itemtype="http://schema.org/Product">
    <div id="mod_item_<?php echo $item[0]->article; ?>" class="mod_item">
      <div class="item_img">
        <a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&article='.$item[0]->article.'&Itemid='.$itemid); ?>" title="Купить <?php echo replace_quotes($item[0]->name); ?>">    
          <img src="/images/items/min/<?php echo $item_img_min; ?>" alt="<?php echo replace_quotes($item[0]->name); ?>" itemprop="image" />
        </a>
      </div>

      <div class="item_name">
        <a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&article='.$item[0]->article.'&Itemid='.$itemid); ?>" title="Купить <?php echo replace_quotes($item[0]->name); ?>" itemprop="url"><span itemprop="name"><?php echo replace_quotes($item[0]->name); ?></span></a>
      </div>

      <?php
        if ($item[0]->height != '0' && $item[0]->width != '0') $item_razmer = $item[0]->height.'х'.$item[0]->width.' мм';
        if ($item[0]->height == '0' && $item[0]->width != '0') $item_razmer = $item[0]->width.' мм';
        if ($item[0]->height != '0' && $item[0]->width == '0') $item_razmer = $item[0]->height.' мм';
        if ($item[0]->height == '0' && $item[0]->width == '0') $item_razmer = ''; 
      ?>
      <div class="item_razmer">
        <div class="item_razmer_text"><?php echo $item_razmer; ?></div>
        <?php 
          $razmer2_html = '';
          foreach ($items2 as $item2 ) {
            if ($item[0]->name == $item2[0]->name && $item[0]->article != $item2[0]->article) {
              $item2_jroute = JRoute::_('index.php?option=com_catcomplects&view=items&article='.$item2[0]->article.'&Itemid='.$itemid);
              if ($item2[0]->height != '0' && $item2[0]->width != '0') $item_razmer2 = $item2[0]->height.'х'.$item2[0]->width.' мм';
              if ($item2[0]->height == '0' && $item2[0]->width != '0') $item_razmer2 = $item2[0]->width.' мм';
              if ($item2[0]->height != '0' && $item2[0]->width == '0') $item_razmer2 = $item2[0]->height.' мм';
              if ($item2[0]->height == '0' && $item2[0]->width == '0') $item_razmer2 = '';
              $razmer2_html .= '<span><a href="'.$item2_jroute.'" title="Купить '.replace_quotes($item2[0]->name).' '.$item_razmer2.'">'.$item_razmer2.'</a>&nbsp;-&nbsp;'.number_format($item2[0]->price, 0, ".", " ").' руб.</span>';
            }
          }
          if (!empty($razmer2_html)) echo '<div class="item_otherrazmer_text">ДРУГИЕ РАЗМЕРЫ:</div>'.$razmer2_html;
        ?>
      </div>
      <div class="clear"></div>
     
      <?php if ($item[0]->color_back != 0 || $item[0]->color_word != 0) {  ?>
      <div class="item_color">
        <div class="item_color_text">РАСЦВЕТКИ: </div>
        <div class="item_colorbox">
          <a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&article='.$item[0]->article.'&Itemid='.$itemid); ?>" title="Выбрать другую расцветку">
        <?php if (isset($item_color_arr[0]) && $item_color_arr[0] != '') { ?>
          <?php foreach ($item_color_arr as $key => $value) { ?>
            <?php if ($item_color_cur == $value && $item[0]->color_default != '') { ?>
              <div class="item_color_val" style="background-color: #<?php echo $color_hex[$value]; ?>; box-shadow: 0px 0px 5px 5px #<?php echo $color_hex[$value]; ?>" data-hexcolor="<?php echo $color_hex[$value]; ?>" data-imgcolor="<?php echo $item[0]->article.'-'.$value.'.jpg'; ?>"></div>
            <?php } else { ?>
              <div class="item_color_val" style="background-color: #<?php echo $color_hex[$value]; ?>;" data-hexcolor="<?php echo $color_hex[$value]; ?>" data-imgcolor="<?php echo $item[0]->article.'-'.$value.'.jpg'; ?>"></div>
            <?php } ?>
          <?php } ?>
        <?php } else { ?>
          <?php foreach ($color_hex as $key => $value) { ?>
            <div class="item_color_val" style="background-color: #<?php echo $value; ?>;" data-hexcolor="<?php echo $value; ?>"></div>
          <?php } ?>
        <?php } ?>
          </a>
        </div>
      </div>
      <div class="clear"></div>
      <?php } ?>
      
      <!-- <div class="item_desk"><?php // echo replace_quotes($item[0]->description); ?></div> -->
      <meta itemprop="description" content="<?php echo replace_quotes($item[0]->description); ?>" />
      <meta itemprop="manufacturer" content="БИСМА" />
      <div class="mod_item_price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
        <div style="display: inline-block;">
          <?php if ($item[0]->price_old != 0) { ?>
          <div class="item_price_old"><?php echo number_format($item[0]->price_old, 0, '.', ' '); ?> руб.</div>
          <?php } ?>
          <div class="item_price"><?php echo number_format($item[0]->price, 0, '.', ' '); ?> руб.</div>
          <meta itemprop="price" content="<?php echo $item[0]->price.'.00'; ?>">
          <meta itemprop="priceCurrency" content="RUB">
          <meta itemprop="availability" content="http://schema.org/InStock" />
          <div class="item_buy">
            <a id="cart_<?php echo $item[0]->article.$color_cur; ?>" class="btn btn-success no-cart" data-article="<?php echo $item[0]->article.$color_cur; ?>" href="#" onclick="vsCartAdd('<?php echo $item[0]->article.$color_cur; ?>'); yaCounter29661885.reachGoal('InCart'); return false;" title="Положить в корзину"><i class="fa fa-shopping-cart"></i>В корзину</a>
          </div>
        </div>
        <div class="clear"></div>
      </div>
    </div>
  </div>
      <?php if ($row_cnt == 3) { ?>
        <div class="clear"></div>
        <?php $row_cnt = 0; ?>
      <?php } ?>
      <?php $item_count = $item_count + 1; ?>
      <?php $row_cnt = $row_cnt + 1; ?>
    <?php } ?>
    <?php $item_name = $item[0]->name; ?>
  <?php } ?>
  <meta itemprop="numberOfItems" content="<?php echo $item_count - 1; ?>" />
</div>
</div>
</div>
<div class="clear"></div>