<?php
/*
  $Id: ht_canonical.php v1.0 20101128 Kymation $
  Based on Sam's/Spooks' Remove & Prevent duplicate content with the canonical tag V1.3.2

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  class ht_canonical {
    var $code = 'ht_canonical';
    var $group = 'header_tags';
    var $title;
    var $description;
    var $sort_order;
    var $enabled = false;
    var $languages_array = array ();

    function ht_canonical() {
      $this->title = MODULE_HEADER_TAGS_CANONICAL_TITLE;
      $this->description = MODULE_HEADER_TAGS_CANONICAL_DESCRIPTION;

      if (defined('MODULE_HEADER_TAGS_CANONICAL_STATUS')) {
        $this->sort_order = MODULE_HEADER_TAGS_CANONICAL_SORT_ORDER;
        $this->enabled = (MODULE_HEADER_TAGS_CANONICAL_STATUS == 'True');
      }
    }

    function execute() {
      global $request_type, $PHP_SELF, $oscTemplate, $cPath, $current_category_id, $language;

      $domain = ($request_type == 'SSL' && MODULE_HEADER_TAGS_CANONICAL_SSL == 'True' ? HTTPS_SERVER : HTTP_SERVER); // gets the base URI

      // partial match to ssl filenames
      $set_tag = true;
      if (preg_match("{MODULE_HEADER_TAGS_CANONICAL_IGNORE_PAGES}", $PHP_SELF)) {
        $set_tag = false;
      }

      // REQUEST_URI usually doesn't exist on Windows servers ( sometimes ORIG_PATH_INFO doesn't either )
      if (array_key_exists('REQUEST_URI', $_SERVER)) {
        $request_uri = $_SERVER['REQUEST_URI'];
      }  elseif (array_key_exists('ORIG_PATH_INFO', $_SERVER)) {
        $request_uri = $_SERVER['ORIG_PATH_INFO'];
      } else {
        // we need to fail here as we have no REQUEST_URI and return no canonical link html
        $set_tag = false;
      }

      if( $set_tag == true ) {
      	$remove_array = explode( ',', MODULE_HEADER_TAGS_CANONICAL_ON );

        $page_remove_array = array (
          FILENAME_PRODUCT_INFO => array (
            'manufacturers_id',
            'cPath'
          ),
          FILENAME_DEFAULT => array ()
        );

        if (is_array($page_remove_array[$PHP_SELF])) {
          $remove_array = array_merge($remove_array, $page_remove_array[$PHP_SELF]);
        }

        $search = array();
        foreach ($remove_array as $value) {
          $search[] = '/&*' . $value . '[=\/]+[\w%..\+]*\/?/i';
        }
        $search[] = ('/&*osCsid.*/');
        $search[] = ('/\?\z/');

        if (MODULE_HEADER_TAGS_CANONICAL_REMOVE_INDEX == 'True') {
          $search[] = ('/index.php\/*/');
        }

        $request_uri = preg_replace('/\?&/', '?', preg_replace($search, '', $request_uri));

        switch( $PHP_SELF ) { 
        	case FILENAME_DEFAULT:
            $link = tep_href_link( FILENAME_DEFAULT, (($cPath != '')? 'cPath=' . $cPath_new : ''), 'NONSSL' );
            $meta_tag = '<link rel="canonical" href="' . $domain . '/' . $link . '" />' . PHP_EOL;
            break;

        	case FILENAME_PRODUCT_INFO:
        	  $products_id = (int)$_GET['products_id'];
            $cPath_new = tep_get_product_path( $products_id );
            
            $link = tep_href_link( FILENAME_PRODUCT_INFO, 'cPath=' . $cPath_new . '&products_id=' . $products_id, 'NONSSL' );
            $meta_tag = '<link rel="canonical" href="' . $domain . '/' . $link . '" />' . PHP_EOL;
            break;
            
        	default:
            $meta_tag = '<link rel="canonical" href="' . $domain . $request_uri . '"' . ' />' . PHP_EOL;
            break;
        }

        $oscTemplate->addBlock( $meta_tag, $this->group );
      }
    }

    function isEnabled() {
      return $this->enabled;
    }

    function check() {
      return defined('MODULE_HEADER_TAGS_CANONICAL_STATUS');
    }

    function install() {
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ( 'No Translate Meta Tag', 'MODULE_HEADER_TAGS_CANONICAL_STATUS', 'True', 'Do you want to add a notranslate tag to all pages?', '6', '1', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ( 'Sort Order', 'MODULE_HEADER_TAGS_CANONICAL_SORT_ORDER', '50', 'Sort order of display. Lowest is displayed first.', '6', '2', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ( 'Ignore Pages', 'MODULE_HEADER_TAGS_CANONICAL_IGNORE_PAGES', 'account,address,checkout,login,password,logoff', 'Ignore pages containing these strings.', '6', '3', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added) values ( 'Noindex on Flags', 'MODULE_HEADER_TAGS_CANONICAL_ON', 'currency,language,main_page,page,ref,affiliate_banner_id,max,sort,tab,mfr,price,type', 'Add the canonical tag when these parameters are set.', '6', '4', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ( 'Remove Index', 'MODULE_HEADER_TAGS_CANONICAL_REMOVE_INDEX', 'False', 'Set index.php as non-canonical.', '6', '5', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
      tep_db_query( "insert into " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added) values ( 'Catalog SSL', 'MODULE_HEADER_TAGS_CANONICAL_SSL', 'False', 'Are all of your catalog pages SSL?', '6', '6', 'tep_cfg_select_option(array(\'True\', \'False\'), ', now())" );
    }

    function remove() {
      tep_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      $keys_array = array ();

      $keys_array[] = 'MODULE_HEADER_TAGS_CANONICAL_STATUS';
      $keys_array[] = 'MODULE_HEADER_TAGS_CANONICAL_SORT_ORDER';
      $keys_array[] = 'MODULE_HEADER_TAGS_CANONICAL_IGNORE_PAGES';
      $keys_array[] = 'MODULE_HEADER_TAGS_CANONICAL_ON';
      $keys_array[] = 'MODULE_HEADER_TAGS_CANONICAL_REMOVE_INDEX';
      $keys_array[] = 'MODULE_HEADER_TAGS_CANONICAL_SSL';

      return $keys_array;
    }
  }

?>