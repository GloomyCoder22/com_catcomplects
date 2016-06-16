<?php
/**
 * @version     1.0.0
 * @package     com_catcomplects
 * @copyright   © 2015. Demin Artem. Все права защищены.
 * @license     GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
 * @author      Demin Artem <ademin1982@gmail.com> - http://
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_catcomplects')) 
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

$controller	= JControllerLegacy::getInstance('Catcomplects');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
