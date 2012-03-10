<?php
/*
  $Id: ht_product_title_insert.php v1.0 20101122 Kymation $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class ht_product_title_insert {
    var $code = 'ht_product_title_insert';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function ht_product_title_insert() {
      $this->title = MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_NEW_TITLE;
      $this->description = MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_NEW_DESCRIPTION;

      if ( defined('MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_STATUS == 'True');
      }
    }

    function execute() {
      global $PHP_SELF, $oscTemplate, $languages_id, $product_check;

      // If we are on the product pages, output a header title
      if( basename( $PHP_SELF ) == FILENAME_PRODUCT_INFO && isset( $_GET['products_id'] ) && $product_check['total'] > 0 ) {
        // Get the product ID
        $products_id = 0; // Default in case no product is set
        if( isset( $_GET['products_id']) && $_GET['products_id'] > 0 ) {
          $products_id = ( int )$_GET['products_id'];
        }

        if( $products_id > 0 ) {
          // Now get the current value of the heading title, even if it's blank
          $product_info_query_raw = "
            select
              pd.head_title
            from
              " . TABLE_PRODUCTS . " p
              join " . TABLE_PRODUCTS_DESCRIPTION . " pd
                on pd.products_id = p.products_id
            where
              p.products_status = '1'
              and p.products_id = '" . $products_id . "'
              and pd.language_id = '" . ( int )$languages_id . "'
          ";
          $product_info_query = tep_db_query( $product_info_query_raw );
          $product_info = tep_db_fetch_array( $product_info_query );
          $head_title = $product_info['head_title'];

      	  if( strlen( $oscTemplate->getTitle() ) > 0 ) {
      	    $head_title = $oscTemplate->getTitle() . MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_SEPARATOR . ' ' . $head_title;
      	  }

          $oscTemplate->setTitle( $head_title );  // Save the new title string
        } // if( $products_id
      } // if( basename( $PHP_SELF
    } // function execute

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_STATUS');
    }

    function install() {
    	// Check whether the products_description table has been altered and add the field if it has not
      $check_structure_query_raw = "describe " . TABLE_PRODUCTS_DESCRIPTION;
      $check_structure_query = tep_db_query( $check_structure_query_raw );

      $head_title = false;
      while( $check_structure_data = tep_db_fetch_array( $check_structure_query ) ) {
        if( $check_structure_data['Field'] == 'head_title' ) {
          $head_title = true;
          break;
        }
      }

      if( $head_title == false ) {
        tep_db_query( "alter table " . TABLE_PRODUCTS_DESCRIPTION . " add column head_title varchar(255) NOT NULL default '' after products_description");
      }

      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Product Title Module', 'MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_STATUS', 'True', 'Do you want to add a custom titles to the product head title?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_SORT_ORDER', '200', 'Sort order of display. Lowest is displayed first.', '6', '2', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Separator', 'MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_SEPARATOR', '-', 'The separator to put between this element and the following element.', '6', '8', now())" );
    }

    function remove() {
      tep_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
    	$keys_array = array();

      $keys_array[] = 'MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_SORT_ORDER';
      $keys_array[] = 'MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_SEPARATOR';

      return $keys_array;
    }
  }
?>
