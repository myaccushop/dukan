<?php
/*
  $Id: category_title.php v1.0 20101126 Kymation $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class ht_category_title {
    var $code = 'ht_category_title';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function ht_category_title() {
      $this->title = MODULE_HEADER_TAGS_CATEGORY_TITLE_TITLE;
      $this->description = MODULE_HEADER_TAGS_CATEGORY_TITLE_DESCRIPTION;

      if ( defined('MODULE_HEADER_TAGS_CATEGORY_TITLE_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_CATEGORY_TITLE_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_CATEGORY_TITLE_STATUS == 'True');
      }
    }

    function execute() {
      global $PHP_SELF, $oscTemplate, $categories, $current_category_id, $languages_id;

      if( basename( $PHP_SELF ) == FILENAME_DEFAULT ) {
        // $categories is set in application_top.php to add the category to the breadcrumb
        if( isset( $categories ) && ( sizeof( $categories ) == 1 ) && isset( $categories['categories_name'] ) ) {
          $category_name = $categories['categories_name'];
        } else {
          // $categories is not set so a database query is needed
          if ($current_category_id > 0) {
            $categories_query_raw = "
              select
                categories_name
              from
                " . TABLE_CATEGORIES_DESCRIPTION . "
              where
                categories_id = '" . ( int )$current_category_id . "'
                and language_id = '" . ( int )$languages_id . "'
               limit 1
            ";
            $categories_query = tep_db_query( $categories_query_raw );

            if( tep_db_num_rows( $categories_query ) > 0) {
              $categories = tep_db_fetch_array( $categories_query );
              $category_name = $categories['categories_name'];
      	    } // if (tep_db_num_rows

          } // if ($current_category_id
        } // if( isset( $categories ... else ...

        if( strlen( $oscTemplate->getTitle() ) > 0 ) {
          $category_name = $oscTemplate->getTitle() . MODULE_HEADER_TAGS_CATEGORY_TITLE_SEPARATOR . ' ' . $category_name;
        }

        $oscTemplate->setTitle( $category_name );
      } // if( basename( $PHP_SELF
    } // function execute

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_HEADER_TAGS_CATEGORY_TITLE_STATUS');
    }

    function install() {
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Category Title - Category Name', 'MODULE_HEADER_TAGS_CATEGORY_TITLE_STATUS', 'True', 'Do you want the category name to be added to the category head title?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_CATEGORY_TITLE_SORT_ORDER', '600', 'Sort order of display. Lowest is displayed first.', '6', '2', now())");
      tep_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Separator', 'MODULE_HEADER_TAGS_CATEGORY_TITLE_SEPARATOR', '-', 'The separator to put between this element and the following element.', '6', '3', now())");
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
    	$keys_array = array();

      $keys_array[] = 'MODULE_HEADER_TAGS_CATEGORY_TITLE_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_CATEGORY_TITLE_SORT_ORDER';
      $keys_array[] = 'MODULE_HEADER_TAGS_CATEGORY_TITLE_SEPARATOR';

      return $keys_array;
    }
  }
?>
