<?php
  // $Id: page-nodetype-credit-definition.tpl.php 47069 2013-05-09 14:49:59Z conor $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */

  $styles .= '<link type="text/css" rel="stylesheet" media="all" href="/sites/all/themes/usgbc/lib/css/section/leed.css" />';
  $scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/section/credits.js"></script>';
  //$scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/node/member_landing/js/scripts.js"></script>';
  $scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/jquery.stickyscroll.js"></script>';
  $scripts .= '<script type="text/javascript" src="/sites/all/themes/usgbc/lib/js/jquery.scrollTo.js"></script>';
  
  
  include('page_inc/page_top.php'); ?>
<?php 

 	$links = array();

	global $base_url;
	$sections = explode ('/', $_GET['return'], 5);

	$links[] .= l(t(ucfirst(str_replace('%26','&',str_replace('-',' ',$sections[2]))).' '.str_replace('%26','&',str_replace('-',' ',$sections[3]))), str_replace('%26','%26',$base_url.'/'.$sections['1'].'/'.$sections['2'].'/'.$sections['3']));
	$links[] .= l(t(ucfirst(str_replace('%26','&',str_replace('-',' ',$sections[4])))), str_replace('%26','%26',$base_url.$_GET['return']));

?>
<div class="breadcrumb">
<?php foreach($links as $l){
	// print $l;
 }?>
</div>

<?php print $content; ?>

<!--<?php if ($_GET['view'] == 'discussion'): ?>
  </div>

  <div id="sideCol">
    <div id="-involved-box" class="emphasized-box">
    <div class="container hidden">
              <h5>Sample credit forms</h5>
              <p>A public version of [<?php print $node->field_credit_short_id[0]['value']?>]&rsquo;s dynamic credit template within LEED Online v3 is available to registered project team members.</p>
              <div class="">
                  <a href="#" class="button">Download</a>
              </div>
          </div>
      <div class="container">
        <h5>Join LEEDUser</h5>

        <p>Ask questions, share tips, and get notified of new forum posts by joining LEEDuser, a tool developed by BuildingGreen and supported by USGBC!</p>

        <div class="">
          <a href="http://www.leeduser.com/user/register" target="_blank" class="button">Create free account</a>
        </div>
      </div>-->
    </div>
    <div class="section">
      <?php
      $viewname = 'leed_credits';
      $args = array();
      $args [0] = $node->nid;
      $display_id = 'page_6'; // or any other display
      $view = views_get_view ($viewname);
      $view->set_display ($display_id);
      $view->set_arguments ($args);
      print $view->preview ();
      ?>
    </div>
  </div>
</div>
<?php endif; ?>

<?php include('page_inc/page_bottom.php'); ?>
