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

$promocode = '';
if (isset($_POST["promocode"])) $promocode = @trim($_POST["promocode"]);

if (!empty($promocode)) {
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query 
    ->select('*')
    ->from($db->quoteName('#__catcomplects_promocodes'))
    ->where($db->quoteName('promocode').'='.$db->quote($promocode).' AND '.$db->quoteName('state').'=1');
  $db->setQuery($query);
  $result = $db->loadObject();
  
  if ($result) {
    echo json_encode($result);
  } else {
    echo json_encode('no');
  }
} else {
  echo json_encode('Пустое поле');
}