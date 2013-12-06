<?php
// $Id: views-view--SlideshowGallery--page-4.tpl.php 10693 2011-12-15 17:11:10Z jmehta $
?>

<?php if ($admin_links): ?>
<div class="<?php print $classes; ?>">
<?php endif; ?>

  <?php if ($admin_links): ?>
    <div class="views-admin-links views-hide">
      <?php print $admin_links; ?>
    </div>
  <?php endif; ?>

  <?php if ($header) print $header; ?>

  <?php if ($exposed) print $exposed; ?>
  <?php if ($attachment_before) print $attachment_before; ?>

       <?php
      if ($rows){
        print $rows;
      } else {
        print $empty;
      }
      ?>

  <?php if ($pager) print $pager; ?>

  <?php if ($attachment_after) print $attachment_after; ?>
  <?php if ($more)  print $more; ?>
  <?php if ($footer) print $footer; ?>
  <?php if ($feed_icon)  print $feed_icon; ?>

<?php if ($admin_links): ?>
</div> <?php /* class view */ ?>
<?php endif; ?>


