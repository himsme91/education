<?php
  // $Id: views-view--SlideshowGallery--block.tpl.php 11382 2011-12-23 12:58:29Z pnewswanger $

?>

<?php if ($admin_links): ?>
<div class="<?php print $classes; ?>">
<?php endif; ?>

<?php if ($admin_links): ?>
  <div class="views-admin-links views-hide">
    <?php print $admin_links; ?>
  </div>
<?php endif; ?>

  <ul class="thumbs">
    <?php if ($rows) print $rows; ?>
  </ul>




<?php if ($admin_links): ?>
</div> <?php /* class view */ ?>
<?php endif; ?>


