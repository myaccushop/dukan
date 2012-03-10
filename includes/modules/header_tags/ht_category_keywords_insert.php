<?php
/*
  $Id: ht_category_keywords_insert.php v1.0 20110415 Kymation $
  $Loc: catalog/includes/modules/header_tags/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2011 osCommerce

  Released under the GNU General Public License
*/

  class ht_category_keywords_insert {
    var $code = 'ht_category_keywords_insert';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function ht_category_keywords_insert() {
      $this->title = MODULE_HEADER_TAGS_CATEGORY_KEYWORDS_INSERT_NEW_TITLE;
      $this->description = MODULE_HEADER_TAGS_CATEGORY_KEYWORDS_INSERT_NEW_DESCRIPTION;

      if ( defined('MODULE_HEADER_TAGS_CATEGORY_KEYWORDS_INSERT_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_CATEGORY_KEYWORDS_INSERT_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_CATEGORY_KEYWORDS_INSERT_STATUS == 'True');
      }
    }

    function execute() {
      global $PHP_SELF, $oscTemplate, $current_category_id, $languages_id;

      // If we are on the category pages, output a header title
      if( basename( $PHP_SELF ) == FILENAME_DEFAULT && $current_category_id > 0 && (!isset($_GET['manufacturers_id']) || $_GET['manufacturers_id'] == 0 ) ) {
        // Now get the current value of the category keywords, even if it's blank
        $categories_query_raw = "
          select
            head_keywords
          from
            " . TABLE_CATEGORIES_DESCRIPTION . "
          where
            categories_id = '" . ( int )$current_category_id . "'
            and language_id = '" . ( int )$languages_id . "'
            limit 1
        ";
        $categories_query = tep_db_query( $categories_query_raw );
        $categories_info = tep_db_fetch_array( $categories_query );

        $head_keywords = $categories_info['head_keywords'];
        $head_keywords = '<meta name="keywords" content="' . $head_keywords . '" />';

        $oscTemplate->addBlock( $head_keywords, $this->group );
      } // if( basename( $PHP_SELF
    } // function execute

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined( 'MODULE_HEADER_TAGS_CATEGORY_KEYWORDS_INSERT_STATUS' );
    }

    function install() {
    	// Check whether the products_description table has been altered and add the field if it has not
      $check_structure_query_raw = "describe " . TABLE_CATEGORIES_DESCRIPTION;
      $check_structure_query = tep_db_query( $check_structure_query_raw );

      $head_title = false;
      $head_description = false;
      $head_keywords = false;
      while( $check_structure_data = tep_db_fetch_array( $check_structure_query ) ) {
        if( $check_structure_data['Field'] == 'head_title' ) {
          $head_title = true;
        }

        if( $check_structure_data['Field'] == 'head_description' ) {
          $head_description = true;
        }

        if( $check_structure_data['Field'] == 'head_keywords' ) {
          $head_keywords = true;
        }
      }

      // Check if we need to insert the new field
      if( $head_keywords == false ) {
      	$insert_after = 'categories_name';

      	if( $head_title == true ) {
      	  $insert_after = 'head_title';
      	}

        if( $head_description == true ) {
          $insert_after = 'head_description';
        }

        tep_db_query( "alter table " . TABLE_CATEGORIES_DESCRIPTION . " add column head_keywords varchar(255) NOT NULL default '' after " . $insert_after );
      }

      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Category Keywords Module', 'MODULE_HEADER_TAGS_CATEGORY_KEYWORDS_INSERT_STATUS', 'True', 'Do you want to add custom keywords to the product meta keywords tag?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_CATEGORY_KEYWORDS_INSERT_SORT_ORDER', '290', 'Sort order of keywords text. Meta tags are duplicated, so add only one per page.', '6', '2', now())" );
    }

    function remove() {
      tep_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
    	$keys_array = array();

      $keys_array[] = 'MODULE_HEADER_TAGS_CATEGORY_KEYWORDS_INSERT_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_CATEGORY_KEYWORDS_INSERT_SORT_ORDER';

      return $keys_array;
    }
  }
?>
