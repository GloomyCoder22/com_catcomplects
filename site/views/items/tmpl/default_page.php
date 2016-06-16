<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
// JHtml::_('behavior.caption');

$CanonicalLink = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$siteurl = 'http://'.$_SERVER["HTTP_HOST"];

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$doc->addHeadLink($CanonicalLink, 'canonical');

$item = $this->item;
$items = $this->items;
$cat = $this->cat;
$count_row = 1;

$pathway = $app->getPathway();
$pathway->addItem(replace_quotes($item->name));

$item_name = str_replace("\"", "", $item->name);
$item_name = mb_strtolower($item_name);
if ($item->meta_desc != '') {
  $this->document->setDescription($item->meta_desc);
} else {
  $this->document->setDescription($item->name.' для наружной рекламы. Покупайте в интернет магазине по низкой цене с гарантией от производителя.');
}
if ($item->meta_keywords != '') {
  $this->document->setMetaData('keywords',$item->meta_keywords);
} else {
  $this->document->setMetaData('keywords', 'купить '.$item_name.', продажа '.$item_name.', '.$item_name.',  интернет магазин, Барнаул, Vyveski.me');
}
$item_name = mb_strtolower($item->name);
if ($item->meta_title != '') {
  $this->document->setTitle($item->meta_title);
} else {
  $this->document->setTitle('Купить '.$item_name.' для наружной рекламы в интернет магазине на Vyveski.me недорого!');
}

$doc->addCustomTag('<meta property="og:title" content="'.replace_quotes($item->name).'" />');
$doc->addCustomTag('<meta property="og:description" content="'.replace_quotes($item->description).'" />');
$doc->addCustomTag('<meta property="og:type" content="product" />');
$doc->addCustomTag('<meta property="og:url" content="'.$CanonicalLink.'" />');
$doc->addCustomTag('<meta property="og:image" content="'.$siteurl.'/images/items/'.$item->article.'.jpg" />');
$doc->addCustomTag('<meta property="og:site_name" content="Vyveski.me" />');

$menu_arr = getItemid("alias",$cat->alias);
$itemid = $menu_arr['0'];
$item_img = $item->article.'.jpg';
$item_img_min = $item->article.'_min.jpg';
$item_img_thumb = $item->article.'_thumb.jpg';

global $color_hex;
$color_cur = '';
$style_cur = array();
$item_color_arr[0] = '';
if ($item->color != '') {
  $item_color_arr = explode(",", $item->color);
  $item_img = $item->article.'-'.$item_color_arr[0].'.jpg';
  $item_img_min = $item->article.'-'.$item_color_arr[0].'_min.jpg';
  $item_img_thumb = $item->article.'-'.$item_color_arr[0].'_thumb.jpg';
  $color_cur = '-'.$item_color_arr[0];
  $item_color_cur = $item_color_arr[0];
  if ($item->color_default != '') {
    $item_img = $item->article.'-'.$item->color_default.'.jpg';
    $item_img_min = $item->article.'-'.$item->color_default.'_min.jpg';
    $item_img_thumb = $item->article.'-'.$item->color_default.'_thumb.jpg';
    $color_cur = '-'.$item->color_default;
    $item_color_cur = $item->color_default;
  }
}

image_thumbs(260, 260, $item_img, $item_img_thumb);
?>

