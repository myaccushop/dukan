<?php
/*
  $Id: ht_front_title.php v1.0.1 20101211 Kymation $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class ht_front_title {
    var $code = 'ht_front_title';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $languages_array = array();

    function ht_front_title() {
      $this->title = MODULE_HEADER_TAGS_FRONT_TITLE_TITLE;
      $this->description = MODULE_HEADER_TAGS_FRONT_TITLE_DESCRIPTION;

      if ( defined( 'MODULE_HEADER_TAGS_FRONT_TITLE_STATUS' ) ) {
        $this->sort_order = MODULE_HEADER_TAGS_FRONT_TITLE_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_FRONT_TITLE_STATUS == 'True');
      }
    }

    function execute() {
      global $PHP_SELF, $cPath, $oscTemplate, $language;

      // If we are on the front page, set a title
      if( basename( $PHP_SELF ) == FILENAME_DEFAULT && $cPath == '' ) {
      	$head_title = constant( 'MODULE_HEADER_TAGS_FRONT_TITLE_TEXT_' . strtoupper( $language ) );

        if( strlen( $oscTemplate->getTitle() ) > 0 ) {
          $head_title = $oscTemplate->getTitle() . MODULE_HEADER_TAGS_FRONT_PAGE_TITLE_SEPARATOR . ' ' . $head_title;
        }

        $oscTemplate->setTitle( $head_title );  // Save the new title string
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined( 'MODULE_HEADER_TAGS_FRONT_TITLE_STATUS' );
    }

    function install() {
      include_once( DIR_WS_CLASSES . 'language.php' );
      $bm_banner_language_class = new language;
      $languages = $bm_banner_language_class->catalog_languages;

      foreach( $languages as $this_language ) {
        $this->languages_array[$this_language['id']] = $this_language['directory'];
      }
      
    	tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Front Page Title', 'MODULE_HEADER_TAGS_FRONT_TITLE_STATUS', 'True', 'Do you want to add a head title to the front page?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_FRONT_TITLE_SORT_ORDER', '10', 'Sort order of display. Lowest is displayed first.', '6', '0', now())");
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Separator', 'MODULE_HEADER_TAGS_FRONT_PAGE_TITLE_SEPARATOR', '-', 'The separator to put between this element and the next element.', '6', '3', now())" );

    	foreach( $this->languages_array as $language_id => $language_name ) {
        tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ( '" . ucwords( $language_name ) . " Text', 'MODULE_HEADER_TAGS_FRONT_TITLE_TEXT_" . strtoupper( $language_name ) . "', 'Q. Caepio Brutus pro consule provinciam Macedoniam', 'Enter the head title that you want on the front page in " . $language_name . "', '6', '2', now())" );
      }
    }

    function remove() {
      tep_db_query( "delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      include_once( DIR_WS_CLASSES . 'language.php' );
      $bm_banner_language_class = new language;
      $languages = $bm_banner_language_class->catalog_languages;

      foreach( $languages as $this_language ) {
        $this->languages_array[$this_language['id']] = $this_language['directory'];
      }
      
    	$keys_array = array();

      $keys_array[] = 'MODULE_HEADER_TAGS_FRONT_TITLE_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_FRONT_TITLE_SORT_ORDER';
      $keys_array[] = 'MODULE_HEADER_TAGS_FRONT_PAGE_TITLE_SEPARATOR';

    	foreach( $this->languages_array as $language_name ) {
    	  $keys_array[] = 'MODULE_HEADER_TAGS_FRONT_TITLE_TEXT_' . strtoupper( $language_name );
    	}

      return $keys_array;
    }
  }
?>
