<?php
/**
 * @version     1.0.0
 * @package     com_catcomplects
 * @copyright   © 2015. Demin Artem. Все права защищены.
 * @license     GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
 * @author      Demin Artem <ademin1982@gmail.com> - http://
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.'/controller.php';

/**
 * Complects list controller class.
 */
class CatcomplectsControllerComplects extends CatcomplectsController
{
	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Complects', $prefix = 'CatcomplectsModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}