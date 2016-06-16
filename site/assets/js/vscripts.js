/*! jQuery Cookie Plugin v1.4.1 */
jQuery.cookie=function(b,j,m){if(typeof j!="undefined"){m=m||{};if(j===null){j="";m.expires=-1}var e="";if(m.expires&&(typeof m.expires=="number"||m.expires.toUTCString)){var f;if(typeof m.expires=="number"){f=new Date();f.setTime(f.getTime()+(m.expires*24*60*60*1000))}else{f=m.expires}e="; expires="+f.toUTCString()}var l=m.path?"; path="+(m.path):"";var g=m.domain?"; domain="+(m.domain):"";var a=m.secure?"; secure":"";document.cookie=[b,"=",encodeURIComponent(j),e,l,g,a].join("")}else{var d=null;if(document.cookie&&document.cookie!=""){var k=document.cookie.split(";");for(var h=0;h<k.length;h++){var c=jQuery.trim(k[h]);if(c.substring(0,b.length+1)==(b+"=")){d=decodeURIComponent(c.substring(b.length+1));break}}}return d}};
// end jQuery.cookie
/*! jQuery JSON plugin v2.5.1 | github.com/Krinkle/jquery-json */
!function($){"use strict";var escape=/["\\\x00-\x1f\x7f-\x9f]/g,meta={"\b":"\\b","	":"\\t","\n":"\\n","\f":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},hasOwn=Object.prototype.hasOwnProperty;$.toJSON="object"==typeof JSON&&JSON.stringify?JSON.stringify:function(a){if(null===a)return"null";var b,c,d,e,f=$.type(a);if("undefined"===f)return void 0;if("number"===f||"boolean"===f)return String(a);if("string"===f)return $.quoteString(a);if("function"==typeof a.toJSON)return $.toJSON(a.toJSON());if("date"===f){var g=a.getUTCMonth()+1,h=a.getUTCDate(),i=a.getUTCFullYear(),j=a.getUTCHours(),k=a.getUTCMinutes(),l=a.getUTCSeconds(),m=a.getUTCMilliseconds();return 10>g&&(g="0"+g),10>h&&(h="0"+h),10>j&&(j="0"+j),10>k&&(k="0"+k),10>l&&(l="0"+l),100>m&&(m="0"+m),10>m&&(m="0"+m),'"'+i+"-"+g+"-"+h+"T"+j+":"+k+":"+l+"."+m+'Z"'}if(b=[],$.isArray(a)){for(c=0;c<a.length;c++)b.push($.toJSON(a[c])||"null");return"["+b.join(",")+"]"}if("object"==typeof a){for(c in a)if(hasOwn.call(a,c)){if(f=typeof c,"number"===f)d='"'+c+'"';else{if("string"!==f)continue;d=$.quoteString(c)}f=typeof a[c],"function"!==f&&"undefined"!==f&&(e=$.toJSON(a[c]),b.push(d+":"+e))}return"{"+b.join(",")+"}"}},$.evalJSON="object"==typeof JSON&&JSON.parse?JSON.parse:function(str){return eval("("+str+")")},$.secureEvalJSON="object"==typeof JSON&&JSON.parse?JSON.parse:function(str){var filtered=str.replace(/\\["\\\/bfnrtu]/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,"");if(/^[\],:{}\s]*$/.test(filtered))return eval("("+str+")");throw new SyntaxError("Error parsing JSON, source is not valid.")},$.quoteString=function(a){return a.match(escape)?'"'+a.replace(escape,function(a){var b=meta[a];return"string"==typeof b?b:(b=a.charCodeAt(),"\\u00"+Math.floor(b/16).toString(16)+(b%16).toString(16))})+'"':'"'+a+'"'}}(jQuery);
// end jQuery JSON

