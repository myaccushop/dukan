#
# An SQL command to empty Data tables. Execute this in phpMyAdmin to
# remove any shop-specific data from data tables
#

TRUNCATE `address_book`;
TRUNCATE `categories`;
TRUNCATE `categories_description`;
TRUNCATE `customers`;
TRUNCATE `customers_basket`;
TRUNCATE `customers_basket_attributes`;
TRUNCATE `customers_info`;
TRUNCATE `manufacturers`;
TRUNCATE `manufacturers_info`;
TRUNCATE `newsletters`;
TRUNCATE `orders`;
TRUNCATE `orders_products`;
TRUNCATE `orders_products_attributes`;
TRUNCATE `orders_products_download`;
TRUNCATE `orders_status`;
TRUNCATE `orders_status_history`;
TRUNCATE `orders_total`;
TRUNCATE `products`;
TRUNCATE `products_attributes`;
TRUNCATE `products_attributes_download`;
TRUNCATE `products_description`;
TRUNCATE `products_images`;
TRUNCATE `products_notifications`;
TRUNCATE `products_options`;
TRUNCATE `products_options_values`;
TRUNCATE `products_options_values_to_products_options`;
TRUNCATE `products_to_categories`;
TRUNCATE `reviews`;
TRUNCATE `reviews_description`;
TRUNCATE `specials`;
