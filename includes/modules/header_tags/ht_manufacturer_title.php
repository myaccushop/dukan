<?php
/*
  $Id: ht_manufacturer_title.php v1.0 20101129 Kymation $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class ht_manufacturer_title {
    var $code = 'ht_manufacturer_title';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;

    function ht_manufacturer_title() {
      $this->title = MODULE_HEADER_TAGS_MANUFACTURER_TITLE_TITLE;
      $this->description = MODULE_HEADER_TAGS_MANUFACTURER_TITLE_DESCRIPTION;

      if ( defined('MODULE_HEADER_TAGS_MANUFACTURER_TITLE_STATUS') ) {
        $this->sort_order = MODULE_HEADER_TAGS_MANUFACTURER_TITLE_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_MANUFACTURER_TITLE_STATUS == 'True');
      }
    }

    function execute() {
      global $PHP_SELF, $oscTemplate, $manufacturers, $languages_id;

      if( basename($PHP_SELF) == FILENAME_DEFAULT ) {
        if( isset( $_GET['manufacturers_id'] ) && is_numeric( $_GET['manufacturers_id'] ) ) {
          // $manufacturers is set in application_top.php to add the manufacturer to the breadcrumb
          if( isset($manufacturers) && (sizeof($manufacturers) == 1) && isset( $manufacturers['manufacturers_name'] ) ) {
            $oscTemplate->setTitle($manufacturers['manufacturers_name'] . ', ' . $oscTemplate->getTitle());
          } else {
            // $manufacturers is not set so a database query is needed
            $manufacturers_query_raw = "
              select
                manufacturers_name
              from
                " . TABLE_MANUFACTURERS . "
              where
                manufacturers_id = '" . ( int )$_GET['manufacturers_id'] . "'
            ";
            $manufacturers_query = tep_db_query( $manufacturers_query_raw );
            if( tep_db_num_rows( $manufacturers_query ) ) {
              $manufacturers = tep_db_fetch_array( $manufacturers_query );
              $head_title = $manufacturers['manufacturers_name'];

              if( strlen( $oscTemplate->getTitle() ) > 0 ) {
                $head_title = $oscTemplate->getTitle() . MODULE_HEADER_TAGS_MANUFACTURER_TITLE_SEPARATOR . ' ' . $head_title;
              }

              $oscTemplate->setTitle( $head_title );
            }
          }
        }
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined( 'MODULE_HEADER_TAGS_MANUFACTURER_TITLE_STATUS' );
    }

    function install() {
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Manufacturer Title Module', 'MODULE_HEADER_TAGS_MANUFACTURER_TITLE_STATUS', 'True', 'Do you want to allow manufacturer titles to be added to the page title?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())");
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_MANUFACTURER_TITLE_SORT_ORDER', '0', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Separator', 'MODULE_HEADER_TAGS_MANUFACTURER_TITLE_SEPARATOR', '-', 'The separator to put between this element and the following element.', '6', '8', now())" );
    }

    function remove() {
      tep_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')" );
    }

    function keys() {
    	$keys_array = array();

      $keys_array[] = 'MODULE_HEADER_TAGS_MANUFACTURER_TITLE_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_MANUFACTURER_TITLE_SORT_ORDER';
      $keys_array[] = 'MODULE_HEADER_TAGS_MANUFACTURER_TITLE_SEPARATOR';

      return $keys_array;
    }
  }
?>
