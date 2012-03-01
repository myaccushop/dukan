<?php
/*
  $Id: headertags_seo_install.php, v 3.0 by Jack_mcs

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  define('CONTRIBUTION_TITLE', 'Sitemap SEO');

  $check = tep_db_query("show tables like 'sitemap_seo_pages'") or die ('error reading database');
  if (tep_db_num_rows($check) > 0)
  {
     echo 'Looks like ' . CONTRIBUTION_TITLE . ' is already installed. Aborting...';
	 tep_exit();
  }

  $sitemap_sql_array = array(array("DROP TABLE IF EXISTS sitemap_seo_pages"),
                             array("CREATE TABLE sitemap_seo_pages (exclude_id INT NOT NULL AUTO_INCREMENT, page_file_name VARCHAR (255) NOT NULL, alternate_page_name VARCHAR (255) NOT NULL DEFAULT '', anchor_text VARCHAR (255) NOT NULL DEFAULT '', excluded_page TINYINT (1) NOT NULL DEFAULT 0, registered_only TINYINT (1) NOT NULL DEFAULT 0, sort_order TINYINT (3) NOT NULL DEFAULT 0, language_id int DEFAULT '1' NOT NULL, PRIMARY KEY ( exclude_id ))"),
                             array("DROP TABLE IF EXISTS sitemap_seo_boxes"),
                             array("CREATE TABLE sitemap_seo_boxes (box_file_name VARCHAR (50) NOT NULL DEFAULT '', box_page_name VARCHAR (255) NOT NULL DEFAULT '', pseudo_page_name VARCHAR (255) NOT NULL DEFAULT '', excluded_box TINYINT (1) NOT NULL DEFAULT 0, registered_box TINYINT (1) NOT NULL DEFAULT 0, language_id int DEFAULT '1' NOT NULL, PRIMARY KEY ( box_file_name, language_id ))"),
                             array("DROP TABLE IF EXISTS sitemap_seo_box_links"),
                             array("CREATE TABLE sitemap_seo_box_links (box_link_id INT NOT NULL AUTO_INCREMENT, box_file_name VARCHAR (50) NOT NULL DEFAULT '', page_link_name VARCHAR (255) NOT NULL DEFAULT '', pseudo_page_link_name VARCHAR (255) NOT NULL DEFAULT '', anchor_text VARCHAR (255) NOT NULL DEFAULT '', excluded_link TINYINT (1) NOT NULL DEFAULT 0, registered_link TINYINT(1) NOT NULL DEFAULT 0, sort_order TINYINT (3) NOT NULL DEFAULT 0, language_id int DEFAULT '1' NOT NULL, PRIMARY KEY ( box_link_id ))"),
                             array("DROP TABLE IF EXISTS sitemap_seo_settings"),
                             array("CREATE TABLE sitemap_seo_settings (enable_articles_manager TINYINT (1) NOT NULL DEFAULT 0, enable_infopages TINYINT (1) NOT NULL DEFAULT 0, enable_page_manager TINYINT (1) NOT NULL DEFAULT 0, heading_title VARCHAR (40) NOT NULL DEFAULT 'Site Map', heading_sub_text TEXT NOT NULL, heading_articles_manager VARCHAR (50) NOT NULL DEFAULT '', heading_categories VARCHAR (50) NOT NULL DEFAULT '', heading_infopages VARCHAR (50) NOT NULL DEFAULT '', heading_manufacturers VARCHAR (50) NOT NULL DEFAULT '', heading_page_manager VARCHAR (50) NOT NULL DEFAULT '',  heading_standard_boxes VARCHAR (50) NOT NULL DEFAULT '', heading_standard_pages VARCHAR (50) NOT NULL DEFAULT '', language_id int DEFAULT '1' NOT NULL, PRIMARY KEY ( language_id ))")
                             );
  $db_error = false;

  // create tables
  foreach ($sitemap_sql_array as $sql_array) {
    foreach ($sql_array as $value) {
      if (tep_db_query($value) == false) {
        $db_error = true;
      }
    }
  }


  $sm_check_query = tep_db_query("select max(configuration_group_id) as id from configuration_group ");
  $max = tep_db_fetch_array($sm_check_query);
  $configuration_group_id = $max['id'] + 1;

  // create configuration group
 $group_query = "INSERT INTO `configuration_group` ( `configuration_group_id` , `configuration_group_title` , `configuration_group_description` , `sort_order` , `visible` ) VALUES ('" . $configuration_group_id . "', 'Sitemap SEO', 'Sitemap SEO site wide options', '22' , '1')";

 if (tep_db_query($group_query) == false) {
   $db_error = true;
 } else {

     $sortID = 1;

     // create configuration variables
     $sitemap_sql_array = array(array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL,'Display Products in Categories', 'SITEMAP_SEO_DISPLAY_PRODUCTS_CATEGORIES', 'false', 'Display the products for each category. This option will cause slower page load times, and possibly a display problem if there are many nested entries.<br>(true=on false=off)', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL,'Display Products in Manufacturers', 'SITEMAP_SEO_DISPLAY_PRODUCTS_MANUFACTURERS', 'false', 'Display the products for each manufacturer. This option will cause slower page load times, and possibly a display problem if there are many nested entries.<br>(true=on false=off)', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL,'Display Manufacturers', 'SITEMAP_SEO_DISPLAY_MANUFACTURERS', 'true', 'Display the manufacturers.<br>(true=on false=off)', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL,'Enable Version Checker', 'SITEMAP_SEO_ENABLE_VERSION_CHECKER', 'false', 'Enables the version checking code to automatically check if an update is available.', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL,'Heading Alignment', 'SITEMAP_SEO_HEADING_ALIGNMENT', 'left', 'Align headings as selected.', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'left\', \'center\', \'right\'), ', now(), NULL)"),
    
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL,'Module Placement - Articles Manager', 'SITEMAP_SEO_MODULE_PLACEMENT_ARTICLES_MANAGER', 'right', 'Place this listing in the left or right column of the SiteMap SEO page.', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'left\', \'right\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL,'Module Placement - Categories', 'SITEMAP_SEO_MODULE_PLACEMENT_CATEGORIES', 'left', 'Place this listing in the left or right column of the SiteMap SEO page.', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'left\', \'right\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL,'Module Placement - InfoPages', 'SITEMAP_SEO_MODULE_PLACEMENT_INFOPAGES', 'right', 'Place this listing in the left or right column of the SiteMap SEO page.', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'left\', \'right\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL,'Module Placement - Manufacturers', 'SITEMAP_SEO_MODULE_PLACEMENT_MANUFACTURERS', 'left', 'Place this listing in the left or right column of the SiteMap SEO page.', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'left\', \'right\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL,'Module Placement - Page Manager', 'SITEMAP_SEO_MODULE_PLACEMENT_PAGE_MANAGER', 'right', 'Place this listing in the left or right column of the SiteMap SEO page.', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'left\', \'right\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL,'Module Placement - Standard Boxes', 'SITEMAP_SEO_MODULE_PLACEMENT_STANDARD_BOXES', 'right', 'Place this listing in the left or right column of the SiteMap SEO page.', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'left\', \'right\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL,'Module Placement - Standard Pages', 'SITEMAP_SEO_MODULE_PLACEMENT_STANDARD_PAGES', 'right', 'Place this listing in the left or right column of the SiteMap SEO page.', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'left\', \'right\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL, 'Show Related Categories', 'SITEMAP_SEO_SHOW_INDIVIDUAL_CATEGORY_SITEMAP', 'true', 'Display a link on the category and product pages to display all categories in that category.', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL, 'Show Related Products', 'SITEMAP_SEO_SHOW_RELATED_PRODUCTS', 'true', 'Display a link on the products page to display all products in that category.', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL, 'Show Related Products by Manufacturer', 'SITEMAP_SEO_SHOW_INDIVIDUAL_MANUFACTURER_SITEMAP', 'true', 'Display a link on the category and product pages to display all products in the current category (by manufacturer).', '" . $configuration_group_id . "', '" . ($sortID++). "', 'tep_cfg_select_option(array(\'true\', \'false\'), ', now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL, 'Sort Order - Articles Manager', 'SITEMAP_SEO_SORTORDER_ARTICLES_MANAGER', '4', 'Where to place this module in the listings.', '" . $configuration_group_id . "', '" . ($sortID++). "', NULL, now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL, 'Sort Order - Categories', 'SITEMAP_SEO_SORTORDER_CATEGORIES', '1', 'Where to place this module in the listings.', '" . $configuration_group_id . "', '" . ($sortID++). "', NULL, now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL, 'Sort Order - InfoPages', 'SITEMAP_SEO_SORTORDER_INFOPAGES', '5', 'Where to place this module in the listings.', '" . $configuration_group_id . "', '" . ($sortID++). "', NULL, now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL, 'Sort Order - Manufacturers', 'SITEMAP_SEO_SORTORDER_MANUFACTURERS', '2', 'Where to place this module in the listings.', '" . $configuration_group_id . "', '" . ($sortID++). "', NULL, now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL, 'Sort Order - Page Manager', 'SITEMAP_SEO_SORTORDER_PAGE_MANAGER', '5', 'Where to place this module in the listings.', '" . $configuration_group_id . "', '" . ($sortID++). "', NULL, now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL, 'Sort Order - Standard Boxes', 'SITEMAP_SEO_SORTORDER_STANDARD_BOXES', '3', 'Where to place this module in the listings.', '" . $configuration_group_id . "', '" . ($sortID++). "', NULL, now(), NULL)"),
                                array("INSERT INTO configuration (configuration_id, configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, set_function, date_added, use_function)  VALUES (NULL, 'Sort Order - Standard Pages', 'SITEMAP_SEO_SORTORDER_STANDARD_PAGES', '2', 'Where to place this module in the listings.', '" . $configuration_group_id . "', '" . ($sortID++). "', NULL, now(), NULL)"));
    
     foreach ($sitemap_sql_array as $sql_array) {
      foreach ($sql_array as $value) {
       if (tep_db_query($value) == false) {
         $db_error = true;
       }
      }
     }

 }

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?></title>
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">
<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="3" cellpadding="3">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="0" cellpadding="2">
<!-- left_navigation //-->
<?php //require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo CONTRIBUTION_TITLE . ' Setup'; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
      <tr>
        <td class="main">
<?php
  if ($db_error == false) {
    echo 'Database successfully updated for ' . CONTRIBUTION_TITLE . '!!!';
?>
        </td>
       </tr>
       <tr>
         <td><?php echo '<a href="' . tep_href_link(FILENAME_DEFAULT) . '">' . tep_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE) . '</a>'; ?></td>
       </tr>

<?php
  } else {
    echo 'Error encountered during the ' . CONTRIBUTION_TITLE . ' database update.</td></tr>';
  }
?>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->

  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
