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
<dt><b>Why Digital Readout?</b></dt><dt><br />
</dt><dt>Manually controlled machines require an operator to directly position 
          the workpiece or tool to carry out the machining process. A handwheel 
          attached to a leadscrew is turned and the number of revolutions has 
          to be counted by the operator to know how far the workpiece or tool 
          has traveled. Digital readout systems comprise a linear measuring scale, one for 
          each slideway axis, usually two or three, and a digital display unit. 
          When installed on a machine, the display will show the exact travel 
          of the tool or workpiece. A direct digital display of position or travel 
          will now assist the operator to produce parts up to 50% quicker, with 
          fewer mistakes and therefore less scrapped parts. Accuracy is also improved 
          as any mechanical errors in the leadscrew are eliminated, the displayed 
          travel being the precise movement of the slide not revolutions of the 
          leadscrew. </dt>

<P><FONT SIZE="+2">Simple Adder</FONT></P>

<FORM NAME="Calculator" METHOD="post">
<P>Lathe or Mill used hours per week: <INPUT TYPE=TEXT NAME="input_A" SIZE=2 VALUE=60></P>
<P>Shop Rate/Hour ($): <INPUT TYPE=TEXT NAME="input_B" SIZE=2 VALUE=50></P>
<P>DRO Productivity Improvement (%): <INPUT TYPE=TEXT NAME="input_C" SIZE=2 VALUE=25></P>
<P>Average Cost of a DRO kit ($): <INPUT TYPE=TEXT NAME="input_D" SIZE=2 VALUE=800></P>
<P><INPUT TYPE="button" VALUE="Calculate" name="AddButton" onClick="CalculateSum(this.form.input_A.value, this.form.input_B.value, this.form.input_C.value,this.form.input_D.value,this.form)"></P>
<P>Hours saved     = <INPUT TYPE=TEXT NAME="Answer" SIZE=1>hrs/week</P>
<P>Productivity improvement = $<INPUT TYPE=TEXT NAME="Answer1" SIZE=1>per week</P>
<P>Return of Investment  in <INPUT TYPE=TEXT NAME="Answer2" SIZE=1> weeks</P>
<P><INPUT TYPE="button" VALUE="Clear Fields" name="ClearButton" onClick="ClearForm(this.form)"></P>
</FORM>



<br/>
<br/>

');
?>
