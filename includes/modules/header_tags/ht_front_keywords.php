<?php
/*
  $Id: ht_front_keywords.php v1.0 20110415 Kymation $
  $Loc: catalog/includes/modules/header_tags/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2011 osCommerce

  Released under the GNU General Public License
*/

  class ht_front_keywords {
    var $code = 'ht_front_keywords';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $languages_array = array();

    function ht_front_keywords() {
      $this->title = MODULE_HEADER_TAGS_FRONT_KEYWORDS_TITLE;
      $this->description = MODULE_HEADER_TAGS_FRONT_KEYWORDS_DESCRIPTION;

      if ( defined( 'MODULE_HEADER_TAGS_FRONT_KEYWORDS_STATUS' ) ) {
        $this->sort_order = MODULE_HEADER_TAGS_FRONT_KEYWORDS_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_FRONT_KEYWORDS_STATUS == 'True');
      }
    }

    function execute() {
      global $PHP_SELF, $cPath, $oscTemplate, $language;

      // If we are on the front page, set a meta description
      if( basename( $PHP_SELF ) == FILENAME_DEFAULT && ( $cPath == '' || $cPath == 0 ) ) {
      	$head_keywords = constant( 'MODULE_HEADER_TAGS_FRONT_KEYWORDS_TEXT_' . strtoupper( $language ) );
        $head_keywords = '<meta name="keywords" content="' . $head_keywords . '" />';

        $oscTemplate->addBlock( $head_keywords, $this->group );
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined( 'MODULE_HEADER_TAGS_FRONT_KEYWORDS_STATUS' );
    }

    function install() {
      include_once( DIR_WS_CLASSES . 'language.php' );
      $bm_banner_language_class = new language;
      $languages = $bm_banner_language_class->catalog_languages;

      foreach( $languages as $this_language ) {
        $this->languages_array[$this_language['id']] = $this_language['directory'];
      }
      
    	tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ('Enable Front Page Meta Keywords', 'MODULE_HEADER_TAGS_FRONT_KEYWORDS_STATUS', 'True', 'Do you want to add a meta keywords tag to the front page?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ('Sort Order', 'MODULE_HEADER_TAGS_FRONT_KEYWORDS_SORT_ORDER', '1', 'Sort order of display. Meta tags are duplicated, so add only one per page.', '6', '0', now())");

    	foreach( $this->languages_array as $language_id => $language_name ) {
        tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ( '" . ucwords( $language_name ) . " Text', 'MODULE_HEADER_TAGS_FRONT_KEYWORDS_TEXT_" . strtoupper( $language_name ) . "', 'Nam ut superiora omittam, hoc certe, quod mihi maximam admirationem movet, non tacebo.', 'Enter the meta keywords that you want on the front page in " . $language_name . "', '6', '2', 'tep_draw_textarea_field(\'configuration[MODULE_HEADER_TAGS_FRONT_KEYWORDS_TEXT_" . strtoupper( $language_name ) . "]\', false, 35, 20, ', now())" );
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

      $keys_array[] = 'MODULE_HEADER_TAGS_FRONT_KEYWORDS_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_FRONT_KEYWORDS_SORT_ORDER';

    	foreach( $this->languages_array as $language_name ) {
    	  $keys_array[] = 'MODULE_HEADER_TAGS_FRONT_KEYWORDS_TEXT_' . strtoupper( $language_name );
    	}

      return $keys_array;
    }
  }
?>
