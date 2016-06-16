<?php
defined('_JEXEC') or die;

//jimport('joomla.application.component.view');
class CatcomplectsViewComplectcart extends JViewLegacy {
  protected $params;

  public function display($tpl = null) {
    $app = JFactory::getApplication();
    $this->params = $app->getParams('com_catcomplects');
    
    $model = $this->getModel();
    $params_array = $this->params->toArray();
    $complect_id = 0;
    $item = [];
    $i = 0;

    if (isset($params_array['cmpl_id'])) {
      if ($params_array['cmpl_id'] == '0') {
        if (isset($_POST['complect_id'])) $complect_id = $_POST['complect_id'];
        if (isset($_POST['cmpl_formsend']) || isset($_POST['mod_item_submit'])){
          $form_post_arr = $_POST;
          foreach ($form_post_arr as $key => $form_item) {
            $key_arr = explode('_',$key);
            if ($key_arr[0] == 'item') {
              $item[$i] = $model->getItem($key_arr[1]);
              $item[$i]->foncolor = 'none';
              $item[$i]->wordcolor = 'none';
              $item[$i]->item_address = 'none';
              $item[$i]->item_timework = 'none';
              if ($item[$i]->color_back != '0') $item[$i]->foncolor = 'E6E6E6';
              if ($item[$i]->color_word != '0') $item[$i]->wordcolor = 'E6E6E6';
              if ($item[$i]->address != '0') $item[$i]->item_address = '';
              if ($item[$i]->time_work != '0') $item[$i]->item_timework = '';
              
              foreach ($form_post_arr as $key2 => $form_params) {
                $key_arr2 = explode('_',$key2);
                if ($key_arr2[0] == 'foncolor' && $key_arr2[1] == $item[$i]->article) {
                  $item[$i]->foncolor = $form_params;
                }
                if ($key_arr2[0] == 'wordcolor' && $key_arr2[1] == $item[$i]->article) {
                  $item[$i]->wordcolor = $form_params;
                }
                if ($key_arr2[0] == 'address' && $key_arr2[1] == $item[$i]->article) {
                  $item[$i]->item_address = $form_params;
                }
                if ($key_arr2[0] == 'timework' && $key_arr2[1] == $item[$i]->article) {
                  $item[$i]->item_timework = $form_params;
                }            
              }
              $i = $i + 1;
            }
          }
        } else {
          if (!empty($_COOKIE["vs_cart"])) {
            $vs_coockie = json_decode($_COOKIE["vs_cart"], true);
            foreach ($vs_coockie as $key => $items) {
              $items_arr = explode("-", $items);
              if (!isset($items_arr[1])) {
                $item[$i] = $model->getItem($items);
                if ($item[$i]->color_back != '0') {
                  $item[$i]->foncolor = 'E6E6E6';
                } else {
                  $item[$i]->foncolor = 'none';
                }            
              } else {
                $item[$i] = $model->getItem($items_arr[0]);
                $item[$i]->article = $items;
                if ($item[$i]->color_back != '0') {
                  $item[$i]->foncolor = $items_arr[1];
                } else {
                  $item[$i]->foncolor = 'none';
                }
              }
              
              if ($item[$i]->color_word != '0') {
                $item[$i]->wordcolor = 'E6E6E6';
              } else {
                $item[$i]->wordcolor = 'none';
              }
              if ($item[$i]->address != '0') {
                $item[$i]->item_address = '';
              } else {
                $item[$i]->item_address = 'none';
              }          
              if ($item[$i]->time_work != '0') {
                $item[$i]->item_timework = '';
              } else {
                $item[$i]->item_timework = 'none';
              }           
              $i = $i + 1;
            }
          }        
        }
      }
    } else {
      if (!empty($_COOKIE["vs_cart"])) {
        $vs_coockie = json_decode($_COOKIE["vs_cart"], true);
        foreach ($vs_coockie as $key => $items) {
          $items_arr = explode("-", $items);
          if (!isset($items_arr[1])) {
            $item[$i] = $model->getItem($items);
            if ($item[$i]->color_back != '0') {
              $item[$i]->foncolor = 'E6E6E6';
            } else {
              $item[$i]->foncolor = 'none';
            }            
          } else {
            $item[$i] = $model->getItem($items_arr[0]);
            $item[$i]->article = $items;
            if ($item[$i]->color_back != '0') {
              $item[$i]->foncolor = $items_arr[1];
            } else {
              $item[$i]->foncolor = 'none';
            }
          }
          
          if ($item[$i]->color_word != '0') {
            $item[$i]->wordcolor = 'E6E6E6';
          } else {
            $item[$i]->wordcolor = 'none';
          }
          if ($item[$i]->address != '0') {
            $item[$i]->item_address = '';
          } else {
            $item[$i]->item_address = 'none';
          }          
          if ($item[$i]->time_work != '0') {
            $item[$i]->item_timework = '';
          } else {
            $item[$i]->item_timework = 'none';
          }           
          $i = $i + 1;
        }
      }
    }
    $this->assignRef('complect_id',$complect_id);
    $this->assignRef('item',$item);
    
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
    $doc->addStyleSheet('components/com_catcomplects/assets/css/cart.css');
    $doc->addScript('components/com_catcomplects/assets/js/cart.js', 'text/javascript', true, true);

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
