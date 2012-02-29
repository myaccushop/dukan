<?php
/*
  $Id: sitemap_seo_page control.php 2008-12-20 by Jack_mcs

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2009 oscommerce-solution.com

  Released under the GNU General Public License
*/
 
  require('includes/application_top.php');
  require(DIR_WS_FUNCTIONS . FILENAME_SITEMAP_SEO);
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SITEMAP_SEO);

  /********************** BEGIN VERSION CHECKER *********************/
  if (file_exists(DIR_WS_FUNCTIONS . 'version_checker.php'))
  {
     require(DIR_WS_LANGUAGES . $language . '/version_checker.php');
     require(DIR_WS_FUNCTIONS . 'version_checker.php');
     $contribPath = 'http://addons.oscommerce.com/info/6459';
     $currentVersion = 'Sitemap SEO V 1.8';
     $contribName = 'Sitemap SEO V';
     $versionStatus = '';
  }
  /********************** END VERSION CHECKER *********************/

  $pageArray = array();
  $linkArray = array();
  $languages = tep_get_languages();
  
  $action = (isset($_POST['action']) ? $HTTP_POST_VARS['action'] : '');
  
  if (tep_not_null($action))
  {
     /********************** CHECK THE VERSION ***********************/
     if ($action == 'getversion')
     {
         if (isset($_POST['version_check']) && $_POST['version_check'] == 'on')
             $versionStatus = AnnounceVersion($contribPath, $currentVersion, $contribName);
     }
     
     else
     {
    for ($i = 0; $i < count($languages); ++$i)
    {
      $fileCnt = sprintf("total_entries_%d", $languages[$i]['id']); //find count per language
      $fileCnt = $_POST[$fileCnt];

      for ($p = 0; $p < $fileCnt; ++$p)
      {
        $append = $languages[$i]['id'] . '_' . $p;

        $alternateName  = 'alternate_name_' . $append;
        $anchorText  = 'anchor_text_' . $append;
        $excludePage = 'exclude_page_' . $append;
        $fileName = 'filename_' . $append;
        $registeredOnly = 'registered_only_' . $append;
        $sortOrder   = 'sort_order_' . $append;

        $alternateName = (isset($_POST[$alternateName]) && tep_not_null($_POST[$alternateName]) ? tep_db_prepare_input($_POST[$alternateName]) : '');
        $anchorText = (isset($_POST[$anchorText]) && tep_not_null($_POST[$anchorText]) ? tep_db_prepare_input($_POST[$anchorText]) : '');
        $excludePage = (isset($_POST[$excludePage]) && $_POST[$excludePage] == 'on') ? 1 : 0;
        $fileName = (isset($_POST[$fileName]) && tep_not_null($_POST[$fileName]) ? tep_db_prepare_input($_POST[$fileName]) : '');
        $registeredOnly = (isset($_POST[$registeredOnly]) && $_POST[$registeredOnly] == 'on') ? 1 : 0;
        $sortOrder = (isset($_POST[$sortOrder])) ? (int)$_POST[$sortOrder] : 0;  
     
        if (tep_not_null($fileName)) {
          $pages_query = tep_db_query("select exclude_id from " . TABLE_SITEMAP_SEO_PAGES . " where page_file_name LIKE '" . $fileName . "' and language_id = '" . (int)$languages[$i]['id'] . "' LIMIT 1");
          $pages = tep_db_fetch_array($pages_query);  

          if ($pages['exclude_id'] > 0)  { //then entry exists
            tep_db_query("update " . TABLE_SITEMAP_SEO_PAGES . " set alternate_page_name = '" . tep_db_input($alternateName) . "', anchor_text = '" . $anchorText . "', excluded_page = '" . (int)$excludePage . "', registered_only = '" . (int)$registeredOnly . "', sort_order = '" . (int)$sortOrder . "' where exclude_id = '" . $pages['exclude_id'] . "' and page_file_name LIKE '" . $fileName . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
          } else {
            tep_db_query("insert into " . TABLE_SITEMAP_SEO_PAGES . " (page_file_name, alternate_page_name, anchor_text, excluded_page, registered_only, sort_order, language_id) values ('" . tep_db_input($fileName) . "', '" . tep_db_input($alternateName) . "', '" . tep_db_input($anchorText) . "', '" . (int)$excludeLink . "', '" . (int)$registeredOnly . "', '" . (int)$sortOrder . "', '" . (int)$languages[$i]['id'] . "')");
          }  
        }  
      }
    }   
  }
  }
 
  $excludeList = array();
  $excludeList[] = 'account.php';
  $excludeList[] = 'account_edit.php';
  $excludeList[] = 'account_history.php';
  $excludeList[] = 'account_history_info.php';
  $excludeList[] = 'account_newsletters.php';
  $excludeList[] = 'account_notifications.php';
  $excludeList[] = 'account_password.php';
  $excludeList[] = 'address_book.php';
  $excludeList[] = 'address_book_process.php';
  $excludeList[] = 'checkout_confirmation.php';
  $excludeList[] = 'checkout_payment.php';
  $excludeList[] = 'checkout_payment_address.php';
  $excludeList[] = 'checkout_process.php';
  $excludeList[] = 'checkout_shipping.php';
  $excludeList[] = 'checkout_shipping_address.php';
  $excludeList[] = 'checkout_success.php';
  $excludeList[] = 'cookie_usage.php';
  $excludeList[] = 'create_account.php';
  $excludeList[] = 'create_account_success.php';
  $excludeList[] = 'download.php';
  $excludeList[] = 'info_shopping_cart.php';
  $excludeList[] = 'login.php';
  $excludeList[] = 'logoff.php';
  $excludeList[] = 'password_forgotten.php';
  $excludeList[] = 'product_info.php';
  $excludeList[] = 'ssl_check.php';
                      
  $pagesArray = GetPagesArray(DIR_FS_CATALOG, DIR_WS_LANGUAGES, $languages, $excludeList);

  require(DIR_WS_INCLUDES . 'template_top.php');
?>


<script type="text/javascript">
function ChangeClickedStatus(boxname, languageid)
{
  var box = boxname + "_" + languageid;
  var ison = document.getElementsByName(box)[0].checked; 
  var elm = document.getElementsByTagName("input");

  for (j = 0; j < elm.length; j++) 
  {
    if (elm[j].type == 'checkbox')
    {    
      if (elm[j].name.search(boxname + "_" + languageid) == 0)
      {
         if (ison == true)
           elm[j].checked = true;
         else
           elm[j].checked = false;
      }
    } 
  }     
}
</script>


<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
     <tr>
      <td><table border="0" width="95%" cellspacing="0" cellpadding="0">
       <tr>
        
        <td><table border="0" width="95%" cellspacing="0" cellpadding="0">
            <tr>
               <td class="pageHeading" valign="top"><?php echo HEADING_TITLE; ?></td>
            </tr>
            <tr>
               <td class="smallText" valign="top"><?php echo HEADING_TITLE_SUPPORT_THREAD; ?></td>
            </tr>
        </table></td>    
            
        
        <td><table border="0" width="100%">
         <tr>       
          <td class="smallText" align="right"><?php echo HEADING_TITLE_AUTHOR; ?></td>
         </tr>
         <?php  
         if (function_exists('AnnounceVersion')) {
            if (SITEMAP_SEO_ENABLE_VERSION_CHECKER == 'true') { 
         ?>
               <tr>
                  <td class="smallText" align="right" style="font-weight: bold; color: red;"><?php echo AnnounceVersion($contribPath, $currentVersion, $contribName); ?></td>
               </tr>
         <?php } else if (tep_not_null($versionStatus)) { 
           echo '<tr><td class="smallText" align="right" style="font-weight: bold; color: red;">' . $versionStatus . '</td></tr>';
         } else {
           echo tep_draw_form('version_check', FILENAME_SITEMAP_SEO_PAGE_CONTROL, '', 'post') . tep_draw_hidden_field('action', 'getversion'); 
         ?>
               <tr>
                  <td class="smallText" align="right" style="font-weight: bold; color: red;"><INPUT TYPE="radio" NAME="version_check" onClick="this.form.submit();"><?php echo TEXT_VERSION_CHECK_UPDATES; ?></td>
               </tr>
           </form>
         <?php } } else { ?>
            <tr>
               <td class="smallText" align="right" style="font-weight: bold; color: red;"><?php echo TEXT_MISSING_VERSION_CHECKER; ?></td>
            </tr>
         <?php } ?>         
        </table></td>
       </tr>  
      </table></td>  
     </tr>
     
     
     <!-- Begin of Sitemap SEO Pages Main Control -->
     <tr>
      <td><table border="0" width="75%" style="background-color: #fff; border: ridge #CCFFCC 3px;">
			 <tr>
			  <td><table border="0" width="100%" cellspacing="0" cellpadding="2" style="background-color: #f0f1f1; border: ridge #CCFFCC 3px;">
         <tr>
          <th class="main" style="font-size: 14px"><?php echo HEADING_TITLE_PAGES_GROUP; ?></th>
         </tr>		
         <tr><td height="6"></td></tr>	
         <tr>
          <td class="main"><?php echo TEXT_TITLE_PAGES_GROUP; ?></td>
         </tr>		 
         <tr><td height="6"></td></tr>	
        </table></td>
       </tr>       
       <tr>
        <td align="right"><?php echo tep_draw_form('sitemap_seo_pages', FILENAME_SITEMAP_SEO_PAGE_CONTROL, '', 'post') . tep_draw_hidden_field('action', 'process_pages'); ?></td>
         <tr>
          <td><table border="2" width="100%">

           <tr>
            <td><table border="0" width="100%">
             <?php for ($i=0; $i < count($languages); ++$i) { 
                     $name = sprintf("box_page_name_%d", $languages[$i]['id']);             
             ?>
             <tr><td><?php echo tep_black_line(); ?></td></tr>
             <tr>
              <td><table border="0" width="60%" cellpadding="0">             
               <tr class="main"> 
                <th align="left" style="font-weight: bold;"><?php echo $languages[$i]['name']; ?></th>
               </tr>
              </table></td>
             </tr>                 
             <tr><td height="6"></td></tr>
             
             <tr>
              <td><table border="0" width="100%" cellpadding="0">
               <tr class="smallText">
                <th><?php echo ENTRY_EXCLUDE; ?></th>    
                <th width="22%"><?php echo TEXT_FILENAME; ?></th>
                <th width="22%"><?php echo TEXT_DISPLAY_NAME; ?></th>
                <th width="22%"><?php echo TEXT_DISPLAY_NAME_ALTERNATE; ?></th>
                <th width="22%"><?php echo TEXT_LINK_ANCHOR_TEXT; ?></th>
                <th align="right"><?php echo TEXT_LINK_SORT_ORDER; ?></th>
                <th><?php echo ENTRY_REGISTERED_ONLY; ?></th>               
               </tr>
               <tr class="smallText">
                <th align="left"><input type="checkbox" name="exclude_page_<?php echo $languages[$i]['id']; ?>" onclick="ChangeClickedStatus('exclude_page', <?php echo $languages[$i]['id']; ?>);"><?php echo TEXT_CHECKBOX_ALL; ?></th>
                <td colspan="5"></th>    
                <th align="right"><?php echo TEXT_CHECKBOX_ALL; ?><input type="checkbox" name="registered_only" onclick="ChangeClickedStatus('registered_only', <?php echo $languages[$i]['id']; ?>);">&nbsp;</th>    
               </tr>               
              </table></td> 
             </tr>
             
             <?php if (count($pagesArray) > 0) { ?>            
             <tr>
              <td><table border="0" width="100%" cellpadding="0">
               <?php
               $id = $languages[$i]['id']; //reduce clutter 
               $pageSettings = GetPageSettings($pagesArray[$id], $id);
               for ($p = 0; $p < count($pagesArray[$id]); ++$p) {
               ?>
               <tr class="smallText">
                <td><input type="checkbox" name="<?php echo 'exclude_page_' . $id . '_' . $p; ?>" <?php echo $pageSettings[$p]['excluded']; ?> id="<?php echo 'exclude_page_' . $id . '_' . $p; ?>" <?php echo $pageSettings[$p]['excluded']; ?> maxlength="2" size="3"></td>
                <td width="22%"><?php echo $pagesArray[$id][$p]['filename']; ?></td>
                <td width="22%"><nobr><?php echo $pagesArray[$id][$p]['display_name']; ?></nobr></td>
                <td width="22%"><input type="text" name="<?php echo 'alternate_name_' . $id . '_' . $p; ?>" value="<?php echo $pageSettings[$p]['alternate_page_name']; ?>" maxlength="255" size="24"></td>
                <td width="22%"><input type="text" name="<?php echo 'anchor_text_' . $id . '_' . $p; ?>" value="<?php echo $pageSettings[$p]['anchor_text']; ?>" maxlength="255" size="24"></td>
                <td><input type="text" name="<?php echo 'sort_order_' . $id . '_' . $p; ?>" value="<?php echo $pageSettings[$p]['sortorder']; ?>" maxlength="2" size="3"></td>
                <td><input type="checkbox" name="<?php echo 'registered_only_' . $id . '_' . $p; ?>" <?php echo $pageSettings[$p]['registered_only']; ?> maxlength="2" size="3"></td>
                <td>
               </tr> 
               <?php 
                echo tep_draw_hidden_field('filename_'.$id.'_'.$p, $pagesArray[$id][$p]['filename']);
               } 
               echo tep_draw_hidden_field('total_entries_'.$id, count($pagesArray[$id]));
               ?>
              </table></td>
             </tr>             
             <?php 
             } } 
             ?>
            </table></td>
           </tr>
          </table></td>   
         </tr>
        <tr> 
         <td align="center"><?php echo (tep_image_submit('button_update.gif', IMAGE_UPDATE, 'name="update_pages"') ); ?></td>
        </tr> 
        </form>
        </td>
       </tr>
      </table></td>
     </tr>  
     <!-- end of Sitemap SEO Pages--> 
	 
    </table></td>
  </tr>
</table>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
