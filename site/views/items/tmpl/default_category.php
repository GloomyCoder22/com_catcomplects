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

$doc = JFactory::getDocument();
$CanonicalLink = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$siteurl = 'http://'.$_SERVER["HTTP_HOST"];
$doc->addHeadLink($CanonicalLink, 'canonical');

global $color_hex;

$items = $this->items;
$items2 = $items;
$cat = $this->cat;
$cat_name = replace_quotes($cat->name);
// $cat_name = 'Готовые '.mb_strtolower($cat_name);
// if ($cat_name == 'Готовые разное') $cat_name = 'Готовую продукцию';
if ($cat_name == 'Разное') $cat_name = 'Разная продукция';
$item_name = '';
$item_count = 1;
$row_cnt = 1;

$menu_arr = getItemid("alias",$cat->alias);
$itemid = $menu_arr['0'];
?>
<div id="items" itemscope itemtype="http://schema.org/ItemList">
  <h1 itemprop="name"><?php echo $cat_name; ?> для наружной рекламы</h1>
  <link itemprop="url" href="<?php echo $CanonicalLink; ?>" />
  <div class="block-text">
    <?php $cat_name = mb_strtolower($cat_name); ?>
    <p>У нас Вы можете <strong>купить <?php echo $cat_name; ?></strong> или <a href="/" title="Каталог готовых комплектов вывесок"><strong>готовые комплекты вывесок</strong></a> для наружной рекламы.</p>
    <?php echo $cat->description; ?>
  </div>
  <!--<div class="lozung">Не теряйте время, закажите сейчас и сэкономьте до 70%!</div><br /> -->
  <?php 
    foreach ($items as $item ) {
      if ($item_name != $item->name) {
        $item_img = $item->article.'.jpg';
        $item_img_min = $item->article.'_min.jpg';

        $color_cur = '';
        $style_cur = array();
        $item_color_arr[0] = '';
        if ($item->color != '') {
          $item_color_arr = explode(",", $item->color);
          $item_img = $item->article.'-'.$item_color_arr[0].'.jpg';
          $item_img_min = $item->article.'-'.$item_color_arr[0].'_min.jpg';
          $color_cur = '-'.$item_color_arr[0];
          $item_color_cur = $item_color_arr[0];
          if ($item->color_default != '') {
            $item_img = $item->article.'-'.$item->color_default.'.jpg';
            $item_img_min = $item->article.'-'.$item->color_default.'_min.jpg';
            $color_cur = '-'.$item->color_default;
            $item_color_cur = $item->color_default;
          }
        }       
  ?>    
  <div class="span3 cmpl_item" itemprop="itemListElement" itemscope itemtype="http://schema.org/Product">
    <div id="mod_item_<?php echo $item->article; ?>" class="mod_item">
      <div class="item_img">
        <a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&article='.$item->article.'&Itemid='.$itemid); ?>" title="Купить <?php echo replace_quotes($item->name); ?>">    
          <img src="/images/items/min/<?php echo $item_img_min; ?>" alt="<?php echo replace_quotes($item->name); ?>" itemprop="image" />
        </a>
      </div>

      <div class="item_name">
        <a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&article='.$item->article.'&Itemid='.$itemid); ?>" title="Купить <?php echo replace_quotes($item->name); ?>" itemprop="url"><span itemprop="name"><?php echo replace_quotes($item->name); ?></span></a>
      </div>

      <?php
        if ($item->height != '0' && $item->width != '0') $item_razmer = $item->height.'х'.$item->width.' мм';
        if ($item->height == '0' && $item->width != '0') $item_razmer = $item->width.' мм';
        if ($item->height != '0' && $item->width == '0') $item_razmer = $item->height.' мм';
        if ($item->height == '0' && $item->width == '0') $item_razmer = ''; 
      ?>
      <div class="item_razmer">
        <div class="item_razmer_text"><?php echo $item_razmer; ?></div>
        <?php 
          $razmer2_html = '';
          foreach ($items2 as $item2 ) {
            if ($item->name == $item2->name && $item->article != $item2->article) {
              $item2_jroute = JRoute::_('index.php?option=com_catcomplects&view=items&article='.$item2->article.'&Itemid='.$itemid);
              if ($item2->height != '0' && $item2->width != '0') $item_razmer2 = $item2->height.'х'.$item2->width.' мм';
              if ($item2->height == '0' && $item2->width != '0') $item_razmer2 = $item2->width.' мм';
              if ($item2->height != '0' && $item2->width == '0') $item_razmer2 = $item2->height.' мм';
              if ($item2->height == '0' && $item2->width == '0') $item_razmer2 = '';
              $razmer2_html .= '<span><a href="'.$item2_jroute.'" title="Купить '.replace_quotes($item2->name).' '.$item_razmer2.'">'.$item_razmer2.'</a>&nbsp;-&nbsp;'.number_format($item2->price, 0, ".", " ").' руб.</span>';
            }
          }
          if (!empty($razmer2_html)) echo '<div class="item_otherrazmer_text">ДРУГИЕ РАЗМЕРЫ:</div>'.$razmer2_html;
        ?>
      </div>
      <div class="clear"></div>

      <?php if ($item->color_back != 0 || $item->color_word != 0) {  ?>
      <div class="item_color">
        <div class="item_color_text">РАСЦВЕТКИ: </div>
        <div class="item_colorbox">
          <a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&article='.$item->article.'&Itemid='.$itemid); ?>" title="Выбрать другую расцветку">
        <?php if (isset($item_color_arr[0]) && $item_color_arr[0] != '') { ?>
          <?php foreach ($item_color_arr as $key => $value) { ?>
            <?php if ($item_color_cur == $value && $item->color_default != '') { ?>
              <div class="item_color_val" style="background-color: #<?php echo $color_hex[$value]; ?>; box-shadow: 0px 0px 5px 5px #<?php echo $color_hex[$value]; ?>" data-hexcolor="<?php echo $color_hex[$value]; ?>" data-imgcolor="<?php echo $item->article.'-'.$value.'.jpg'; ?>"></div>
            <?php } else { ?>
              <div class="item_color_val" style="background-color: #<?php echo $color_hex[$value]; ?>;" data-hexcolor="<?php echo $color_hex[$value]; ?>" data-imgcolor="<?php echo $item->article.'-'.$value.'.jpg'; ?>"></div>
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
      
      <!-- <div class="item_desk"><?php // echo replace_quotes($item->description); ?></div> -->
      <meta itemprop="description" content="<?php echo replace_quotes($item->description); ?>" />
      <meta itemprop="manufacturer" content="БИСМА" />
      <div class="mod_item_price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
        <div style="display: inline-block;">
          <?php if ($item->price_old != 0) { ?>
          <div class="item_price_old"><?php echo number_format($item->price_old, 0, '.', ' '); ?> руб.</div>
          <?php } ?>
          <div class="item_price"><?php echo number_format($item->price, 0, '.', ' '); ?> руб.</div>
          <meta itemprop="price" content="<?php echo $item->price.'.00'; ?>">
          <meta itemprop="priceCurrency" content="RUB">
          <meta itemprop="availability" content="http://schema.org/InStock" />
          <div class="item_buy">
            <a id="cart_<?php echo $item->article.$color_cur; ?>" class="btn btn-success no-cart" data-article="<?php echo $item->article.$color_cur; ?>" href="#" onclick="vsCartAdd('<?php echo $item->article.$color_cur; ?>'); yaCounter29661885.reachGoal('InCart'); return false;" title="Положить в корзину"><i class="fa fa-shopping-cart"></i>В корзину</a>
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
    <?php $item_name = $item->name; ?>
  <?php } ?>
  <meta itemprop="numberOfItems" content="<?php echo $item_count - 1; ?>" />
</div>
<div class="clear"></div>
<div class="vs_hr"></div>
<?php include("media/zvonok_vs/zvonok_vs.php"); ?>
<div class="clear"></div>
<!--
<div class="share42init"></div>
<script type="text/javascript" src="http://www.vyveski.me/components/com_catcomplects/assets/js/share42.js" defer async></script>
-->