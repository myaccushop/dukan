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
 require(DIR_WS_FUNCTIONS . FILENAME_SITEMAP_SEO);
 
 $registeredOnly = tep_session_is_registered('customer_id') ? 1 : 0;
 $settings_query = tep_db_query("select * from " . TABLE_SITEMAP_SEO_SETTINGS . " where language_id = '" . (int)$languages_id . "' LIMIT 1");
 $settings = tep_db_fetch_array($settings_query);

 /********************* Find the Articles Manager pages to add ***********************/
 $articlesManagerLinksArray = array();
 if (defined('TABLE_ARTICLES') && $settings['enable_articles_manager'])
 {
   $article_info_query = tep_db_query("select a.articles_id, ad.articles_name from " . TABLE_ARTICLES . " a left join " . TABLE_ARTICLES_DESCRIPTION . " ad on ad.articles_id = a.articles_id where a.articles_status = '1' and ad.language_id = '" . (int)$languages_id . "'");
  
   while ($article_info = tep_db_fetch_array($article_info_query))
   {
     $name = ucwords($article_info['articles_name']);
     $articlesManagerLinksArray[] = array('link' => $article_info['articles_id'],
                                          'text' => $name,
                                          'anchor_text' => $name); 
   }
 }

 /********************* Find the boxes to show ***********************/
 $boxDataArray = array();
 $boxLinksArray = array();
 $boxes_query = tep_db_query("select b.box_file_name, b.box_page_name, b.pseudo_page_name, b.registered_box, bl.box_file_name as link_file, bl.page_link_name, bl.pseudo_page_link_name, bl.anchor_text, bl.excluded_link, bl.registered_link from " . TABLE_SITEMAP_SEO_BOXES . " b left join " . TABLE_SITEMAP_SEO_BOX_LINKS . " bl on b.box_file_name LIKE bl.box_file_name and b.language_id = bl.language_id where b.excluded_box = '0' and bl.excluded_link = 0 and bl.language_id = '" . (int)$languages_id . "' order by bl.sort_order, bl.page_link_name, bl.pseudo_page_link_name");

 while($boxes = tep_db_fetch_array($boxes_query)) {
     if (! $registeredOnly && ($boxes['registered_box'] || $boxes['registered_link'])) {
         continue;
     }  
         
     $boxHeading = (tep_not_null($boxes['pseudo_page_name']) ? $boxes['pseudo_page_name'] : $boxes['box_page_name']);

     if (! tep_not_null($boxes['pseudo_page_link_name'])) {  //pseudo name not present - don't check if it is
         if (! in_multi_array($boxes['box_file_name'], $boxLinksArray))
             $boxLinksArray = GetBoxLinks($boxes['box_file_name']);

         for ($i = 0; $i < count($boxLinksArray); ++$i) {
             if ($boxes['page_link_name'] === $boxLinksArray[$i]['link']) {
                 $define = $boxLinksArray[$i]['text'];
                 break;
             }
         }
     } else {
         $define = $boxes['pseudo_page_link_name'];
     }    
       
     $name = GetNameFromDefine($define, $language, $boxes['box_file_name']);

     if ($boxes['page_link_name'] === strtoupper($boxes['page_link_name'])) { //may not be a defined name
         $filename = GetFileName($boxes['page_link_name']);
     } else {
         $filename = $boxes['page_link_name'] ;  
     }  

     $boxDataArray[] = array('heading' => $boxHeading, 
                             'link' => $filename, 
                             'text' => $name,
                             'anchor_text' => (tep_not_null($boxes['anchor_text']) ? $boxes['anchor_text'] : $name));
 }

 /********************* Find the InfoPages to add ***********************/
 $infoPagesArray = array();
 if (defined('TABLE_INFORMATION_GROUP') && $settings['enable_infopages'])
 {
   $information_query = tep_db_query("SELECT information_id, information_title FROM " . TABLE_INFORMATION . " WHERE visible='1' and language_id='" . (int)$languages_id ."' ORDER BY sort_order");
   while ($information = tep_db_fetch_array($information_query))
   {
     $name = ucwords($information['information_title']);
     $infoPagesArray[] = array('link' => $information['information_id'],
                               'text' => $name,
                               'anchor_text' => $name);
   }
 }
 
 /********************* Find the Manufacturers to add ***********************/
 $manufacturersArray = array();
 $manufacturersProductsArray = array();

 if (SITEMAP_SEO_DISPLAY_MANUFACTURERS == 'true')
 {
    $manufacturers_query = tep_db_query("select manufacturers_id, manufacturers_name from " . TABLE_MANUFACTURERS . " order by manufacturers_name");
    while ($manufacturers = tep_db_fetch_array($manufacturers_query))
    {
       $manufacturersProductsArray = array();
       
       if (SITEMAP_SEO_DISPLAY_PRODUCTS_MANUFACTURERS == 'true')
       {
         $products_query = tep_db_query("select p.products_id, pd.products_name, p2c.categories_id from " . TABLE_PRODUCTS . " p left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id left join " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c on p.products_id = p2c.products_id left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on pd.products_id = p2c.products_id where p.products_status = '1' and m.manufacturers_id = '" . (int)$manufacturers['manufacturers_id'] . "'  and pd.language_id = '" . (int)$languages_id . "'");

         while ($products = tep_db_fetch_array($products_query))
         {
           $name = $products['products_name'];
           $manufacturersProductsArray[] = array('link' => $products['products_id'],
                                                 'text' => $name,
                                                 'anchor_text' => $name);
         }                                        
       }
       
       $name = ucwords($manufacturers['manufacturers_name']);
       $manufacturersArray[] = array('link' => $manufacturers['manufacturers_id'],
                                     'text' => $name,
                                     'anchor_text' => $name,
                                     'productArray' => $manufacturersProductsArray);
    }
 }

 /********************* Find the Page Manager pages to add ***********************/
 $pageManagerLinksArray = array();
 if (defined('TABLE_PAGES') && $settings['enable_page_manager'])
 {
   $page_query = tep_db_query("select pd.pages_title, pd.pages_body, p.pages_id, p.pages_name, p.pages_image, p.pages_status, p.sort_order from " . TABLE_PAGES . " p left join " . TABLE_PAGES_DESCRIPTION . " pd on p.pages_id = pd.pages_id where p.pages_status = '1' and pd.language_id = '" . (int)$languages_id . "' order by p.sort_order");
  
   $page_menu_text = '';
   while($page = tep_db_fetch_array($page_query))
   {
     if($page["pages_id"]!=1 && $page["pages_id"]!=2)
     {
       $name = ucwords($page["pages_name"]);
       $pageManagerLinksArray[] = array('link' => $name,
                                        'text' => $page["pages_title"],
                                        'anchor_text' => $name);
     }
   }
 }

 /********************* Find the standard pages to add ***********************/
 $pagesArray = array();
 $pages_query = tep_db_query("select page_file_name, alternate_page_name, anchor_text, registered_only from " . TABLE_SITEMAP_SEO_PAGES . " where excluded_page = '0' and language_id = '" . (int)$languages_id . "' order by sort_order, page_file_name, alternate_page_name");

 while ($pages = tep_db_fetch_array($pages_query))
 {
   if (! $registeredOnly && $pages['registered_only'])
     continue;
   
   if (tep_not_null($pages['alternate_page_name']))
     $name = $pages['alternate_page_name'];
   else
     $name = ucwords(str_replace("_", " ", substr($pages['page_file_name'], 0, strpos($pages['page_file_name'], "."))));
       
   if (IsViewable($pages['page_file_name']))    
     $pagesArray[] = array('link' => $pages['page_file_name'],
                           'text' => $name,
                           'anchor_text' => (tep_not_null($pages['anchor_text']) ? $pages['anchor_text'] : $name));                        
 }

?>
