<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
//$app = JFactory::getApplication();
//$menu = $app->getMenu();
//$Itemid	= $menu->getActive()->id;
?>
<!-- <script src="components/com_catcomplects/assets/js/complects.js" type="text/javascript"></script> -->

<h1>Конструктор комплекта наружной рекламы</h1>
<div class="block-text">Не подходят наши готовые комплекты? Соберите комплект сами - воспользуйтесь <strong>конструктором комплектов</strong> на этой странице, это просто и удобно, попробуйте!</div>
<br />
<div id="complect_add">
<?php
  $complect = $this->complect;
  $cmpl_type = $this->cmpl_type;
  $items = $this->items;
  $cmpl_id = 0;
  
  if (count($complect) == 0) {
    $imgsrc = 'images'.DIRECTORY_SEPARATOR.'complects'.DIRECTORY_SEPARATOR;
    $imgsrc_min = 'images'.DIRECTORY_SEPARATOR.'complects'.DIRECTORY_SEPARATOR;
    $imgfname = 'noimage.jpg';
    $imgfname_min = 'noimage.jpg';
    $cmpl_price = 0;
    $cmpl_img_sfx = '';
    $cmpl_type_ru = '';
    $cmpl_type_items = '';
    $cmpl_name = 'Создание нового комплекта вывесок для наружной рекламы';
    $cmpl_article = '000000';
    $complect_id = 0;
    $cmpl_catid = '0';
  } else {
    $imgsrc = 'images'.DIRECTORY_SEPARATOR.'complects'.DIRECTORY_SEPARATOR;
    $imgsrc_min = 'images'.DIRECTORY_SEPARATOR.'complects'.DIRECTORY_SEPARATOR.'min'.DIRECTORY_SEPARATOR;
    $imgfname = $complect->article.'.jpg';
    $imgfname_min = $complect->article.'_min.jpg';
    //if  (!file_exists($imgsrc)) $imgsrc = 'images/complects/noimage.jpg';
    $cmpl_price = 0;
    $cmpl_items_econom = explode(',', $complect->items_econom);
    $cmpl_items_standart = explode(',', $complect->items_standart);
    $cmpl_items_premium = explode(',', $complect->items_premium);
      
    if ($cmpl_type == 'econom') {
      $cmpl_img_sfx = 'e';
      $cmpl_type_ru = 'Эконом';
      $cmpl_type_items = $cmpl_items_econom;
    }
    if ($cmpl_type == 'standart') {
      $cmpl_img_sfx = 's';
      $cmpl_type_ru = 'Стандарт';
      $cmpl_type_items = $cmpl_items_standart;
    }
    if ($cmpl_type == 'premium') {
      $cmpl_img_sfx = 'p';
      $cmpl_type_ru = 'Премиум';
      $cmpl_type_items = $cmpl_items_premium;
    }
    $cmpl_name = 'Редактирование "'.replace_quotes($complect->name).' ('.$cmpl_type_ru.')"';
    $cmpl_article = $complect->article;
    $complect_id = $complect->id;
    $cmpl_catid = $complect->catid;
  }
  $this->document->setDescription($cmpl_name);
