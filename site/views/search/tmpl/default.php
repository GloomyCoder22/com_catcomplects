<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$items = $this->items;
$item_count = 1;
$row_cnt = 1;
?>
<div id="search">
  <h1>Поиск продукции в каталоге</h1>
  
  <form id="searchForm" method="GET" action="http://www.vyveski.me/search">
    <input  class="inputbox" type="text" name="q" value="" placeholder="артикул / наименование" />
    <button class="btn btn-success" type="submit">ПОИСК</button>
  </form>
</div>
<div class="clear"></div>