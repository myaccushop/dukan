<?php
/*
  $Id: sitemap_seo.php,v 1.0 2008/12/29
  written by Jack_mcs at www.osocmmerce-solution.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2008 osocmmerce-solution.com
  Portions Copyright 2009 oscommerce-solution.com

  Released under the GNU General Public License
*/
  if (!isset($_GET['manufacturers_id']) && SITEMAP_SEO_SHOW_INDIVIDUAL_CATEGORY_SITEMAP  == 'true') { 
      $registeredOnly = tep_session_is_registered('customer_id') ? 1 : 0;
      $settings_query = tep_db_query("select * from " . TABLE_SITEMAP_SEO_SETTINGS . " where language_id = '" . (int)$languages_id . "' LIMIT 1");
      $settings = tep_db_fetch_array($settings_query);
      
      $cpPath = (basename($_SERVER['PHP_SELF']) == FILENAME_PRODUCT_INFO) ? tep_get_product_path($_GET['products_id']) : $cPath; 
      
      if (strpos($cpPath, "_") !== FALSE) {
          $parts = explode("_", $cpPath); 
          $cID = $parts[0]; 
      } else {
          $cID = $cpPath;
      }    
      
      $catname_query = tep_db_query("select categories_name as cname from " . TABLE_CATEGORIES_DESCRIPTION . " where categories_id = '" . (int)$cID . "' and language_id = '" . (int)$languages_id . "' limit 1");
      $catname =  tep_db_fetch_array($catname_query);
      
      $showCategories = '';
      $showCategories .= '<tr><td class="sitemap">';
      $class = (SITEMAP_SEO_DISPLAY_PRODUCTS_CATEGORIES == 'true') ? 'category_tree.php' : 'category_tree_no_products.php';
      require DIR_WS_CLASSES . $class;
      $osC_CategoryTree = new osC_CategoryTree($cID); 
      $showCategories .= $osC_CategoryTree->buildTree();                
      $showCategories .= '</td></tr>';
      
      $mapCatStr = '
       <tr>
         <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
           <tr>
             <td class="sitemap_indvidual">' . $catname['cname'] . '</td>
           </tr>
         </table></td>
       </tr>';

      $mapCatStr .= $showCategories;

      echo '<div>
        <tr>
         <td class="smallText"><a href="javascript:displaySitemapCategory();" class="smallText"><span style="vertical-align:text-bottom; "><img src="images/sitemap_arrow.jpg" alt="" border="0"></span><span style="padding-left: 3px;">' . TEXT_SITEMAP_RELATED_CATEGORIES . '</span></a></td>
        </tr>
        <tr><td height="5"></td></tr>
        <tr>
         <td colspan="3"><table border="0" id="sitemap_category" style="display: none;" cellspacing="0" cellpadding="2">
          <tr>
           <td class="smallText">' . $mapCatStr . '</td>
          </tr>     
         </table></td>
        </tr></div>';      
  }        