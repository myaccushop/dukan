<?php
/*
=========================================================================================
This module does one thing: It creates the contents of the html email in the variable $html_email.

If you would like to customize this html email you should first make sure you know a bit about html emails.
Here are some liks that might be interesting for you: 

http://www.xavierfrenette.com/articles/css-support-in-webmail/
http://www.alistapart.com/articles/cssemail/
http://www.campaignmonitor.com/blog/archives/2006/03/a_guide_to_css_1.html
http://www.reachcustomersonline.com/content/2004/11/11/09.27.00/index.php
=========================================================================================
*/
require(DIR_FS_CATALOG . DIR_WS_LANGUAGES . $language . '/modules/UHtmlEmails/Standard/orders.php');
$ArrayLNTargets = array("\r\n", "\n\r", "\n", "\r", "\t"); //This will be used for taking away linefeeds with str_replace() throughout the mail. Tabs is invisible so we take them away to


$html_email = '<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body style="margin: 0px; padding: 0px; background-color:#87A44C;">
<font face="Times New Roman, Times, serif">

<table width="100%" height="75px" border="0" background="'. HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_MODULES .'UHtmlEmails/'.ULTIMATE_HTML_EMAIL_LAYOUT.'/mailgradient.png" cellpadding="0" cellspacing="0"><tr valign="middle"><td>
	<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '" style="text-decoration:none; color:white;"><font size="+4" color="white" style="margin-left:0.3em; text-decoration:none; color:white;">'.STORE_NAME.'</font></a>
</td></tr></table>

<div style="font-size:14px; padding: 1em; border-style:solid; border-width: 14px; border-color: #87A44C; background-color:#FFFFFF;">



<span style="font-size: 24px;">'. UHE_TEXT_DEAR .' '. $check_status['customers_name'] .',</span><br/>'. UHE_MESSAGE_GREETING .'<br/><br/>

		<strong>'.UHE_TEXT_STATUS.'</strong> '. $orders_status_array[$status] .'<br /><br />';
		
		if ($comments != '') {// Add the customers order comments If the exists.
    		$html_email .= '<strong>'.UHE_TEXT_COMMENTS.'</strong><br /><font face="Courier New, Courier, monospace" size="-1">'. str_replace($ArrayLNTargets, '<br />', $comments) .'</font><br /><br />';
  		}
		
		$html_email .='
		<table style="font-size:14px; font-family:\'times\';" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td><font face="Times New Roman, Times, serif" style="font-size:14px;"><strong>'.UHE_TEXT_ORDER_NUMBER.'</strong></font></td>
			<td><font face="Times New Roman, Times, serif" style="font-size:14px;">&nbsp;'.$oID.'</font></td>
		  </tr>
		  <tr>
			<td><font face="Times New Roman, Times, serif" style="font-size:14px;"><strong>'.UHE_TEXT_DATE_ORDERED.'</strong></font></td>
			<td><font face="Times New Roman, Times, serif" style="font-size:14px;">&nbsp;'.tep_date_long($check_status['date_purchased']).'</font></td>
		  </tr>
		  <tr>
			<td><font face="Times New Roman, Times, serif" style="font-size:14px;"><strong>'.UHE_TEXT_INVOICE_URL.'</strong></font></td>
			<td><font face="Times New Roman, Times, serif" style="font-size:14px;">&nbsp;<a href="' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') .'">' . tep_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id=' . $oID, 'SSL') .'</a></font></td>
		  </tr>
		</table>
</div>

</font>
</body>
</html>';


$html_email = str_replace($ArrayLNTargets, '', $html_email);
?>