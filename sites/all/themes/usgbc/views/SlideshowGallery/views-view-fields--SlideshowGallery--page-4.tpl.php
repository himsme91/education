<?php
  // $Id: views-view-fields--SlideshowGallery--page-4.tpl.php,v 1.6 2008/09/24 22:48:21 jmehta $

  $current_delta = $fields['delta']->content;
  $nid = $fields['nid']->content;
  if(isset($_GET['referring'])){
      $referring_pg = $_GET['referring'];
    } else {
      $referring_pg = url(drupal_get_path_alias( 'node/' . $nid));
    }

  $viewname = 'SlideshowGallery';
  $args = array();
  $args [0] = $nid;
  $display_id = 'block_2'; // or any other display
  $view = views_get_view ($viewname);
  $view->set_items_per_page(0);
  $view->set_display ($display_id);
  $view->set_arguments ($args);
  $view->execute ();


  $total = count ($view->result);
  $current = $current_delta + 1;

  $prev = '<a class="prev disabled" title="Previous Photo" href="#">Previous</a>';
  $next = '<a class="next disabled" title="Next Photo" href="#">Next</a>';
  if ($current > 1) {
    $prev = '<a class="prev" title="Previous Photo" href="/gallery/video/' . $nid . '/' . ($current_delta - 1) . '">Previous</a>';
  }
  if ($current < $total) {
    $next = '<a class="next" title="Next Photo" href="/gallery/video/' . $nid . '/' . ($current_delta + 1) . '">Next</a>';
  }

?>
<div class="container">
  <span class="loading"></span>

  <div class="header">

    <div class="menu">
      <ul class="controls">
        <li class="nav">
          <?php print $prev; ?>
          <p class="current">Video
            <span class="num"><?php print $current; ?></span>&nbsp;of&nbsp;<span class="total"><?php print $total; ?></span>
          </p>
          <?php print $next; ?>
        </li>
        <li class="exit"><a href="<?php print $referring_pg; ?>" title="Close">Close</a></li>
      </ul>


    </div>
  </div>

  <div class="body">
    <div class="media">

      <div id="video-embed">
        <?php print $fields['field_art_videos_embed']->content; ?>
      </div>
      <p class="copyright"><?php print $fields['field_art_videos_provider']->content; ?></p>

      <p class="caption"></p>

      <p class="meta">
        <span class="duration"><?php print 'Duration: ' . $fields['field_art_videos_duration']->content; ?></span>
      </p>

    </div>
  </div>
</div>

<div>
  <?php
  print $view->preview ();
  ?>
</div>
