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
require(DIR_WS_LANGUAGES . $language . '/modules/UHtmlEmails/Standard/password_forgotten.php');
$ArrayLNTargets = array("\r\n", "\n\r", "\n", "\r", "\t"); //This will be used for taking away linefeeds with str_replace() throughout the mail. Tabs is invisible so we take them away to

$check_customer_query_uhtml = tep_db_query("select customers_gender from " . TABLE_CUSTOMERS . " where customers_email_address = '" . tep_db_input($email_address) . "'");
$check_customer_uhtml = tep_db_fetch_array($check_customer_query_uhtml);
$gender = $check_customer_uhtml['customers_gender'];

	if (ACCOUNT_GENDER == 'true'){
		if($gender == 'm'){
			$HTMLGreet = sprintf(trim(UHE_GREET_MR), $check_customer['customers_lastname']);
		}elseif($gender == 'f'){
			$HTMLGreet = sprintf(trim(UHE_GREET_MS), $check_customer['customers_lastname']);
		}else{
			$HTMLGreet = sprintf(trim(UHE_GREET_NONE), $check_customer['customers_firstname'].' '.$check_customer['customers_lastname']);
		}
	} else {
		$HTMLGreet = sprintf(trim(UHE_GREET_NONE), $check_customer['customers_firstname'].' '.$check_customer['customers_lastname']);
	}
	
$html_email = '<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"></head>
<body style="margin: 0px; padding: 0px; background-color:#87A44C;">
<font face="Times New Roman, Times, serif">

<table width="100%" height="75px" border="0" background="'. HTTP_SERVER . DIR_WS_CATALOG . DIR_WS_MODULES .'UHtmlEmails/'.ULTIMATE_HTML_EMAIL_LAYOUT.'/mailgradient.png" cellpadding="0" cellspacing="0"><tr valign="middle"><td>
	<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '" style="text-decoration:none; color:white;"><font size="+4" color="white" style="margin-left:0.3em; text-decoration:none; color:white;">'.STORE_NAME.'</font></a>
</td></tr></table>


<div style="font-size: medium; padding: 1em; border-style:solid; border-width: 14px; border-color: #87A44C;	background-color:#FFFFFF;">
<span style="font-size: 24px;">'.$HTMLGreet.'</span><br/><br/>'. sprintf(UHE_PASSWORD_REMINDER_BODY, $new_password).sprintf(UHE_SIGNATURE, STORE_NAME, HTTP_SERVER . DIR_WS_CATALOG).'</div>

</font>
</body>
</html>';


$html_email = str_replace($ArrayLNTargets, '', $html_email);

?>