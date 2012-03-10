<?php
/*
  $Id: ht_robots.php v1.0 20101128 Kymation $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class ht_robots {
    var $code = 'ht_robots';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $languages_array = array();

    function ht_robots() {
      $this->title = MODULE_HEADER_TAGS_ROBOTS_TITLE;
      $this->description = MODULE_HEADER_TAGS_ROBOTS_DESCRIPTION;

      if ( defined('MODULE_HEADER_TAGS_ROBOTS_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_ROBOTS_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_ROBOTS_STATUS == 'True');
      }
    }

    function execute() {
    	global $oscTemplate;

    	$set_noindex = false;
    	$get_vars = explode( ',', MODULE_HEADER_TAGS_ROBOTS_NOINDEX_ON );
    	if( count( $get_vars ) > 0 ) {
    	  foreach( $get_vars as $get_var ) {
    	    if( isset( $_GET[$get_var] ) ) {
    	      $set_noindex = true;
    	      break;
    	    }
    	  }
    	}

      $tag_array = array();
      if( $set_noindex == true || MODULE_HEADER_TAGS_ROBOTS_NOINDEX == 'True' ) {
        $tag_array[] = 'noindex';
      }
    	if( MODULE_HEADER_TAGS_ROBOTS_NOFOLLOW == 'True' )  $tag_array[] = 'nofollow';
    	if( MODULE_HEADER_TAGS_ROBOTS_NOSNIPPET == 'True' )  $tag_array[] = 'nosnippit';
    	if( MODULE_HEADER_TAGS_ROBOTS_NOODP == 'True' )  $tag_array[] = 'noodp';
    	if( MODULE_HEADER_TAGS_ROBOTS_NOARCHIVE == 'True' )  $tag_array[] = 'noarchive';
    	if( MODULE_HEADER_TAGS_ROBOTS_NOIMAGEINDEX == 'True' )  $tag_array[] = 'noimageindex';

      if( count( $tag_array ) > 0 ) {
        $tag_string = implode( ',', $tag_array );
        $meta_tag = '<meta name="robots" content="' . $tag_string . '" />';

        $oscTemplate->addBlock( $meta_tag, $this->group );
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined( 'MODULE_HEADER_TAGS_ROBOTS_STATUS' );
    }

    function install() {
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Robots Meta Tag', 'MODULE_HEADER_TAGS_ROBOTS_STATUS', 'True', 'Do you want to add a robots meta tag to all pages?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_ROBOTS_SORT_ORDER', '50', 'Sort order of display. Lowest is displayed first.', '6', '2', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Noindex Tag', 'MODULE_HEADER_TAGS_ROBOTS_NOINDEX', 'False', 'Add the noindex tag?.', '6', '3', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Noindex on Flags', 'MODULE_HEADER_TAGS_ROBOTS_NOINDEX_ON', 'sort,tab,mfr,price,type', 'Add the noindex tag when these Get variables are set?.', '6', '3', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Nofollow Tag', 'MODULE_HEADER_TAGS_ROBOTS_NOFOLLOW', 'False', 'Add the nofollow tag?.', '6', '4', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Nosnippit Tag', 'MODULE_HEADER_TAGS_ROBOTS_NOSNIPPET', 'False', 'Add the nosnippit tag?.', '6', '5', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('NoODP Tag', 'MODULE_HEADER_TAGS_ROBOTS_NOODP', 'False', 'Add the noodp tag?.', '6', '6', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Noarchive Tag', 'MODULE_HEADER_TAGS_ROBOTS_NOARCHIVE', 'False', 'Add the noarchive tag?.', '6', '7', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Noimageindex Tag', 'MODULE_HEADER_TAGS_ROBOTS_NOIMAGEINDEX', 'False', 'Add the noimageindex tag?.', '6', '8', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
    }

    function remove() {
      tep_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
    	$keys_array = array();

      $keys_array[] = 'MODULE_HEADER_TAGS_ROBOTS_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_ROBOTS_SORT_ORDER';
    	$keys_array[] = 'MODULE_HEADER_TAGS_ROBOTS_NOINDEX';
    	$keys_array[] = 'MODULE_HEADER_TAGS_ROBOTS_NOINDEX_ON';
    	$keys_array[] = 'MODULE_HEADER_TAGS_ROBOTS_NOFOLLOW';
    	$keys_array[] = 'MODULE_HEADER_TAGS_ROBOTS_NOSNIPPET';
    	$keys_array[] = 'MODULE_HEADER_TAGS_ROBOTS_NOODP';
    	$keys_array[] = 'MODULE_HEADER_TAGS_ROBOTS_NOARCHIVE';
    	$keys_array[] = 'MODULE_HEADER_TAGS_ROBOTS_NOIMAGEINDEX';

      return $keys_array;
    }
  }
?>
