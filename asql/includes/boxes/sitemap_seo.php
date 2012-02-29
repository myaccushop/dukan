<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $cl_box_groups[] = array(
    'heading' => BOX_HEADING_SITEMAP_SEO,
    'apps' => array(
      array(
        'code' => FILENAME_SITEMAP_SEO_BOX_CONTROL,
        'title' => BOX_SITEMAP_SEO_BOX_CONTROL,
        'link' => tep_href_link(FILENAME_SITEMAP_SEO_BOX_CONTROL)
      ),
      array(
        'code' => FILENAME_SITEMAP_SEO_PAGE_CONTROL,
        'title' => BOX_SITEMAP_SEO_PAGE_CONTROL,
        'link' => tep_href_link(FILENAME_SITEMAP_SEO_PAGE_CONTROL)
      ),
      array(
        'code' => FILENAME_SITEMAP_SEO_SETTINGS_CONTROL,
        'title' => BOX_SITEMAP_SEO_SETTINGS_CONTROL,
        'link' => tep_href_link(FILENAME_SITEMAP_SEO_SETTINGS_CONTROL)
      )
    )
  );
?>
