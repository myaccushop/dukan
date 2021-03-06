<?php
/*
  $Id$

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2010 osCommerce

  Released under the GNU General Public License
*/

  $oscTemplate->buildBlocks();

  if (!$oscTemplate->hasBlocks('boxes_column_left')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }

  if (!$oscTemplate->hasBlocks('boxes_column_right')) {
    $oscTemplate->setGridContentWidth($oscTemplate->getGridContentWidth() + $oscTemplate->getGridColumnWidth());
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>" />
<title><?php echo tep_output_string_protected($oscTemplate->getTitle()); ?> Digital Readouts beats Newall Acurite Sargon Fagro Electronica Heidenhain. </title>
<meta name="description" content="At AccuDRO we sell high quality digital readout systems with magnetic scales for lathe and mill machines starting at only $650! Call us at 877-407-3515 for all your digital readout needs!" />
<meta name="keywords" content=" dro, digital readout, heidenhain, newall, acurite,mini lathe dro, mini mill dro, minilathe dro, minimill dro , mini-lathe dro, mini-mill dro, lathe dro, mill dro, Accudro.com, Newall DP700 DRO Mill Packages 2 & 3 Axes, Newall, mill digital read out, readouts, dros,Anilam dro, Heidenhain dro, Heidenhain DRO, Anilam DRO, dro, digital read out, 2 or 3 axis dro, dro packages, dro bundles, dro kits, dro systems, 2 or 3 axis dro kits, 2 or 3 axis dro bundles,  2 or 3 axis dro packages, 2 axis dro kits, 2 axis dro bundles,  2 axis dro packages,3 axis dro kits, 3 axis dro bundles,  3 axis dro packages, digital readout for lathe machine , digital readouts for lathe machine , lathe digital readout,lathe machine digital readout, digital readout for mill machine , digital readouts for mill machine , mill digital readout,mill machine digital readout, high quality digital readout for lathe or mill, rigid digital readout for lathe or mill,  magnetic scales for digital readouts, high resolution magnetic scales for digital readouts, digital readout for manual lathe and mill machines, 8x40 dro for lathe machine,10x40 dro for lathe machine,12x40 dro for lathe machine,14x80 dro for lathe machine,16x80 dro for lathe machine,8 x 40 dro for lathe machine,10 x 40 dro for lathe machine,12 x 40 dro for lathe machine,14 x 80 dro for lathe machine,16 x 80 dro for lathe machine,8 inches x 40 inches dro for lathe machine,10 inches x 40 inches dro for lathe machine,12 inches x 40 inches dro for lathe machine,14 inches x 80 inches dro for lathe machine,16 inches x 80 inches dro for lathe machine,10x20 dro for mill machine,12x32 dro for mill machine,12x36 dro for mill machine,16x40 dro for mill machine,18x40 dro for mill machine,12x32x16 dro for mill machine,12x36x16 dro for mill machine,18x40x18 dro for mill machine,10 x 20 dro for mill machine,12 x 32 dro for mill machine,12 x 36 dro for mill machine,16 x 40 dro for mill machine,18 x 40 dro for mill machine,12 x 32 x 16 dro for mill machine,12 x 36 x 16 dro for mill machine,18 x 40 x 18 dro for mill machine,10 inches x 20 inches dro for mill machine,12 inches x 32 inches dro for mill machine,12 inches x 36 inches dro for mill machine,16 inches x 40 inches dro for mill machine,18 inches x 40 inches dro for mill machine,12 inches x 32 inches x 16 inches dro for mill machine,12 inches x 36 inches x 16 inches dro for mill machine,18 inches x 40 inches x 18 inches dro for mill machine" />
<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>" />
<link rel="stylesheet" type="text/css" href="ext/jquery/ui/custom-theme/jquery-ui-1.8.10.custom.css" />
<script type="text/javascript" src="ext/jquery/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="ext/jquery/ui/jquery-ui-1.8.7.custom.min.js"></script>
<script type="text/javascript" src="ext/cal/prod_improv_cal.js"></script>

<?php
  if (tep_not_null(JQUERY_DATEPICKER_I18N_CODE)) {
?>
<script type="text/javascript" src="ext/jquery/ui/i18n/jquery.ui.datepicker-<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>.js"></script>
<script type="text/javascript">
$.datepicker.setDefaults($.datepicker.regional['<?php echo JQUERY_DATEPICKER_I18N_CODE; ?>']);
</script>
<?php
  }
?>

<script type="text/javascript" src="ext/jquery/bxGallery/jquery.bxGallery.1.1.min.js"></script>
<link rel="stylesheet" type="text/css" href="ext/jquery/fancybox/jquery.fancybox-1.3.4.css" />
<script type="text/javascript" src="ext/jquery/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="ext/960gs/<?php echo ((stripos(HTML_PARAMS, 'dir="rtl"') !== false) ? 'rtl_' : ''); ?>960_24_col.css" />
<link rel="stylesheet" type="text/css" href="stylesheet.css" />
<link rel="stylesheet" type="text/css" href="acdr.css" />
<?php echo $oscTemplate->getBlocks('header_tags'); ?>

<link rel="stylesheet" href="ext/jquery/tinycarousel/css/website.css" type="text/css" media="screen"/> 

<script type="text/javascript" src="ext/jquery/tinycarousel/jquery.tinycarousel.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //$('#slider2').tinycarousel({display: 2});
        $('#slider3').tinycarousel({ display:3, pager: true  });	
      });
</script>	
<?php
// load server configuration parameters
  if (file_exists('includes/local/noanalytics.php')) { // for developers

  } else {
?>
    <script type="text/javascript">

      var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-29342563-1']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

    </script>


    <!-- Quantcast Tag -->
    <script type="text/javascript">
    var _qevents = _qevents || [];
    
    (function() {
   var elem = document.createElement('script');
   elem.src = (document.location.protocol == "https:" ? "https://secure" : "http://edge") + ".quantserve.com/quant.js";
   elem.async = true;
   elem.type = "text/javascript";
   var scpt = document.getElementsByTagName('script')[0];
   scpt.parentNode.insertBefore(elem, scpt);
   })();

   _qevents.push({
   qacct:"p-84dUqzRKnAMMI"
   });
   </script>

   <noscript>
   <div style="display:none;">
   <img src="//pixel.quantserve.com/pixel/p-84dUqzRKnAMMI.gif" border="0" height="1" width="1" alt="Quantcast"/>
   </div>
   </noscript>
   <!-- End Quantcast tag -->
<?php  
     }
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Place this render call where appropriate -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

</head>
<body>

<div id="bodyWrapper" class="container_<?php echo $oscTemplate->getGridContainerWidth(); ?>">

<?php require(DIR_WS_INCLUDES . 'header.php'); ?>

<div id="bodyContent" class="grid_<?php echo $oscTemplate->getGridContentWidth(); ?> <?php echo ($oscTemplate->hasBlocks('boxes_column_left') ? 'push_' . $oscTemplate->getGridColumnWidth() : ''); ?>">
