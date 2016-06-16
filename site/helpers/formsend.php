<?php
define('_JEXEC', 1);

if (file_exists($_SERVER['DOCUMENT_ROOT'].'/defines.php')) {
	include_once $_SERVER['DOCUMENT_ROOT'].'defines.php';
}

if (!defined('_JDEFINES')) {
  define('JPATH_BASE', $_SERVER['DOCUMENT_ROOT']);
	require_once JPATH_BASE.'/includes/defines.php';
}

require_once JPATH_BASE.'/includes/framework.php';
$app = JFactory::getApplication('site');

$fio_name = '';
$phone = '';
$email = '';
  
if (isset($_POST["fio_name"])) $fio_name = @trim($_POST["fio_name"]);
if (isset($_POST["phone"])) $phone = @trim($_POST["phone"]);
if (isset($_POST["email"])) $email = @trim($_POST["email"]);
if (isset($_POST["comments"])) $comments = $_POST["comments"];
if (isset($_POST["html_form"])) $html_form = $_POST["html_form"];

// $header="Content-type:text/html;charset=utf-8\r\n";
if (!empty($fio_name) && !empty($email)) {
  $body = '<div>'
           .'<div>'
           .'Спасибо за заказ! Наш менеджер свяжется с вами в ближайшее время.<br />'
           .'Мы будем Вам очень признательны, если Вы <a href="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=1252/*https://market.yandex.ru/grade-shop.xml?shop_id=302915" target="_blank">оцените качество</a> нашего интернет-магазина на Яндекс.Маркете.<img width="1" height="1" src="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=1252/*http://img.yandex.ru/i/pix.gif" alt="" border="0"/>'
           .'</div><br />'
           .'<h3>Информация о заказе</h3><br />'
           .'<table width="100%">'
             .'<tbody>'
               .'<tr>'
                 .'<td width="50%">Имя: </td>'
                 .'<td width="50%">'.$fio_name.'</td>'
               .'</tr>'
               .'<tr>'
                 .'<td width="50%">Телефон: </td>'
                 .'<td width="50%">'.$phone.'</td>'
               .'</tr>'
               .'<tr>'
                 .'<td width="50%">E-mail: </td>'
                 .'<td width="50%">'.$email.'</td>'
               .'</tr>'
               .'<tr>'
                 .'<td width="50%">Комментарий: </td>'
                 .'<td width="50%">'.$comments.'</td>'
               .'</tr>'
             .'</tbody>'
           .'</table>'
         .'</div><br /><br />'
         .'<h3>Товары</h3>'
         .'<div>'.$html_form.'<br /><br /></div>'
         .'<div style="clear: both;"></div>'
         .'<br />'
         .'<div>'
         .'<a href="http://www.vyveski.me">VYVESKI.me - готовые вывески для вашего бизнеса</a><br />'
         .'E-mail: <a href="mailto:manager@vyveski.me">manager@vyveski.me</a><br />'
         .'Адрес: г Барнаул, ул. Пролетарская, д. 135<br />'
         .'Время работы: c 9 до 18 (суббота, воскресенье - выходные дни). <br />'
         .'Наши телефоны: <br />'
         .'8 800 222 6232 (бесплатные звонки по России) <br />'
         .'+7 (3852) 226-232 (по г. Барнаулу)'
         .'</div>';
  $config = JFactory::getConfig();


  $mailer = JFactory::getMailer();
  $mailer->setSender(array($config->get('mailfrom'),$config->get('fromname')));
  $mailer->addRecipient($email);
  $mailer->setSubject('Ваш заказ с сайта Vyveski.me');
  $mailer->isHTML(true);
  $mailer->setBody($body);
  $send = $mailer->Send();

  if ($send !== true) {
    echo '<span style="color: red; font-size: 18px;">Ошибка при отправке копии заказа на Ваш E-mail: <span style="font-weight: bold;">'.$email.'</span><br />Укажите другой E-mail или обновите страницу и попробуйте еще раз.</span>';
  } else {
    echo '<span style="color: #2C90CF;">Копия заказа успешно отправлена на Ваш E-mail: <span style="font-weight: bold;">'.$email.'</span><br /> Наш менеджер свяжется с вами в ближайшее время.</span><span id="zakaz_ok" style="font-size: 18px; padding: 0 10px; color: #CB3876;">Спасибо за заказ!</span><br /><br />Мы будем Вам очень признательны, если Вы <a href="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=1252/*https://market.yandex.ru/grade-shop.xml?shop_id=302915" target="_blank">оцените качество</a> нашего интернет-магазина на Яндекс.Маркете.<img width="1" height="1" src="http://clck.yandex.ru/redir/dtype=stred/pid=47/cid=1252/*http://img.yandex.ru/i/pix.gif" alt="" border="0"/>';
    $mailer = JFactory::getMailer();
    $mailer->setSender(array($config->get('mailfrom'),$config->get('fromname')));
    // $mailer->addRecipient(array('manager@vyveski.me', 'admin@vyveski.me'));
    $mailer->addRecipient('manager@vyveski.me');
    $mailer->setSubject('Заказ с сайта Vyveski.me');
    $mailer->isHTML(true);
    $mailer->setBody($body);
    $send = $mailer->Send();
    if ($send !== true) {
      echo '<br /><br /><span style="color: red; font-size: 18px;">Ошибка при отправке заявки нашему менеджеру: </span>';
    }


  // }
  // Optionally add embedded image <img src="cid:logo_id" alt="logo"/></div>
  // $mailer->AddEmbeddedImage(PATH_COMPONENT.DS.'assets'.DS.'logo128.png', 'logo_id', 'logo.png', 'base64', 'image/jpeg');  
  }
} else {
  echo '<span style="color: red; font-size: 18px;">Не заполнены некоторые поля формы! Пожалуйста заполните их.</span>';
}