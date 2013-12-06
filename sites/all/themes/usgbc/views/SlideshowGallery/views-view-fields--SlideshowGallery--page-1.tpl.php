<?php
  // $Id: views-view-fields--SlideshowGallery--page-1.tpl.php,v 1.6 2008/09/24 22:48:21 jmehta $

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
  $display_id = 'block_1'; // or any other display
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
    $prev = '<a class="prev" title="Previous Photo" href="/gallery/img/' . $nid . '/' . ($current_delta - 1) . '">Previous</a>';
  }
  if ($current < $total) {
    $next = '<a class="next" title="Next Photo" href="/gallery/img/' . $nid . '/' . ($current_delta + 1) . '">Next</a>';
  }

?>
<div class="container">
  <span class="loading"></span>

  <div class="header">

    <div class="menu">
      <ul class="controls">
        <li class="nav">
          <?php print $prev; ?>
          <p class="current">Photo
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

      <div id="img-embed">
        <?php print $fields['field_art_slideshow_image_fid']->content; ?>
      </div>
      <p class="copyright"><?php print $fields['field_art_slideshow_image_data_1']->content; ?></p>

      <p class="caption"><?php print $fields['field_art_slideshow_image_data_2']->content; ?><br />
      <?php print $fields['field_art_slideshow_image_data']->content; ?></p>

      <p class="meta">
        <span class="description"></span>
      </p>
 <?php if (user_access("create credit_definition content")){ ?>
      <p class="meta">
		<span class="description">
			[view:embed_project_img==<?php print $nid?>/<?php print $current?>]
		</span>
	</p>
<?php }?>
    </div>
  </div>
</div>



<div>
  <?php
  print $view->preview ();
  ?>
</div>



