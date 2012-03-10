<?php
/*
  $Id: categories_products_process.php v1.1 20101129 Kymation $
  $Loc: catalog/admin/includes/modules/header_tags/ $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2007 osCommerce

  Released under the GNU General Public License
*/


  // Check whether the products_description table has been altered
  $check_structure_query_raw = "describe " . TABLE_PRODUCTS_DESCRIPTION;
  $check_structure_query = tep_db_query($check_structure_query_raw);

  $products_field_exists = false;
  while ($check_structure_data = tep_db_fetch_array($check_structure_query)) {
    if ($check_structure_data['Field'] == 'head_title') {
      $products_field_exists = true;
    }

    if ($check_structure_data['Field'] == 'head_description') {
      $products_field_exists = true;
    }
  }

  // Check whether the categories_description table has been altered
  $check_structure_query_raw = "describe " . TABLE_CATEGORIES_DESCRIPTION;
  $check_structure_query = tep_db_query($check_structure_query_raw);

  $categories_field_exists = false;
  while ($check_structure_data = tep_db_fetch_array($check_structure_query)) {
    if ($check_structure_data['Field'] == 'head_title') {
      $categories_field_exists = true;
    }

    if ($check_structure_data['Field'] == 'head_description') {
      $categories_field_exists = true;
    }
  }

  // Input titles and meta descriptions from the admin products/categories page
  switch( $action ) {
    case 'insert_product' : // Process new/updated products title
    case 'update_product' :
      if ($products_field_exists == true) {
        if (isset ($_GET['pID']))
          $products_id = tep_db_prepare_input($_GET['pID']);

        if (isset ($_POST['head_title']) || isset ($_POST['head_description'])) {
          if ($action == 'insert_product') {
            $sql_data_array = array (
              'products_date_added' => 'now()'
            );

            tep_db_perform(TABLE_PRODUCTS, $sql_data_array);
            $products_id = tep_db_insert_id();

            tep_db_query("insert into " . TABLE_PRODUCTS_TO_CATEGORIES . " (products_id, categories_id) values ('" . ( int ) $products_id . "', '" . ( int ) $current_category_id . "')");
          }

          $languages = tep_get_languages();
          for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
            $language_id = ( int ) $languages[$i]['id'];

            $sql_data_array = array ();
            if (isset ($_POST['head_title'])) {
              $sql_data_array['head_title'] = tep_db_prepare_input($_POST['head_title'][$language_id]);
            }

            if (isset ($_POST['head_description'])) {
              $sql_data_array['head_description'] = tep_db_prepare_input($_POST['head_description'][$language_id]);
            }

            if ($action == 'insert_product') {
              $insert_sql_data = array (
                'products_id' => $products_id,
                'language_id' => $language_id
              );

              $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

              tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array);

            } elseif ($action == 'update_product') {
              tep_db_perform(TABLE_PRODUCTS_DESCRIPTION, $sql_data_array, 'update', "products_id = '" . ( int ) $products_id . "' and language_id = '" . $language_id . "'");
            }
          } // for ($i=0

          $action = 'update_product';
        } // if( isset( $_POST
      }
      break;

    case 'copy_to_confirm' : // Copy product
      // Don't do this. Titles and descriptions should never be duplicated. See 'duplicate penalty'.
      break;

    case 'move_product_confirm' : // Move product
      // Nothing to do here. The existing code just changes the categories_id.
      break;

    case 'delete_product_confirm' :
      // Nothing to do here; the whole row is deleted.
      break;

      // Input titles and meta descriptions from the category sidebar
    case 'insert_category' :
    case 'update_category' :
      if ($categories_field_exists == true) {
        if (isset ($_POST['categories_id']))
          $categories_id = tep_db_prepare_input($_POST['categories_id']);

        if (isset ($_POST['head_title']) || isset ($_POST['head_description'])) {
          if ($action == 'insert_category') {
            $sql_data_array = array (
              'parent_id' => $current_category_id,
              'date_added' => 'now()'
            );

            tep_db_perform(TABLE_CATEGORIES, $sql_data_array);
            $categories_id = tep_db_insert_id();
          }

          $languages = tep_get_languages();
          for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
            $language_id = ( int ) $languages[$i]['id'];

            $sql_data_array = array ();
            if (isset ($_POST['head_title'])) {
              $sql_data_array['head_title'] = tep_db_prepare_input($_POST['head_title'][$language_id]);
            }

            if (isset ($_POST['head_description'])) {
              $sql_data_array['head_description'] = tep_db_prepare_input($_POST['head_description'][$language_id]);
            }

            if ($action == 'insert_category') {
              $insert_sql_data = array (
                'categories_id' => $categories_id,
                'language_id' => $language_id
              );

              $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

              tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array);

            } elseif ($action == 'update_category') {
              tep_db_perform(TABLE_CATEGORIES_DESCRIPTION, $sql_data_array, 'update', "categories_id = '" . ( int ) $categories_id . "' and language_id = '" . $language_id . "'");
            }
          } // for ($i=0

          $action = 'update_category';
        } // if( isset( $_POST
      } // if ($categories_field_exists
      break;

    case 'move_category_confirm' :
      // Nothing to do; the code just renumbers the row
      break;

    case 'delete_category_confirm' :
      // Nothing to do here; the row is deleted.
      break;

  } // switch( $action )

?>
