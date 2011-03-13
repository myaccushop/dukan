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
      global $HTTP_GET_VARS, $languages_id, $currencies, $oscTemplate;

      $nav_counter = 0;

      $data = <<<LOF
<script type="text/javascript">
$(document).ready( function(){
  var buttons_f = { previous  : \$('#lofslidecontent45_features .lof-previous') ,
                  next      : \$('#lofslidecontent45_features .lof-next') };

  \$obj_f = $('#lofslidecontent45_features').lofJSidernews( {
    interval        : 7000,
    easing          : 'easeInOutQuad',
    duration        : 1200,
    auto            : false,
    maxItemDisplay  : 5,
    navItemsSelector    : '.lof-navigator li.fs',
    mainWidth       : 475,
    navPosition     : 'horizontal', // horizontal
    navigatorHeight : 15,
    navigatorWidth  : 25,
    buttons         : buttons_f} );
});
</script>
LOF;
      $data .= '<div class="grid_12 bottom_box box_with_image omega">' .
                '  <div class="bottom_box_title">' . MODULE_BOXES_FEATURES_BOX_TITLE . '</div>';

      // $data .= $this->getSlider();
      $data .= <<<LOF
  <ul>
    <li><a href="f1.html">Magnetic Scale</a></li>
    <li><a href="f2.html">Remote Control</a></li>
  </ul>
LOF;
      $data .= '</div>';

      $this->html = $data;
      $oscTemplate->addBlock($data, $this->group);
    }

    function getSlider () {
      $data .= '  <div id="lofslidecontent45_features" class="lof-slidecontent grid_12" style="height:250px;margin: 1em 0 0 0;">';
      $data .= '    <div class="preload"><div></div></div>';
      $data .= '    <div class="lof-main-outer grid_12 alpha omega" style="height:250px;">' . "\n";
      $data .= '      <div onclick="return false" href="" class="lof-previous">Previous</div>' . "\n";
      $data .= '      <ul class="lof-main-wapper">' . "\n";

      $counter = 5;
      while ($nav_counter < $counter) {
        $nav_counter++;
        $data .= '      <li class="slide grid_12 alpha omega" style="color: #000; font-weight: bold;">';
        $data .= '<img height="250px" /><div style="float: left">Slide text ' . $nav_counter . ' </div>';

        // $data .= '<div class="lof-main-item-desc grid_12">' . "\n";
        // $data .= '  <h3>Read more slide ' . $nav_counter . '</a>'. "\n";
        // $data .= "</div>\n";
        $data .= "      </li>\n";
      }

      $data .= "      </ul>\n";
      $data .= '      <div onclick="return false" href="" class="lof-next">Next</div>' . "\n";
      $data .= "    </div>\n";

      $data .= "    <div class=\"lof-navigator-wapper\">\n";
      $data .= "      <div class=\"lof-navigator-outer\">\n";
      $data .= "        <ul class=\"lof-navigator\">\n";
      $nav_counter = 0;
      while ($nav_counter < $counter) {
        $nav_counter++;
        $data .= '        <li class="fs"><span>' . $nav_counter . "</span></li>\n";
      }
      $data .= "        </ul>\n";
      $data .= "      </div>\n";
      $data .= "    </div>\n";
      $data .= "  </div>\n";

      return $data;
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_BOXES_FEATURES_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Specials Module', 'MODULE_BOXES_FEATURES_STATUS', 'True', 'Do you want to add the module to your shop?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Content Placement', 'MODULE_BOXES_FEATURES_CONTENT_PLACEMENT', 'Right Column', 'Should the module be loaded in the left or right column?', '6', '1', 'tep_cfg_select_option(array(\'Left Column\', \'Right Column\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_BOXES_FEATURES_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_BOXES_FEATURES_STATUS', 'MODULE_BOXES_FEATURES_CONTENT_PLACEMENT', 'MODULE_BOXES_FEATURES_SORT_ORDER');
    }
  }
?>
