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
<div id="bottomContent" class="bottomContent grid_24">
<?php

$bottom_boxes = array ('information', 'categories', 'knowledgebase');
foreach ($bottom_boxes as $box_type) {
  //
  // Print Information box (need to style it).
  //
  $group = "boxes";
  $class = "bm_" . $box_type;
  if ( !class_exists($class) ) {
    global $language;
    $module = $class . '.php';
    include(DIR_WS_LANGUAGES . $language . '/modules/' . $group . '/' . $module);
    include(DIR_WS_MODULES . $group . '/' . $class . '.php');
  }

  $mb = new $class();
  $mb->execute();
  echo $mb->html;
}

?>
<div class="grid_9 bottom_accu_box">
  <img src="images/store_logo.png" alt="AccuDRO logo" width="100px">
  <div class="accu_text">555.555.5555</div>
  <div class="accu_text"><a href="mailto:support@accudro.com">support@accudro.com</a></div>
  <!-- PayPal Logo --><a href="#" onclick="javascript:window.open('https://www.paypal.com/cgi-bin/webscr?cmd=xpt/Marketing/popup/OLCWhatIsPayPal-outside','olcwhatispaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=400, height=350');"><img  src="https://www.paypal.com/en_US/i/bnr/horizontal_solution_PPeCheck.gif" border="0" alt="Solution Graphics" width="150px"></a><!-- PayPal Logo -->
  <a href="//www.PositiveSSL.com" title="SSL Certificate Authority" style="font-family: arial; font-size: 10px; text-decoration: none;"><img src="images/PositiveSSL_tl_trans.gif" alt="SSL Certificate Authority" title="SSL Certificate Authority" border="0" width="60px" /></a>

</div>

</div> <!-- bottomContent -->

<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

</div> <!-- bodyWrapper //-->

<?php echo $oscTemplate->getBlocks('footer_scripts'); ?>

</body>
</html>
