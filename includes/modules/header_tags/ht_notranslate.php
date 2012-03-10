<?php
/*
  $Id: ht_notranslate.php v1.0 20101128 Kymation $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class ht_notranslate {
    var $code = 'ht_notranslate';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $languages_array = array();

    function ht_notranslate() {
      $this->title = MODULE_HEADER_TAGS_NOTRANSLATE_TITLE;
      $this->description = MODULE_HEADER_TAGS_NOTRANSLATE_DESCRIPTION;

      if ( defined('MODULE_HEADER_TAGS_NOTRANSLATE_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_NOTRANSLATE_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_NOTRANSLATE_STATUS == 'True');
      }
    }

    function execute() {
    	global $oscTemplate;

      $meta_tag = '<meta name="google" content="notranslate" />';
      $oscTemplate->addBlock( $meta_tag, $this->group );
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined( 'MODULE_HEADER_TAGS_NOTRANSLATE_STATUS' );
    }

    function install() {
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('No Translate Meta Tag', 'MODULE_HEADER_TAGS_NOTRANSLATE_STATUS', 'True', 'Do you want to add a notranslate tag to all pages?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_NOTRANSLATE_SORT_ORDER', '40', 'Sort order of display. Lowest is displayed first.', '6', '2', now())" );
    }

    function remove() {
      tep_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
    	$keys_array = array();

      $keys_array[] = 'MODULE_HEADER_TAGS_NOTRANSLATE_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_NOTRANSLATE_SORT_ORDER';

      return $keys_array;
    }
  }
?>
