<?php

/**
 * @version     1.0.0
 * @package     com_catcomplects
 * @copyright   © 2015. Demin Artem. Все права защищены.
 * @license     GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
 * @author      Demin Artem <ademin1982@gmail.com> - http://
 */
defined('_JEXEC') or die;

global $color_hex;
$color_hex = array();
$color_hex['WE'] = 'E6E6E6';
$color_hex['OE'] = 'ff5601';
$color_hex['RD'] = '9A1415';
$color_hex['PK'] = 'AC2861';
$color_hex['BE'] = '1D5AB5';
$color_hex['GN'] = '166E3B';
$color_hex['BK'] = '000000';
$color_hex['BN'] = '5F3112';

  // Получить все комплекты
  function getComplects() {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query 
        ->select('*')
        ->from($db->quoteName('#__catcomplects_complects'))
        ->where($db->quoteName('state').'=1')
        ->order($db->quoteName('ordering'));
    $db->setQuery($query);

    return $db->loadObjectlist();
  }

  // Получить все комплектующие комплекта
  function getItemsComplect($items) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query 
        ->select('*')
        ->from($db->quoteName('#__catcomplects_items'))
        ->where($db->quoteName('article').' IN('.$items.') AND '.$db->quoteName('state').'=1')
        ->order($db->quoteName('price').' DESC');
    $db->setQuery($query);

    return $db->loadObjectlist();
  }
  
  // Получить все комплектующие
  function getItems() {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query 
        ->select('*')
        ->from($db->quoteName('#__catcomplects_items'))
        ->where($db->quoteName('state').'=1')
        ->order('catid, name, price');
    $db->setQuery($query);

    return $db->loadObjectlist();
  }

  // Получить выбраный комплект
  function getComplect($cmpl_id) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query 
        ->select('*')
        ->from($db->quoteName('#__catcomplects_complects'))
        ->where($db->quoteName('id').'='.$cmpl_id);
    $db->setQuery($query);

    //return $db->loadResult();
    //return $db->loadRow();
    //return $db->loadAssoc();
    return $db->loadObject();
  }

  // Получить выбранную комплектующую
  function getItem($item_id) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query 
        ->select('*')
        ->from($db->quoteName('#__catcomplects_items'))
        ->where($db->quoteName('article').'='.$db->quote($item_id));
    $db->setQuery($query);

    return $db->loadObject();
  }
  
  // Получить выбранную категорию
  function getCat($cat_id) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query 
        ->select('*')
        ->from($db->quoteName('#__catcomplects_items_categories'))
        ->where($db->quoteName('id').'='.$cat_id);
    $db->setQuery($query);

    return $db->loadObject();
  }
  
    
  // Создание thumbs картинок
  function image_thumbs ($width, $height, $img_path, $img_thumb_path) {
    if (!file_exists(JPATH_SITE . '/images/items/thumbs/' . $img_thumb_path)) {
      $image = new JImage(JPATH_SITE . '/images/items/' . $img_path);
      // $image->resize($width, $height, false, JImage::SCALE_OUTSIDE);
      $image->resize($width, $height, false, JImage::SCALE_INSIDE);
      // $image->toFile(JPATH_SITE . '/images/items/thumbs/' . $img_thumb_path, IMAGETYPE_JPEG, array('quality'=>85));
      $image->toFile(JPATH_SITE . '/images/items/thumbs/' . $img_thumb_path, IMAGETYPE_JPEG);
    
      return true;
    } else {
      return false;
    }
  }
  
  // Замена кавычек на "елочки"
  function replace_quotes($text) {
    $search = array('<', '>', '&', ' - ', "\n");
    $replace = array('<', '>', '&amp;', '&nbsp;&mdash; ', '<br>');
    $count = substr_count($text, '"');
    $new = str_replace($search, $replace, stripslashes($text));
    for ($i=0; $i<($count/2); $i++) {
      $new = preg_replace('/\"([^\"]+)\"/', '&laquo;$1&raquo;', $new);
    }
    
    return $new;
  }
  
  // Объект в массив
  function objectToArray( $object ) { 
    if( !is_object($object) && !is_array($object) ) { 
      return $object; 
    } 
    if( is_object($object) ) { 
      $object = get_object_vars($object); 
    } 
    return array_map('objectToArray', $object); 
  } 

  // Сортировка массива по двум параметрам с помощью
  function items_sort_np($a, $b) {
    $array = array('name'=>'ask', 'price'=>'ask'); // поля по которым сортировать
	  $res = 0;
    foreach( $array as $k=>$v ){
      if( $a->$k == $b->$k ) continue;

      $res = ( $a->$k < $b->$k ) ? -1 : 1;
      if ($v=='desc') $res = -$res;
      break;
    }
    return $res;
  }

  // Сортировка объекта items от меньшего к большему
  function items_sort1($f1,$f2) {
    if($f1->price < $f2->price) return -1;
    elseif($f1->price > $f2->price) return 1;
    else return 0;
  }

  // Сортировка объекта items от большего к меньшему
  function items_sort2($f1,$f2) {
    if($f1->price > $f2->price) return -1;
    elseif($f1->price < $f2->price) return 1;
    else return 0;
  }
   
  // Вывод комплектующих в комплекте
  function complect_sostav ($cmpl_items, $items, $cmpl_id, $mode = 0) {
    $cmpl_price = 0;
    $catid = '0';
    $current_item = [];

    foreach ($cmpl_items as $item_article) {
      foreach ($items as $item) {
        if ($item->article == $item_article) {
          $current_item[] = $item;
        }
      }
    }
    $item = [];
    // uasort($current_item,"items_sort2");
    $cnt = 0;
    $cmpl_html = '';    
    if ($mode == 1) {
      foreach ($current_item as $item) {
          if ($item->height != '0' && $item->width != '0') $item_razmer = $item->height.'х'.$item->width.' мм.';
          if ($item->height == '0' && $item->width != '0') $item_razmer = $item->width.' мм.';
          if ($item->height != '0' && $item->width == '0') $item_razmer = $item->height.' мм.';
          if ($item->height == '0' && $item->width == '0') $item_razmer = '';

          $cmpl_price = $cmpl_price + $item->price;
          echo '<div class="item_img">'
              .'  <a class="zoom" href="/images/items/'.$item->article.'.jpg" title="Увеличить изображение">'
              .'   <img id="img_'.$item->article.'" src="/images/items/min/'.$item->article.'_min.jpg" alt="'.replace_quotes($item->name).'"><i class="fa fa-search-plus"></i>'
              .'  </a>'
              .'</div>'
              .'<div class="cmpl_item">'
              .'  <input id="item_'.$cmpl_id.'_'.$item->article.'" type="checkbox" name="'.$item->article.'" value="'.$item->price.'" checked="checked" disabled="disabled" /><label class="cmpl_item_name" for="item_'.$cmpl_id.'_'.$item->article.'">'.replace_quotes($item->name).'</label><span class="cmpl_item_razmer">'.$item_razmer.' (артикул: '.$item->article.')</span>&nbsp;-&nbsp;<span class="cmpl_item_price">'.number_format($item->price, 0, ".", " ").' руб.</span>'
              .'  <span class="item_desc">'.replace_quotes($item->description).'</span>'
              .'</div>'
              .'<div class="clear"></div>';
      }
    } else {
      foreach ($current_item as $item) {    
        if ($item->height != '0' && $item->width != '0') $item_razmer = $item->height.'х'.$item->width.' мм.';
        if ($item->height == '0' && $item->width != '0') $item_razmer = $item->width.' мм.';
        if ($item->height != '0' && $item->width == '0') $item_razmer = $item->height.' мм.';
        if ($item->height == '0' && $item->width == '0') $item_razmer = '';
        
        $cmpl_price = $cmpl_price + $item->price;
        
        $cat_arr = getAliasItemcat("id", $item->catid);
        $menu_arr = getItemid("alias", $cat_arr[1]);
        $itemid = $menu_arr['0'];
        $itemurl = JRoute::_("index.php?option=com_catcomplects&view=items&article=".$item->article."&Itemid=".$itemid);
        if ($cnt == 0) {
          $cmpl_html .= '<div class="cmpl_item">'
              .'  <div>'
              .'    <div class="cmpl_item_first">'
              .'      <input id="item_'.$cmpl_id.'_'.$item->article.'" type="checkbox" name="item_'.$item->article.'" value="'.$item->price.'" checked="checked" />'
              .'      <label class="cmpl_item_name">'
              .'        <a href="'.$itemurl.'" title="'.replace_quotes($item->name).'">'.replace_quotes($item->name).'</a>'
              .'      </label>'
              .'    </div>'
              .'  </div>'
              .'<div class="cmpl_img">'
              .'  <a class="zoom" href="/images/items/'.$item->article.'.jpg" title="Увеличить изображение" data-lightbox="group:item_img_'.$cmpl_id.'" data-title="'.replace_quotes($item->name).'">'
              .'    <img src="/images/items/min/'.$item->article.'_min.jpg" width="220" height="166" alt="'.replace_quotes($item->name).'" /><i class="fa fa-search-plus"></i>'
              .'  </a>'
              .'    <span class="cmpl_item_price">'.number_format($item->price, 0, ".", " ").' руб.</span>'
              .'</div>'
              .'  <span class="item_desc"><i class="fa fa-info-circle"></i><span class="cmpl_item_razmer">'.$item_razmer.' </span>'.replace_quotes($item->description).'</span>'
              .'</div>'
              .'<div class="v_sostav_vhodit"></div>';
        } else {
          $cmpl_html .= '<div class="cmpl_item">'
              .'  <input id="item_'.$cmpl_id.'_'.$item->article.'" type="checkbox" name="item_'.$item->article.'" value="'.$item->price.'" checked="checked" />'
              .'  <label class="cmpl_item_name">'
              .'    <a href="'.$itemurl.'" title="'.replace_quotes($item->name).'">'.replace_quotes($item->name).'</a>'
              .'  </label><br />'
              .'  <div class="cmpl_item_img">'
              .'    <a class="zoom nohref" href="/images/items/'.$item->article.'.jpg" data-lightbox="group:item_img_'.$cmpl_id.'" data-title="'.replace_quotes($item->name).'" title="Показать изображение">'
              .'      <img src="/images/items/min/'.$item->article.'_min.jpg" alt="'.replace_quotes($item->name).'" /><i class="fa fa-search-plus"></i>'
              .'    </a>'
              .'    <span class="cmpl_item_price">'.number_format($item->price, 0, ".", " ").' руб.</span>'
              .'  </div>'
              .'  <span class="item_desc"><i class="fa fa-info-circle"></i><span class="cmpl_item_razmer">'.$item_razmer.' </span>'.replace_quotes($item->description).'</span>'
              .'</div>';        
        }
        $cnt = $cnt + 1;
      }
      echo $cmpl_html;
    }
    
    return $cmpl_price; 
  }


  // Форма заказа
  function window_send ($type, $complect_article) {
    $html = '<!--noindex-->
             <div id="window_send_'.$complect_article.'_'.$type.'" class="cmpl_windowsend">
              <div class="cmpl_formtitle">Отправить заявку нашему менеджеру для обратного звонка</div>
              <div class="cmpl_form">
                <input name="cmpl_form_name" class="placeholder" required placeholder="Ваше имя" title="Введите Ваше имя" type="text" autofocus /><br />
                <input name="cmpl_form_tel" class="placeholder" required placeholder="Контактный телефон" title="Введите телефон для связи с Вами" type="text" />
                <div class="cmpl_send">
                  <div class="cmpl_send_desc">я хочу этот комлект</div>
                  <a href="#" class="cmpl_sendzakaz" title="Отправить заявку" onclick="sendzakaz(); return false">Позвоните мне</a>
                </div>
              </div>
              <a href="#" class="cmpl_windowclose" onclick="windowclose(); return false" title="Закрыть"></a>
            </div>
            <!--/noindex-->';
    echo $html;
  }
