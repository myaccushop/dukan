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
<div id="bottomContent" class="grid_24">
<?php

$bottom_boxes = array ('information', 'categories');
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
<div class="grid_12 bottom_accu_box">
  <img src="images/store_logo.png" alt="AccuDRO logo">
  <div class="accu_text">555.555.5555</div>
  <div class="accu_text"><a href="mailto:support@accudro.com">support@accudro.com</a></div>

</div>

</div> <!-- bottomContent -->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

</div> <!-- bodyWrapper //-->

<?php echo $oscTemplate->getBlocks('footer_scripts'); ?>

</body>
</html>
