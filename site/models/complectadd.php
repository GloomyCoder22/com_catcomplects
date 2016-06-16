<?php
defined('_JEXEC') or die;

class CatcomplectsModelComplectadd extends JModelLegacy {
/*
	public function __construct($config = array())  {
		parent::__construct($config);
    
    require_once JPATH_COMPONENT . '/helpers/complects.php';
  }
*/

  // Получить все комплектующие
  public function getItems() {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query 
        ->select('*')
        ->from('#__catcomplects_items')
        ->where('state = 1')
        ->order('catid, name, price');
    $db->setQuery($query);

    return $db->loadObjectlist();
  }

  // Получить выбраный комплект
  public function getComplect($cmpl_id) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query 
        ->select('*')
        ->from('#__catcomplects_complects')
        ->where('id = '.$cmpl_id);
    $db->setQuery($query);

    //return $db->loadResult();
    //return $db->loadRow();
    //return $db->loadAssoc();
    return $db->loadObject();
  }

  // Получить категорию комплектующей
  public function getItemCatid($catid) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query 
        ->select('*')
        ->from('#__catcomplects_items_categories')
        ->where('id='.$catid);
    $db->setQuery($query);

    return $db->loadObject();
  }
  
  // Получить выбранную комплектующую
  public function getItem($item_id) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query 
        ->select('*')
        ->from('#__catcomplects_items')
        ->where('article = '.$item_id);
    $db->setQuery($query);

    return $db->loadObject();
  }

}
