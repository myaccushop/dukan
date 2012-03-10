<?php
/*
  $Id: ht_googlebot.php v1.0 20101128 Kymation $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class ht_googlebot {
    var $code = 'ht_googlebot';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $languages_array = array();

    function ht_googlebot() {
      $this->title = MODULE_HEADER_TAGS_GOOGLEBOT_TITLE;
      $this->description = MODULE_HEADER_TAGS_GOOGLEBOT_DESCRIPTION;

      if ( defined('MODULE_HEADER_TAGS_GOOGLEBOT_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_GOOGLEBOT_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_GOOGLEBOT_STATUS == 'True');
      }
    }

    function execute() {
    	global $oscTemplate;

    	$tag_array = array();
    	if( MODULE_HEADER_TAGS_GOOGLEBOT_NOINDEX == 'True' )  $tag_array[] = 'noindex';
    	if( MODULE_HEADER_TAGS_GOOGLEBOT_NOFOLLOW == 'True' )  $tag_array[] = 'nofollow';
    	if( MODULE_HEADER_TAGS_GOOGLEBOT_NOSNIPPET == 'True' )  $tag_array[] = 'nosnippit';
    	if( MODULE_HEADER_TAGS_GOOGLEBOT_NOODP == 'True' )  $tag_array[] = 'noodp';
    	if( MODULE_HEADER_TAGS_GOOGLEBOT_NOARCHIVE == 'True' )  $tag_array[] = 'noarchive';
    	if( MODULE_HEADER_TAGS_GOOGLEBOT_NOIMAGEINDEX == 'True' )  $tag_array[] = 'noimageindex';

      if( count( $tag_array ) > 0 ) {
        $tag_string = implode( ',', $tag_array );
        $meta_tag = '<meta name="googlebot" content="' . $tag_string . '" />';

        $oscTemplate->addBlock( $meta_tag, $this->group );
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined( 'MODULE_HEADER_TAGS_GOOGLEBOT_STATUS' );
    }

    function install() {
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Googlebot Meta Tag Module', 'MODULE_HEADER_TAGS_GOOGLEBOT_STATUS', 'True', 'Do you want to add a googlebot meta tag to all pages?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_GOOGLEBOT_SORT_ORDER', '60', 'Sort order of display. Lowest is displayed first.', '6', '2', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Noindex Tag', 'MODULE_HEADER_TAGS_GOOGLEBOT_NOINDEX', 'False', 'Add the noindex tag?.', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Nofollow Tag', 'MODULE_HEADER_TAGS_GOOGLEBOT_NOFOLLOW', 'False', 'Add the nofollow tag?.', '6', '4', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Nosnippit Tag', 'MODULE_HEADER_TAGS_GOOGLEBOT_NOSNIPPET', 'False', 'Add the nosnippit tag?.', '6', '5', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('NoODP Tag', 'MODULE_HEADER_TAGS_GOOGLEBOT_NOODP', 'False', 'Add the noodp tag?.', '6', '6', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Noarchive Tag', 'MODULE_HEADER_TAGS_GOOGLEBOT_NOARCHIVE', 'False', 'Add the noarchive tag?.', '6', '7', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Noimageindex Tag', 'MODULE_HEADER_TAGS_GOOGLEBOT_NOIMAGEINDEX', 'False', 'Add the noimageindex tag?.', '6', '8', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
    }

    function remove() {
      tep_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
    	$keys_array = array();

      $keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_SORT_ORDER';
    	$keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_NOINDEX';
    	$keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_NOFOLLOW';
    	$keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_NOSNIPPET';
    	$keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_NOODP';
    	$keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_NOARCHIVE';
    	$keys_array[] = 'MODULE_HEADER_TAGS_GOOGLEBOT_NOIMAGEINDEX';

      return $keys_array;
    }
  }
?>
