<?php
// $Id: page.tpl.php 7027 2013-03-13 16:54:26Z jmehta $
/**
 * @file
 * USGBC theme
 * Displays a single Drupal page.
 */
?>
<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
$title = $node->title;
$share_text = "Worth checking out: $title on www.usgbc.org";
$head_title = str_replace('&amp;', '&',$head_title);
$pageurl = $_SERVER["REQUEST_URI"];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><!--  <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">-->
<!--[if lt IE 7 ]> <html class="ie ie6" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie ie7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie ie8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie ie9" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language ?>" lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>"><!--<![endif]-->

<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" >
<meta name="google-site-verification" content="2z0A9kITfB_cjJthmZmsOol8JFV1j63k2hE_GTLy_CA" />
<?php print  "<meta name='description' content='$share_text' />"?>
  <title><?php print $head_title; ?></title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
<script src="/sites/all/themes/usgbc/lib/node/leed_automation/js/jquery.autoclear.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="/sites/all/themes/usgbc/lib/node/leed_automation/base.css" type="text/css" media="all"/>
<link rel="stylesheet" href="/sites/all/themes/usgbc/lib/node/leed_automation/styles.css" type="text/css" media="all"/>
<link rel="stylesheet" href="/sites/all/themes/usgbc/lib/node/leed_automation/720_grid.css" type="text/css" media="screen and (min-width: 720px)"/>
<link rel="stylesheet" href="/sites/all/themes/usgbc/lib/node/leed_automation/986_grid.css" type="text/css" media="screen and (min-width: 986px)"/>
<link rel="stylesheet" href="/sites/all/themes/usgbc/lib/node/leed_automation/1236_grid.css" media="screen and (min-width: 1236px)"/>

</head>

<body>
 <?php print $content; ?>
  
</body>
</html>

