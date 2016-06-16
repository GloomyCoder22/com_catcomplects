<?php
defined('_JEXEC') or die;

//jimport('joomla.application.component.view');
class CatcomplectsViewCalc extends JViewLegacy {
  protected $params;

  public function display($tpl = null) {
    $app = JFactory::getApplication();
    $this->params = $app->getParams('com_catcomplects');
    $model = $this->getModel();

    // $this->assignRef('items',$items);

    // Check for errors.
    if (count($errors = $this->get('Errors'))) {
      throw new Exception(implode("\n", $errors));
    }
           
    $this->_prepareDocument(); 
    parent::display($tpl);
  }
 
  protected function _prepareDocument() {
    $app = JFactory::getApplication();
    $menus = $app->getMenu();
    $title = null;

    $doc = JFactory::getDocument();
    $doc->addStyleSheet('//yastatic.net/jquery-ui/1.11.2/themes/redmond/jquery-ui.min.css');
    $doc->addScript('//yastatic.net/jquery-ui/1.11.2/jquery-ui.min.js', 'text/javascript');
    
    $doc->addStyleSheet('components/com_catcomplects/assets/css/calc.css');
    $doc->addScript('components/com_catcomplects/assets/js/calc.min.js', 'text/javascript', true, true);

    $menu = $menus->getActive();
    if ($menu) {
      $this->params->def('page_heading', $this->params->get('page_title', $menu->title));
    } else {
      $this->params->def('page_heading', JText::_('COM_CATCOMPLECTS_DEFAULT_PAGE_TITLE'));
    }
    $title = $this->params->get('page_title', '');
    if (empty($title)) {
      $title = $app->getCfg('sitename');
    } elseif ($app->getCfg('sitename_pagetitles', 0) == 1) {
      $title = JText::sprintf('JPAGETITLE', $app->getCfg('sitename'), $title);
    } elseif ($app->getCfg('sitename_pagetitles', 0) == 2) {
      $title = JText::sprintf('JPAGETITLE', $title, $app->getCfg('sitename'));
    }
      $this->document->setTitle($title);

    if ($this->params->get('menu-meta_description')) {
      $this->document->setDescription($this->params->get('menu-meta_description'));
    }

    if ($this->params->get('menu-meta_keywords')) {
      $this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
    }

    if ($this->params->get('robots')) {
      $this->document->setMetadata('robots', $this->params->get('robots'));
    }
  }
   
}
