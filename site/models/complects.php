<?php
defined('_JEXEC') or die;
 
class CatcomplectsModelComplects extends JModelLegacy {

/*
	public function __construct($config = array())  {
		parent::__construct($config);
    
    require_once JPATH_COMPONENT . '/helpers/complects.php';
  }
*/
  // Получить все комплекты
  public function getComplects() {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query 
        ->select('*')
        ->from($db->quoteName('#__catcomplects_complects'))
        ->where($db->quoteName('state').'=1')
        ->order($db->quoteName('ordering'));
    $db->setQuery($query);

    return $db->loadObjectlist();
  }

  // Получить все комплектующие комплекта
  public function getItemsComplect($items) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query 
        ->select('*')
        ->from($db->quoteName('#__catcomplects_items'))
        ->where($db->quoteName('article').' IN('.$items.') AND '.$db->quoteName('state').'=1')
        ->order($db->quoteName('price').' DESC');
    $db->setQuery($query);

    return $db->loadObjectlist();
  }
  
  // Получить все комплектующие
  public function getItems() {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query 
        ->select('*')
        ->from($db->quoteName('#__catcomplects_items'))
        ->where($db->quoteName('state').'=1')
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
        ->from($db->quoteName('#__catcomplects_complects'))
        ->where($db->quoteName('id').'='.$cmpl_id);
    $db->setQuery($query);

    //return $db->loadResult();
    //return $db->loadRow();
    //return $db->loadAssoc();
    return $db->loadObject();
  }

  // Получить выбранную комплектующую
  public function getItem($item_id) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query 
        ->select('*')
        ->from($db->quoteName('#__catcomplects_items'))
        ->where($db->quoteName('article').'='.$db->quote($item_id));
    $db->setQuery($query);

    return $db->loadObject();
  }
  
  // Получить выбранную категорию
  public function getCat($cat_id) {
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query 
        ->select('*')
        ->from($db->quoteName('#__catcomplects_items_categories'))
        ->where($db->quoteName('id').'='.$cat_id);
    $db->setQuery($query);

    return $db->loadObject();
  }
}
