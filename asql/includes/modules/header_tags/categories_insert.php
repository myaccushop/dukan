<?php
/*
  $Id: categories_insert.php v1.0 20101129 Kymation $
  $Loc: catalog/admin/includes/modules/header_tags/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/


  $check_structure_query_raw = "describe " . TABLE_CATEGORIES_DESCRIPTION;
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

  $languages = tep_get_languages();

  switch ($action) {
    case 'edit_category':
      if( $head_title_field == true ) {
      	$head_title = array();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        	$language_id = ( int )$languages[$i]['id'];
          $category_title_query_raw = "
            select
              head_title
            from
              " . TABLE_CATEGORIES_DESCRIPTION . "
            where
              categories_id = '" . ( int )$cInfo->categories_id . "'
              and language_id = '" . $language_id . "'
          ";
          // print 'Category Title Query: ' . $category_title_query_raw;
          $category_title_query = tep_db_query( $category_title_query_raw );
          $category_title = tep_db_fetch_array( $category_title_query );

          $head_title[$language_id] = $category_title['head_title'];
        }
      }

      if( $head_description_field == true ) {
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        	$language_id = ( int )$languages[$i]['id'];
          $category_description_query_raw = "
            select
              head_description
            from
              " . TABLE_CATEGORIES_DESCRIPTION . "
            where
              categories_id = '" . ( int )$cInfo->categories_id . "'
              and language_id = '" . $language_id . "'
          ";
          // print 'Category Description Query: ' . $category_title_query_raw;
          $category_description_query = tep_db_query( $category_description_query_raw );
          $category_description = tep_db_fetch_array( $category_description_query );

          $head_description[$language_id] = $category_description['head_description'];
        }
      }

      if( $head_keywords_field == true ) {
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        	$language_id = ( int )$languages[$i]['id'];
          $category_keywords_query_raw = "
            select
              head_keywords
            from
              " . TABLE_CATEGORIES_DESCRIPTION . "
            where
              categories_id = '" . ( int )$cInfo->categories_id . "'
              and language_id = '" . $language_id . "'
          ";
          // print 'Category Description Query: ' . $category_title_query_raw;
          $category_keywords_query = tep_db_query( $category_keywords_query_raw );
          $category_keywords = tep_db_fetch_array( $category_keywords_query );

          $head_keywords[$language_id] = $category_keywords['head_keywords'];
        }
      }
      // The lack of a break is deliberate

    case 'new_category':
      if( !isset( $head_title ) ) $head_title = array();
      if( !isset( $head_description ) ) $head_description = array();
      if( !isset( $head_keywords ) ) $head_keywords = array();

      // We need to insert text boxes before the form buttons.
      //   The buttons are in the last element of the contents array,
      //   so we pop the last entry off and save it for later
      $temp_data = array_pop( $contents );

      // Insert the new title fields if the database has been set up to accept them
      if( $head_title_field == true ) {
        $category_title_inputs_string = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_title_inputs_string .= '<br />' . tep_image( HTTPS_CATALOG_SERVER . DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_input_field( 'head_title[' . $languages[$i]['id'] . ']', $head_title[$languages[$i]['id']] );
        }

        $contents[] = array('text' => '<br />' . MODULE_HEADER_TAGS_EDIT_CATEGORIES_TITLE . $category_title_inputs_string);
      }

      // Insert the new description fields if the database has been set up to accept them
      if( $head_description_field == true ) {
        $category_description_inputs_string = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_description_inputs_string .= '<br />' . tep_image( HTTPS_CATALOG_SERVER . DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_textarea_field( 'head_description[' . $languages[$i]['id'] . ']', false, 35, 20, $head_description[$languages[$i]['id']] );
        }

        $contents[] = array( 'text' => '<br />' . MODULE_HEADER_TAGS_EDIT_CATEGORIES_DESCRIPTION . $category_description_inputs_string );
      }

      // Insert the new keywords fields if the database has been set up to accept them
      if( $head_keywords_field == true ) {
        $category_keywords_inputs_string = '';
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $category_keywords_inputs_string .= '<br />' . tep_image( HTTPS_CATALOG_SERVER . DIR_WS_CATALOG_LANGUAGES . $languages[$i]['directory'] . '/images/' . $languages[$i]['image'], $languages[$i]['name']) . '&nbsp;' . tep_draw_textarea_field( 'head_keywords[' . $languages[$i]['id'] . ']', false, 35, 20, $head_keywords[$languages[$i]['id']] );
        }

        $contents[] = array( 'text' => '<br />' . MODULE_HEADER_TAGS_EDIT_CATEGORIES_KEYWORDS . $category_keywords_inputs_string );
      }

      // Put the last element back in the contents array
      $contents[] = $temp_data;
      break;

    case 'delete_category':
      // Nothing to do; the entire row is deleted
      break;

    case 'move_category':
      // Nothing to do; the existing code renumbers the row
      break;
  }

?>
