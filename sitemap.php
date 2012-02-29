<?php
/*
  $Id: sitemap_seo.php 1739 2008-12-20 by Jack_mcs

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2009 oscommerce-solution.com

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
  require(DIR_WS_MODULES . FILENAME_SITEMAP_SEO);
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SITEMAP_SEO);
   
  /****************** DISPLAY ARTICLES MANAGER LINKS *********************/           
  $showArticlesManager = '';
  if (count($articlesManagerLinksArray) > 0) 
  {  
    if (tep_not_null($settings['heading_articles_manager'])) { 
      $showArticlesManager .= '<tr><th class="sitemapHeading" align="' . SITEMAP_SEO_HEADING_ALIGNMENT . '">' . $settings['heading_articles_manager'] . '</th></tr>';
    }                          
    $showArticlesManager .= '<tr><td width="50%" class="sitemap"><ul class="sitemap">';
    $pageCount = count($articlesManagerLinksArray);
    for ($i = 0; $i < $pageCount; ++$i) 
      $showArticlesManager .= '<li><a class="sitemap" href="' . tep_href_link(FILENAME_ARTICLE_INFO, 'articles_id=' . $articlesManagerLinksArray[$i]['link']) .'" title="' . $articlesManagerLinksArray[$i]['anchor_text'] . '">' . $articlesManagerLinksArray[$i]['text'] . '</a></li>';
    $showArticlesManager .= '</ul></td></tr>';
  }    
  
  /****************** DISPLAY CATEGORIES *********************/
  $showCategories = '';

  if (isset($_POST['show_products'])) {
      if ($_POST['show_products'] == 'on') {
          $showProducts = TEXT_SHOW_PRODUCTS;
          $showStatus = 'off';
          $class = 'category_tree_no_products.php';
      } else {
          $showProducts = TEXT_HIDE_PRODUCTS;
          $showStatus = 'on';
          $class = 'category_tree.php';
      }
  } else if (SITEMAP_SEO_DISPLAY_PRODUCTS_CATEGORIES == 'true' ) {
      $showProducts = TEXT_HIDE_PRODUCTS;
      $showStatus = 'on';   
      $class = 'category_tree.php'; 
  } else {
      $showProducts = TEXT_SHOW_PRODUCTS;
      $showStatus = 'off';   
      $class = 'category_tree_no_products.php';    
  }
   
  if (tep_not_null($settings['heading_categories'])) { 
      $showCategories .= '<tr><th class="sitemapHeading" align="' . SITEMAP_SEO_HEADING_ALIGNMENT . '">' . $settings['heading_categories'] . '&nbsp;&nbsp;';

      $showCategories .= tep_draw_form('sitemap', tep_href_link(FILENAME_SITEMAP_SEO)) . tep_hide_session_id() . tep_draw_hidden_field('show_products', $showStatus); 
      $showCategories .= '<a class="sitemap" href="javascript:document.sitemap.submit()">' . $showProducts . '</a> ';
      
      $showCategories .= '</form></th></tr>';
  }
  $showCategories .= '<tr><td class="sitemap">';
  require DIR_WS_CLASSES . $class;
  $osC_CategoryTree = new osC_CategoryTree; 
  $showCategories .= $osC_CategoryTree->buildTree();                
  $showCategories .= '</td></tr>';
                 
  /****************** DISPLAY INFOPAGES LINKS *********************/           
  $showInfoPages = '';
  if (count($infoPagesArray) > 0) 
  {  
    if (tep_not_null($settings['heading_infopages'])) { 
      $showInfoPages .= '<tr><th class="sitemapHeading" align="' . SITEMAP_SEO_HEADING_ALIGNMENT . '">' . $settings['heading_infopages'] . '</th></tr>';
    }                         
    $showInfoPages .= '<tr><td width="50%" class="sitemap"><ul class="sitemap">';
    $pageCount = count($infoPagesArray);
    for ($i = 0; $i < $pageCount; ++$i) 
 			$showInfoPages .= '<li><a class="sitemap" href="' . tep_href_link(FILENAME_INFORMATION, 'info_id='. $infoPagesArray[$i]['link']) .'" title="' . $infoPagesArray[$i]['anchor_text'] . '">' . $infoPagesArray[$i]['text'] . '</a></li>';
    $showInfoPages .= '</ul></td></tr>';
  }    
 
  /****************** DISPLAY MANUFACTURERS *********************/
  $showManufacturers = '';
  if (count($manufacturersArray) > 0) 
  {
    if (tep_not_null($settings['heading_manufacturers'])) { 
      $showManufacturers .= '<tr><th class="sitemapHeading" align="' . SITEMAP_SEO_HEADING_ALIGNMENT . '">' . $settings['heading_manufacturers'] . '</th></tr>';
    }  
    $showManufacturers .= '<tr><td width="50%" class="sitemap"><ul class="sitemap">';
    $pageCount = count($manufacturersArray);
    for ($i = 0; $i < $pageCount; ++$i)
    { 
  		$showManufacturers .= '<li><a class="sitemap" href="' . tep_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $manufacturersArray[$i]['link']) .'" title="' . $manufacturersArray[$i]['anchor_text'] . '">' . $manufacturersArray[$i]['text'] . '</a></li>';
      $cnt = count($manufacturersArray[$i]['productArray']);

      if ($cnt > 0)
      {
        $showManufacturers .= '<ul>';
        for ($p = 0; $p < $cnt; ++$p)
        {
          $pA = $manufacturersArray[$i]['productArray'][$p]; //makes it more readable
     		 $showManufacturers .= '<li><a class="sitemapProducts" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $pA['link']) .'" title="' . $pA['anchor_text'] . '">' . $pA['text'] . '</a></li>';
        }
        $showManufacturers .= '</ul>';
      } 
    }  
    $showManufacturers .= '</ul></td></tr>';
  }
    
  /****************** DISPLAY PAGEMANAGER LINKS *********************/           
  $showPageManager = '';
  if (count($pageManagerLinksArray) > 0) 
  {  
    if (tep_not_null($settings['heading_page_manager'])) { 
      $showPageManager .= '<tr><th class="sitemapHeading" align="' . SITEMAP_SEO_HEADING_ALIGNMENT . '">' . $settings['heading_page_manager'] . '</th></tr>';
    }                         
    $showPageManager .= '<tr><td width="50%" class="sitemap"><ul class="sitemap">';
    $pageCount = count($pageManagerLinksArray);
    for ($i = 0; $i < $pageCount; ++$i) 
 			$showPageManager .= '<li><a class="sitemap" href="' . tep_href_link(FILENAME_PAGES, 'page=' . $pageManagerLinksArray[$i]['link']) .'" title="' . $pageManagerLinksArray[$i]['anchor_text'] . '">' . $pageManagerLinksArray[$i]['text'] . '</a></li>';
    $showPageManager .= '</ul></td></tr>';
  }    

  /****************** DISPLAY STANDARD INFOBOXES LINKS *********************/
  $showInfoBoxes = '';    
  if (count($boxDataArray) > 0) 
  {  
    if (tep_not_null($settings['heading_standard_boxes'])) { 
      $showInfoBoxes .= '<tr><th class="sitemapHeading" align="' . SITEMAP_SEO_HEADING_ALIGNMENT . '">' . $settings['heading_standard_boxes'] . '</th></tr>';
    }                          
    $showInfoBoxes .= '<tr><td width="50%" class="sitemap"><ul class="sitemap">';
 		$showInfoBoxes .= '<li>'.$boxDataArray[0]['heading'].'</li><ul>'; 
    $pageCount = count($boxDataArray);
    for ($i = 0; $i < $pageCount; ++$i) 
 			$showInfoBoxes .= '<li><a class="sitemap" href="' . tep_href_link($boxDataArray[$i]['link']) .'" title="' . $boxDataArray[$i]['anchor_text'] . '">' . $boxDataArray[$i]['text'] . '</a></li>';
    $showInfoBoxes .= '</ul></ul></td></tr>';
  }   

  /****************** DISPLAY STANDARD PAGES *********************/
  $showPages = '';
  if (count($pagesArray) > 0)
  {
    if (tep_not_null($settings['heading_standard_pages'])) { 
      $showPages .= '<tr><th class="sitemapHeading" align="' . SITEMAP_SEO_HEADING_ALIGNMENT . '">' . $settings['heading_standard_pages'] . '</th></tr>';
    }                         
    $showPages .= '<tr><td width="50%" class="sitemap"><ul class="sitemap">';
    $pageCount = count($pagesArray); 
    if ($pageCount > 0)  
      for ($b = 0; $b < $pageCount; ++$b)  
        $showPages .= '<li><a class="sitemap" title="'. $pagesArray[$b]['anchor_text'] .'" href="' . tep_href_link($pagesArray[$b]['link']) . '">' . $pagesArray[$b]['text'] . '</a></li>';
    $showPages .= '</ul></td></tr>';
  }


  /****************** BUILT THE DISPLAY  *********************/
  $leftColDisplay = array();
  $rightColDisplay = array();
  $sortOrderArray = array(array('placement' => SITEMAP_SEO_MODULE_PLACEMENT_ARTICLES_MANAGER, 'sortkey' => SITEMAP_SEO_SORTORDER_ARTICLES_MANAGER, 'module' => $showArticlesManager),
                          array('placement' => SITEMAP_SEO_MODULE_PLACEMENT_CATEGORIES, 'sortkey' => SITEMAP_SEO_SORTORDER_CATEGORIES, 'module' => $showCategories),
                          array('placement' => SITEMAP_SEO_MODULE_PLACEMENT_INFOPAGES, 'sortkey' => SITEMAP_SEO_SORTORDER_INFOPAGES, 'module' => $showInfoPages),
                          array('placement' => SITEMAP_SEO_MODULE_PLACEMENT_MANUFACTURERS, 'sortkey' => SITEMAP_SEO_SORTORDER_MANUFACTURERS, 'module' => $showManufacturers),
                          array('placement' => SITEMAP_SEO_MODULE_PLACEMENT_PAGE_MANAGER, 'sortkey' => SITEMAP_SEO_SORTORDER_PAGE_MANAGER, 'module' => $showPageManager),
                          array('placement' => SITEMAP_SEO_MODULE_PLACEMENT_STANDARD_BOXES, 'sortkey' => SITEMAP_SEO_SORTORDER_STANDARD_BOXES, 'module' => $showInfoBoxes),
                          array('placement' => SITEMAP_SEO_MODULE_PLACEMENT_STANDARD_PAGES, 'sortkey' => SITEMAP_SEO_SORTORDER_STANDARD_PAGES, 'module' => $showPages));
  
  foreach($sortOrderArray as $key)
  {
    if (tep_not_null($key['module']))
    {
      if ($key['placement'] == 'left')                 
        $leftColDisplay[] = $key;  
      else                          
        $rightColDisplay[] = $key;  
    }
  }
                                                 
  usort($leftColDisplay, "SortOnKeys"); 
  usort($rightColDisplay, "SortOnKeys"); 
 
  $breadcrumb->add(NAVBAR_TITLE, tep_href_link(FILENAME_SITEMAP_SEO));
  require(DIR_WS_INCLUDES . 'template_top.php');
