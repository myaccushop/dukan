<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_knowledgebase {
    var $code = 'bm_knowledgebase';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $html = "";

    function bm_knowledgebase() {
      $this->title = MODULE_BOXES_KNOWLEDGEBASE_TITLE;
      $this->description = MODULE_BOXES_KNOWLEDGEBASE_DESCRIPTION;

      if ( defined('MODULE_BOXES_KNOWLEDGEBASE_STATUS') ) {
        $this->sort_order = MODULE_BOXES_KNOWLEDGEBASE_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_KNOWLEDGEBASE_STATUS == 'True');

        $this->group = ((MODULE_BOXES_KNOWLEDGEBASE_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $oscTemplate;

      // $data = '<div class="ui-widget infoBoxContainer grid_6">' .
      //         '  <div class="ui-widget-header infoBoxHeading">' . MODULE_BOXES_KNOWLEDGEBASE_BOX_TITLE . '</div>' .
      //         '  <div class="ui-widget-content infoBoxContents">' .
      //         '    <a href="' . tep_href_link(FILENAME_SHIPPING) . '">' . MODULE_BOXES_KNOWLEDGEBASE_BOX_SHIPPING . '</a><br />' .
      //         '    <a href="' . tep_href_link(FILENAME_PRIVACY) . '">' . MODULE_BOXES_KNOWLEDGEBASE_BOX_PRIVACY . '</a><br />' .
      //         '    <a href="' . tep_href_link(FILENAME_CONDITIONS) . '">' . MODULE_BOXES_KNOWLEDGEBASE_BOX_CONDITIONS . '</a><br />' .
      //         '    <a href="' . tep_href_link(FILENAME_CONTACT_US) . '">' . MODULE_BOXES_KNOWLEDGEBASE_BOX_CONTACT . '</a>' .
      //         '  </div>' .
      //         '</div>';
      $data = '<div class="grid_5 bottom_box">' .
              '  <div class="bottom_box_title">' . MODULE_BOXES_KNOWLEDGEBASE_BOX_TITLE . '</div>' .
              '  <div class="bottom_box_items"> <ul>' .
              '    <li><a href="' . tep_href_link(FILENAME_MAGNETIC_SCALE) . '">' . MODULE_BOXES_KNOWLEDGEBASE_BOX_MAGNETIC_SCALES . '</a></li>' .
              '    <li><a href="' . tep_href_link(FILENAME_REMOTE_CONTROL) . '">' . MODULE_BOXES_KNOWLEDGEBASE_BOX_REMOTE_CONTROL . '</a></li>' .
              '    <li><a href="' . tep_href_link(FILENAME_KB_VIDEOS) . '">' . MODULE_BOXES_KNOWLEDGEBASE_BOX_VIDEOS . '</a></li>' .
              '    <li><a href="' . tep_href_link(FILENAME_KB_MANUALS) . '">' . MODULE_BOXES_KNOWLEDGEBASE_BOX_MANUALS . '</a></li>' .
              '    <li><a href="' . tep_href_link(FILENAME_KB_FAQ) . '">' . MODULE_BOXES_KNOWLEDGEBASE_BOX_FAQ . '</a></li>' .

              '  </ul></div>' .
              '</div>';
      $this->html = $data;
      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_KNOWLEDGEBASE_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Information Module', 'MODULE_BOXES_KNOWLEDGEBASE_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_KNOWLEDGEBASE_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_KNOWLEDGEBASE_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_KNOWLEDGEBASE_STATUS', 'MODULE_BOXES_KNOWLEDGEBASE_CONTENT_PLACEMENT', 'MODULE_BOXES_KNOWLEDGEBASE_SORT_ORDER');
    }
  }
?>
