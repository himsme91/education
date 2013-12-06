<?php
// $Id: page.tpl.php 7027 2011-10-18 16:54:26Z pnewswanger $
/**
 * @file
 * USGBC theme
 * Displays a single Drupal page.
 */

$styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/store.css" />';
include('page_inc/page_top.php'); ?>      


<div id="content" class="twoColLeft checkout-process cart">
      				<?php print $content; ?>
  
</div><!--content-->

     
      
<?php include('page_inc/page_bottom.php'); ?>