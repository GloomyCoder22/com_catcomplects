<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_catcomplects
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

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
  
/**
 * Catcomplects Component Route Helper.
 *
 * @since  3.1
 */
class CatcomplectsHelperRoute extends JHelperRoute
{
	protected static $lookup;

	/**
	 * Tries to load the router for the component and calls it. Otherwise uses getTagRoute.
	 *
	 * @param   integer  $contentItemId     Component item id
	 * @param   string   $contentItemAlias  Component item alias
	 * @param   integer  $contentCatId      Component item category id
	 * @param   string   $language          Component item language
	 * @param   string   $typeAlias         Component type alias
	 * @param   string   $routerName        Component router
	 *
	 * @return  string  URL link to pass to JRoute
	 *
	 * @since   3.1
	 */
	public static function getItemTitle($article)
	{
    $item = getItem($article);
	
    return $item->name;
	}
	
	public static function getItemDesc($article)
	{
    $item = getItem($article);
	
    return $item->name.' ('.$item->description.') артикул: '.$item->article;
	}
	
	public static function getItemRoute($contentItemId, $contentItemAlias, $contentCatId, $language, $typeAlias, $routerName)
	{
		$link = '';
		$explodedAlias = explode('.', $typeAlias);
		$explodedRouter = explode('::', $routerName);

		if (file_exists($routerFile = JPATH_BASE . '/components/' . $explodedAlias[0] . '/helpers/route.php'))
		{
			JLoader::register($explodedRouter[0], $routerFile);
			$routerClass = $explodedRouter[0];
			$routerMethod = $explodedRouter[1];

			if (class_exists($routerClass) && method_exists($routerClass, $routerMethod))
			{
				if ($routerMethod == 'getCategoryRoute')
				{
					$link = $routerClass::$routerMethod($contentItemId, $language);
				}
				else
				{
					$link = $routerClass::$routerMethod($contentItemId . ':' . $contentItemAlias, $contentCatId, $language);
				}
			}
		}

		if ($link == '')
		{
			// Create a fallback link in case we can't find the component router
			$router = new JHelperRoute;
			$link = $router->getRoute($contentItemId, $typeAlias, $link, $language, $contentCatId);
		}

		return $link;
	}

	/**
	 * Tries to load the router for the component and calls it. Otherwise calls getRoute.
	 *
	 * @param   integer  $id  The ID of the tag
	 *
	 * @return  string  URL link to pass to JRoute
	 *
	 * @since   3.1
	 */
	public static function getCatcomplectsRoute($id)
	{
		if ($id < 1) {
			$link = '';
		} else	{
			$link = 'index.php?option=com_catcomplects&view=items&article=' . $id;

      $catid = getItemcatid("article", $id);
      $catalias = getAliasItemcat("id", $catid[1]);
      $itemid = getItemid("alias", $catalias[1]);
      $link .= '&Itemid='.$itemid[0];
		}

		return $link;
	}

	/**
	 * Find Item static function
	 *
	 * @param   array  $needles  Array used to get the language value
	 *
	 * @return null
	 *
	 * @throws Exception
	 */
	protected static function _findItem($needles = null)
	{
		$app      = JFactory::getApplication();
		$menus    = $app->getMenu('site');
		$language = isset($needles['language']) ? $needles['language'] : '*';

		// Prepare the reverse lookup array.
		if (self::$lookup === null)
		{
			self::$lookup = array();

			$component = JComponentHelper::getComponent('com_catcomplects');
			$items     = $menus->getItems('component_id', $component->id);

			if ($items)
			{
				foreach ($items as $item)
				{
					if (isset($item->query) && isset($item->query['view']))
					{
						$lang = ($item->language != '' ? $item->language : '*');

						if (!isset(self::$lookup[$lang]))
						{
							self::$lookup[$lang] = array();
						}

						$view = $item->query['view'];

						if (!isset(self::$lookup[$lang][$view]))
						{
							self::$lookup[$lang][$view] = array();
						}

						// Only match menu items that list one tag
						if (isset($item->query['id']) && is_array($item->query['id']))
						{
							foreach ($item->query['id'] as $position => $itemId)
							{
								if (!isset(self::$lookup[$lang][$view][$item->query['id'][$position]]) || count($item->query['id']) == 1)
								{
									self::$lookup[$lang][$view][$item->query['id'][$position]] = $item->id;
								}
							}
						}
					}
				}
			}
		}

		if ($needles)
		{
			foreach ($needles as $view => $ids)
			{
				if (isset(self::$lookup[$language][$view]))
				{
					foreach ($ids as $id)
					{
						if (isset(self::$lookup[$language][$view][(int) $id]))
						{
							return self::$lookup[$language][$view][(int) $id];
						}
					}
				}
			}
		}
		else
		{
			$active = $menus->getActive();

			if ($active)
			{
				return $active->id;
			}
		}

		return null;
	}
}
