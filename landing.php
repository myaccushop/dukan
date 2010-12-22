<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');

  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_DEFAULT);

  require(DIR_WS_INCLUDES . 'template_top.php');
?>
<link rel="stylesheet" type="text/css" href="http://look.mahesha.com/ext/jquery/lofslidernews/css/style4.css" />
<script language="javascript" type="text/javascript" src="http://look.mahesha.com/ext/jquery/lofslidernews/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="http://look.mahesha.com/ext/jquery/lofslidernews/js/jquery.easing.js"></script>
<script language="javascript" type="text/javascript" src="http://look.mahesha.com/ext/jquery/lofslidernews/js/script.js"></script>
<script type="text/javascript">
$(document).ready( function(){
  $obj = $('#lofslidecontent45').lofJSidernews( { interval : 4000,
    easing      : 'easeInOutQuad',
    duration    : 1200,
    auto      : true,
    maxItemDisplay  : 3,
    startItem:1,
    navPosition     : 'horizontal', // horizontal
    navigatorHeight : 15,
    navigatorWidth  : 25,
    mainWidth:980} );
  });
</script>

<?php
  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $new_products_query = tep_db_query("select p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd where p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
  } else {
    $new_products_query = tep_db_query("select distinct p.products_id, p.products_image, p.products_tax_class_id, pd.products_name, if(s.status, s.specials_new_products_price, p.products_price) as products_price from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c where p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and c.parent_id = '" . (int)$new_products_category_id . "' and p.products_status = '1' and p.products_id = pd.products_id and pd.language_id = '" . (int)$languages_id . "' order by p.products_date_added desc limit " . MAX_DISPLAY_NEW_PRODUCTS);
  }

  $num_new_products = tep_db_num_rows($new_products_query);

  if ($new_products_query > 0) {
    $counter = 0;
    $nav_counter = 0;

    $new_prods_content = '<div id="lofslidecontent45" class="lof-slidecontent" style="height:340px;"><div class="preload"><div></div></div> <div class="lof-main-outer" style="height:340px;"><ul class="lof-main-wapper">';
    while ($new_products = tep_db_fetch_array($new_products_query)) {
      $counter++;

# $new_prods_content .= '<td width="33%" align="center" valign="top"><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) . '</a><br /><a href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . $new_products['products_name'] . '</a><br />' . $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</td>';
      $new_prods_content .= '<li>' . tep_image(DIR_WS_IMAGES . $new_products['products_image'], $new_products['products_name'], "980px", "340px"). "\n";
      $new_prods_content .= '<div class="lof-main-item-desc">' . "\n";
      $new_prods_content .= '  <h3><a target="_parent" title="Newsflash 1" href="' . tep_href_link(FILENAME_PRODUCT_INFO, 'products_id=' . $new_products['products_id']) . '">' . $new_products['products_name'] . '</a> <i>' . $currencies->display_price($new_products['products_price'], tep_get_tax_rate($new_products['products_tax_class_id'])) . '</i></h3>' . "\n";
      $new_prods_content .= '  <h2>Content of Newsflash 1</h2>' . "\n";
      $new_prods_content .= '  <p>The one thing about a Web site, it always changes! Joomla! makes it easy to add Articles, content,...' . "\n";
      $new_prods_content .= '  <a class="readmore" href="#">Read more </a>'. "\n";
      $new_prods_content .= "  </p>\n";
      $new_prods_content .= "</div>\n";
      $new_prods_content .= "</li>\n";
    }

    $new_prods_content .= "</div>\n";

    $new_prods_content .= "<div class=\"lof-navigator-wapper\">\n";
    $new_prods_content .= "  <div class=\"lof-navigator-outer\">\n";
    $new_prods_content .= "    <ul class=\"lof-navigator\">\n";
    while ($nav_counter <= $counter) {
      $nav_counter++;
      $new_prods_content .= "      <li><span>" . $nav_counter . "</span></li>\n";
    }
    $new_prods_content .= "    </ul>\n";
    $new_prods_content .= "  </div>\n";
    $new_prods_content .= "</div>\n";
?>

  <div class="contentText">
    <?php echo $new_prods_content; ?>
  </div>
<?php
  }

  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');

/*
<div class="lof-main-outer" style="width:980px; height:340px;">
  <ul class="lof-main-wapper">
    <li>
      <img src="images/thumbl_980x340.png" title="Newsflash 2" >
      <div class="lof-main-item-desc">
        <h3><a target="_parent" title="Newsflash 1" href="#Category-1">/ Newsflash 1 /</a> <i> \u2014 Monday, February 15, 2010 12:42</i></h3>
        <h2>Content of Newsflash 1</h2>
        <p>The one thing about a Web site, it always changes! Joomla! makes it easy to add Articles, content,...
        <a class="readmore" href="#">Read more </a>
        </p>
      </div>
    </li>

  </ul>
</div>
<!-- END MAIN CONTENT -->
<!-- NAVIGATOR -->
<div class="lof-navigator-wapper">
  <div class="lof-navigator-outer">
    <ul class="lof-navigator">
      <li><span>1</span></li>
      <li><span>2</span></li>
      <li><span>3</span></li>
      <li><span>4</span></li>
      <li><span>5</span></li>
      <li><span>6</span></li>
      <li><span>7</span></li>
      <li><span>8</span></li>
    </ul>
  </div>
</div>
*/

?>
