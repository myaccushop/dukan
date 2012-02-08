<?php

  /*Copied from admin functions*/
  function tep_values_name($values_id) {
    global $languages_id;

    $values = tep_db_query("select products_options_values_name from " . TABLE_PRODUCTS_OPTIONS_VALUES . " where products_options_values_id = '" . (int)$values_id . "' and language_id = '" . (int)$languages_id . "'");
    $values_values = tep_db_fetch_array($values);

    return $values_values['products_options_values_name'];
  }

/////   MISSION CODENAME: "GET INFORMATION" STARTS HERE   /////
//Get the products_price and products_tax_class_id
$products_facts_query = "select IF(s.status, s.specials_new_products_price, p.products_price) as products_price, p.products_tax_class_id from " . TABLE_PRODUCTS . " p left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id where p.products_id = " . (int)$HTTP_GET_VARS['products_id'] ;
$products_facts = tep_db_fetch_array(tep_db_query($products_facts_query)); 

// Get the stocklevels
$products_stock_query=tep_db_query("SELECT products_stock_attributes, products_stock_quantity 
								  FROM " . TABLE_PRODUCTS_STOCK . " 
								  WHERE products_id=" . (int)$HTTP_GET_VARS['products_id'] ." 
								  ORDER BY products_stock_attributes");

// get the option names
$products_options_name_query = tep_db_query("SELECT distinct popt.products_options_id, popt.products_options_name 
										   FROM " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib 
										   WHERE patrib.products_id='" . (int)$HTTP_GET_VARS['products_id'] . "' 
										   AND patrib.options_id = popt.products_options_id 
										   AND popt.products_options_track_stock = '1' 
										   AND popt.language_id = '" . (int)$languages_id . "' 
										   ORDER BY popt.products_options_id");			

// build array of attributes price delta
$attributes_price = array();
$products_attributes_query = tep_db_query("SELECT pa.options_id, pa.options_values_id, pa.options_values_price, pa.price_prefix 
										 FROM " . TABLE_PRODUCTS_ATTRIBUTES . " pa 
										 WHERE pa.products_id = '" . (int)$HTTP_GET_VARS['products_id'] . "'"); 
while ($products_attributes_values = tep_db_fetch_array($products_attributes_query)) {
	$option_price = $products_attributes_values['options_values_price'];
	if ($products_attributes_values['price_prefix'] == "-") $option_price= -1*$option_price;
	$attributes_price[$products_attributes_values['options_id']][$products_attributes_values['options_values_id']] = $option_price;
}									   
/////   MISSION CODENAME: "GET INFORMATION" ENDS HERE   /////


//OK! time to generate the html table
//$html_ev_out will be displayed at the end of the script if $rowscounter > 0
$rowscounter = 0;
$html_ev_out = '<br /><strong>' . STOCK_LIST_IN_PI_TEXT_HEADING . '</strong> 
<table border="0" cellspacing="0" cellpadding="0"><tr><td class="infoBoxHeading">
<table class="boxText" border="0" cellspacing="2" cellpadding="6"> <tr>';
//I have 2 tables because the parent table creates the background and lines in correct collor between the child tables cells. Parent table has only one cell.

// build heading line with option names
while ($products_options_name = tep_db_fetch_array($products_options_name_query)) {
	$html_ev_out .= '<td class="infoBoxHeading" align="center">' . $products_options_name['products_options_name'] . '</td>';
}
	$html_ev_out .= '<td class="infoBoxHeading" align="center">'. STOCK_LIST_IN_PI_TEXT_PRICE .'</td>';	
	$html_ev_out .= '<td class="infoBoxHeading" align="center">'. STOCK_LIST_IN_PI_TEXT_STOCK .'</td>';
	$html_ev_out .= '</tr>';


// now create the rows! Each row will display the quantity for one combination of attributes.
while($products_stock_values=tep_db_fetch_array($products_stock_query)) {
	if($products_stock_values['products_stock_quantity'] > 0){
		//We only want to display rows for combinations we have on stock...
		//For example the quantity can be 0 or even negative if oversold.
		$rowscounter += 1; 
		$attributes=explode(",",$products_stock_values['products_stock_attributes']);
		$html_ev_out .= '<tr >'; 
		
		
		$total_price=$products_facts['products_price'];			
		foreach($attributes as $attribute) {
			$attr=explode("-",$attribute);
			$html_ev_out .= '<td class="infoBoxContents" align="center">'.tep_values_name($attr[1]).'</td>';
			$total_price+=$attributes_price[$attr[0]][$attr[1]];
		}
		$total_price=$currencies->display_price($total_price, tep_get_tax_rate($products_facts['products_tax_class_id']));
		//$total_price=$currencies->format($total_price);
		
		$html_ev_out .= '<td class="infoBoxContents" align="center">'.$total_price.'</td>';
		$html_ev_out .= '<td class="infoBoxContents" align="center">'.$products_stock_values['products_stock_quantity'].'</td>';
	}
}


$html_ev_out .= '</tr></table></td></tr></table>'; //Table is finished!
if($rowscounter > 0){//Only display the table if it contains anything =)
	echo $html_ev_out;
}
?>