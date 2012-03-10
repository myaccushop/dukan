<?php
/*
  $Id: products_insert.php v1.0 20101124 Kymation $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/


  $products_id = 0; // Default in case no product is set
  $products_id = ( int )$pInfo->products_id;

  if( $products_id > 0 ) {
  	// Check whether the products_description table has been altered
    $check_structure_query_raw = "describe " . TABLE_PRODUCTS_DESCRIPTION;
    $check_structure_query = tep_db_query( $check_structure_query_raw );

    $head_title_field = false;
    $head_description_field = false;
    $head_keywords_field = false;
    while( $check_structure_data = tep_db_fetch_array( $check_structure_query ) ) {
      if( $check_structure_data['Field'] == 'head_title' ) {
        $head_title_field = true;
      }

      if( $check_structure_data['Field'] == 'head_description' ) {
        $head_description_field = true;
      }

      if( $check_structure_data['Field'] == 'head_keywords' ) {
        $head_keywords_field = true;
      }
    }

    // Add the Title input field if the corresponding database field exists
    if( $head_title_field == true ) {
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

      // Add the Title input field to the products/categories page
      if( $action == 'new_product' ) {
        $body_text = '';

        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $body_text .= '          <tr bgcolor="#ebebff">' . "\n";
          $body_text .= '            <td class="main">';
          if ($i == 0) $body_text .= MODULE_HEADER_TAGS_PRODUCT_TITLE_INSERT_TITLE;
          $body_text .= '</td>' . "\n";

          $body_text .= '            <td class="main">';
          $body_text .= tep_image( DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name'] );
          $body_text .= '&nbsp;' . tep_draw_input_field('head_title[' . $languages[$i]['id'] . ']', $head_title );
          $body_text .= '</td>' . "\n";
          $body_text .= '          </tr>' . "\n";
        } // for ($i=0

        echo $body_text;
      } // if( $action
    } // if( $head_title_field

    // Add the Description input field if the corresponding database field exists
    if( $head_description_field == true ) {
      // Now get the current value of the heading description, even if it's blank
      $product_info_query_raw = "
        select
          pd.head_description
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
      $head_description = $product_info['head_description'];

      // Add the Description input field to the products/categories page
      if( $action == 'new_product' ) {
        $body_text = '';

        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $body_text .= '          <tr bgcolor="#ebebff">' . "\n";
          $body_text .= '            <td class="main" valign="top">';
          if ($i == 0) $body_text .= MODULE_HEADER_TAGS_PRODUCT_KEYWORDS_INSERT_TITLE;
          $body_text .= '</td>' . "\n";

          $body_text .= '            <td class="main">';
          $body_text .= tep_image( DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name'] );
          $body_text .= '&nbsp;' . tep_draw_textarea_field('head_description[' . $languages[$i]['id'] . ']', 'soft', '70', '4', $head_description );
          $body_text .= '</td>' . "\n";
          $body_text .= '          </tr>' . "\n";
        } // for ($i=0

        echo $body_text;
      } // if( $action
    } // if( $head_description_field

    // Add the Keywords input field if the corresponding database field exists
    if( $head_keywords_field == true ) {
      // Now get the current value of the heading keywords, even if it's blank
      $product_info_query_raw = "
        select
          pd.head_keywords
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
      $head_keywords = $product_info['head_keywords'];

      // Add the keywords input field to the products/categories page
      if( $action == 'new_product' ) {
        $body_text = '';

        for ($i=0, $n=sizeof($languages); $i<$n; $i++) {
          $body_text .= '          <tr bgcolor="#ebebff">' . "\n";
          $body_text .= '            <td class="main" valign="top">';
          if ($i == 0) $body_text .= MODULE_HEADER_TAGS_PRODUCT_KEYWORDS_INSERT_TITLE;
          $body_text .= '</td>' . "\n";

          $body_text .= '            <td class="main">';
          $body_text .= tep_image( DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name'] );
          $body_text .= '&nbsp;' . tep_draw_textarea_field('head_keywords[' . $languages[$i]['id'] . ']', 'soft', '70', '4', $head_keywords );
          $body_text .= '</td>' . "\n";
          $body_text .= '          </tr>' . "\n";
        } // for ($i=0

        echo $body_text;
      } // if( $action
    } // if( $head_keywords_field

  } // if( $products_id

?>
