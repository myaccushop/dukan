<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_information {
    var $code = 'bm_information';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $html = "";

    function bm_information() {
      $this->title = MODULE_BOXES_INFORMATION_TITLE;
      $this->description = MODULE_BOXES_INFORMATION_DESCRIPTION;

      if ( defined('MODULE_BOXES_INFORMATION_STATUS') ) {
        $this->sort_order = MODULE_BOXES_INFORMATION_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_INFORMATION_STATUS == 'True');

        $this->group = ((MODULE_BOXES_INFORMATION_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $oscTemplate;

      // $data = '<div class="ui-widget infoBoxContainer grid_6">' .
      //         '  <div class="ui-widget-header infoBoxHeading">' . MODULE_BOXES_INFORMATION_BOX_TITLE . '</div>' .
      //         '  <div class="ui-widget-content infoBoxContents">' .
      //         '    <a href="' . tep_href_link(FILENAME_SHIPPING) . '">' . MODULE_BOXES_INFORMATION_BOX_SHIPPING . '</a><br />' .
      //         '    <a href="' . tep_href_link(FILENAME_PRIVACY) . '">' . MODULE_BOXES_INFORMATION_BOX_PRIVACY . '</a><br />' .
      //         '    <a href="' . tep_href_link(FILENAME_CONDITIONS) . '">' . MODULE_BOXES_INFORMATION_BOX_CONDITIONS . '</a><br />' .
      //         '    <a href="' . tep_href_link(FILENAME_CONTACT_US) . '">' . MODULE_BOXES_INFORMATION_BOX_CONTACT . '</a>' .
      //         '  </div>' .
      //         '</div>';
      $data = '<div class="grid_5 bottom_box">' .
              '  <div class="bottom_box_title">' . MODULE_BOXES_INFORMATION_BOX_TITLE . '</div>' .
              '  <div class="bottom_box_items"> <ul>' .
              '    <li><a href="' . tep_href_link(FILENAME_SHIPPING) . '">' . MODULE_BOXES_INFORMATION_BOX_SHIPPING . '</a></li>' .
              '    <li><a href="' . tep_href_link(FILENAME_RETURNS) . '">' . MODULE_BOXES_INFORMATION_BOX_RETURNS . '</a></li>' .
              '    <li><a href="' . tep_href_link(FILENAME_WARRANTY) . '">' . MODULE_BOXES_INFORMATION_BOX_WARRANTY . '</a></li>' .
              '    <li><a href="' . tep_href_link(FILENAME_FAQ) . '">' . MODULE_BOXES_INFORMATION_BOX_FAQ . '</a></li>' .
              '    <li><a href="' . tep_href_link(FILENAME_ABOUT) . '">' . MODULE_BOXES_INFORMATION_BOX_ABOUT . '</a></li>' .
              '    <li><a href="https://twitter.com/AccuDRO" class="twitter-follow-button" data-show-count="false" data-show-screen-name="false">Follow @AccuDRO</a></li>' .
              '  </ul></div>' .
             '</div>';


      $this->html = $data;
      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_INFORMATION_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Information Module', 'MODULE_BOXES_INFORMATION_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_INFORMATION_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_INFORMATION_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_INFORMATION_STATUS', 'MODULE_BOXES_INFORMATION_CONTENT_PLACEMENT', 'MODULE_BOXES_INFORMATION_SORT_ORDER');
    }
  }
?>
