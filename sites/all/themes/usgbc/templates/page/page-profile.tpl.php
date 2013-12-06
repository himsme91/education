<?php
// $Id: page-profile.tpl.php 29599 2012-07-31 23:53:49Z pkhanna $
/**
 * @file
 * USGBC theme
 * Displays a single Drupal page.
 */

$styles .= '<link type="text/css" rel="stylesheet" media="screen" href="/sites/all/themes/usgbc/lib/css/section/directory.css" />';

include('page_inc/page_top.php'); ?>      
      

<div id="content" class="oneCol">
      
      	<div id="mainCol">
      	   
      	   
      			<div class="three-cols">
      			     
      			     <div class="col">
      			         <?php print views_embed_view('OrgViews', 'page_3'); ?>
      			     </div>	
      			     
      			     <div class="col">
      			         <?php print views_embed_view('Persons', 'page_2'); ?>
      			     </div>	
      			     
      			     <div class="col">
      			         <?php print views_embed_view('leed_projects', 'page_5'); ?>
      			     </div>
      			     	
      			</div>
      	</div>
  
</div><!--content-->

      
      
<?php include('page_inc/page_bottom.php'); ?>