jQuery(document).ready(function() {
  jQuery('#promocode').on('input', function () {
    if (jQuery(this).val().length >= 9){
      var promocode = jQuery(this).val();
      var itogo = jQuery('#item_price_itogo').val();
      jQuery.ajax({
        type: 'POST',
        url: '/components/com_catcomplects/helpers/promocodes.php',
        data: 'promocode='+promocode,
        dataType: 'json',
        success: function(response) {
          if (response != 'no') {
            if (response.used != 1) {
              jQuery('#formsend span.promo').html('Промокод действителен!');
              jQuery('#formsend span.promo').removeClass('promo_red');
              jQuery('#formsend span.promo').addClass('promo_green');
              
              itogoSale = Number(itogo) - (Number(itogo) * 0.2);
              // jQuery('#item_price_itogo').val(itogo);
              jQuery('#item_price_itogo').prev().html('Итого: '+number_format(itogo, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.<br />Итого c 20% скидкой: '+number_format(itogoSale, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.');
              jQuery('#promocode').prop('readonly', true);
            } else {
              jQuery('#formsend span.promo').html('Этот промокод уже был использован ранее! Укажите другой промокод.');
              jQuery('#formsend span.promo').removeClass('promo_green');
              jQuery('#formsend span.promo').addClass('promo_red');
            }
          } else {
            jQuery('#formsend span.promo').html('Такой промокод не существует! Укажите другой промокод.');
            jQuery('#formsend span.promo').removeClass('promo_green');
            jQuery('#formsend span.promo').addClass('promo_red');
          }
        },
        error: function(response) {
          console.log('Ошибка AJAX!');
        }
      });
    }
    // console.log(msg);
  });

  jQuery('#formsend').submit(function(e){
    e.preventDefault();         //отменяем стандартное действие при отправке формы
    var m_method=jQuery(this).attr('method');   //берем из формы метод передачи данных
    //var m_action=jQuery(this).attr('action');   //получаем адрес скрипта на сервере, куда нужно отправить форму
    m_action='/components/com_catcomplects/helpers/formsend.php';
    var form_html = jQuery('#formsend').html();
    var form_fio_name = jQuery('#fio_name').val();
    var form_phone = jQuery('#phone').val();
    var form_email = jQuery('#email').val();

    //получаем данные, введенные пользователем в формате input1=value1&input2=value2...,
    //то есть в стандартном формате передачи данных формы
    
    jQuery('.count_minus').remove();
    jQuery('.count_plus').remove();
    jQuery('.item_del').remove();
    
    jQuery('.item_params input:radio').each(function(){
      jQuery(this).attr('checked',jQuery(this).prop("checked"));
    });
    jQuery('.item_params input:text').each(function(){
      jQuery(this).attr('value',jQuery(this).val());
    });
    
    var m_zakaz_html = jQuery('#cmpl_zakaz').html();
    var m_data = jQuery(this).serialize();
    
    jQuery.ajax({
      type: m_method,
      url: m_action,
      data: m_data+'&html_form='+m_zakaz_html,
      success: function(response) {
        jQuery('#form_send_error').html(response);
        if (jQuery('#zakaz_ok').length > 0) {
          jQuery('#cmpl_zakaz').remove();
          jQuery('#formsend_bottom h2').remove();
          jQuery('#formsend').remove();
          vsCartAdd('clear');
          vsCartAdd('check');
        } else {
          jQuery('#formsend').html(form_html);
          jQuery('#fio_name').val(form_fio_name);
          jQuery('#phone').val(form_phone);
          jQuery('#email').val(form_email);
        }
      },
      error: function(response) {
        jQuery('#form_send_error').html(response);
        jQuery('#formsend').html(form_html);
        jQuery('#fio_name').val(form_fio_name);
        jQuery('#phone').val(form_phone);
        jQuery('#email').val(form_email);
      }
    });
  });
  
  jQuery('.item_count .count_minus').click(function(){
    var item_article = jQuery(this).next('.count').attr('id');
    var item_count = jQuery(this).next('.count').val();
    var item_price = jQuery('#itemprice_'+item_article).val();
    var item_summa = jQuery('#itemsumma_'+item_article).val();
    var itogo = jQuery('#item_price_itogo').val();
    
    itogo = Number(itogo) - Number(item_summa);
    
    if (item_count > 0) {
      item_count = Number(item_count) - 1;
      jQuery(this).next('.count').val(item_count);
      jQuery(this).next('.count').attr('value',item_count);
      
      item_summa = Number(item_price) * Number(item_count);
      jQuery('#itemsumma_'+item_article).val(item_summa);
      jQuery('#itemsumma_'+item_article).prev().html(number_format(item_summa, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.');
      
      itogo = itogo + item_summa;
      jQuery('#item_price_itogo').val(itogo);
      
      if (jQuery('#promocode').attr('readonly')) { 
        itogoSale = Number(itogo) - (Number(itogo) * 0.2);
        jQuery('#item_price_itogo').prev().html('Итого: '+number_format(itogo, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.<br />Итого c 20% скидкой: '+number_format(itogoSale, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.');
      } else {
        jQuery('#item_price_itogo').prev().html('Итого: '+number_format(itogo, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.');
      }
    }
  });

  jQuery('.item_count .count_plus').click(function(){
    var item_article = jQuery(this).prev('.count').attr('id');
    var item_count = jQuery(this).prev('.count').val();
    var item_price = jQuery('#itemprice_'+item_article).val();
    var item_summa = jQuery('#itemsumma_'+item_article).val();
    var itogo = jQuery('#item_price_itogo').val();
    
    itogo = Number(itogo) - Number(item_summa);
    if (item_count < 10000) {
      item_count = Number(item_count) + 1;
      jQuery(this).prev('.count').val(item_count);
      jQuery(this).prev('.count').attr('value',item_count);
      
      item_summa = Number(item_price) * Number(item_count);
      jQuery('#itemsumma_'+item_article).val(item_summa);
      jQuery('#itemsumma_'+item_article).prev().html(number_format(item_summa, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.');
      
      itogo = itogo + item_summa;
      jQuery('#item_price_itogo').val(itogo);

      if (jQuery('#promocode').attr('readonly')) { 
        itogoSale = Number(itogo) - (Number(itogo) * 0.2);
        jQuery('#item_price_itogo').prev().html('Итого: '+number_format(itogo, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.<br />Итого c 20% скидкой: '+number_format(itogoSale, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.');
      } else {
        jQuery('#item_price_itogo').prev().html('Итого: '+number_format(itogo, {decimals: 0, thousands_sep: " ", dec_point: ","})+' руб.');
      }
    }
  });

  jQuery('#cmpl_zakaz .item_foncolor .img_yes input').click(function () {
    var tmp_split = jQuery(this).parent().attr('data-imgcolor').split('.');
    var item_id = jQuery(this).parents('tr').attr('id');
    
    jQuery('#'+item_id+' .zoom').attr('href','http://www.vyveski.me/images/items/'+jQuery(this).parent().attr('data-imgcolor'));
    jQuery('#'+item_id+' .zoom img').attr('src','http://www.vyveski.me/images/items/min/'+tmp_split[0]+'_min.jpg');
  });  
  
});
