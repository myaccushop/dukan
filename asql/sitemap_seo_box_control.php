<?php
/*
  $Id: sitemap_seo_box_control.php 2008-12-20 by Jack_mcs

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce
  Portions Copyright 2009 oscommerce-solution.com

  Released under the GNU General Public License
*/
 
  require('includes/application_top.php');
  require(DIR_WS_FUNCTIONS . FILENAME_SITEMAP_SEO);
  require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_SITEMAP_SEO);

  $activeSection = '';
  $boxArray = array();
  $excludedBox = '';
  $linkArray = array();
  $languages = tep_get_languages();
  
  $action = (isset($HTTP_POST_VARS['action']) ? $HTTP_POST_VARS['action'] : '');

  switch ($action)
  {
   case 'process_boxes_group':
 
     $exclude = isset($_POST['exclude_all']) && $_POST['exclude_all'] == 'on' ? 1 : 0;
     $registered = isset($_POST['registered_box']) && $_POST['registered_box'] == 'on' ? 1 : 0;

     if (isset($_POST['boxfiles']))
     {
       foreach ($_POST['boxfiles'] as $filename) 
       {
         $boxFile = trim(substr($filename, 0, strpos($filename, "-"))); //strip the language name
         $boxName = trim(substr($filename, 0, strpos($filename, "."))); //get the name without an extension
         $boxLanguage = trim(substr($filename, strpos($filename, "-") + 2)); //get the language name
  
         for ($i = 0; $i < count($languages); ++$i)
         {
           if ($boxLanguage === $languages[$i]['name'])
           {
             $boxes_query = tep_db_query("select count(*) as total from " . TABLE_SITEMAP_SEO_BOXES . " where box_file_name LIKE '" . $boxFile . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
             $boxes = tep_db_fetch_array($boxes_query);     
             
             if ($boxes['total'] > 0)  //then new entry 
               tep_db_query("update " . TABLE_SITEMAP_SEO_BOXES . " set box_page_name = '" . tep_db_input($boxName) . "', excluded_box = '" . (int)$exclude . "', registered_box = '" . (int)$registered . "' where box_file_name LIKE '" . $boxFile . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
             else
               tep_db_query("insert into " . TABLE_SITEMAP_SEO_BOXES . " (box_file_name, box_page_name, excluded_box, registered_box, language_id) values ('" . tep_db_input($boxFile) . "', '" . tep_db_input($boxName) . "', '" . (int)$exclude . "', '" . (int)$registered . "', '" . (int)$languages[$i]['id'] . "')");
           }  
         }
       }
     }    
     else
      $messageStack->add(ERROR_MISSING_SELECTION, 'error');
      
   break;
     
   case 'process_boxes_individual':
    
     /********************** UPDATE DISPLAY **********************/ 
     if (isset($_POST['update_individual_x']))  //allow dropdown selection to fall through
     { 
        if (isset($_POST['boxfiles']) && $_POST['boxfiles'] !== TEXT_MAKE_BOX_SELECTION)
        {
          $exclude = isset($_POST['exclude_link']) && $_POST['exclude_link'] == 'on' ? 1 : 0;
 
          for ($i = 0; $i < count($languages); ++$i)
          {
            $boxes_query = tep_db_query("select count(*) as total from " . TABLE_SITEMAP_SEO_BOXES . " where box_file_name LIKE '" . $_POST['boxfiles'] . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
            $boxes = tep_db_fetch_array($boxes_query);     
            
            $boxPageName = trim(substr($_POST['boxfiles'], 0, strpos($_POST['boxfiles'], "."))); //get the name without an extension
            $pseudoName = $_POST[sprintf("box_page_name_%d", $languages[$i]['id'])];
            
            if ($boxes['total'] > 0)  //then entry exists
              tep_db_query("update " . TABLE_SITEMAP_SEO_BOXES . " set box_page_name = '" . tep_db_input($boxPageName) . "', pseudo_page_name = '" . tep_db_input($pseudoName) . "', excluded_box = '" . $exclude . "' where box_file_name LIKE '" . $_POST['boxfiles'] . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
            else
              tep_db_query("insert into " . TABLE_SITEMAP_SEO_BOXES . " (box_file_name, box_page_name, pseudo_page_name, excluded_box, language_id) values ('" . tep_db_input($_POST['boxfiles']) . "', '" . tep_db_input($boxPageName) . "', '" . tep_db_input($pseudoName) . "', '" . $exclude . "', '" . (int)$languages[$i]['id'] . "')");
          }
          
          /*---------------- Now update the links for this box ----------------*/       
          
          if (isset($_POST['total_entries']))
          {
            $id = tep_db_insert_id();
 
            for ($i = 0; $i < count($languages); ++$i)
            {
               for ($b = 0; $b < $_POST['total_entries']; ++$b)
               {
                 $append = $b . '_' . $languages[$i]['id'];
                 
                 $anchorText  = 'anchor_text_' . $append;
                 $excludeLink = 'exclude_link_' . $append;  //will be overriden by above box exclude, if set
                 $pseudoName  = 'box_entry_pseduo_page_name_' . $append;
                 $realName    = 'real_define_' . $append;
                 $registeredLink = 'registered_link_' . $append;
                 $sortOrder   = 'box_entry_sort_order_' . $append;
 
                 $anchorText = (isset($_POST[$anchorText]) && tep_not_null($_POST[$anchorText]) ? $_POST[$anchorText] : '');
                 $excludeLink = (isset($_POST[$excludeLink]) && $_POST[$excludeLink] == 'on') ? 1 : 0;
                 $pseudoName = (isset($_POST[$pseudoName]) && tep_not_null($_POST[$pseudoName]) ? $_POST[$pseudoName] : '');
                 $realName = $_POST[$realName];
                 $registeredLink = (isset($_POST[$registeredLink]) && $_POST[$registeredLink] == 'on') ? 1 : 0;
                 $sortOrder = (isset($_POST[$sortOrder])) ? $_POST[$sortOrder] : 0;
        
                 if (tep_not_null($realName))                     
                 {
                   $boxes_query = tep_db_query("select box_link_id from " . TABLE_SITEMAP_SEO_BOX_LINKS . " where box_file_name LIKE '" . $_POST['boxfiles'] . "' and page_link_name = '" . $realName . "' and language_id = '" . (int)$languages[$i]['id'] . "' LIMIT 1");
                   $boxes = tep_db_fetch_array($boxes_query);  
 
                   if ($boxes['box_link_id'] > 0)  //then entry exists
                     tep_db_query("update " . TABLE_SITEMAP_SEO_BOX_LINKS . " set page_link_name = '" . tep_db_input($realName) . "', pseudo_page_link_name = '" . tep_db_input($pseudoName) . "', anchor_text = '" . $anchorText . "', excluded_link = '" . (int)$excludeLink . "', registered_link = '" . (int)$registeredLink . "', sort_order = '" . (int)$sortOrder . "' where box_link_id = '" . $boxes['box_link_id'] . "' and box_file_name LIKE '" . $_POST['boxfiles'] . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
                   else
                     tep_db_query("insert into " . TABLE_SITEMAP_SEO_BOX_LINKS . " (box_file_name, page_link_name, pseudo_page_link_name, anchor_text, excluded_link, registered_link, sort_order, language_id) values ('" . tep_db_input($_POST['boxfiles']) . "', '" . tep_db_input($realName) . "', '" . tep_db_input($pseudoName) . "', '" . tep_db_input($anchorText) . "', '" . (int)$excludeLink . "', '" . (int)$registeredLink . "', '" . (int)$sortOrder . "', '" . (int)$languages[$i]['id'] . "')");
                 }                    
               } 
            }
          }  
        }       
     }
    
   break;
   
   case 'process_boxes_additional':

     $anchorText = 'anchor_text';
     $fileName   = 'filename';
     $linkName   = 'link_name';
 
     $anchorText = (isset($_POST[$anchorText]) && tep_not_null($_POST[$anchorText]) ? $_POST[$anchorText] : '');
     $linkName = (isset($_POST[$linkName]) && tep_not_null($_POST[$linkName]) ? $_POST[$linkName] : '');
     $fileName = $_POST[$fileName];
 
     if (tep_not_null($fileName) && tep_not_null($linkName))                     
     {
       $boxes_query = tep_db_query("select box_link_id from " . TABLE_SITEMAP_SEO_BOX_LINKS . " where box_file_name LIKE '" . $_POST['boxfiles_additional'] . "' and page_link_name = '" . $fileName . "' LIMIT 1");
       $boxes = tep_db_fetch_array($boxes_query);  
 
       if ($boxes['box_link_id'] > 0)  //then entry exists
         $messageStack->add_session(sprintf(ERROR_LINKS_EXISTS), 'error');
       else
       {
         $id = tep_db_insert_id();
         for ($i = 0; $i < count($languages); ++$i)
           tep_db_query("insert into " . TABLE_SITEMAP_SEO_BOX_LINKS . " (box_file_name, page_link_name, pseudo_page_link_name, anchor_text, language_id) values ('" . tep_db_input($_POST['boxfiles_additional']) . "', '" . tep_db_input($fileName) . "', '" . tep_db_input($linkName) . "', '" . tep_db_input($anchorText) . "', '" . (int)$languages[$i]['id'] . "')");
       }  
     }                    
   break; 
  }
  
  /********************** UPDATE THE BOX SECTION **********************/ 
  if (isset($_POST['boxfiles']) && $_POST['boxfiles'] !== TEXT_MAKE_BOX_SELECTION ||
      isset($_POST['boxfiles_additional']) && $_POST['boxfiles_additional'] !== TEXT_MAKE_BOX_SELECTION)
  {
     $activeBox = isset($_POST['boxfiles']) ? $_POST['boxfiles']: $_POST['boxfiles_additional'];
     $boxArray['box_file_name'] = $activeBox;

     $boxName = explode(".", $activeBox);
     for ($i = 0; $i < count($languages); ++$i) 
     {
       $boxes_query = tep_db_query("select box_page_name, pseudo_page_name, excluded_box from " . TABLE_SITEMAP_SEO_BOXES . " where box_file_name LIKE '" . $boxArray['box_file_name'] . "' and language_id = '" . (int)$languages[$i]['id'] . "'");
       $boxes = tep_db_fetch_array($boxes_query);
       $name = sprintf("box_page_name_%d", $languages[$i]['id']);
       $excludedBox = $boxes['excluded_box'] ? 'checked' : '';

       $activeSection = (isset($_POST['boxfiles']) ? 'files' : 'additional'); 
       $boxArray[$name] = tep_not_null($boxes['pseudo_page_name']) ? $boxes['pseudo_page_name'] : (tep_not_null($boxes['box_page_name']) ? $boxes['box_page_name'] :$boxName[0]);
     }   
     $linkArray = GetBoxLinks($boxArray['box_file_name'], $languages);
  }  

  $excludeList = array(0 => 'best_sellers.php',      1 => 'categories.php',    2 => 'currencies.php',     3 => 'languages.php',
                       4 => 'manufacturer_info.php', 5 => 'manufacturers.php', 6 => 'order_history.php',  7 => 'product_notifications.php',
                       8 => 'reviews.php',           9 => 'search.php',        10 => 'shopping_cart.php', 11 => 'specials.php',
                       12 => 'tell_a_friend.php',    13 => 'whats_new.php');   

  AddMissingBoxes(DIR_FS_CATALOG.DIR_WS_MODULES . 'boxes/', $languages, $excludeList, $linkArray); //fill in the database with all boxes if not present
  $boxFilesGroup = GetBoxListGroup(DIR_FS_CATALOG.DIR_WS_MODULES . 'boxes/', $languages, $excludeList);
  $boxFiles = GetBoxList(DIR_FS_CATALOG.DIR_WS_MODULES . 'boxes/', $excludeList);

  require(DIR_WS_INCLUDES . 'template_top.php');
?>


<script type="text/javascript">
function ChangeClickedStatus(boxname)
{
  var ison = document.getElementsByName(boxname)[0].checked; 
  var elm = document.getElementsByTagName("input");

  for (j = 0; j < elm.length; j++) 
  {
    if (elm[j].type == 'checkbox')
    {
      if (elm[j].name.search(boxname + "_") == 0)
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
      <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
     </tr>
     <tr>
      <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
     </tr>
     
     
     <!-- Begin of Sitemap SEO Boxes Main Control -->
     <tr>
      <td><table border="0" width="100%" style="background-color: #fff; border: ridge #CCFFCC 3px;">
			 <tr>
			  <td><table border="0" width="100%" cellspacing="0" cellpadding="2" style="background-color: #f0f1f1; border: ridge #CCFFCC 3px;">
         <tr>
          <th class="smallText" style="font-size: 14px"><?php echo HEADING_TITLE_BOXES_GROUP; ?></th>
         </tr>			
         <tr><td height="6"></td></tr>	        
         <tr>
          <td class="smallText"><?php echo TEXT_TITLE_BOXES_GROUP; ?></td>
         </tr>		 
         <tr><td height="6"></td></tr>	         
        </table></td>
       </tr> 
       <tr>
        <td align="right"><?php echo tep_draw_form('sitemap_seo_boxes_group', FILENAME_SITEMAP_SEO_BOX_CONTROL, '', 'post') . tep_draw_hidden_field('action', 'process_boxes_group'); ?></td>
         <tr>
          <td align="center"><table border="0" width="85%">
           <tr class="smallText">          
            <td width="30%" valign="top"><?php echo ENTRY_SELECT_BOX_GROUP; ?></td>
     		    	<td class="smallText"><?php echo SMMultiSelectMenu('boxfiles[]', $boxFilesGroup, '', 'style="width: 290;" size=10 id="multilist"'); ?></td>
            <td valign="top"><table border="0" width="100%">
             <tr class="smallText">
              <td><?php echo ENTRY_EXCLUDE; ?></td>
              <td><input type="checkbox" name="exclude_all"></td>
             </tr>
             <tr class="smallText">
              <td><?php echo ENTRY_SHOW_REGISTERED_ONLY; ?></td>
              <td><input type="checkbox" name="registered_box"></td>
             </tr>
             <tr class="smallText">
              <td><?php echo ENTRY_CLEAR_MULTI_LIST; ?></td>
              <td><input type="radio" name="clear_list" onclick="reset();"></td>
             </tr>             
             <tr><td colspan="2"><?php echo tep_black_line(); ?></td></tr>
             <tr class="smallText">
              <td colspan="2"><?php echo TEXT_COLOR_EXCLUDED; ?></td>
             </tr>
             <tr class="smallText">
              <td colspan="2"><?php echo TEXT_COLOR_REGISTERED; ?></td>
             </tr>
             <tr class="smallText">
              <td colspan="2"><?php echo TEXT_COLOR_BOTH_EXCLUDED_REGISTERED; ?></td>
             </tr>             
             <tr class="smallText">
              <td colspan="2"><?php echo TEXT_COLOR_SELECTED; ?></td>
             </tr>             
            </table></td>  
           </tr>
          </table></td>   
         </tr>
         <tr> 
          <td align="center"><?php echo (tep_image_submit('button_update.gif', IMAGE_UPDATE, 'name="update_group"')); ?></td>
         </tr> 
        </form>
        </td>
       </tr>
      </table></td>
     </tr>      
     <!-- end of Sitemap SEO Boxes Main Control --> 
     
     <tr><td height="20"></td></tr>
     
     <!-- Begin of Sitemap SEO Boxes-->
     <tr>
      <td><table border="0" width="100%" style="background-color: #fff; border: ridge #CCFFCC 3px;">
			 <tr>
			  <td><table border="0" width="100%" cellspacing="0" cellpadding="2" style="background-color: #f0f1f1; border: ridge #CCFFCC 3px;">
         <tr>
          <th class="smallText" style="font-size: 14px"><?php echo HEADING_TITLE_BOXES_INDIVIDUAL; ?></th>
         </tr>		
         <tr><td height="6"></td></tr>	
         <tr>
          <td class="smallText"><?php echo TEXT_TITLE_BOXES_INDIVIDUAL; ?></td>
         </tr>		 
         <tr><td height="6"></td></tr>	
        </table></td>
       </tr>       
       <tr>
        <td align="right"><?php echo tep_draw_form('sitemap_seo_boxes_individual', FILENAME_SITEMAP_SEO_BOX_CONTROL, '', 'post') . tep_draw_hidden_field('action', 'process_boxes_individual'); ?></td>
         <tr>
          <td><table border="2" width="100%">
           <tr>
            <td><table border="0" width="60%" cellpadding="0">
             <tr class="smallText">
              <td><?php echo ENTRY_SELECT_BOX; ?></td>
              <td><?php echo tep_draw_pull_down_menu('boxfiles', $boxFiles, '', 'onChange="this.form.submit();"'); ?></td>
              <td><?php echo ENTRY_EXCLUDE; ?></td>
              <td><input type="checkbox" name="exclude_link" <?php echo $excludedBox; ?> onChange="ChangeClickedStatus('exclude_link');"></td>
             </tr>
            </table></td>
           </tr>  
           <?php if ($activeSection == 'files' && tep_not_null($boxArray[$name]) && $boxArray[$name] !== 'Array') {  ?>
           <tr>
            <td><table border="0" width="100%">
             <?php for ($i=0; $i < count($languages); ++$i) { 
             $name = sprintf("box_page_name_%d", $languages[$i]['id']);  
             ?>
             <tr><td><?php echo tep_black_line(); ?></td></tr>
             <tr>
              <td><table border="0" width="60%" cellpadding="0">             
               <tr class="smallText"> 
                <td class="smallText" style="font-weight: bold;"><?php echo $languages[$i]['name']; ?></td>
                <td><input name="<?php echo $name; ?>" value="<?php echo $boxArray[$name]; ?>" ></td>
               </tr>
              </table></td>
             </tr>                 
             <tr><td height="6"></td></tr>
             <?php if (count($linkArray) > 0) { 
              if (in_multi_array($boxArray['box_file_name'], $linkArray)) {
             ?>
             <tr>
              <td><table border="0" width="100%" cellpadding="0">
               <tr class="smallText">               
                <th width="22%"><?php echo TEXT_LINK_FILE; ?></th>
                <th width="25%"><?php echo TEXT_LINK_NAME; ?></th>
                <th width="28%"><?php echo TEXT_LINK_PSEUDO_NAME; ?></th>
                <th width="18%"><?php echo TEXT_LINK_ANCHOR_TEXT; ?></th>
                <th width="8%" align="center"><?php echo TEXT_LINK_SORT_ORDER; ?></th>
                <th><?php echo ENTRY_EXCLUDE_SHORT; ?></th>
                <th><?php echo ENTRY_REGISTERED_ONLY_SHORT; ?></th>
               </tr>
              </table></td>
             </tr>  
             <tr>
              <td><table border="0" width="100%" cellpadding="0"> 
              <?php     
               $missingDefine = false;
               $linkSettings = GetLinkSettings($boxArray['box_file_name'], $linkArray, $languages[$i]['id']);

               for ($b = 0; $b < count($linkArray); ++$b)
               {               
                  if (tep_not_null($linkArray[$b]['box']) && $linkArray[$b]['box'] == $boxArray['box_file_name'])
                  { 
                     $bkcolor = '';
                     if (tep_not_null($linkArray[$b]['text']) && $linkArray[$b]['text'] === strtoupper(GetNameFromDefine($linkArray[$b]['text'], $languages[$i]['directory'])))
                     {
                        $bkcolor = 'red';         //this definitions can't be found
                        $missingDefine = true;
                     }   
                    
                     echo '<tr class="smallText">';
                     echo '<td width="30%">' .$linkArray[$b]['link'].'</td>';
                     echo '<td width="30%" style="background-color:' . $bkcolor . '">' .GetNameFromDefine($linkArray[$b]['text'], $languages[$i]['directory'], $boxArray['box_file_name']) .'</td>';
                     echo '<td width="25%"><input type="text" name="box_entry_pseduo_page_name_' . $b . '_' . $languages[$i]['id'] . '" value="' . $linkSettings[$b]['pseudo_page_link_name'] . '" maxlength="255" size="24"></td>';
                     echo '<td width="25%"><input type="text" name="anchor_text_' . $b . '_' . $languages[$i]['id'] . '" value="' . $linkSettings[$b]['anchor_text'] . '" maxlength="255" size="24"></td>';
                     echo '<td width="8%" align="center"><input type="text" name="box_entry_sort_order_' . $b . '_' . $languages[$i]['id'] . '" value = "' . $linkSettings[$b]['sortorder'] . '" maxlength="2" size="3"></td>';
                     echo '<td><input type="checkbox" name="exclude_link_' . $b . '_' . $languages[$i]['id'] . '"' . $linkSettings[$b]['excluded'] . '" maxlength="2" size="3"></td>';
                     echo '<td><input type="checkbox" name="registered_link_' . $b . '_' . $languages[$i]['id'] . '"' . $linkSettings[$b]['registered'] . '" maxlength="2" size="3"></td>';
                     echo '</tr>';
                     echo tep_draw_hidden_field('real_define_'.$b . '_' . $languages[$i]['id'],$linkArray[$b]['link']);
                  }
               }
           
               echo tep_draw_hidden_field('total_entries', count($linkArray));
                
               if ($missingDefine) //a define can't be found so let the user know
                 echo '<tr><td height="6"></td></tr><tr><td class="smallText" colspan="6">' . ERROR_MISSING_DEFINE . '</td></tr>';
              ?>
              </table></td>
             </tr>
             <tr><td height="6"></td></tr>
             <?php } } ?>
             <?php } ?>
            </table></td>
           </tr>
           <?php } ?> 
          </table></td>   
         </tr>
        <tr> 
         <td align="center"><?php echo (tep_image_submit('button_update.gif', IMAGE_UPDATE, 'name="update_individual"') ); ?></td>
        </tr> 
        </form>
        </td>
       </tr>
      </table></td>
     </tr>  
     <!-- end of Sitemap SEO Boxes--> 
	 
     <tr><td height="20"></td></tr>
     
     <!-- Begin of Sitemap SEO Box Links-->
     <tr>
      <td><table border="0" width="100%" style="background-color: #fff; border: ridge #CCFFCC 3px;">
			 <tr>
			  <td><table border="0" width="100%" cellspacing="0" cellpadding="2" style="background-color: #f0f1f1; border: ridge #CCFFCC 3px;">
         <tr>
          <th class="smallText" style="font-size: 14px"><?php echo HEADING_TITLE_ADDITIONAL_LINKS; ?></th>
         </tr>		
         <tr><td height="6"></td></tr>	
         <tr>
          <td class="smallText"><?php echo TEXT_TITLE_ADDITIONAL_LINKS; ?></td>
         </tr>		 
         <tr><td height="6"></td></tr>	
        </table></td>
       </tr>       
       <tr>
        <td align="right"><?php echo tep_draw_form('sitemap_seo_boxes_additional', FILENAME_SITEMAP_SEO_BOX_CONTROL, '', 'post') . tep_draw_hidden_field('action', 'process_boxes_additional'); ?></td>
         <tr>
          <td><table border="2" width="100%">
           <tr>
            <td><table border="0" width="60%" cellpadding="0">
             <tr class="smallText">
              <td><?php echo ENTRY_SELECT_BOX; ?></td>
              <td><?php echo tep_draw_pull_down_menu('boxfiles_additional', $boxFiles, '', 'onChange="this.form.submit();"'); ?></td>
             </tr>
            </table></td>
           </tr>  
           <?php if ($activeSection == 'additional' && tep_not_null($boxArray[$name]) && $boxArray[$name] !== 'Array') {  ?>
           <tr>
            <td><table border="0" width="100%">
             <tr><td><?php echo tep_black_line(); ?></td></tr>
             <tr>
              <td><table border="0" width="100%" cellpadding="0">
               <tr class="smallText">               
                <th width="28%" ><?php echo TEXT_FILENAME; ?></th>
                <th width="36%" ><?php echo TEXT_DISPLAY_NAME; ?></th>
                <th width="26%" align="center"><?php echo TEXT_LINK_ANCHOR_TEXT; ?></th>
               </tr>
              </table></td>
             </tr>  
             <tr>
              <td><table border="0" width="100%" cellpadding="0"> 
               <tr class="smallText" >
                <td width="22%"><input type="text" name="filename" size="37"></td>    
                <td width="26%"><input type="text" name="link_name" size="37"></td>    
                <td width="26%"><input type="text" name="anchor_text" size="37"></td>    
               </tr>
              </table></td>
             </tr>
             <tr><td height="6"></td></tr>
            </table></td>
           </tr>
           <?php } ?> 
          </table></td>   
         </tr>
        <tr> 
         <td align="center"><?php echo (tep_image_submit('button_update.gif', IMAGE_UPDATE, 'name="update_additional"') ); ?></td>
        </tr> 
        </form>
        </td>
       </tr>
      </table></td>
     </tr>       
     <!-- end of Sitemap SEO Box Links--> 
   
    </table></td>
  </tr>
</table>

<?php
  require(DIR_WS_INCLUDES . 'template_bottom.php');
  require(DIR_WS_INCLUDES . 'application_bottom.php');
?>
