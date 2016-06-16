<?php
defined('_JEXEC') or die;

//jimport('joomla.application.component.view');
class CatcomplectsViewItems extends JViewLegacy {
  protected $params;

  public function display($tpl = null) {
    $app = JFactory::getApplication();
    $this->params = $app->getParams('com_catcomplects');
    $model = $this->getModel();

    $input = $app->input;
    $item_article = $input->getCmd('article', '');

    $params_array = $this->params->toArray();
    if (!empty($item_article)) {
      $item = $model->getItem($item_article);
      $items = $model->getCatItems($item->catid);
      $cat = $model->getCat($item->catid);
             
      $tpl = 'page';
    } elseif (isset($params_array['cat_id'])) {
      if ($params_array['cat_id'] == '0') {
        $items = $model->getItems();
        $cats = $model->getCats();
      } else {
        $items = $model->getCatItems($params_array['cat_id']);
        uasort($items,"items_sort_np");
        $cat = $model->getCat($params_array['cat_id']);
                    
        $tpl = 'category';
      }
    }
    
    $this->assignRef('item',$item);
    $this->assignRef('items',$items);
    $this->assignRef('cats',$cats);
    $this->assignRef('cat',$cat);

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
    $doc->addStyleSheet('components/com_catcomplects/assets/css/items.css');
    $doc->addScript('components/com_catcomplects/assets/js/items.js', 'text/javascript', true, true);

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
