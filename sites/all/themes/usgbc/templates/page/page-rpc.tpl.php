<?php
// $Id: page.tpl.php 7027 2011-10-18 16:54:26Z pnewswanger $
/**
 * @file
 * USGBC theme
 * Displays a single Drupal page.
 */
$styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/usgbc/lib/css/section/leed.css" />';
//$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/section/leed.js"></script>';

//Turn off page caching
$GLOBALS['conf']['cache'] = FALSE;
unset($_SESSION['pilot-credit']);

include('page_inc/page_top.php'); ?>
	
<div id="content" class="twoColRight">

      <div id='navCol' class='clearfix '>
      <?php print $section_sub_menu; ?>
    &nbsp;
     </div>

   	<div class="subcontent-wrapper">
      			<div id="mainCol">
      				<h1>Regional Priority Credits</h1>
      				<?php print $content; ?>
      			</div>
      	</div>

</div><!--content-->

<?php include('page_inc/page_bottom.php'); ?>

