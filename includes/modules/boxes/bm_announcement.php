<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class bm_announcement {
    var $code = 'bm_announcement';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $html = "";

    function bm_announcement() {
      $this->title = MODULE_BOXES_ANNOUNCEMENT_TITLE;
      $this->description = MODULE_BOXES_ANNOUNCEMENT_DESCRIPTION;

      if ( defined('MODULE_BOXES_ANNOUNCEMENT_STATUS') ) {
        $this->sort_order = MODULE_BOXES_ANNOUNCEMENT_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_ANNOUNCEMENT_STATUS == 'True');

        $this->group = ((MODULE_BOXES_ANNOUNCEMENT_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

    function execute() {
      global $oscTemplate;

      // include the welcome file
      include (DIR_WS_LANGUAGES . english. '/' . MODULE_BOXES_ANNOUNCEMENT_WELCOME_BOX_FILENAME);

      $data = '<div class="grid_23 bottom_box" >' .
        //              '  <div class="bottom_box_title">' . MODULE_BOXES_ANNOUNCEMENT_BOX_TITLE . '</div>' .
        '      <div class="bottom_box_items"> ' .
                      ' '. TEXT_WELCOME_INFORMATION .' '.
         '     </div>'.
        '</br></div>';
      $this->html = $data;
      $oscTemplate->addBlock($data, $this->group);
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_ANNOUNCEMENT_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Announcement Module', 'MODULE_BOXES_ANNOUNCEMENT_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_ANNOUNCEMENT_CONTENT_PLACEMENT', 'Left Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_ANNOUNCEMENT_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_ANNOUNCEMENT_STATUS', 'MODULE_BOXES_ANNOUNCEMENT_CONTENT_PLACEMENT', 'MODULE_BOXES_ANNOUNCEMENT_SORT_ORDER');
    }
  }
?>