?>
 
 
<div class="contentContainer">
  <div class="contentText">
 
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td><h1><?php echo $settings['heading_title']; ?></h1></td>
            <td align="right"><h1><?php echo tep_image(DIR_WS_IMAGES . 'table_background_specials.gif', HEADING_TITLE, HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></h1></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="5"></td>
      </tr>
      <tr>
        <td><h2><?php echo $settings['heading_sub_text']; ?></h2></td>
      </tr>
      <tr>
        <td height="10"></td>
      </tr>
      
      <tr>
        <td><table border="0" width="100%" cellspacing="1" cellpadding="2">
          <tr>
          
            <!-- DISPALY THE LEFT COLUMN -->
            <td width="50%" valign="top"><table border="0" cellpadding="0">
             <?php
              for ($i = 0; $i < count($leftColDisplay); ++$i)
               echo $leftColDisplay[$i]['module'];
              ?>
            </table></td>  
 
            <!-- DISPALY THE RIGHT COLUMN -->
            <td width="50%" valign="top"><table border="0" cellpadding="0">  
             <?php
              for ($i = 0; $i < count($rightColDisplay); ++$i)
               echo $rightColDisplay[$i]['module'];
              ?>
            </table></td>  
          
          </tr>
        </table></td>
      </tr>
      <tr>
       <td><table border="0" width="100%" cellspacing="1" cellpadding="2">
        <tr>
          <td class="smallText"><?php echo TEXT_INFORMATION; ?></td>
        </tr>
       </table></td>
      </tr> 
 
  </div>
</div>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
