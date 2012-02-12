<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/


  class bm_features {
    var $code = 'bm_features';
    var $group = 'boxes';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function bm_features() {
      $this->title = MODULE_BOXES_FEATURES_TITLE;
      $this->description = MODULE_BOXES_FEATURES_DESCRIPTION;

      if ( defined('MODULE_BOXES_FEATURES_STATUS') ) {
        $this->sort_order = MODULE_BOXES_FEATURES_SORT_ORDER;
        $this->enabled = (MODULE_BOXES_FEATURES_STATUS == 'True');

        $this->group = ((MODULE_BOXES_FEATURES_CONTENT_PLACEMENT == 'Left Column') ? 'boxes_column_left' : 'boxes_column_right');
      }
    }

     function execute() {
      global $oscTemplate;
      $data = '<div class="grid_11 bottom_box">' .
        '      <div class="bottom_box_title">' . MODULE_BOXES_FEATURES_TITLE . '</div>' .
        '      <div class="bottom_box_items"> ' .
         '	<div id="slider3">'.
         '		<a class=butt1ons_tiny_carousel prev" href="#">left</a>'.
         '		<div class="viewport">'.
         '			<ul class="overview">'.
         '				<li><a href="' . tep_href_link(FILENAME_MAGNETIC_SCALE) . '">' . MODULE_BOXES_FEATURES_BOX_MAGNETIC_SCALES . '<img src="images/magnetic_scale.JPG" width="240" height="125" />  </a></li>'.
         '				<li><a href="' . tep_href_link(FILENAME_REMOTE_CONTROL) . '">' . MODULE_BOXES_FEATURES_BOX_REMOTE_CONTROL . '<img src="images/remote_controller_small.JPG" width="240" height="125" /></a></li>'.
         '				<li><a href="' . tep_href_link(FILENAME_MAGNETIC_SCALE) . '">' . MODULE_BOXES_FEATURES_BOX_MAGNETIC_SCALES . '<img src="images/magnetic_head.JPG" width="240" height="125" /></a></li>'.
         '			</ul>'.
         '		</div>'.
         '		<a class="butt1ons_tiny_carousel next" href="#">right</a>'.
         '                  <ul class="pager">'.
         '                    <li><a rel="0" class="pagenum" href="#">1</a></li>'.
         '                    <li><a rel="1" class="pagenum" href="#">2</a></li>'.
         '                    <li><a rel="2" class="pagenum" href="#">3</a></li>'.
         '                 </ui>'.
         '	</div>'.
         '     </div>'.
         '  </div>';
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
