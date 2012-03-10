<?php
/*
  $Id: ht_product_description.php v1.0 20101122 Kymation $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class ht_product_description {
    var $code = 'ht_product_description';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function ht_product_description() {
      $this->title = MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_TITLE;
      $this->description = MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_DESCRIPTION;

      if ( defined('MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_STATUS == 'True');
      }
    }

    function execute() {
      global $PHP_SELF, $oscTemplate, $languages_id, $product_check;

      // If we are on the product pages, output a header title
      if( basename( $PHP_SELF ) == FILENAME_PRODUCT_INFO && isset( $_GET['products_id'] ) && $product_check['total'] > 0 && (!isset($_GET['manufacturers_id']) || $_GET['manufacturers_id'] == 0 ) ) {
        // Get the product ID
        $products_id = 0; // Default in case no product is set
        if( isset( $_GET['products_id']) && $_GET['products_id'] > 0 ) {
          $products_id = ( int )$_GET['products_id'];
        }

        if( $products_id > 0 ) {
          // Now get the current value of the heading title, even if it's blank
          $product_info_query_raw = "
            select
              pd.products_description
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
          $head_description = $product_info['products_description'];

          // Chop the text at tne nearest word break to the character limit
          $head_description = wordwrap ( $head_description, MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_LENGTH, 'breakmehere' );
          $head_description_array = explode( 'breakmehere', $head_description );
          $head_description = trim( $head_description_array[0] );

          // Strip out all HTML and hard returns
          $returns = array( '/\r/', '/\n/' );
          $head_description = preg_replace( $returns, '', $head_description );
          $head_description = strip_tags( $head_description );

          $head_description = '<meta name="description" content="' . $head_description . '" />' . "\n";

          $oscTemplate->addBlock( $head_description, $this->group );  // Save the new description
        } // if( $products_id
      } // if( basename( $PHP_SELF
    } // function execute

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_STATUS');
    }

    function install() {
    	// Check whether the products_description table has been altered and add the field if it has not
      $check_structure_query_raw = "describe " . TABLE_PRODUCTS_DESCRIPTION;
      $check_structure_query = tep_db_query( $check_structure_query_raw );

      $head_title = false;
      $head_description = false;
      while( $check_structure_data = tep_db_fetch_array( $check_structure_query ) ) {
        if( $check_structure_data['Field'] == 'head_title' ) {
          $head_title = true;
        }

        if( $check_structure_data['Field'] == 'head_description' ) {
          $head_description = true;
        }
      }

      // Check if we need to insert the new field
      if( $head_description == false ) {
        // Decide where to insert the new field
      	$insert_after = 'products_description';
      	if( $head_title == true ) {
      	  $insert_after = 'head_title';
      	}

        tep_db_query( "alter table " . TABLE_PRODUCTS_DESCRIPTION . " add column head_description varchar(255) NOT NULL default '' after " . $insert_after );
      }

      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Head Description from Product Description', 'MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_STATUS', 'True', 'Do you want to add a custom description to the product meta description?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_SORT_ORDER', '200', 'Sort order of description text.  Meta tags are duplicated, so add only one per page.', '6', '2', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Head Description Length', 'MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_LENGTH', '250', 'The number of characters from the product description to use.', '6', '3', now())" );
    }

    function remove() {
      tep_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
    	$keys_array = array();

      $keys_array[] = 'MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_SORT_ORDER';
      $keys_array[] = 'MODULE_HEADER_TAGS_PRODUCT_DESCRIPTION_LENGTH';

      return $keys_array;
    }
  }
?>