<div id="page_item" itemscope itemtype="http://schema.org/Product">
  <h1 itemprop="name"><?php echo replace_quotes($item->name); ?></h1>
    <?php if ($item->state == 1) { ?>
      <?php
        if ($item->height != '0' && $item->width != '0') $item_razmer = $item->height.'х'.$item->width.' мм';
        if ($item->height == '0' && $item->width != '0') $item_razmer = $item->width.' мм';
        if ($item->height != '0' && $item->width == '0') $item_razmer = $item->height.' мм';
        if ($item->height == '0' && $item->width == '0') $item_razmer = '';
      ?>
      
  <div class="item_img">
    <a class="zoom" href="/images/items/<?php echo $item_img; ?>" title="Увеличить изображение" data-lightbox="group:item_img" data-title="<?php echo replace_quotes($item->name).' (артикул: '.$item->article.')'; ?>"><img src="/images/items/thumbs/<?php echo $item_img_thumb; ?>" alt="<?php echo replace_quotes($item->name).' (артикул: '.$item->article.')'; ?>" itemprop="image" /><i class="fa fa-search-plus"></i></a>
    <!--
    <div class="share42init" style="margin: 0; text-align: left;"></div>
    <script type="text/javascript" src="http://www.vyveski.me/components/com_catcomplects/assets/js/share42.js" defer="defer" async="async"></script>
    -->
    <?php if ($item->color_back != 0 || $item->color_word != 0) {  ?>
      <div class="item_colorbox">
      <?php if (isset($item_color_arr[0]) && $item_color_arr[0] != '') { ?>
        <?php foreach ($item_color_arr as $key => $value) { ?>
          <?php image_thumbs(260, 260, $item->article.'-'.$value.'.jpg', $item->article.'-'.$value.'_thumb.jpg'); ?>
          <?php if ($item_color_cur == $value && $item->color_default != '') { ?>
            <?php $style_color = 'background-color: #'.$color_hex[$value].'; box-shadow: 0px 0px 5px 5px #'.$color_hex[$value]; ?>
          <?php } else { ?>
            <?php $style_color = 'background-color: #'.$color_hex[$value]; ?>
          <?php } ?>
                 <div class="item_color_val img_href" style="<?php echo $style_color; ?>" data-hexcolor="<?php echo $color_hex[$value]; ?>" data-imgcolor="<?php echo $item->article.'-'.$value.'_thumb.jpg'; ?>" data-articleimg="<?php echo $item->article.'-'.$value; ?>"></div>
        <?php } ?>
      <?php } else { ?>
        <?php foreach ($color_hex as $key => $value) { ?>
          <div class="item_color_val" style="background-color: #<?php echo $value; ?>;" data-hexcolor="<?php echo $value; ?>"></div>
        <?php } ?>
      <?php } ?>
        <div class="clear"></div>
        <div class="item_colorbox_text">выбор расцветки</div>      
      </div>
    <?php } ?>
  </div>
  
  <div class="item_right">
    <div class="block_title">Описание</div>
    <div class="block_desk">
      <div class="item_desk" itemprop="description"><?php echo replace_quotes($item->description); ?></div>
    </div>
    <div class="block_title">Характеристики</div>
    <div class="ItemProperties">
      <div class="ItemProperties_line">
        <div class="ItemProperties_name">Размеры</div>
        <div class="ItemProperties_text">
          <?php foreach ($items as $item2 ) { ?>
            <?php if ($item->name == $item2->name && $item->article != $item2->article && $item2->state == 1) { ?>
              <?php
                if ($item2->height != '0' && $item2->width != '0') $item_razmer2 = $item2->height.'х'.$item2->width.' мм.';
                if ($item2->height == '0' && $item2->width != '0') $item_razmer2 = $item2->width.' мм.';
                if ($item2->height != '0' && $item2->width == '0') $item_razmer2 = $item2->height.' мм.';
                if ($item2->height == '0' && $item2->width == '0') $item_razmer2 = '';    
              ?>
                <span><a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&article='.$item2->article.'&Itemid='.$itemid); ?>" title="<?php echo replace_quotes($item->name).' '.$item_razmer2; ?>"><?php echo $item_razmer2; ?></a>&nbsp;-&nbsp;<?php echo number_format($item2->price, 0, ".", " "); ?>&nbsp;руб.</span>
            <?php } else if ($item->article == $item2->article) { ?>
                <span style="color: #CB3876; font-weight: bold;"><?php echo $item_razmer; ?></span>
            <?php } 
            ?>
          <?php } ?>
        </div>
      </div>
      <div class="ItemProperties_line">
        <!-- <div class="item_model">Модель: <span itemprop="model">Модель продукта</span></div> -->
        <div class="ItemProperties_name">Гарантия</div><div class="ItemProperties_text">3 года</div>
      </div>
      <div class="ItemProperties_line">
        <div class="ItemProperties_name">Производитель</div><div class="ItemProperties_text" itemprop="manufacturer">БИСМА</div>
      </div>
      <div class="ItemProperties_line">
        <div class="ItemProperties_name">Страна-производитель</div><div class="ItemProperties_text">Россия</div>
      </div>
      <div class="ItemProperties_line">
        <div class="ItemProperties_name">Артикул</div><div class="ItemProperties_text"><?php echo $item->article; ?></div>
      </div>
    </div>
    <!-- <div class="lozung">Не теряйте время, закажите сейчас и сэкономьте до 70%!</div> -->
    <div style="display: inline-block; position: relative; width: 100%; margin: 20px 0 0 0; text-align: left;">
      <div class="mod_item_price" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
        <?php if ($item->price_old != 0) { ?>
        <div class="item_price_old"><?php echo number_format($item->price_old, 0, '.', ' '); ?> руб.</div>
        <?php } ?>      
        <div class="item_price"><?php echo number_format($item->price, 0, '.', ' '); ?> руб.</div>
        <meta itemprop="price" content="<?php echo $item->price.'.00'; ?>">
        <meta itemprop="priceCurrency" content="RUB">
        <meta itemprop="availability" content="http://schema.org/InStock" />
        <div class="item_buy">
          <a id="cart_<?php echo $item->article.$color_cur; ?>" class="btn btn-success cartadd no-cart" data-article="<?php echo $item->article.$color_cur; ?>" href="#" onclick="vsCartAdd('<?php echo $item->article.$color_cur; ?>'); yaCounter29661885.reachGoal('InCart'); return false;" title="Положить в корзину"><i class="fa fa-shopping-cart"></i>В корзину</a>
        </div>
        <div class="clear"></div>
        <div class="bespl_dostavka">Бесплатная доставка по всей России *</div>      
      </div>
      <div class="help_manager">
        <a class="href_manager modal" href="/forma-zakaza-obratnogo-zvonka" title="Нужна помощь менеджера!">Нужна помощь менеджера!</a>
      </div>
    </div>
  </div>
  <div class="clear"></div>
    <?php } ?>
  <!-- <div class="button_back"><a href="#" onclick="history.back(); return false;">Вернуться к списку товаров</a></div> -->
  <div class="button_back"><a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&Itemid='.$itemid); ?>" title="Вернуться к списку товаров">Вернуться к списку товаров</a></div>
</div>
<div class="clear"></div>
<script type="text/javascript">
// jQuery(document).ready(function(){
  window.dataLayer = window.dataLayer || [];
  dataLayer.push({
    "ecommerce": {
        "detail": {
            "products": [
                {
                    "id": "<?php echo $item->article; ?>",
                    "name" : "<?php echo replace_quotes($item->name); ?>",
                    "price": "<?php echo $item->price.'.00'; ?>",
                    "brand": "БИСМА",
                    "category": "Наружная реклама/<?php echo $cat->name; ?>",
                    "variant" : "<?php echo $item_razmer; ?>"
                }
            ]
        }
    }
  });
// });
</script>