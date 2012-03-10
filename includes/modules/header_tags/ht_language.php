<?php
/*
  $Id: ht_language.php v1.0 20110103 Kymation $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2011 osCommerce

  Released under the GNU General Public License
*/

  class ht_language {
    var $code = 'ht_language';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function ht_language() {
      $this->title = MODULE_HEADER_TAGS_LANGUAGE_TITLE;
      $this->description = MODULE_HEADER_TAGS_LANGUAGE_DESCRIPTION;

      if ( defined( 'MODULE_HEADER_TAGS_LANGUAGE_STATUS' ) ) {
        $this->sort_order = MODULE_HEADER_TAGS_LANGUAGE_SORT_ORDER;
        $this->enabled = ( MODULE_HEADER_TAGS_LANGUAGE_STATUS == 'True' );
      }
    }

    function execute() {
    	global $oscTemplate, $languages_id;

      $language_query_raw = "
        select
          code
        from
          " . TABLE_LANGUAGES . "
        where languages_id = '" . ( int )$languages_id . "'
      ";
      $language_query = tep_db_query( $language_query_raw );

      if( tep_db_num_rows( $language_query ) > 0 ) {
        $language_info = tep_db_fetch_array( $language_query );

        $meta_tag = '<meta http-equiv="content-language" content="' . $language_info['code'] . '" />';
        $oscTemplate->addBlock( $meta_tag, $this->group );
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined( 'MODULE_HEADER_TAGS_LANGUAGE_STATUS' );
    }

    function install() {
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Language Meta Tag', 'MODULE_HEADER_TAGS_LANGUAGE_STATUS', 'True', 'Do you want to add the language tag to all pages?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_LANGUAGE_SORT_ORDER', '260', 'Sort order of display. Lowest is displayed first.', '6', '2', now())" );
    }

    function remove() {
      tep_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
    	$keys_array = array();

      $keys_array[] = 'MODULE_HEADER_TAGS_LANGUAGE_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_LANGUAGE_SORT_ORDER';

      return $keys_array;
    }
  }
?>
