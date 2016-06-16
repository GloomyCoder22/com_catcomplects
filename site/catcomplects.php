<?php
/**
 * @version     1.0.0
 * @package     com_catcomplects
 * @copyright   © 2015. Demin Artem. Все права защищены.
 * @license     GNU General Public License версии 2 или более поздней; Смотрите LICENSE.txt
 * @author      Demin Artem <ademin1982@gmail.com> - http://
 */

defined('_JEXEC') or die;

require_once 'components/com_catcomplects/helpers/catcomplects.php';
require_once 'components/com_catcomplects/helpers/complects.php';
require_once 'components/com_catcomplects/helpers/route.php';

// Include dependancies
jimport('joomla.application.component.controller');
JHtml::_('jquery.framework', true);
$doc = JFactory::getDocument();
$doc->addStyleSheet('components/com_catcomplects/assets/css/style.css');
// $doc->addScript('components/com_catcomplects/assets/js/vscripts.js', 'text/javascript', true, true);

// Execute the task.
$controller	= JControllerLegacy::getInstance('Catcomplects');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
