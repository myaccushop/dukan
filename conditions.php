<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_CONDITIONS);
  require(DIR_WS_LANGUAGES . $language . '/' .FILENAME_WARRANTY);
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_RETURNS);
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SHIPPING);


  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_CONDITIONS));

  require(DIR_WS_INCLUDES . 'template_top.php');
?>



<div class="contentContainer">
  <div class="contentText">
    <?php echo TEXT_INFORMATION; ?>
    <hr style="width: 960px; height: 5px; color: rgb(9, 12, 9); border-style: solid; margin-left: 0px; margin-right: auto;" />
    <h1> Warranty </h1>
    <?php echo TEXT_WARRANTY_INFORMATION; ?>
    <hr style="width: 960px; height: 5px; color: rgb(9, 12, 9); border-style: solid; margin-left: 0px; margin-right: auto;" />
    <h1> Returns </h1>
    <?php echo TEXT_RETURNS_INFORMATION; ?>
    <hr style="width: 960px; height: 5px; color: rgb(9, 12, 9); border-style: solid; margin-left: 0px; margin-right: auto;" />
    <h1> Shipping </h1>
    <?php echo TEXT_SHIPPING_INFORMATION; ?>
  </div>
  <div class="buttonSet">
    <span class="buttonAction"><?php echo tep_draw_button(IMAGE_BUTTON_CONTINUE, 'triangle-1-e', tep_href_link(FILENAME_DEFAULT)); ?></span>
  </div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
