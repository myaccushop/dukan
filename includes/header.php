<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  if ($messageStack->size('header') > 0) {
    echo '<div class="grid_24">' . $messageStack->output('header') . '</div>';
  }

  /* global $session_started;
  // MMA Debug
  echo '<p style="font-weight:bold;color:red;">header.php: action=' . $HTTP_POST_VARS['action'] . ', ' .
       'formid=' . $HTTP_POST_VARS['formid'] . ', ' .
       'session_started=' . $session_started . ', ' .
       'sessiontoken=' . $sessiontoken . '</p>';*/
?>

<div id="header" class="grid_24">
  <div id="storeLogo"><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image(DIR_WS_IMAGES . 'store_logo.png', STORE_NAME) . '</a>'; ?></div>

  <div id="headerShortcuts">
<?php
  echo tep_draw_button(HEADER_TITLE_CART_CONTENTS . ($cart->count_contents() > 0 ? ' (' . $cart->count_contents() . ')' : ''), 'cart', tep_href_link(FILENAME_SHOPPING_CART));
       // tep_draw_button(HEADER_TITLE_CHECKOUT, 'triangle-1-e', tep_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

  //
  // Due to PWA, we never want to show my account and logoff buttons
  //
  // if (tep_session_is_registered('customer_id')
  //     && (!isset($HTTP_GET_VARS['guest'])
  //       && !isset($HTTP_POST_VARS['guest']))
  //     && !$order->customer['is_dummy_account']) {
  //   echo tep_draw_button(HEADER_TITLE_MY_ACCOUNT, 'person', tep_href_link(FILENAME_ACCOUNT, '', 'SSL'));
  // }

  // if (tep_session_is_registered('customer_id')) {
  //   echo tep_draw_button(HEADER_TITLE_LOGOFF, null, tep_href_link(FILENAME_LOGOFF, '', 'SSL'));
  // }
?>
  </div>

<script type="text/javascript">
  $("#headerShortcuts").buttonset();
</script>
</div>

<?php
// if ($PHP_SELF == FILENAME_DEFAULT) {
//   //
//   // Do not show breadcrumb on landing page
//   //
// } else {
?>

<!-- div class="grid_24 ui-widget infoBoxContainer">
  <div class="ui-widget-header infoBoxHeading"><?php echo '&nbsp;&nbsp;' . $breadcrumb->trail(' &raquo; '); ?></div>
</div -->
  <div class="grid_24 bread_trail"><?php echo '&nbsp;&nbsp;' . $breadcrumb->trail(' &raquo; '); ?>
    <div id="search_container">
      <?php echo tep_draw_form('quick_find', tep_href_link(FILENAME_ADVANCED_SEARCH_RESULT, '', 'NONSSL', false), 'get') ?>
      <?php echo tep_draw_input_field('keywords', '', 'size="10" maxlength="30" style="width: 75%"') . '&nbsp;'
        . tep_draw_hidden_field('search_in_description', '1') . tep_hide_session_id()
        . tep_image_submit('button_quick_find.png', MODULE_BOXES_SEARCH_BOX_TITLE) ?>
      </form>
    </div>
  </div>

<?php
  // }
  if (isset($HTTP_GET_VARS['error_message']) && tep_not_null($HTTP_GET_VARS['error_message'])) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr class="headerError">
    <td class="headerError"><?php echo htmlspecialchars(stripslashes(urldecode($HTTP_GET_VARS['error_message']))); ?></td>
  </tr>
</table>
<?php
  }

  if (isset($HTTP_GET_VARS['info_message']) && tep_not_null($HTTP_GET_VARS['info_message'])) {
?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
  <tr class="headerInfo">
    <td class="headerInfo"><?php echo htmlspecialchars(stripslashes(urldecode($HTTP_GET_VARS['info_message']))); ?></td>
  </tr>
</table>
<?php
  }
?>
