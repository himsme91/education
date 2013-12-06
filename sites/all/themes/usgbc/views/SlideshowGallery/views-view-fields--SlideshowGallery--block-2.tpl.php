<?php
  // $Id: views-view-fields--SlideshowGallery--block-2.tpl.php 25723 2012-06-27 18:33:28Z pkhanna $

  $url = "/gallery/video/" . $fields['nid']->content . '/';
  $pg_arg = arg();
  if(!isset($pg_arg[3])) $pg_arg[3] = 0;
?>
<li<?php if($pg_arg[3] == $fields['delta']->content) print ' class="active"'; ?>>

  <?php  $url .= $fields['delta']->content; ?>
  <a href="<?php echo $url;?>"><?php print str_replace('http://img.youtube.com','https://img.youtube.com',$fields['field_art_videos_embed']->content); ?></a>

</li>
