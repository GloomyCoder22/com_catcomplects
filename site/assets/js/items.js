jQuery(document).ready(function() {
  jQuery('.cmpl_item').hover(
    function () {
      jQuery('.cmpl_razmer',this).hide();
      jQuery('.cmpl_box',this).stop().slideDown();
    },
    function () {
      jQuery('.cmpl_razmer',this).show();
      jQuery('.cmpl_box',this).stop().slideUp();
    }
  );
    
  // Выбор групп комплектующих
  jQuery('.cmpl_group_title').click(function () {
    jQuery(this).next('.cmpl_group').slideToggle();
  });
  
  
  // Выбор размеров
  function SelectItemRazmer(){
    jQuery('.item_razmer_href').click(function () {
      jQuery('.item_razmer_href').off();
      
      var items_div = jQuery('.item_razmer_nohref',jQuery(this).parent());
      var items_price = jQuery('.item_price',jQuery(this).parent().parent());
      var items_buy = jQuery('.inp_item_article',jQuery(this).parent().parent());
      var items_name = jQuery('a',jQuery(this).parent().prev('.item_name'));
      
      var item_article = items_div.attr('data-item-article');
      var item_price = items_div.attr('data-item-price');
      var item_href = items_div.attr('data-item-href');
      var item_razmer = items_div.html();

      var item_href_article = jQuery(this).attr('data-item-article');
      var item_href_price = jQuery(this).attr('data-item-price');
      var item_href_href = jQuery(this).attr('data-item-href');
      var item_href_razmer = jQuery(this).html();

      var items_cart = jQuery('#cart_'+item_article);

      items_div.replaceWith('<a class="href_dashed item_razmer_href" href="#" onclick="return false" data-item-article="'+item_article+'" data-item-price="'+item_price+'" data-item-href="'+item_href+'" title="Выбрать другой размер">'+item_razmer+'</a>');
      items_price.html(item_href_price);
      items_buy.val(item_href_article);
      items_name.attr('href',item_href_href);
      jQuery(this).replaceWith('<span class="item_razmer_nohref" data-item-article="'+item_href_article+'" data-item-price="'+item_href_price+'" data-item-href="'+item_href_href+'">'+item_href_razmer+'</span>');
      items_cart.attr('id','cart_'+item_href_article);
               
      vsCartAdd(item_href_article, 1);
      SelectItemRazmer();
    });
  }
  SelectItemRazmer();

  jQuery('#page_item .item_colorbox .img_href').click(function () {
    var articleimg = jQuery(this).attr('data-articleimg');
    jQuery('.item_colorbox div').css('box-shadow','');
    jQuery(this).css('box-shadow','0px 0px 5px 5px #'+jQuery(this).attr('data-hexcolor'));
    
    jQuery('.item_img a').attr('href','/images/items/'+articleimg+'.jpg');
    jQuery('.item_img a img').attr('src','/images/items/thumbs/'+articleimg+'_thumb.jpg');
    
    jQuery('.item_buy .cartadd').attr("id","cart_"+articleimg);
    jQuery('.item_buy .cartadd').attr("onclick","vsCartAdd('"+articleimg+"'); yaCounter29661885.reachGoal('InCart'); return false;");
    jQuery('.item_buy .cartadd').attr("data-article",articleimg);
    
    vsCartAdd('check');
  });
  
});