function number_format(_number, _cfg){
  function obj_merge(obj_first, obj_second){
    var obj_return = {};
    for (key in obj_first){
      if (typeof obj_second[key] !== 'undefined') obj_return[key] = obj_second[key];
      else obj_return[key] = obj_first[key];
      }
    return obj_return;
  }
  function thousands_sep(_num, _sep){
    if (_num.length <= 3) return _num;
    var _count = _num.length;
    var _num_parser = '';
    var _count_digits = 0;
    for (var _p = (_count - 1); _p >= 0; _p--){
      var _num_digit = _num.substr(_p, 1);
      if (_count_digits % 3 == 0 && _count_digits != 0 && !isNaN(parseFloat(_num_digit))) _num_parser = _sep + _num_parser;
      _num_parser = _num_digit + _num_parser;
      _count_digits++;
      }
    return _num_parser;
  }
  if (typeof _number !== 'number'){
    _number = parseFloat(_number);
    if (isNaN(_number)) return false;
  }
  var _cfg_default = {before: '', after: '', decimals: 2, dec_point: '.', thousands_sep: ','};
  if (_cfg && typeof _cfg === 'object'){
    _cfg = obj_merge(_cfg_default, _cfg);
  }
  else _cfg = _cfg_default;
  _number = _number.toFixed(_cfg.decimals);
  if(_number.indexOf('.') != -1){
    var _number_arr = _number.split('.');
    var _number = thousands_sep(_number_arr[0], _cfg.thousands_sep) + _cfg.dec_point + _number_arr[1];
  }
  else var _number = thousands_sep(_number, _cfg.thousands_sep);
  return _cfg.before + _number + _cfg.after;
}

function vsCartAdd(item_article, item_check) {
  var cart_count = 0;  
  var cookie_cart = new Array();
  var cookieOptions = {expires: 1, path: '/'};
  
  if (item_article && item_check === undefined) {
    if (item_article == 'check') {
      if (jQuery.cookie('vs_cart')) cookie_cart = jQuery.secureEvalJSON(jQuery.cookie('vs_cart'));
      cart_count = cookie_cart.length;
      jQuery('.cart .cart_count').html('корзина: '+cart_count);
      jQuery('.no-cart').each(function(){
        if (jQuery.inArray(jQuery(this).attr('data-article'), cookie_cart) > -1) {
          jQuery(this).removeClass('no-cart')
                      .addClass('in-cart')
                      .html('В корзине')
                      .attr({
                        href: '/cart',
                        title: 'Перейти в корзину',
                        onclick: ''
                      });
        }
      });
    } else if (item_article == 'clear') {
      jQuery.cookie('vs_cart',null);
    } else {
      var item_href = jQuery('#cart_'+item_article);
      if (jQuery.cookie('vs_cart')) cookie_cart = jQuery.secureEvalJSON(jQuery.cookie('vs_cart'));
      if (jQuery.inArray(item_article, cookie_cart) == -1) cookie_cart.push(item_article);
      cart_count = cookie_cart.length;
      jQuery.cookie('vs_cart', jQuery.toJSON(cookie_cart), cookieOptions);
      jQuery('.cart .cart_count').html('корзина: '+cart_count);
      item_href.removeClass('no-cart')
               .addClass('in-cart')
               .html('В корзине')
               .attr({
                  href: '/cart',
                  title: 'Перейти в корзину',
                  onclick: ''
               });
    }
  } else if (item_check == 1) {
    var item_href = jQuery('#cart_'+item_article);
    
    if (jQuery.cookie('vs_cart')) cookie_cart = jQuery.secureEvalJSON(jQuery.cookie('vs_cart'));
    if (jQuery.inArray(item_article, cookie_cart) > -1) {
      item_href.removeClass('no-cart')
               .addClass('in-cart')
               .html('В корзине')
               .attr({
                  id: 'cart_'+item_article,
                  href: '/cart',
                  title: 'Перейти в корзину',
                  onclick: ''
               })
               .attr('data-article',item_article);
    } else {
      item_href.removeClass('in-cart')
               .addClass('no-cart')
               .html('В корзину')
               .attr({
                  id: 'cart_'+item_article,
                  href: '#',
                  title: 'Положить в корзину',
                  onclick: 'vsCartAdd(\''+item_article+'\'); return false;'
               })
               .attr('data-article',item_article);
    }
  }
}
function vsCartDel(item_article, item_check) {
  var cart_count = 0;  
  var cookie_cart = new Array();
  var cookieOptions = {expires: 1, path: '/'};
  var item_del = 0;

  if (jQuery.cookie('vs_cart')) cookie_cart = jQuery.secureEvalJSON(jQuery.cookie('vs_cart'));
  item_del = jQuery.inArray(item_article, cookie_cart);
  if (jQuery.inArray(item_article, cookie_cart) > -1) cookie_cart.splice(item_del,1);
  cart_count = cookie_cart.length;  
  jQuery.cookie('vs_cart', jQuery.toJSON(cookie_cart), cookieOptions);
  jQuery('.cart .cart_count').html('корзина: '+cart_count);
}  

/*
jQuery(document).ready(function() {
  vsCartAdd('check');
});
*/