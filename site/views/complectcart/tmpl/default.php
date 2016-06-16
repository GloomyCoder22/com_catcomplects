<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
//$app = JFactory::getApplication();
//$menu = $app->getMenu();
//$Itemid	= $menu->getActive()->id;

$html_form = '';
$html_table = '';
$items = $this->item;
// var_dump($items);
$complect_id = $this->complect_id;
$item_itogo = 0;

$edit_complect = '';
if ($complect_id != '0') {
  $edit_complect = '<div class="edit_complect" style="margin: 15px 0 0 0; text-align: center;">
      <a class="btn btn-primary" href="'.JRoute::_('index.php?option=com_catcomplects&view=complectadd&cmpl_id='.(int) $complect_id.'&Itemid=158').'" title="Изменить состав комплекта">изменить состав комплекта</a>
    </div>';
}

$html_table .= '
<div id="cmpl_zakaz">
<table>
  <tbody>
    <tr style="background-color: #D7D7D7;">
      <th width="15%" style="text-align: center; font-weight: bold; padding: 12px 3px; background-color: #D7D7D7; border-right: 1px solid #ffffff;">Изображение</th>
      <th width="30%" style="text-align: center; font-weight: bold; padding: 12px 3px; background-color: #D7D7D7; border-right: 1px solid #ffffff;">Наименование</th>
      <th width="20%" style="text-align: center; font-weight: bold; padding: 12px 3px; background-color: #D7D7D7; border-right: 1px solid #ffffff;">Доп. параметры</th>
      <th width="10%" style="text-align: center; font-weight: bold; padding: 12px 3px; background-color: #D7D7D7; border-right: 1px solid #ffffff;">Цена</th>
      <th width="10%" style="text-align: center; font-weight: bold; padding: 12px 3px; background-color: #D7D7D7; border-right: 1px solid #ffffff;">Кол- во</th>
      <th width="10%" style="text-align: center; font-weight: bold; padding: 12px 3px; background-color: #D7D7D7; border-right: 1px solid #ffffff;">Сумма</th>
    </tr>';

