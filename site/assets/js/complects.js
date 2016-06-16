// проверка на присутствие файла
/*
jQuery.ajax({
  url:'http://wargot.com/big_image.png',
  type:'HEAD',
  error:
    function(){
    // картинка отсутствует
  },
  success:
    function(){
    // картинка на месте
  }
});
*/

/*
function cmpl_zakazat (article, type) {
  var img = jQuery('#complect_'+article+' .cmpl_img img').attr('src');
  var title_cmpl = jQuery('#complect_'+article+' .cmpl_box .cmpl_header h2').html();
  var desc = jQuery('#complect_'+article+' .cmpl_box .cmpl_header .cmpl_desc').html();
  var title_type = jQuery('#complect_'+article+' .cmpl_type .cmpl_'+type+' h3').html();
  var razmer = jQuery('#complect_'+article+' .cmpl_type .cmpl_'+type+' cmpl_razmer').html();
  var sostav = jQuery('#complect_'+article+' .cmpl_type .cmpl_'+type+' cmpl_sostav').html();
  var price = jQuery('#complect_'+article+' .cmpl_type .cmpl_'+type+' cmpl_price a').html();

  jQuery('.cmpl_windowsend').hide();
  jQuery('#window_send_'+article+'_'+type).show(500);
}

function windowclose () {
  jQuery('.cmpl_windowsend').hide();
}
*/

function sendzakaz() {
  jQuery('.cmpl_windowsend').hide();
}

function price_update() {
  var cmpl_price = 0;
  var cmpl_price_text = '0';
  // Перебираем элементы формы: input:checkbox:checked (отмеченные флажки)
  jQuery('.cmpl_sostav input:checkbox:checked').each(function(nf, inputData) {
    // cmpl_price = parseInt(cmpl_price) + parseInt(jQuery(inputData).attr('value'));
    cmpl_price = parseInt(cmpl_price) + parseInt(jQuery(inputData).val());
  });
  cmpl_price_text = number_format(cmpl_price, {decimals: 0, thousands_sep: " ", dec_point: ","});
    
  jQuery('input[name="cmpl_price"]').val(cmpl_price);
  // jQuery('input[name="cmpl_price"]').attr("value",cmpl_price);
  jQuery('.cmpl_zakazat').html(cmpl_price_text+' руб.');
}

// Удалить комплектующую из списка и снять галочку
function item_del(item_article) {
  var item_input;
  if (item_article != '0') {
    item_input = jQuery('#complect_add .cmpl_sostav input[name="item_'+item_article+'"]');
  } else {
    item_input = jQuery('#complect_add .cmpl_sostav input:checkbox:checked');
  }

  item_input.change(function(){ 
    var article = jQuery(this).attr('name');
    var item_arr = article.split('_');
    var item_article = item_arr[1];
        
    jQuery('.cmpl_sostav .item_'+item_article).remove();
    jQuery('.cmpl_items_list input[name="itemlist_'+item_article+'"]').prop("checked", false);
    
    price_update();
  });
}

