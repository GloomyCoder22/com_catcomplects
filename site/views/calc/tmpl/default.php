<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$CanonicalLink = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$doc = JFactory::getDocument();
$doc->addHeadLink($CanonicalLink, 'canonical');
?>
<h1>Расчет стоимости объемных букв</h1>
<div class="block-text">
  <p>Для расчета стоимости изготовления световых объемных букв Вы можете восользоваться нашим онлайн-калькулятором, с помощью которого можно быстро рассчитать примерную стоимость световых объемных букв.</p>
</div>
<br />
<div id="bis_calcbs">
  <div class="bis_calc_title">Задайте высоту и шрифт букв:</div>
  <div id="bis_calc_nzd" data-word-type="normal">
    <div class="bis_calc_normal bis_calc_setshift" data-word-type="normal"><span>без засечек</span></div>
    <div class="bis_calc_zasech" data-word-type="zasech"><span>с засечками</span></div>
    <div class="bis_calc_decor" data-word-type="decor"><span>декоративный</span></div>
  </div>
  <span id="bis_calcbs_y_top">60 cм</span>
  <div id="bis_calcbs_y">
    <div id="bis_calcbs_y_ui"></div>
    <div class="bis_calc_textcm"><input id="bis_calcbs_y_point_ui" type="text" disabled />см.</div>
  </div>
  <span id="bis_calcbs_y_bottom">30 cм</span>
  <div id="bis_calcbs_imagebox">
    <img src="/images/calc/normal2.jpg" />
  </div>
  <div class="clear"></div>
  <div class="bis_calc_word_wrap">
    <div>Введите слова:</div>
    <input type="text" name="bis_calc_word" size="34" id="bis_calc_word" value="слова для вывески" onblur="if(this.value=='') this.value='слова для вывески';" onfocus="if(this.value=='слова для вывески') this.value='';"><span id="bis_calc_word_cnt" data-word-count="0"> 0 букв</span>
  </div>
</div>
<div class="clear"></div>
<div id="bis_itogo">
  <div><span class="bis_itogo_ptext">Примерная стоимость вывески: </span><span class="bis_itogo_price">0 руб.</span></div>
  <div class="bis_infocena">Точную стоимость Вы можете узнать у наших менеджеров оставив заявку на <a class="href_zvonok href_dashed modal" href="/forma-zakaza-obratnogo-zvonka" title="Заказать обратный звонок">обратный звонок</a> или позвонив к нам в офис по тел.: 8 800 222 6232 (бесплатные звонки по России).</div>
</div>