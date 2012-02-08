# =====  QTPro   =====
# This SQL code will instert the configuration menu 'Prod Info (QTPro)' and it's keys.
# As "DELETE FROM ... " is run before every entry this file can be run over the same database as many times as you like =)
# ====================

# Insert configuration group for Product Information page
DELETE FROM configuration_group WHERE configuration_group_id=888001;
INSERT INTO configuration_group (configuration_group_id, configuration_group_title, configuration_group_description, sort_order, visible) VALUES (888001, 'Prod Info (QTPro)', 'Configuration options for the Product Information page. This configuration menu is acctually the menu for the contribution QTPro.', 8, 1);

# Insert configuration keys for Product Information Page
DELETE FROM configuration WHERE configuration_key='PRODINFO_ATTRIBUTE_PLUGIN';
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES ('Product Info Attribute Display Plugin', 'PRODINFO_ATTRIBUTE_PLUGIN', 'multiple_dropdowns', 'The plugin used for displaying attributes on the product information page.', 888001, 1, now(), NULL, 'tep_cfg_pull_down_class_files(\'pad_\',');

DELETE FROM configuration WHERE configuration_key='PRODINFO_ATTRIBUTE_SHOW_OUT_OF_STOCK';
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES ('Show Out of Stock Attributes', 'PRODINFO_ATTRIBUTE_SHOW_OUT_OF_STOCK', 'True', '<b>If True:</b> Attributes that are out of stock will be displayed.<br /><br /><b>If False:</b> Attributes that are out of stock will <b><em>not</em></b> be displayed.</b><br /><br /><b>Default is True.</b>', 888001, 10, now(), NULL, 'tep_cfg_select_option(array(\'True\', \'False\'),');

DELETE FROM configuration WHERE configuration_key='PRODINFO_ATTRIBUTE_MARK_OUT_OF_STOCK';
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES ('Mark Out of Stock Attributes', 'PRODINFO_ATTRIBUTE_MARK_OUT_OF_STOCK', 'Right', 'Controls how out of stock attributes are marked as out of stock.', 888001, 20, now(), NULL, 'tep_cfg_select_option(array(\'None\', \'Right\', \'Left\'),');

DELETE FROM configuration WHERE configuration_key='PRODINFO_ATTRIBUTE_OUT_OF_STOCK_MSGLINE';
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES ('Display Out of Stock Message Line', 'PRODINFO_ATTRIBUTE_OUT_OF_STOCK_MSGLINE', 'True', '<b>If True:</b> If an out of stock attribute combination is selected by the customer, a message line informing on this will displayed.', 888001, 30, now(), NULL, 'tep_cfg_select_option(array(\'True\', \'False\'),');

DELETE FROM configuration WHERE configuration_key='PRODINFO_ATTRIBUTE_NO_ADD_OUT_OF_STOCK';
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES ('Prevent Adding Out of Stock to Cart', 'PRODINFO_ATTRIBUTE_NO_ADD_OUT_OF_STOCK', 'True', '<b>If True:</b> Customer will not be able to ad a product with an out of stock attribute combination to the cart. A javascript form will be displayed.', 888001, 40, now(), NULL, 'tep_cfg_select_option(array(\'True\', \'False\'),');

DELETE FROM configuration WHERE configuration_key='PRODINFO_ATTRIBUTE_ACTUAL_PRICE_PULL_DOWN';
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES ('Use Actual Price Pull Downs', 'PRODINFO_ATTRIBUTE_ACTUAL_PRICE_PULL_DOWN', 'False', '<font color="red"><b>NOTE:</b></font> This can only be used with a satisfying result if you have only one option per product.<br /><br /><b>If True:</b> Option prices will displayed as a final product price.<br /><br /><b>Default is false.</b>', 888001, 40, now(), NULL, 'tep_cfg_select_option(array(\'True\', \'False\'),');

DELETE FROM configuration WHERE configuration_key='PRODINFO_ATTRIBUTE_DISPLAY_STOCK_LIST';
INSERT INTO configuration (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, use_function, set_function) VALUES ('Display table with stock information', 'PRODINFO_ATTRIBUTE_DISPLAY_STOCK_LIST', 'True', '<b>If True:</b> A table with information on whats on stock will be displayed to the customer. If product doesn\'t have any attributes with tracked stock; the table won\'t be displayed.<br /><br /><b>Default is true.</b>', 888001, 50, now(), NULL, 'tep_cfg_select_option(array(\'True\', \'False\'),');

# =====  QTPro   =====
# These are database changes for a store that does not have a previous version of QT Pro installed.
# These database changes must be run uppon installation for the contribution to work.
# ====================

# Add new column to products_options to indicate if stock should be tracked for an option
ALTER TABLE products_options
  ADD products_options_track_stock tinyint(4) default '0' not null
  AFTER products_options_name;

  
# Add new column to orders_products to track attributes to make it possible to delete an order and restock
ALTER TABLE orders_products
  ADD products_stock_attributes varchar(255) default NULL
  AFTER products_quantity;


# Create new table to track stock for products attributes
DROP TABLE IF EXISTS products_stock;
CREATE TABLE products_stock (
  products_stock_id int(11) not null auto_increment,
  products_id int(11) default '0' not null ,
  products_stock_attributes varchar(255) not null,
  products_stock_quantity int(11) default '0' not null ,
  PRIMARY KEY (products_stock_id),
  UNIQUE idx_products_stock_attributes (products_id,products_stock_attributes)
);