<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
//$app = JFactory::getApplication();
//$menu = $app->getMenu();
//$Itemid	= $menu->getActive()->id;

$doc = JFactory::getDocument();
$CanonicalLink = 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
$siteurl = 'http://'.$_SERVER["HTTP_HOST"];
$doc->addHeadLink($CanonicalLink, 'canonical');
$model = $this->getModel();

$flag = 'complect';
if (!isset($complect)) $complect = $this->complect;
?>
<!-- <script src="components/com_catcomplects/assets/js/complects.js" type="text/javascript"></script> -->
<div id="items" itemscope itemtype="http://schema.org/ItemList">
  <h1 itemprop="name">Комплект вывесок «<?php echo $complect->name; ?>»</h1>
  <link itemprop="url" href="<?php echo $CanonicalLink; ?>" />
  <div class="block-text">
    <p><?php echo $complect->description; ?></p>
  </div>
  <!--<div class="lozung">Не теряйте время, закажите сейчас и сэкономьте до 70%!</div><br /> -->


  <?php if ($complect->state == 1) { ?>
    <?php include(JPATH_COMPONENT . "/views/complect/tmpl/complect.php"); ?>
    <div class="jComments">
    <?php 
    /*
      $comments = JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_jcomments'.DIRECTORY_SEPARATOR.'jcomments.php';
      if (file_exists($comments)) {
        require_once($comments);
        echo JComments::showComments($complect->article, 'com_catcomplects', $complect->title);
      }
    */
    ?>
    </div>
  <?php } ?>
</div>
<div class="vs_hr"></div>
<?php include("media/zvonok_vs/zvonok_vs.php"); ?>
<div class="clear"></div>
