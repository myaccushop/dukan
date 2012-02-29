<?php
/*
  $Id: sitemap_seo.php 1739 2008-12-20 by Jack_mcs

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2009 oscommerce-solution.com

  Released under the GNU General Public License
*/
define('HEADING_TITLE', 'Sitemap SEO');
define('HEADING_TITLE_AUTHOR', 'by Jack_mcs from <a href="http://www.oscommerce-solution.com/" target="_blank"><span style="font-family: Verdana, Arial, sans-serif; color: sienna; font-size: 12px;">oscommerce-solution.com</span></a>');
define('HEADING_TITLE_BOXES_GROUP', 'Boxes Group Control');
define('HEADING_TITLE_BOXES_INDIVIDUAL', 'Boxes Individual Control');
define('HEADING_TITLE_ADDITIONAL_LINKS', 'Additional Link Control');
define('HEADING_TITLE_PAGES_GROUP', 'Pages Group Control');
define('HEADING_TITLE_SETTINGS', 'Settings Control');
define('HEADING_TITLE_SUPPORT_THREAD', '<a href="http://forums.oscommerce.com/index.php?showtopic=324829" target="_blank"><span style="color: sienna;">(visit the support thread)</span></a>');

define('ENTRY_CLEAR_MULTI_LIST', 'Clear Selected');
define('ENTRY_EXCLUDE', 'Exclude');
define('ENTRY_EXCLUDE_SHORT', 'Exc');
define('ENTRY_REGISTERED_ONLY', 'Registered');
define('ENTRY_REGISTERED_ONLY_SHORT', 'Reg');
define('ENTRY_SELECT_BOX', '<b>Select a Box</b>');
define('ENTRY_SELECT_BOX_GROUP', '<b>Select a Box</b><br><br>Note: This is a multi-select list so more than one item can be selected at once.');
define('ENTRY_SELECT_PAGE', '<b>Select a Page</b><br><br>Note: This is a multi-select list so more than one item can be selected at once.');
define('ENTRY_SHOW_REGISTERED_ONLY', 'Registered Customers Only');

define('TEXT_ADD_A_LINK', 'Add A Link');
define('TEXT_CHECKBOX_ALL', 'All');
define('TEXT_COLOR_BOTH_EXCLUDED_REGISTERED', '<span style="color: #4CC417; font-weight: bold;">Green</span> = Excluded and Registered');
define('TEXT_COLOR_EXCLUDED', '<span style="color: #F778A1; font-weight: bold;">Red</span> = Excluded');
define('TEXT_COLOR_REGISTERED', '<span style="color: #66FFFF; font-weight: bold;">Cyan</span> = Registered');
define('TEXT_COLOR_SELECTED', '<span style="color: #b2b4bf; font-weight: bold;">Gray</span> = Selected');
define('TEXT_DISPLAY_NAME', 'Display Name');
define('TEXT_DISPLAY_NAME_ALTERNATE', 'Alternate Name');
define('TEXT_FILENAME', 'File Name');
define('TEXT_LINK_ANCHOR_TEXT', 'Anchor Text');
define('TEXT_LINK_FILE', 'Contains Links To');
define('TEXT_LINK_NAME', 'Using Name Of');
define('TEXT_LINK_SORT_ORDER', 'Sort');
define('TEXT_LINK_PSEUDO_NAME', 'Use Alternate Name');
define('TEXT_MAKE_BOX_SELECTION', 'Select a File'); 
define('TEXT_MISSING_VERSION_CHECKER', 'Version Checker is not installed. See <a href="http://addons.oscommerce.com/info/7148" target="_blank">here</a> for details.');