foreach ($items as $item) {
  $item_article = $item->article;
  $item_article_color = $item->article;
  $item_count = 1;
  $item_summa = $item->price * $item_count;
  $item_itogo = $item_itogo + $item_summa;
  
  $color_cur = '';
  $img_yesno_we = $img_yesno_oe = $img_yesno_rd = $img_yesno_pk = $img_yesno_be = $img_yesno_gn = $img_yesno_bk = $img_yesno_bn = 'img_no';

  $imgsrc = 'images'.DIRECTORY_SEPARATOR.'items'.DIRECTORY_SEPARATOR;
  $imgsrc_min = 'images'.DIRECTORY_SEPARATOR.'items'.DIRECTORY_SEPARATOR.'min'.DIRECTORY_SEPARATOR;
  $imgfname = $item_article.'.jpg';
  $imgfname_min = $item_article.'_min.jpg';
  
  //echo $imgsrc_min.$imgfname_min;
  if  (!file_exists($imgsrc_min.$imgfname_min)) { 
    $imgfname = 'noimage.jpg';
    $imgfname_min = 'noimage.jpg';
  }
  
  if ($item->height != '0' && $item->width != '0') $item_razmer = $item->height.'х'.$item->width.' мм.';
  if ($item->height == '0' && $item->width != '0') $item_razmer = $item->width.' мм.';
  if ($item->height != '0' && $item->width == '0') $item_razmer = $item->height.' мм.';
  if ($item->height == '0' && $item->width == '0') $item_razmer = '';

  $item_article_arr = explode("-", $item->article);
  if (isset($item_article_arr[1])) {
    $item_article = $item_article_arr[0];
  }

  $item_color_arr = explode(",", $item->color);
  if (isset($item_color_arr[0])) {
    if ($item_color_arr[0] != '') {
      foreach ($item_color_arr as $key => $value) {
        if ($value == 'WE') $img_yesno_we = 'img_yes';
        if ($value == 'OE') $img_yesno_oe = 'img_yes';
        if ($value == 'RD') $img_yesno_rd = 'img_yes';
        if ($value == 'PK') $img_yesno_pk = 'img_yes';
        if ($value == 'BE') $img_yesno_be = 'img_yes';
        if ($value == 'GN') $img_yesno_gn = 'img_yes';
        if ($value == 'BK') $img_yesno_bk = 'img_yes';
        if ($value == 'BN') $img_yesno_bn = 'img_yes';
      }
    }
  }
    
  $html_table .= '
  <tr id="itemtr_'.$item_article_color.'">
    <td width="15%" style="text-align: center; padding: 12px 3px; border-right: 1px solid #ffffff;">
      <a class="zoom" style="border: none;" href="http://www.vyveski.me/'.$imgsrc.$imgfname.'" title="Увеличить изображение" data-lightbox="item_img" data-title="'.replace_quotes($item->name).'"><img style="width: auto; height: auto; margin: 0; padding: 0;" src="http://www.vyveski.me/'.$imgsrc_min.$imgfname_min.'" alt="'.replace_quotes($item->name).'" /></a>
    </td>
    <td width="30%" style="text-align: left; padding: 12px 3px; border-right: 1px solid #ffffff;">'.replace_quotes($item->name).'<span style="padding: 0 0 0 5px; color: #A6A6A6; font-size: 12px; font-style: italic;">'.$item_razmer.' <span class="item_article">(артикул: '.$item_article.')</span></span>
      <div style="font-size: 12px; padding: 5px 20px 0;">'.replace_quotes($item->description).'</div>
    </td>
    <td width="20%" style="text-align: left; padding: 12px 3px; border-right: 1px solid #ffffff;">
      <div class="item_params">';
  if ($item->foncolor != 'none') {
    $param_checked = '';
    $html_table .= '<div class="item_foncolor" style="border-right: none !important;">';
    if ($item->foncolor == 'E6E6E6' || $item->foncolor == 'WE') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_white '.$img_yesno_we.'" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #E6E6E6;" data-imgcolor="'.$item_article.'-WE.jpg"><input type="radio" name="foncolor_'.$item_article_color.'" value="E6E6E6" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->foncolor == 'FF5601' || $item->foncolor == 'OE') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_orange '.$img_yesno_rd.'" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #FF5601;" data-imgcolor="'.$item_article.'-OE.jpg"><input type="radio" name="foncolor_'.$item_article_color.'" value="FF5601" '.$param_checked.' /></div>';    
    $param_checked = '';
    if ($item->foncolor == '9A1415' || $item->foncolor == 'RD') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_red '.$img_yesno_rd.'" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #9A1415;" data-imgcolor="'.$item_article.'-RD.jpg"><input type="radio" name="foncolor_'.$item_article_color.'" value="9A1415" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->foncolor == 'AC2861' || $item->foncolor == 'PK') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_pink '.$img_yesno_pk.'" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #AC2861;" data-imgcolor="'.$item_article.'-PK.jpg"><input type="radio" name="foncolor_'.$item_article_color.'" value="AC2861" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->foncolor == '1D5AB5' || $item->foncolor == 'BE') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_blue '.$img_yesno_be.'" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #1D5AB5;" data-imgcolor="'.$item_article.'-BE.jpg"><input type="radio" name="foncolor_'.$item_article_color.'" value="1D5AB5" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->foncolor == '166E3B' || $item->foncolor == 'GN') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_green '.$img_yesno_gn.'" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #166E3B;" data-imgcolor="'.$item_article.'-GN.jpg"><input type="radio" name="foncolor_'.$item_article_color.'" value="166E3B" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->foncolor == '000000' || $item->foncolor == 'BK') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_black '.$img_yesno_bk.'" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #000000;" data-imgcolor="'.$item_article.'-BK.jpg"><input type="radio" name="foncolor_'.$item_article_color.'" value="000000" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->foncolor == '5F3112' || $item->foncolor == 'BN') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_brown '.$img_yesno_bn.'" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #5F3112;" data-imgcolor="'.$item_article.'-BN.jpg"><input type="radio" name="foncolor_'.$item_article_color.'" value="5F3112" '.$param_checked.' /></div>';
    $html_table .= '<div class="item_foncolor_title">цвет фона</div></div>';
  }
  if ($item->wordcolor != 'none') {
    $param_checked = '';
    $html_table .= '<div class="item_wordcolor" style="border-right: none !important;">';
    if ($item->wordcolor == 'E6E6E6') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_white" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #E6E6E6;"><input type="radio" name="wordcolor_'.$item_article_color.'" value="E6E6E6" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->wordcolor == 'FF5601') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_orange" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #FF5601;"><input type="radio" name="wordcolor_'.$item_article_color.'" value="FF5601" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->wordcolor == '9A1415') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_red" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #9A1415;"><input type="radio" name="wordcolor_'.$item_article_color.'" value="9A1415" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->wordcolor == 'AC2861') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_pink" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #AC2861;"><input type="radio" name="wordcolor_'.$item_article_color.'" value="AC2861" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->wordcolor == '1D5AB5') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_blue" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #1D5AB5;"><input type="radio" name="wordcolor_'.$item_article_color.'" value="1D5AB5" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->wordcolor == '166E3B') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_green" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #166E3B;"><input type="radio" name="wordcolor_'.$item_article_color.'" value="166E3B" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->wordcolor == '000000') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_black" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #000000;"><input type="radio" name="wordcolor_'.$item_article_color.'" value="000000" '.$param_checked.' /></div>';
    $param_checked = '';
    if ($item->wordcolor == '5F3112') $param_checked = 'checked="checked"';
    $html_table .= '<div class="item_color_brown" style="display: inline-block; width: 18px; height: 18px; margin: 0 5px 0 0; background-color: #5F3112;"><input type="radio" name="wordcolor_'.$item_article_color.'" value="5F3112" '.$param_checked.' /></div>';
    $html_table .= '<div class="item_wordcolor_title">цвет букв</div></div>';
  }
  if ($item->item_address != 'none') {
    $html_table .= '<div><input class="address_inp" style="width: 140px !important; height: 16px !important; margin: 5px 0 0 0 !important; line-height: 14px; font-size: 14px;" type="text" name="address_'.$item_article_color.'" placeholder="адрес" value="'.$item->item_address.'" /></div>';
  }
  if ($item->item_timework != 'none') {
    $html_table .= '<div><input class="timework_inp" style="width: 140px !important; height: 16px !important; margin: 5px 0 0 0 !important; line-height: 14px; font-size: 14px;" type="text" name="timework_'.$item_article_color.'" placeholder="время работы" value="'.$item->item_timework.'" /></div>';
  }

  $html_table .= '
      </div>
    </td>
    <td width="10%" style="text-align: left; padding: 12px 3px; border-right: 1px solid #ffffff;">
      '.number_format($item->price, 0, '.', ' ').' руб.
      <input id="itemprice_'.$item_article_color.'" type="hidden" name="item_price" value="'.$item->price.'">
    </td>
    <td class="item_count" width="10%" style="text-align: center; padding: 12px 3px; border-right: 1px solid #ffffff;">
      <input class="count_minus" type="button" name="countminus_'.$item_article_color.'" value="-" /><input id="'.$item_article_color.'" class="count" style="width: 20px; height: 16px; margin: 0 10px; font-size: 14px; text-align: center;" type="text" name="count_'.$item_article_color.'" value="'.$item_count.'" readonly="readonly" /><input class="count_plus" type="button" name="countplus_'.$item_article_color.'" value="+" />
      <div class="item_del" style="padding: 10px 0 0 0;">
        <a href="#" style="border: none; font-size: 20px; font-weight: bold; color: #DC458C; text-decoration: none; font-family: Verdana, Arial;" onclick="vsCartDel(\''.$item_article_color.'\'); jQuery(\'#itemtr_'.$item_article_color.'\').remove(); location.reload(true); return false;" title="Удалить из корзины">X</a>
      </div>
    </td>
    <td width="10%" style="text-align: right; padding: 12px 3px; border-right: 1px solid #ffffff;">
      <div>'.number_format($item_summa, 0, '.', ' ').' руб.</div>
      <input id="itemsumma_'.$item_article_color.'" type="hidden" name="item_summa" value="'.$item_summa.'">
    </td>
  </tr>';
}

