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
  if (SITEMAP_SEO_SHOW_INDIVIDUAL_MANUFACTURER_SITEMAP  == 'true') { 
      $quotes = (defined('QUOTES_CATEGORY_NAME')) ? " and p.quotes_email_address = '' " : '';
      $manID = '';
      $manName = '';
      
      if (isset($_GET['manufacturers_id'])) {
          $manID = $_GET['manufacturers_id'];
          $manufacturers_query = tep_db_query("select manufacturers_name from " . TABLE_MANUFACTURERS . " where manufacturers_id=" . (int)$manID);
          $manufacturers = tep_db_fetch_array($manufacturers_query);
          $manName = $manufacturers['manufacturers_name'];
      } else {
          $mapCID = $current_category_id;
          $products_query = tep_db_query("select m.manufacturers_id, m.manufacturers_name from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id where p.products_id = " . $mapCID);

          if (tep_db_num_rows($products_query)) {
              $manu = tep_db_fetch_array($products_query);
              $manID = $manu['manufacturers_id'];
              $manName = $manu['manufacturers_name'];
          }
      }  

 
      if ($manID) {      
          $products_query = tep_db_query("select p.products_id, pd.products_name from " . TABLE_PRODUCTS . " p inner join " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id where p.manufacturers_id = " . (int)$manID . $quotes . " and p.products_status > 0 and pd.language_id = '" . (int)$languages_id . "'");

          if (tep_db_num_rows($products_query)) {  
             $mapProdManStr .= '<table border="0" cellpadding="0">';
             $mapProdManStr .= '<tr><td class="sitemap_indvidual_hdg" colspan="2">'.sprintf(TEXT_MANUFACTURERS_NAME, '<a href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manID) . '">' . $manName) . '</a></td></tr>';
             while ($prods = tep_db_fetch_array($products_query)) {
                 $mapProdManStr .= '<tr class="smallText"><td width="10">&nbsp;</td><td class="sitemap_indvidual"><a class="sitemap_indvidual" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $prods['products_id']) . '">' . $prods['products_name'] . '</a></td></tr>';
             }
             $mapProdManStr .= '</table>';

             echo '<div><tr><td class="smallText"><a href="javascript:displaySitemapManufacturers();" class="smallText"><span style="vertical-align:text-bottom; "><img src="images/sitemap_arrow.jpg" alt="" border="0"></span><span style="padding-left: 3px;">' . TEXT_SITEMAP_RELATED_MANUFACTURERS . '</span></a></td>
                   </tr>
                   <tr><td height="5"></td></tr>
                   <tr>
                    <td colspan="3"><table border="0" id="sitemap_manufacturers" style="display: none;" cellspacing="0" cellpadding="2">
                     <tr class="smallText">
                      <td>' . $mapProdManStr . '</td>
                     </tr>     
                    </table></td>
                   </tr></div>'; 
          }   
      } else {
           echo '<tr><td width="10">&nbsp;</td><td class="sitemap_indvidual">' . TEXT_NO_MANUFACTURERS_FOUND . '</td></tr>';
      }           
  }