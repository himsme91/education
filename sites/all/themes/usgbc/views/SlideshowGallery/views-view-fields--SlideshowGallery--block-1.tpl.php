<?php
  // $Id: views-view-fields--SlideshowGallery--block-1.tpl.php 11393 2011-12-23 13:16:56Z pnewswanger $

  $url = "/gallery/img/" . $fields['nid']->content . '/';
  $pg_arg = arg();
  if(!isset($pg_arg[3])) $pg_arg[3] = 0;
?>
<li<?php if($pg_arg[3] == $fields['delta']->content) print ' class="active"'; ?>>

  <?php  $url .= $fields['delta']->content; ?>
  <a href="<?php echo $url;?>"><?php print $fields['field_art_slideshow_image_fid']->content; ?></a>

</li>