$html_table .= '
  </tbody>
</table>
'.$edit_complect.'
  <div class="item_itogo" style="font-size: 16px; font-weight: bold; text-align: right; margin: 20px 0 0 0;">
    Итого: '.number_format($item_itogo, 0, '.', ' ').' руб.
  </div>
  <input id="item_price_itogo" type="hidden" name="item_price_itogo" value="'.$item_itogo.'">
  <div style="font-size: 12px; text-align: right; margin: 10px 0;">Бесплатная доставка по всей России при заказе от 2000 руб.</div>
</div>';

$html_form .= '
<div id="formsend_bottom">
<div id="form_send_error"></div>
<h2>Укажите контактные данные для отправки заявки нашему менеджеру.</h2>
<form id="formsend" method="POST">
  <div class="cmpl_register user_info">
    <fieldset class="checkout_otstup">
      <div class="control-group">
        <label class="control-label">* Имя</label>
        <span class="input">
          <input type="text" name="fio_name" id="fio_name" value="" class="inputbox">
        </span>
      </div>  
      <div class="control-group">
        <label class="control-label">* E-mail</label>
				<span class="input">
          <input type="text" name="email" id="email" value="" class="inputbox">
				</span>
			</div>
      <div class="control-group">
				<label class="control-label">Телефон</label>
				<span class="input">
          <input type="text" name="phone" id="phone" value="" class="inputbox">
				</span>
			</div>       
      <div class="control-group">
        <label class="control-label">Промокод</label>
				<span class="input">
          <input type="text" name="promocode" id="promocode" maxlength="9" value="" class="inputbox">
          <span class="promo"></span>
				</span>
			</div>
      <div class="control-group">
        <label class="control-label">Комментарий</label>
				<span class="input">
          <textarea rows="5" cols="32" name="comments" id="comments" class="inputbox"></textarea>
				</span>
			</div>
    </fieldset>
  </div>
  <button id="cmpl_submit" class="btn btn-success btn-block" name="submit" type="submit" onclick="yaCounter29661885.reachGoal(\'FinishOrder\', '.$item_itogo.'); return true;">ОТПРАВИТЬ</button>
</form>
</div>
<div class="clear"></div>';



  echo '<h1>Оформление заказа</h1>';
  echo '<br />';
  
  $html_table = str_replace('&nbsp;',' ',$html_table);
  //$html_table = str_replace('<i class="fa fa-rub" style="padding: 0 0 0 5px;"></i>',' р.',$html_table);  
  echo $html_table;
  echo $html_form;