?>
  <div id="complect_<?php echo $cmpl_article; ?>" class="cmpl">
    <form id="cmpl_form" name="cmpl_form" method="post" action="<?php echo JRoute::_('index.php?option=com_catcomplects&view=complectcart&Itemid=169'); ?>">
      <div class="cmpl_box">
        <h2><?php echo $cmpl_name; ?></h2>
        <div class="cmpl_help">Выберите из списка нужные комплектующие, чтобы добавить их в состав комлпекта.</div>
        <div class="cmpl_sostav">
        <?php
          $cmpl_price = 0;
          $catid = '0';
          $current_item = [];
          if ($cmpl_type_items != '') {
            foreach ($cmpl_type_items as $item_article) {
              foreach ($items as $item) {
                if ($item->article == $item_article) {
                  $current_item[] = $item;
                }
              }
            }
            $item = [];
            uasort($current_item,"items_sort2");
            foreach ($current_item as $item) {
              if ($item->height != '0' && $item->width != '0') $item_razmer = $item->height.'х'.$item->width.' мм.';
              if ($item->height == '0' && $item->width != '0') $item_razmer = $item->width.' мм.';
              if ($item->height != '0' && $item->width == '0') $item_razmer = $item->height.' мм.';
              if ($item->height == '0' && $item->width == '0') $item_razmer = '';
              $cmpl_price = $cmpl_price + $item->price;
        ?>  
              <div class="cmpl_item item_<?php echo $item->article; ?>">
                <div class="item_img">
                  <a class="zoom" href="/images/items/<?php echo $item->article; ?>.jpg" title="Увеличить изображение" data-lightbox="item_img" data-title="<?php echo replace_quotes($item->name); ?>">
                   <img id="img_<?php echo $item->article; ?>" src="/images/items/min/<?php echo $item->article; ?>_min.jpg" alt="<?php echo replace_quotes($item->name); ?>"><i class="fa fa-search-plus"></i>
                  </a>
                </div>
                <div class="item">
                  <input id="item_<?php echo $cmpl_type.'_'.$cmpl_article.'_'.$item->article; ?>" type="checkbox" name="<?php echo 'item_'.$item->article; ?>" value="<?php echo $item->price; ?>" checked="checked" /><span class="cmpl_item_name"><a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&article='.$item->article); ?>" target="_blank" title="Подробнее о <?php echo replace_quotes($item->name); ?>"><?php echo replace_quotes($item->name); ?></a></span>&nbsp;-&nbsp;<span class="cmpl_item_price"><?php echo number_format($item->price, 0, ".", " "); ?> руб.</span>
                  <div class="cmpl_item_razmer"><?php echo $item_razmer; ?></div>
                  <span class="item_desc"><?php echo replace_quotes($item->description); ?></span>
                  <?php // if ($item->color_back == 1 || $item->color_word == 1 || $item->address == 1 || $item->time_work == 1) { ?>
                  <div class="item_params">
                    <?php if ($item->color_back == 1) { ?>
                    <div class="item_foncolor">
                      <div class="item_color_white"><input type="radio" name="foncolor_<?php echo $item->article; ?>" value="EAEAEA" checked="checked" /></div>
                      <div class="item_color_yellow"><input type="radio" name="foncolor_<?php echo $item->article; ?>" value="E7DB00" /></div>
                      <div class="item_color_red"><input type="radio" name="foncolor_<?php echo $item->article; ?>" value="D05C5C" /></div>
                      <div class="item_color_blue"><input type="radio" name="foncolor_<?php echo $item->article; ?>" value="3454F4" /></div>
                      <div class="item_color_green"><input type="radio" name="foncolor_<?php echo $item->article; ?>" value="4FC542" /></div>
                      <div class="item_foncolor_title">цвет фона</div>
                    </div>
                    <?php } ?>
                    <?php if ($item->color_word == 1) { ?>
                    <div class="item_wordcolor">
                      <div class="item_color_white"><input type="radio" name="wordcolor_<?php echo $item->article; ?>" value="EAEAEA" /></div>
                      <div class="item_color_yellow"><input type="radio" name="wordcolor_<?php echo $item->article; ?>" value="E7DB00" /></div>
                      <div class="item_color_red"><input type="radio" name="wordcolor_<?php echo $item->article; ?>" value="D05C5C" checked="checked" /></div>
                      <div class="item_color_blue"><input type="radio" name="wordcolor_<?php echo $item->article; ?>" value="3454F4" /></div>
                      <div class="item_color_green"><input type="radio" name="wordcolor_<?php echo $item->article; ?>" value="4FC542" /></div>
                      <div class="item_wordcolor_title">цвет букв</div>
                    </div>
                    <?php } ?>
                    <?php if ($item->address == 1) { ?>
                    <div class="item_address">
                      <input type="text" name="address_<?php echo $item->article; ?>" placeholder="адрес" value="" />
                    </div>
                    <?php } ?>
                    <?php if ($item->time_work == 1) { ?>
                    <div class="item_timework">
                      <input type="text" name="timework_<?php echo $item->article; ?>" placeholder="время работы" value="" />
                    </div>
                    <?php } ?>
                  </div>
                  <div class="clear"></div>
                  <?php // } ?>                  
                </div>
              </div>
              <div class="clear"></div>
        <?php
            }
          }
        ?>
        </div>
        <div class="cmpl_price price_default">
          <a href="#" class="cmpl_zakazat cmpl_price_<?php echo $cmpl_type.'_'.$cmpl_article; ?>" title="Заказать <?php echo $cmpl_name.' ('.$cmpl_type_ru.')'; ?>" onclick="jQuery('.cmpl_items_list').remove(); jQuery('#cmpl_form').submit(); return false;"><?php echo number_format($cmpl_price, 0, '.', ' '); ?> руб.</a>
        </div>
        <input type="hidden" name="cmpl_id" value="<?php echo $cmpl_id; ?>" />
        <input type="hidden" name="complect_id" value="<?php echo $complect_id; ?>" />
        <input type="hidden" name="cmpl_article" value="<?php echo $cmpl_article; ?>" />
        <input type="hidden" name="cmpl_type" value="<?php echo $cmpl_type; ?>" />
        <input type="hidden" name="cmpl_price" value="<?php echo $cmpl_price; ?>" />
        <input type="hidden" name="cmpl_formsend" value="Отправить" />
      </div>
      <div class="clear"></div>
    </form>
  </div>

  <div class="cmpl_items_list">
    <h3 class="cmpl_list_header">Список комплектующих</h3>
    <?php 
      $item_catid = 0;
      $flag = 0;
      $item_name = '';
    ?>
    <?php foreach ($items as $item) { ?>
      <?php
        if ($item->height != '0' && $item->width != '0') $item_razmer = $item->height.'х'.$item->width.' мм.';
        if ($item->height == '0' && $item->width != '0') $item_razmer = $item->width.' мм.';
        if ($item->height != '0' && $item->width == '0') $item_razmer = $item->height.' мм.';
        if ($item->height == '0' && $item->width == '0') $item_razmer = '';
        
        $complect_catid = explode(",", $item->complect_catid);
      ?>
      <?php if ($item->state == 1 && (in_array($cmpl_catid,$complect_catid) || in_array('1',$complect_catid) || count($complect) == 0) ) { ?>
      <?php if ($item_name != $item->name) { ?>
        <?php if ($item_catid != $item->catid) { ?>
          <?php
            $item_catid = $item->catid;

            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query 
              ->select('*')
              ->from($db->quoteName('#__catcomplects_items_categories'))
              ->where($db->quoteName('id').'='.$item->catid);
            $db->setQuery($query);
            $catarr = $db->loadObject();
              
            $item_catname = $catarr->name;
            if ($flag == 1) { 
              echo '</div><div class="clear"></div>';
            }
            $flag = 1;
            echo '<div class="cmpl_group_title">'.$item_catname.'</div><div class="cmpl_group">';
          ?>
        <?php } ?>
          
          <div class="cmpl_items">
            <div class="cmpl_item">
              <input id="item_list_<?php echo $item->article; ?>" class="cmpladd_checked_item" type="checkbox" name="itemlist_<?php echo $item->article; ?>" value="<?php echo $item->price; ?>" />
              <label class="cmpl_item_name" for="item_list_<?php echo $item->article; ?>"><a href="<?php echo JRoute::_('index.php?option=com_catcomplects&view=items&article='.$item->article); ?>" target="_blank" title="Подробнее о <?php echo replace_quotes($item->name); ?>"><?php echo replace_quotes($item->name); ?></a></label>&nbsp;&nbsp;<span class="cmpl_item_price"><?php echo number_format($item->price, 0, '.', ' '); ?> руб.</span><i class="fa fa-info-circle"></i>
            </div>
            <div class="cmpl_item_desc cmpl_itemdesc_item_<?php echo $item->article; ?>"><?php echo replace_quotes($item->description); ?></div>
            <?php // if ($item->color_back == 1 || $item->color_word == 1 || $item->address == 1 || $item->time_work == 1) { ?>
            <div class="item_params">
              <?php if ($item->color_back == 1) { ?>
              <div class="item_foncolor">
                <div class="item_color_white"><input type="radio" name="foncolor_<?php echo $item->article; ?>" value="EAEAEA" checked="checked" /></div>
                <div class="item_color_yellow"><input type="radio" name="foncolor_<?php echo $item->article; ?>" value="E7DB00" /></div>
                <div class="item_color_red"><input type="radio" name="foncolor_<?php echo $item->article; ?>" value="D05C5C" /></div>
                <div class="item_color_blue"><input type="radio" name="foncolor_<?php echo $item->article; ?>" value="3454F4" /></div>
                <div class="item_color_green"><input type="radio" name="foncolor_<?php echo $item->article; ?>" value="4FC542" /></div>
                <div class="item_foncolor_title">цвет фона</div>
              </div>
              <?php } ?>
              <?php if ($item->color_word == 1) { ?>
              <div class="item_wordcolor">
                <div class="item_color_white"><input type="radio" name="wordcolor_<?php echo $item->article; ?>" value="EAEAEA" /></div>
                <div class="item_color_yellow"><input type="radio" name="wordcolor_<?php echo $item->article; ?>" value="E7DB00" /></div>
                <div class="item_color_red"><input type="radio" name="wordcolor_<?php echo $item->article; ?>" value="D05C5C" checked="checked" /></div>
                <div class="item_color_blue"><input type="radio" name="wordcolor_<?php echo $item->article; ?>" value="3454F4" /></div>
                <div class="item_color_green"><input type="radio" name="wordcolor_<?php echo $item->article; ?>" value="4FC542" /></div>
                <div class="item_wordcolor_title">цвет букв</div>
              </div>
              <?php } ?>
              <?php if ($item->address == 1) { ?>
              <div class="item_address">
                <input type="text" name="address_<?php echo $item->article; ?>" placeholder="адрес" value="" />
              </div>
              <?php } ?>
              <?php if ($item->time_work == 1) { ?>
              <div class="item_timework">
                <input type="text" name="timework_<?php echo $item->article; ?>" placeholder="время работы" value="" />
              </div>
              <?php } ?>
            </div>
            <div class="clear"></div>
            <?php // } ?>
          </div>
      <?php } ?>
      <?php $item_name = $item->name; ?>
      <?php } ?>
    <?php } ?>
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
</div>
<div class="clear"></div>
