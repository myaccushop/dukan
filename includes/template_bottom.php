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

/*
  if ($oscTemplate->hasBlocks('boxes_column_left')) {
?>

<div id="columnLeft" class="grid_<?php echo $oscTemplate->getGridColumnWidth(); ?> pull_<?php echo $oscTemplate->getGridContentWidth(); ?>">
  <?php echo $oscTemplate->getBlocks('boxes_column_left'); ?>
</div>

<?php
  }

  if ($oscTemplate->hasBlocks('boxes_column_right')) {
?>

<div id="columnRight" class="grid_<?php echo $oscTemplate->getGridColumnWidth(); ?>">
  <?php echo $oscTemplate->getBlocks('boxes_column_right'); ?>
</div>

<?php
  }
  */
  //
  // Pring Information box (need to style it).
  //
  $group = "boxes";
  $class = "bm_information";
  if ( !class_exists($class) ) {
    global $language;
    include(DIR_WS_LANGUAGES . $language . '/modules/' . $group . '/' . $module);
    include(DIR_WS_MODULES . $group . '/' . $class . '.php');
  }

  $mb = new $class();
  $mb->execute();
  echo $mb->html;

?>
</div> <!-- bottomContent -->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

</div> <!-- bodyWrapper //-->

<?php echo $oscTemplate->getBlocks('footer_scripts'); ?>

</body>
</html>
