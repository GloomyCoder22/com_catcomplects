<?php

/**
 * @version     1.0.0
 * @package     com_catcomplects
 * @copyright   © 2015. Demin Artem. Все права защищены.
 * @license     GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
 * @author      Demin Artem <ademin1982@gmail.com> - http://
 */
// No direct access
defined('_JEXEC') or die;

class CatcomplectsRouter extends JComponentRouterBase
{
// Получение алиаса комплекта
function getAliasComplect($row, $value){
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select('id, alias');
  $query->from($db->quoteName('#__catcomplects_complects'));
  $query->where($db->quoteName($row)." = ".$db->quote($value));
  $db->setQuery($query);

  return $db->loadRow();
}

// Получение id каталога товара
function getItemcatid($row, $value){
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select('article, catid');
  $query->from($db->quoteName('#__catcomplects_items'));
  $query->where($db->quoteName($row)." = ".$db->quote($value));
  $db->setQuery($query);

  return $db->loadRow();
}

// Получение алиаса каталога товара
function getAliasItemcat($row, $value){
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select('id, alias');
  $query->from($db->quoteName('#__catcomplects_items_categories'));
  $query->where($db->quoteName($row)." = ".$db->quote($value));
  $db->setQuery($query);

  return $db->loadRow();
}  

// Получение Itemid меню
function getItemid($row, $value) {
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select('id, alias');
  $query->from($db->quoteName('#__menu'));
  $query->where($db->quoteName($row)." = ".$db->quote($value));
  $db->setQuery($query);

  return $db->loadRow();
}

	public function build(&$query) {
		$segments = array();

		if (!empty($query['view'])) {
			switch ($query['view']) {
				case 'complects':
          if (!empty($query['id'])) {
            $data_sql = $this->getAliasComplect("id",$query['id']);
            $data_sql = $this->getItemid("alias",$data_sql['1']);
            $query['Itemid'] = $data_sql['0'];
            unset ($query['id']);
          }
          unset ($query['view']);
          break;
          			
				case 'complect':
          if (!empty($query['id'])) {
            $data_sql = $this->getAliasComplect("id",$query['id']);
            $data_sql = $this->getItemid("alias",$data_sql['1']);
            $query['Itemid'] = $data_sql['0'];
            unset ($query['id']);
          }
          unset ($query['view']);
          break;

				case 'items':
          if (!empty($query['article'])) {
            if (empty($query['Itemid'])) {
              $data_sql = $this->getItemcatid("article",$query['article']);
              $data_sql = $this->getAliasItemcat("id",$data_sql['1']);
              $data_sql = $this->getItemid("alias",$data_sql['1']);
              $query['Itemid'] = $data_sql['0'];
            }
            $segments[] = $query['article'];
            unset ($query['article']);
          }
          unset ($query['view']);
          break;
        
				case 'complectadd':
          if (!empty($query['id'])) {
            $query['Itemid'] = 158;
            $segments[] = $query['id'];
            
            unset ($query['id']);
          }
          unset ($query['view']);          
          break;
				  
				case 'complectcart':
          if (empty($query['item_article'])) {
            if (!empty($query['id'])) {
              $query['Itemid'] = 169;
              unset ($query['id']);
            }
            if (!empty($query['article'])) {
              $query['Itemid'] = 169;
              $segments[] = $query['article'];
              unset ($query['article']);
            }
            unset ($query['view']);
          }
          break;
			}
		}

		$total = count($segments);
		/*
		for ($i = 0; $i < $total; $i++) {
			$segments[$i] = str_replace(':', '-', $segments[$i]);
		}
		*/

		return $segments;
	}

	public function parse(&$segments) {
		$vars = array();
		$count = count($segments);
    $item = $this->menu->getActive();	
    if (isset($item->query['view']) && $count > 0) {
      $vars['view'] = $item->query['view'];
      if ($vars['view'] == 'items' && $count == 1) {
        $article = $segments[0];
        $tmp = $this->getItemcatid('article',$article);
        if (!empty($tmp[0])) {
          $vars['article'] = $tmp[0];
        } else {
          JError::raiseError(404, JText::_('JGLOBAL_RESOURCE_NOT_FOUND'));
        }
      } else {
        JError::raiseError(404, JText::_('JGLOBAL_RESOURCE_NOT_FOUND'));
      }
    } else {
      JError::raiseError(404, JText::_('JGLOBAL_RESOURCE_NOT_FOUND'));
    }

		return $vars;
	}
}

function CatcomplectsBuildRoute(&$query) {
	$router = new CatcomplectsRouter;

	return $router->build($query);
}

function CatcomplectsParseRoute($segments) {
	$router = new CatcomplectsRouter;

	return $router->parse($segments);
}
