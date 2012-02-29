<?php
/*
  $Id: sitemap_seo.php,v 1.0 2008/12/29
  written by Jack_mcs at www.osocmmerce-solution.com

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2008 osocmmerce-solution.com
  Portions Copyright 2009 oscommerce-solution.com

  Released under the GNU General Public License
*/
 
function GetBoxLinks($box) {
    $boxLinks = array();

    if ($box != TEXT_MAKE_BOX_SELECTION) {
        $path = DIR_WS_INCLUDES . 'modules/boxes/' . $box;
        
        $lines = array();

        if (GetFilesArray($path, $lines)) {      
            for ($i = 0, $idx = 0; $i < count($lines); ++$i) {
                if (preg_match('/\<a(.*)\<\/a/i', $lines[$i], $out)) {
                    if (preg_match("/tep_href_link((.*))/i", $out[1], $locn)) {                    
                        $boxLinks[$idx]['box'] = $box;

                        $link = trim(substr($locn[1], strpos($locn[1], "(") + 1, strpos($locn[1], ")") - 1));
                        $linkParts = explode(",", $link); //only use the first part of the link - removes SSL, etc.
                        $link = $linkParts[0];  
                                    
                        if ($link === strtoupper($link)) {
                            $boxLinks[$idx]['link'] = $link;
                        } else {                                 //link contains something like index.php, 'cPath=23'  
                            $parts = explode("'", $link);      //so break it up and try to put it back together so it can be used
                            $newLink = '';
                            for ($p = 0; $p < count($parts); ++$p) {
                              if (empty($parts[$p]) || strpos($parts[$p], ",") !== FALSE)
                               continue;
                              $newLink = (empty($newLink)) ? $parts[$p] : $newLink . '?'. $parts[$p];  
                            }
                            $boxLinks[$idx]['link'] = $newLink;
                        } 

                        $text = substr($locn[1], strpos($locn[1], ">") + 1);
                     
                        if (strpos($text, ".") !== FALSE) {  
                            $boxLinks[$idx]['text'] = trim(substr($text, strpos($text, ".") + 1, strrpos($text, ".")), " .'");
                        } else {
                            $boxLinks[$idx]['text'] = trim($text, " - '");
                        }           
                        $idx++;             
                    }
                }
            }
        }  
    }
    
    return $boxLinks;
}
 
function GetFileName($define)        //retrieve the defined filename
{
  $end =  (substr(DIR_FS_CATALOG, 0, -1) !== '/') ? '/' : '';
  $file = DIR_FS_CATALOG . $end . DIR_WS_INCLUDES . 'filenames.php';
  $fp = @file($file);
  
  for ($idx = 0; $idx < count($fp); ++$idx)
  {
    if (strpos($fp[$idx], $define) !== FALSE)
    {
      $parts = explode("'", $fp[$idx]);   
      return $parts[3];     
    }
  }    
  return NULL;
}
 
/*****************************************************************
Get the contents of the given file
*****************************************************************/  
function GetFilesArray($path, &$lines) {
    $lines = file($path);
    return true;
}

function GetNameFromDefine($define, $languageName, $boxName) { //return the defined name
    $path = DIR_FS_CATALOG . DIR_WS_LANGUAGES . $languageName . '/modules/boxes/' . $boxName;
    $lines = array();
    
    if (GetFilesArray($path, $lines)) { 
        $cnt = count($lines);
        for ($i = 0; $i < $cnt; ++$i) {
            if (strpos($lines[$i], $define) !== FALSE) {
                $parts = explode(",", $lines[$i]);
                $parts[1] = str_replace("\'", "xyz", $parts[1]); //save any required apostrophes before stipping
                $name = explode("'", $parts[1]);                 //strip the apostrophes  
                $name[1] = str_replace("xyz", "'", $name[1]);    //add back the required ones
                return trim($name[1]);
            }
        }
    }
    
    return $define;
} 

function in_multi_array($needle, $haystack) 
{
  $in_multi_array = false;
  if(in_array($needle, $haystack)) 
  {
    $in_multi_array = true;
  } 
  else 
  {
    foreach ($haystack as $key => $val) 
    {
      if(is_array($val)) 
      {
        if (in_multi_array($needle, $val)) 
        {
          $in_multi_array = true;
          break;
        }
      }
    }
  }
  return $in_multi_array;
}

function IsViewable($file) {
  if (($fp = file($file))) {
    for ($idx = 0; $idx < count($fp); ++$idx)     {
        if (strpos($fp[$idx], "template_top.php") !== FALSE) {
            return true;
        } 
    }
  }  
  return false;
}

function SortOnKeys($a, $b) {
  return strnatcasecmp($a["sortkey"], $b["sortkey"]);
}
?>