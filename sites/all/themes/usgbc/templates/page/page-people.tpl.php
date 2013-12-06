<?php include('page_inc/page_top.php'); ?>

<div class="twoColRight" id="content">

     <div id='navCol' class='clearfix '>
      <?php print $section_sub_menu; ?>
    &nbsp;
    <?php include('page_inc/saved_search_nav.php');?>
  </div>
  <div class="subcontent-wrapper">
    <div id="mainCol">
      <?php print $content; ?>
    </div>
  </div>
</div>

<?php include('page_inc/page_bottom.php'); ?>