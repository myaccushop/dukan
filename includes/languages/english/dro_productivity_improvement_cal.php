<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2002 osCommerce

  Released under the GNU General Public License
*/

define('NAVBAR_TITLE', 'DRO Productivity improvement');
define('HEADING_TITLE', 'Productivity improvement gained using DRO.');

define('TEXT_DRO_PRODUCTIVITY_CAL', '
<br/>
Productivity improvement gained using DRO Is typically 20% to 40%. Please use following calculator to findout your productivity gained by using DRO.
<br/>
<br/>
<div class="grid_10"  style="background-color:#f2f2f2" >
<br/>
<FORM NAME="Calculator" METHOD="post">
<P>Lathe or Mill used hours per week: <INPUT TYPE=TEXT NAME="input_A" SIZE=2 VALUE=20></P>
<P>Shop Rate/Hour ($): <INPUT TYPE=TEXT NAME="input_B" SIZE=2 VALUE=50></P>
<P>DRO Productivity Improvement (%): <INPUT TYPE=TEXT NAME="input_C" SIZE=2 VALUE=40></P>
<P>Average Cost of a DRO kit @AccuDRO ($): <INPUT TYPE=TEXT NAME="input_D" SIZE=2 VALUE=800></P>
<P><INPUT TYPE="button" VALUE="Calculate" name="AddButton" onClick="CalculateSum(this.form.input_A.value, this.form.input_B.value, this.form.input_C.value,this.form.input_D.value,this.form)"></P>
<P>Hours saved     = <INPUT TYPE=TEXT NAME="Answer" SIZE=1>hrs/week</P>
<P>Productivity improvement = $<INPUT TYPE=TEXT NAME="Answer1" SIZE=1>per week.</P>
<P>Return of Investment  in <INPUT TYPE=TEXT NAME="Answer2" SIZE=1> weeks.</P>
<P><INPUT TYPE="button" VALUE="Clear Fields" name="ClearButton" onClick="ClearForm(this.form)"></P>
</FORM>
Order your DRO kit here online or by sending us email <a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">' . STORE_OWNER_EMAIL_ADDRESS . '</a> or call ' . SUPPORT_PHONE_NUMBER . ' and start saving money today.<br />

<br/>
</div>
 <div style="clear: both;"></div>
<br/>
<br/>

');
?>
