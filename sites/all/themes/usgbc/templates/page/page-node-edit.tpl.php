<?php
  // $Id: page-node-edit.tpl.php 12751 2012-01-19 07:13:28Z pnewswanger $
  /**
   * @file
   * USGBC theme
   * Displays a single Drupal page.
   */


  include('page_inc/page_top.php'); ?>

<?php if (!empty($section_sub_menu)): ?>

<div id="content" class="twoColRight">

  <div id='navCol' class='clearfix'>
    <?php print $section_sub_menu; ?>
    &nbsp;
  </div>

  <div class="subcontent-wrapper">
    <div id="mainCol">
      <?php print $content; ?>
    </div>
  </div>

</div><!--content-->

<?php else: ?>

<div id="content" class="oneCol">

  <?php print $content; ?>

</div><!--content-->

<?php endif; ?>


<?php include('page_inc/page_bottom.php'); ?>
