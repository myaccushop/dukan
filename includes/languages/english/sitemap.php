<?php
/*
  $Id: sitemap_seo.php 2008-12-20 by Jack_mcs

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'Sitemap');
define('HEADING_TITLE', 'Sitemap');

define('TEXT_CATEGORY_NAME', 'Other products in the <b>%s</b> category');
define('TEXT_MANUFACTURERS_NAME', 'Products by Manufacturer: <b>%s</b>');

define('TEXT_INFORMATION', '<p>Please contact us if you experience any problems finding what you need:</p> ' . 
 nl2br(STORE_NAME_ADDRESS) . '<br>' .
 STORE_OWNER_EMAIL_ADDRESS 
);
 
define('TEXT_SITEMAP_RELATED_PRODUCTS', 'Related Products');
define('TEXT_SITEMAP_RELATED_CATEGORIES', 'Related Categories');
define('TEXT_SITEMAP_RELATED_MANUFACTURERS', 'Related Manufacturers');

define('TEXT_NO_MANUFACTURERS_FOUND', 'No other products were found for this manufacturer.');

define('TEXT_HIDE_PRODUCTS', '(hide products)');
define('TEXT_SHOW_PRODUCTS', '(show products)');

?>