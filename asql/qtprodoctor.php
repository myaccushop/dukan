<?php
/*
  $Id: server_info.php 1785 2008-01-10 15:07:07Z hpdl $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2008 osCommerce

  Released under the GNU General Public License
*/

  require('includes/application_top.php');
    require(DIR_WS_INCLUDES . 'template_top.php');

  if(isset($HTTP_GET_VARS['action'])){
  	$doctor_action = $HTTP_GET_VARS['action'];
  }
  
  if(isset($HTTP_GET_VARS['pID'])){
  	$products_id = $HTTP_GET_VARS['pID'];
  }
  
?>

<table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo 'QTPro Doctor';//echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo tep_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table>
		</td>
      </tr>
      <tr>
        <td>
		<?php 
			switch($doctor_action){
				case 'examine':
					if(qtpro_doctor_product_healthy($products_id)){
						print '<span style="font-family: Verdana, Arial, sans-serif; font-size: 10px; color: green; font-weight: normal; text-decoration: none;"><b>Product is healthy</b><br /> The database entries for this products stock as they should.</span>';
					}else{
						print '<span style="font-family: Verdana, Arial, sans-serif; font-size: 10px; color: red; font-weight: normal; text-decoration: none;"><b>Product is sick</b><br /> The database entries for this products stock is messed up. This is why the table above looks messed up.</span>';
					}
				break;
				case 'amputate':
					print qtpro_doctor_amputate_bad_from_product($products_id).' database entries where amputated';
					qtpro_update_summary_stock($products_id);
				break;
				case 'chuck_trash':
					print qtpro_chuck_trash().' database entries where identified as trash and deleted.';
				break;
				case 'update_summary':
					qtpro_update_summary_stock($products_id);
					print 'The summary stock for the product was updated.';
				break;
				
				
				
				default:
					print "<h1 class=\"pageHeading\">QTPro Doctor - Overview</h1>";
					print "You currently have <b>". qtpro_normal_product_count()."</b> products in your store.<br>";
					print "<b>".qtpro_tracked_product_count()."</b> of them have options with tracked stock.<br>";
					print "In the database we currently have <b>". qtpro_number_of_trash_stock_rows() . "</b> trash rows.";
					//print "<b>".qtpro_sick_product_count()."</b> of the producks with tracked stock is sick.<br><br>";
					qtpro_doctor_formulate_database_investigation();

					
				break;
			
			}
		?>

		</td>
      </tr>
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
    </table>
        <?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>