define('TEXT_SETTING_NAME', 'Setting');
define('TEXT_SETTING_ENABLE_ARTICLES_MANAGER', 'Enable Articles Manager');
define('TEXT_SETTING_ENABLE_INFOPAGES', 'Enable InfoPages');
define('TEXT_SETTING_ENABLE_PAGE_MANAGER', 'Enable Page Manager');
define('TEXT_SETTING_DISPLAY_PRODUCTS_CATEGORIES', 'Display Products in Categories');
define('TEXT_SETTING_DISPLAY_PRODUCTS_MANUFACTURERS', 'Display Products in Manufacturers');
define('TEXT_SETTING_HEADING_ALIGNMENT', 'Heading Alignment');
define('TEXT_SETTING_HEADING_SUB_TEXT', 'Sub Heading Text');
define('TEXT_SETTING_HEADING_TEXT_ARTICLES_MANAGER', 'Heading Text - Articles Manager');
define('TEXT_SETTING_HEADING_TEXT_CATEGORIES', 'Heading Text - Categories');
define('TEXT_SETTING_HEADING_TEXT_INFOPAGES', 'Heading Text - InfoPages');
define('TEXT_SETTING_HEADING_TEXT_MANUFACTURERS', 'Heading Text - Manufacturers');
define('TEXT_SETTING_HEADING_TEXT_PAGE_MANAGER', 'Heading Text - Page Manager');
define('TEXT_SETTING_HEADING_TEXT_STANDARD_BOXES', 'Heading Text - Standard Boxes');
define('TEXT_SETTING_HEADING_TEXT_STANDARD_PAGES', 'Heading Text - Standard Pages');
define('TEXT_SETTING_HEADING_TITLE', 'Page Heading');
define('TEXT_SETTING_HEADING_MODULE_PLACEMENT_ARTICLES_MANAGER', 'Module Placement - Articles Manager');
define('TEXT_SETTING_HEADING_MODULE_PLACEMENT_CATEGORIES', 'Module Placement - Categories');
define('TEXT_SETTING_HEADING_MODULE_PLACEMENT_INFOPAGES', 'Module Placement - InfoPages');
define('TEXT_SETTING_HEADING_MODULE_PLACEMENT_MANUFACTURERS', 'Module Placement - Manufacturers');
define('TEXT_SETTING_HEADING_MODULE_PLACEMENT_PAGE_MANAGER', 'Module Placement - Page Manager');
define('TEXT_SETTING_HEADING_MODULE_PLACEMENT_STANDARD_BOXES', 'Module Placement - Standard Boxes');
define('TEXT_SETTING_HEADING_MODULE_PLACEMENT_STANDARD_PAGES', 'Module Placement - Standard Pages');
define('TEXT_SETTING_SORT_ORDER_ARTICLES_MANAGER', 'Sort Order - Articles Manager');
define('TEXT_SETTING_SORT_ORDER_CATEGORIES', 'Sort Order - Categories');
define('TEXT_SETTING_SORT_ORDER_INFOPAGES', 'Sort Order - InfoPages');
define('TEXT_SETTING_SORT_ORDER_MANUFACTURERS', 'Sort Order - Manufacturers');
define('TEXT_SETTING_SORT_ORDER_PAGE_MANAGER', 'Sort Order - Page Manager');
define('TEXT_SETTING_SORT_ORDER_STANDARD_BOXES', 'Sort Order - Standard Boxes');
define('TEXT_SETTING_SORT_ORDER_STANDARD_PAGES', 'Sort Order - Standard Pages');

define('TEXT_TITLE_BOXES_GROUP', 'This section handles group changes to the boxes.
Any number of boxes can be selected and the settings changed for all with one click.
');

define('TEXT_TITLE_PAGES_GROUP', '<p>This section handles group changes to the standard shop pages.
The Display Name is the name that will be displayed in the site map. If you would like something
else to display, enter it into the <b>Alternate Name</b> field. The <b>Anchor Text</b> is an import SEO
field. It should match the keyword for the page the link is connecting to. Typically, the
name of the link and the anchor should match. But it is really the matching of the anchor
text to the destination page that is the most important aspect of the link.</p>

<p>If the <b>Registered</b> checkbox is checked, that page will only be visible when the 
customer is logged in.
');

define('TEXT_TITLE_BOXES_INDIVIDUAL', 'This section handles changes to individual boxes.
Select the box to be edited from the dropdown menu. Not all boxes will have links that
can be determined by the code. If the links are not displayed properly on the page in admin,
they probably won\'t show up in the shop either. In that case, the box should be excluded. It
should be noted that the name of the box can be changed by editing the box next to the name 
of the language. This text is overridden by the option in configuration settings in Sitemap SEO
in admin. But if that option is not used, this one may be.
');

define('TEXT_TITLE_ADDITIONAL_LINKS', 'This section allows for controlling items not found in the other sections.
To add a page to a specific box, select the box from the dropdown menu, fill in the entries and update.
Then select that box in the "Boxes Individual Control" section and setup any attributes of the link as desired.
This will allow adding links to boxes that cannot be displayed due to code in the box.');

define('TEXT_TITLE_SETTINGS', 'This section is for setting options that may vary for each language. Options
that are common to all lanugages are found in admin->Configuration->Sitemap SEO.');

define('ERROR_FAILED_READ_FILE', 'Failed to read file %s');
define('ERROR_LINKS_EXISTS', 'An entry for this link already exists.');
define('ERROR_MISSING_DEFINE', '<span style="color: red;">Red</span> = Missing Definition');
define('ERROR_MISSING_SELECTION', 'A file must be selected for this operation.');

define('MESSAGE_SUCCESS', 'Update was successful');
define('INPUT_BOX_WIDTH', '15');
?>
