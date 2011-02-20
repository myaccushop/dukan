<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/
?>

</div> <!-- bodyContent //-->
<div id="bottomContent" class="grid_24 alpha omega">
<?php

$bottom_boxes = array ('information', 'whats_new');
foreach ($bottom_boxes as $box_type) {
  //
  // Print Information box (need to style it).
  //
  $group = "boxes";
  $class = "bm_" . $box_type;
  if ( !class_exists($class) ) {
    global $language;
    include(DIR_WS_LANGUAGES . $language . '/modules/' . $group . '/' . $module);
    include(DIR_WS_MODULES . $group . '/' . $class . '.php');
  }

  $mb = new $class();
  $mb->execute();
  echo $mb->html;
}

?>
</div> <!-- bottomContent -->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

</div> <!-- bodyWrapper //-->

<?php echo $oscTemplate->getBlocks('footer_scripts'); ?>

</body>
</html>