jQuery(document).ready(function() {
  item_del('0');

  // Обновление тултипа состава комплекта у комплектующих
  jQuery('#complects .cmpl_sostav .cmpl_item').mousemove(function (e) {
    var item_desc = jQuery(this).next('.cmpl_item_desc');
    
    if (item_desc.html() != '') {
      // положение элемента
      var offset = jQuery(this).parent('.cmpl_sostav').offset();
      var relativeX = (e.pageX - offset.left) + 40;
      var relativeY = (e.pageY - offset.top) - 20;
      item_desc.css({
        "left" : relativeX+'px',
        "top" : relativeY+'px'
      })
      .show();
    } else {
      jQuery(this).css("cursor",'default');
    }
  }).mouseout(function () {
    var item_desc = jQuery(this).next('.cmpl_item_desc');
    
    item_desc.hide()
      .css({
        "top" : 0,
        "left" : 0
      });
  });

  jQuery('#complects .cmpl_zakazat').click(function(){
    jQuery(jQuery(this).parents('form')).attr('action','/cart');
    jQuery(jQuery(this).parents('form')).submit();
  });

  jQuery('#complect .cmpl_zakazat').click(function(){
    jQuery(jQuery(this).parents('form')).attr('action','/cart');
    jQuery(jQuery(this).parents('form')).submit();
  });
  
  // Развернуть / свернуть комплект
  jQuery('#complects .cmpl_header').click(function () {
    jQuery(this).next('.cmpl_type').slideToggle();
  });
  
  // Фиксирование цены
  var $menu = jQuery("#complect_add .cmpl_price");
  jQuery(window).scroll(function(){
    if ( jQuery(this).scrollTop() > 700 && $menu.hasClass("price_default") ){
      $menu.fadeOut('fast',function(){
        jQuery(this).removeClass("price_default")
          .addClass("price_fixed")
          .fadeIn('fast');
      });
    } else if(jQuery(this).scrollTop() <= 700 && $menu.hasClass("price_fixed")) {
      $menu.fadeOut('fast',function(){
        jQuery(this).removeClass("price_fixed")
          .addClass("price_default")
          .fadeIn('fast');
      });
    }
  });

  jQuery('#complects .cmpl_sostav .cmpl_item input:checkbox').change(function(){ 
    var cmpl_price = 0;
    // Перебираем элементы формы: input:checkbox:checked (отмеченные флажки)
    jQuery('input:checkbox:checked',this.form).each(function(nf, inputData) {
      cmpl_price = parseInt(cmpl_price) + parseInt(jQuery(inputData).attr('value'));
    });
    jQuery('.cmpl_price_text',this.form).html(number_format(cmpl_price, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.');
    jQuery('.cmpl_zakazat',this.form).html(number_format(cmpl_price, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.');
    jQuery('input[name="cmpl_price"]',this.form).val(cmpl_price);
  });

  jQuery('#complect .cmpl_sostav .cmpl_item input:checkbox').change(function(){ 
    var cmpl_price = 0;
    // Перебираем элементы формы: input:checkbox:checked (отмеченные флажки)
    jQuery('input:checkbox:checked',this.form).each(function(nf, inputData) {
      cmpl_price = parseInt(cmpl_price) + parseInt(jQuery(inputData).attr('value'));
    });
    jQuery('.cmpl_price_text',this.form).html(number_format(cmpl_price, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.');
    jQuery('.cmpl_zakazat',this.form).html(number_format(cmpl_price, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.');
    jQuery('input[name="cmpl_price"]',this.form).val(cmpl_price);
  });

  // Тултип описание комплектующей в списке (наведение мышкой)
  jQuery('#complect_add .cmpl_items_list .cmpl_item .fa-info-circle').mousemove(function (e) {
    var item_desc = jQuery(this).parent().next('.cmpl_item_desc');
    
    if (item_desc.html() != '') {
      // положение элемента
      var offset = jQuery(this).parents('.cmpl_items').offset();
      var relativeX = (e.pageX - offset.left) + 40;
      var relativeY = (e.pageY - offset.top) - 20;
      item_desc.css({
        "left" : relativeX+'px',
        "top" : relativeY+'px'
      })
      .show();
    } else {
      jQuery(this).css("cursor",'default');
    }
  }).mouseout(function () {
    var item_desc = jQuery(this).parent().next('.cmpl_item_desc');
    
    item_desc.hide()
      .css({
        "top" : 0,
        "left" : 0
      });
  });
  
  // Перебираем элементы формы: input:checkbox:checked (отмеченные флажки)
  if (jQuery('#complect_add .cmpl_items_list').length > 0) {
    jQuery('.cmpl_sostav input:checkbox:checked').each(function(nf1, inputSostav) {
      var item_input_name = jQuery(inputSostav).attr('name');
      var item_arr = item_input_name.split('_');
      var item_article = item_arr[1];
      
      jQuery('.cmpl_items_list input[name="itemlist_'+item_article+'"]').each(function(nf2, inputList) {
        var item_name = jQuery(inputList).nextAll('.cmpl_item_name').html();
        var item_razmer = jQuery(inputList).nextAll('.cmpl_item_razmer').html();
        
        jQuery(inputList).prop("checked", true);
      });
    });
  }
      
  // Выбор групп комплектующих
  jQuery('#complect_add .cmpl_group_title').click(function () {
    // jQuery('#complect_add .cmpl_group').hide();
    jQuery(this).next('.cmpl_group').slideToggle();
    // jQuery(this).nextAll('.cmpl_group:first').slideToggle();
  });
  
  // Показать выбор цвета и добавить в список к комплекту
  jQuery('#complect_add .cmpladd_checked_item').change(function(){ 
    // jQuery('#complect_add .cmpl_group').slideUp();
    jQuery('#complect_add .cmpl_group').hide();
    
    // добавление в список к комплекту
    var article = jQuery(this).attr('name');
    var item_arr = article.split('_');
    var item_article = item_arr[1];
    
    var item_price = jQuery(this).val();
    var item_price_text = jQuery(this).nextAll('.cmpl_item_price').html();
    var item_name = jQuery('a',jQuery(this).nextAll('.cmpl_item_name')).html();
    var item_name_href = jQuery(this).nextAll('.cmpl_item_name').html();
    var item_razmer = jQuery(this).nextAll('.cmpl_item_razmer').html();
    var item_desc = jQuery(this).parent().nextAll('.cmpl_item_desc').html();
    var params_html = jQuery(this).parent().nextAll('.item_params').html();
    
    var item_html = '<div class="cmpl_item item_'+item_article+'"><div class="item_img"><a class="zoom" href="/images/items/'+item_article+'.jpg" title="Увеличить изображение" data-lightbox="item_img_'+item_article+'" data-title="'+item_name+'"><img id="img_'+item_article+'" src="/images/items/min/'+item_article+'_min.jpg" alt="'+item_name+'"><i class="fa fa-search-plus"></i></a></div><div class="item"><input type="checkbox" name="item_'+item_article+'" value="'+item_price+'" checked="checked" /><span class="cmpl_item_name">'+item_name_href+'</span>&nbsp;-&nbsp;<span class="cmpl_item_price">'+item_price_text+'</span><div class="cmpl_item_razmer">'+item_razmer+'</div><span class="item_desc">'+item_desc+'</span><div class="item_params">'+params_html+'</div></div></div><div class="clear"></div>';
    
    var cmpl_sostav = jQuery('.cmpl_sostav');
    var cmpl_sostav_item = jQuery('.cmpl_sostav input[name=item_'+item_article+']');
    
    if (jQuery(this).prop("checked") && cmpl_sostav_item.length == 0) {
      cmpl_sostav.append(item_html);
      item_del(item_article);
      /*
      jQuery('.zoom').lightBox({
        fixedNavigation:true,
      });
      */
    }
    
    if (!jQuery(this).prop("checked") && cmpl_sostav_item.length > 0) {
      jQuery('.item_'+item_article).remove();
    }
    
    price_update();
  });
  
});